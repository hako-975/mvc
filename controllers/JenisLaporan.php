<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JenisLaporan extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('JenisLaporan_model', 'jelamo');
		$this->load->model('Bidang_model', 'bimo');

		$this->admo->checkLoginAdmin();
	}

	public function index()
	{
		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['title']  	= 'Jenis Laporan';
		$data['jenis_laporan']	= $this->jelamo->getJenisLaporan();
		$this->load->view('templates/header-admin', $data);
		$this->load->view('jenis_laporan/index', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function addJenisLaporan()
	{
		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['title'] 		= 'Tambah Jenis Laporan';
		$data['bidang']		= $this->bimo->getBidang();

		$this->form_validation->set_rules('jenis_laporan', 'Jenis Laporan', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
		    $this->load->view('jenis_laporan/add_jenis_laporan', $data);
		    $this->load->view('templates/footer-admin', $data);  
		} else {
		    $this->jelamo->addJenisLaporan();
		}
	}

	public function editJenisLaporan($id_jenis_laporan = "")
	{
		if ($id_jenis_laporan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['jenis_laporan']	= $this->jelamo->getJenisLaporanById($id_jenis_laporan);
		$data['bidang']		= $this->bimo->getBidang();
		$data['title'] 		= 'Ubah Jenis Laporan - ' . $data['jenis_laporan']['jenis_laporan'];

		$this->form_validation->set_rules('jenis_laporan', 'Nama JenisLaporan', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
		    $this->load->view('jenis_laporan/edit_jenis_laporan', $data);
		    $this->load->view('templates/footer-admin', $data);  
		} else {
		    $this->jelamo->editJenisLaporan($id_jenis_laporan);
		}
	}


	public function removeJenisLaporan($id_jenis_laporan = "")
	{
		if ($id_jenis_laporan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$this->jelamo->removeJenisLaporan($id_jenis_laporan);
	}
}
