<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('User_model', 'usmo');
		$this->load->model('Bidang_model', 'bimo');
		$this->load->model('Kecamatan_model', 'kemo');
		$this->load->model('Kelurahan_model', 'kelmo');
		$this->load->model('JenisLaporan_model', 'jemo');

		$this->admo->checkLoginAdmin();
	}

	public function index()
	{
		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['title']  	= 'User';

		$data['user']	= $this->usmo->getUser();
		if ($data['dataUser']['jabatan'] == 'Kepala Desa') {
			$id_kelurahan = $data['dataUser']['id_kelurahan'];
			$data['user']	= $this->usmo->getUserByKelurahanId($id_kelurahan);
		}
	
		$this->load->view('templates/header-admin', $data);
		$this->load->view('user/index', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function addUser()
	{
		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['kelurahan']	= $this->kelmo->getKelurahan();
		$data['kecamatan']	= $this->kemo->getKecamatan();
		$data['bidang']		= $this->bimo->getBidang();
		$data['jenis_laporan']	= $this->jemo->getJenisLaporan();
		$data['title'] 		= 'Tambah User';
		$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[password_verify]');
		$this->form_validation->set_rules('password_verify', 'Verifikasi Password', 'required|trim|min_length[3]|matches[password]');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('no_telepon', 'No. Telepon', 'required|trim');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
		    $this->load->view('user/add_user', $data);
		    $this->load->view('templates/footer-admin', $data);  
		    $this->load->view('templates/include/form_kecamatan', $data);  
		} else {
		    $this->usmo->addUser();
		}
	}

	public function editUser($id_user = "")
	{
		if ($id_user == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['kelurahan']	= $this->kelmo->getKelurahan();
		$data['kecamatan']	= $this->kemo->getKecamatan();
		$data['bidang']		= $this->bimo->getBidang();
		$data['jenis_laporan']	= $this->jemo->getJenisLaporan();
		$data['user']  		= $this->usmo->getUserById($id_user);
		$data['title'] 		= 'Ubah User - ' . $data['user']['username'];
		
		if ($data['dataUser']['jabatan'] != 'Administrator') {
			if ($data['user']['jabatan'] == 'Kepala Desa') {
			 	echo "
					<script>
						window.history.back();
					</script>
				";
				exit;
			}
		}
		
		$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
		$this->form_validation->set_rules('no_telepon', 'No. Telepon', 'required|trim');
		$original_value = $this->db->query("SELECT email FROM user WHERE id_user = " . $id_user)->row()->email;
	    if($this->input->post('email') != $original_value) {
	       $is_unique =  '|is_unique[user.email]';
	    } else {
	       $is_unique =  '';
	    }
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email' . $is_unique);
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
		    $this->load->view('user/edit_user', $data);
		    $this->load->view('templates/footer-admin', $data);  
		    $this->load->view('templates/include/form_kecamatan', $data);  
		} else {
		    $this->usmo->editUser($id_user);
		}
	}

	public function removeUser($id_user = "")
	{
		if ($id_user == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$this->usmo->removeUser($id_user);
	}
}
