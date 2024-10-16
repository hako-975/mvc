<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelurahan extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('Kelurahan_model', 'kelmo');
		$this->load->model('Kecamatan_model', 'kemo');

		$this->admo->checkLoginAdmin();
	}

	public function index()
	{
		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['title']  	= 'Kelurahan/Desa';
		$data['kelurahan']	= $this->kelmo->getKelurahan();

		$this->load->view('templates/header-admin', $data);
		$this->load->view('kelurahan/index', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function getKelurahanFile()
	{
		$this->load->view('kelurahan/get_kelurahan');
	}

	public function addKelurahan()
	{
		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['title'] 		= 'Tambah Kelurahan/Desa';
		$data['kecamatan']	= $this->kemo->getKecamatan();

		$this->form_validation->set_rules('id_kecamatan', 'Nama Kecamatan', 'required|trim');
		$this->form_validation->set_rules('nama_kelurahan', 'Nama Kelurahan', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
		    $this->load->view('kelurahan/add_kelurahan', $data);
		    $this->load->view('templates/footer-admin', $data);  
		} else {
		    $this->kelmo->addKelurahan();
		}
	}

	public function editKelurahan($id_kelurahan = "")
	{
		if ($id_kelurahan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['kecamatan']	= $this->kemo->getKecamatan();
		$data['kelurahan']	= $this->kelmo->getKelurahanById($id_kelurahan);
		$data['title'] 		= 'Ubah Kelurahan/Desa - ' . $data['kelurahan']['nama_kelurahan'];

		$this->form_validation->set_rules('id_kecamatan', 'Nama Kecamatan', 'required|trim');
		$this->form_validation->set_rules('nama_kelurahan', 'Nama Kelurahan', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
		    $this->load->view('kelurahan/edit_kelurahan', $data);
		    $this->load->view('templates/footer-admin', $data);  
		} else {
		    $this->kelmo->editKelurahan($id_kelurahan);
		}
	}

	public function removeKelurahan($id_kelurahan = "")
	{
		if ($id_kelurahan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$this->kelmo->removeKelurahan($id_kelurahan);
	}

}
