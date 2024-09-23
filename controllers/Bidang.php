<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidang extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('Bidang_model', 'bimo');
		$this->load->model('JenisLaporan_model', 'jelamo');

		$this->admo->checkLoginAdmin();
	}

	public function index()
	{
		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['title']  	= 'Bidang';
		$data['bidang']	= $this->bimo->getBidang();
		$this->load->view('templates/header-admin', $data);
		$this->load->view('bidang/index', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function jenisLaporanByBidangId($id_bidang = "")
	{
		if ($id_bidang == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['bidang']		= $this->bimo->getBidangById($id_bidang);
		$data['jenis_laporan']	= $this->jelamo->getJenisLaporanByBidangId($id_bidang);
		$data['title']  	= 'Bidang - ' . $data['bidang']['nama_bidang'];
		$this->load->view('templates/header-admin', $data);
		$this->load->view('bidang/jenis_laporan_by_bidang_id', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function addBidang()
	{
		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['title'] 		= 'Tambah Bidang';

		$this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
		    $this->load->view('bidang/add_bidang', $data);
		    $this->load->view('templates/footer-admin', $data);  
		} else {
		    $this->bimo->addBidang();
		}
	}

	public function editBidang($id_bidang = "")
	{
		if ($id_bidang == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['bidang']	= $this->bimo->getBidangById($id_bidang);
		$data['title'] 		= 'Ubah Bidang - ' . $data['bidang']['nama_bidang'];

		$this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
		    $this->load->view('bidang/edit_bidang', $data);
		    $this->load->view('templates/footer-admin', $data);  
		} else {
		    $this->bimo->editBidang($id_bidang);
		}
	}


	public function removeBidang($id_bidang = "")
	{
		if ($id_bidang == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$this->bimo->removeBidang($id_bidang);
	}
}
