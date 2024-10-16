<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('Laporan_model', 'lamo');
		$this->load->model('Bidang_model', 'bimo');
		$this->load->model('Kecamatan_model', 'kemo');
		$this->load->model('Kelurahan_model', 'kelmo');
	}

	public function index()
	{
		$this->admo->checkLoginAdmin();

		$data['dataUser']		= $this->admo->getDataUserAdmin();
		$data['laporan']		= $this->lamo->getJmlLaporan();
		$data['bidang']			= $this->bimo->getBidang();
		$data['kecamatan']		= $this->kemo->getKecamatan();
		$data['title'] 			= 'Dashboard - ' . $data['dataUser']['jabatan'];

		if ($data['dataUser']['jabatan'] == 'Camat') {
			$id_kecamatan = $data['dataUser']['id_kecamatan'];
			$data['laporan'] = $this->lamo->getJmlLaporan($id_kecamatan);
			$data['kelurahan'] = $this->kelmo->getKelurahanByKecamatanId($id_kecamatan);
		}
		$this->load->view('templates/header-admin', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function fetchLaporanKecamatan()
	{
		$this->admo->checkLoginAdmin();

        $nama_kecamatan = array();
		$jumlah_laporan = array();
		$jumlah_laporan_belum_divalidasi = array();
		$jumlah_laporan_valid = array();
		$jumlah_laporan_tidak_valid = array();

		foreach ($this->lamo->getJmlLaporan() as $row) {
		    $nama_kecamatan[] = $row['nama_kecamatan'];
		    $jumlah_laporan[] = $row['jumlah_laporan'];
		    $jumlah_laporan_belum_divalidasi[] = $row['jumlah_laporan_belum_divalidasi'];
		    $jumlah_laporan_valid[] = $row['jumlah_laporan_valid'];
		    $jumlah_laporan_tidak_valid[] = $row['jumlah_laporan_tidak_valid'];
		}

		$data_array = array(
		    'nama_kecamatan_array' => $nama_kecamatan,
		    'jumlah_laporan_array' => $jumlah_laporan,
		    'jumlah_laporan_belum_divalidasi_array' => $jumlah_laporan_belum_divalidasi,
		    'jumlah_laporan_valid_array' => $jumlah_laporan_valid,
		    'jumlah_laporan_tidak_valid_array' => $jumlah_laporan_tidak_valid
		);

		echo json_encode($data_array);
	}

	public function fetchLaporanKelurahan()
	{
		$this->admo->checkLoginAdmin();
		$data['dataUser']		= $this->admo->getDataUserAdmin();

        $nama_kelurahan = array();
		$jumlah_laporan = array();
		$jumlah_laporan_belum_divalidasi = array();
		$jumlah_laporan_valid = array();
		$jumlah_laporan_tidak_valid = array();
		
		$id_kecamatan = $data['dataUser']['id_kecamatan'];

		foreach ($this->lamo->getJmlLaporan($id_kecamatan) as $row) {
		    $nama_kelurahan[] = $row['nama_kelurahan'];
		    $jumlah_laporan[] = $row['jumlah_laporan'];
		    $jumlah_laporan_belum_divalidasi[] = $row['jumlah_laporan_belum_divalidasi'];
		    $jumlah_laporan_valid[] = $row['jumlah_laporan_valid'];
		    $jumlah_laporan_tidak_valid[] = $row['jumlah_laporan_tidak_valid'];
		}

		$data_array = array(
		    'nama_kelurahan_array' => $nama_kelurahan,
		    'jumlah_laporan_array' => $jumlah_laporan,
		    'jumlah_laporan_belum_divalidasi_array' => $jumlah_laporan_belum_divalidasi,
		    'jumlah_laporan_valid_array' => $jumlah_laporan_valid,
		    'jumlah_laporan_tidak_valid_array' => $jumlah_laporan_tidak_valid
		);

		echo json_encode($data_array);
	}

	public function profile()
	{
		$this->admo->checkLoginAdmin();

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['title'] 		= 'Profil - ' . $data['dataUser']['username'];
		$this->load->view('templates/header-admin', $data);
		$this->load->view('admin/profile', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function changePassword()
	{
		$this->admo->checkLoginAdmin();

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['title'] 		= 'Ganti Password - ' . $data['dataUser']['username'];
		$this->form_validation->set_rules('old_password', 'Password Lama', 'required|trim');
		$this->form_validation->set_rules('new_password', 'Password Baru', 'required|trim|min_length[3]|matches[verify_new_password]');
		$this->form_validation->set_rules('verify_new_password', 'Verifikasi Password Baru', 'required|trim|min_length[3]|matches[new_password]');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
			$this->load->view('admin/change_password', $data);
			$this->load->view('templates/footer-admin', $data);
		} else {
		    $this->admo->changePassword();
		}
	}

	public function editProfile()
	{
		$this->admo->checkLoginAdmin();

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['title'] 		= 'Ubah Profil - ' . $data['dataUser']['username'];
		$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
		$this->form_validation->set_rules('no_telepon', 'No. Telepon', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
			$this->load->view('admin/edit_profile', $data);
			$this->load->view('templates/footer-admin', $data);
		} else {
		    $this->admo->editProfile();
		}
	}
}
