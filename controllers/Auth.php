<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model', 'aumo');
		$this->load->model('Laporan_model', 'lamo');
		$this->load->model('JenisLaporan_model', 'jelamo');
		$this->load->model('Kecamatan_model', 'kemo');
		$this->load->model('Bidang_model', 'bimo');
	}

	public function checkLogin()
	{
		if ($this->session->userdata('id_user')) 
		{
			redirect('admin');		
		}
	}

	function sidebar(&$data)
	{
	    $data['jenis_laporan'] = $this->jelamo->getJenisLaporan();
	    $data['kecamatan'] = $this->kemo->getKecamatan();
	    $data['bidang'] = $this->bimo->getBidang();
	}

	public function search()
	{
	    $this->checkLogin();
	    $keyword = $this->input->get('search');
	    $data['title'] = 'Pencarian: ' . $keyword;
	    $data['laporan_terbuka'] = $this->lamo->getLaporanTerbuka($keyword);
	    $this->sidebar($data);
	    
	    $this->load->view('templates/header-auth', $data);
	    $this->load->view('auth/index', $data);
	    $this->load->view('templates/footer-auth', $data);  
	}

	public function index()
	{
	    $this->checkLogin();

	    $data['title'] = 'Selamat Datang! Laporan Desa Kabupaten Bogor';
	    $data['laporan_terbuka'] = $this->lamo->getLaporanTerbuka();
	    $this->sidebar($data);
	    
	    $this->load->view('templates/header-auth', $data);
	    $this->load->view('auth/index', $data);
	    $this->load->view('templates/footer-auth', $data);  
	}

	public function detailLaporan($id_laporan = null)
	{
		$this->checkLogin();

		if ($id_laporan == null) {
			redirect('auth/index');
			exit;
		}

		$this->sidebar($data);
		$data['laporan_terbuka'] = $this->lamo->getLaporanTerbuka();
		$data['laporan']	= $this->lamo->getLaporanById($id_laporan);
		if ($data['laporan']['transparansi_laporan'] == 'Tertutup') {
			redirect('auth/index');
			exit;
		}
		$data['title']  	= 'Detail Laporan - ' . $data['laporan']['judul_laporan'];
		
	    $this->load->view('templates/header-auth', $data);
	    $this->load->view('auth/detail_laporan', $data);
	    $this->load->view('templates/footer-auth', $data);  
	}

	public function jenisLaporan($nama_jenis_laporan = "")
	{
		if ($nama_jenis_laporan == null) {
			redirect('auth/index');
			exit;
		}

		$this->checkLogin();
		$this->sidebar($data);
		$nama_jenis_laporan = urldecode($nama_jenis_laporan);
		$data['nama_jenis_laporan'] = $nama_jenis_laporan;
		$data['laporan_terbuka']	= $this->lamo->getLaporanTransparansiByJenisLaporan($nama_jenis_laporan);
		$data['title']  	= 'Jenis Laporan - ' . $nama_jenis_laporan;

	    $this->load->view('templates/header-auth', $data);
	    $this->load->view('auth/index', $data);
	    $this->load->view('templates/footer-auth', $data);  
	}

	public function bidang($id_bidang = "")
	{
		if ($id_bidang == null) {
			redirect('auth/index');
			exit;
		}

		$this->checkLogin();
		$this->sidebar($data);
		
		$bidang = $this->bimo->getBidangById($id_bidang);

		$data['nama_bidang'] = $bidang['nama_bidang'];
		$data['laporan_terbuka']	= $this->lamo->getLaporanTransparansiByIdBidang($id_bidang);
		$data['title']  	= 'Bidang Laporan - ' . $bidang['nama_bidang'];

	    $this->load->view('templates/header-auth', $data);
	    $this->load->view('auth/index', $data);
	    $this->load->view('templates/footer-auth', $data);  
	}

	public function kecamatan($nama_kecamatan = "")
	{
		if ($nama_kecamatan == null) {
			redirect('auth/index');
			exit;
		}

		$this->checkLogin();
		$this->sidebar($data);
		
		$nama_kecamatan = urldecode($nama_kecamatan);
		$data['nama_kecamatan'] = $nama_kecamatan;
		$data['laporan_terbuka']	= $this->lamo->getLaporanTransparansiByNamaKecamatan($nama_kecamatan);
		$data['title']  	= 'Kecamatan - ' . $nama_kecamatan;

	    $this->load->view('templates/header-auth', $data);
	    $this->load->view('auth/index', $data);
	    $this->load->view('templates/footer-auth', $data);  
	}

	public function login()
	{
		$this->checkLogin();

		$data['title'] = 'Laporan Desa Kabupaten Bogor - User Login';
		$this->sidebar($data);
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-auth', $data);
		    $this->load->view('auth/login', $data);
		    $this->load->view('templates/footer-auth', $data);  
		} else {
		    $this->aumo->loginAdmin();
		}
	}

	public function lupaPassword()
	{
		$this->checkLogin();

		$data['title'] = 'Lupa Password';
		$this->sidebar($data);
		$this->form_validation->set_rules('email', 'Email', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-auth', $data);
		    $this->load->view('auth/lupa_password', $data);
		    $this->load->view('templates/footer-auth', $data);  
		} else {
		    $this->aumo->lupaPassword();
		}
	}

	public function resetPassword()
	{
		$this->checkLogin();
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		if ($this->admo->getDataUserAdminByEmail($email)) {
			if ($this->admo->getUserTokenByToken($email, $token)) {
				$this->session->set_userdata('email_reset_password', $email);
				$this->session->set_userdata('token_reset_password', $token);
				$this->changePassword();
			}
			else
			{
				$isi_log = "Token tidak valid";
				$this->session->set_flashdata('message-failed', $isi_log);
				redirect('auth/login');	
			}
		}
		else
		{
			$isi_log = "Email tidak terdaftar";
			$this->session->set_flashdata('message-failed', $isi_log);
			redirect('auth/login');	
		}
	}

	public function changePassword()
	{
		if ($email = $this->session->userdata('email_reset_password') && $token = $this->session->userdata('token_reset_password')) {
			$data['title'] = 'Reset Password';
			$data['laporan_terbuka'] = $this->lamo->getLaporanTerbuka();
			$this->form_validation->set_rules('new_password', 'Password Baru', 'required|trim|min_length[3]|matches[verify_new_password]');
			$this->form_validation->set_rules('verify_new_password', 'Verifikasi Password Baru', 'required|trim|min_length[3]|matches[new_password]');
			if ($this->form_validation->run() == false) {
			    $this->load->view('templates/header-auth', $data);
			    $this->load->view('auth/reset_password', $data);
			    $this->load->view('templates/footer-auth', $data);  
			} else {
			    $this->aumo->changePassword();
			}
		} 
		else
		{
			redirect('auth/lupaPassword');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}
}