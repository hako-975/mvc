<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
	}

	public function loginAdmin()
	{
		$username = $this->input->post('username', true);
		$password = $this->input->post('password', true);

		// check username
		if ($dataUser = $this->admo->getDataUserAdminByUsername($username)) 
		{
			// check password
			if (password_verify($password, $dataUser['password'])) 
			{
				// check is_active
				if ($dataUser['is_active'] == 1) {
					$dataSession = [
						'id_user' => $dataUser['id_user']
					];

					$this->session->set_userdata($dataSession);
					redirect('admin');
				}
				else
				{
					$this->session->set_flashdata('message-failed', 'Gagal masuk, akun dinonaktifkan');
					redirect('auth/login');
				}
			}
			else
			{
				$this->session->set_flashdata('message-failed', 'Gagal masuk, password yang anda masukkan salah');
				redirect('auth/login');
			}
		}
		else
		{
			$this->session->set_flashdata('message-failed', 'Gagal masuk, username yang anda masukkan salah');
			redirect('auth/login');
		}
	}

	public function lupaPassword()
	{
		$email = $this->input->post('email');

		if ($this->admo->getDataUserAdminByEmail($email)) {
			$token = base64_encode(random_bytes(32));
		
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];

			$this->db->insert('user_token', $user_token);

			
			$this->_sendEmail($token, $email);
		}
		else
		{
			$this->session->set_flashdata('message-failed', 'Gagal reset password, email tidak terdaftar');
			redirect('auth/lupaPassword');
		}
	}

	public function changePassword()
	{
		if ($this->session->userdata('email_reset_password') && $this->session->userdata('token_reset_password')) {
			$email = $this->session->userdata('email_reset_password');
			$token = $this->session->userdata('token_reset_password');

			$new_password = password_hash($this->input->post('new_password', true), PASSWORD_DEFAULT);
			$data = [
				'password' => $new_password
			];

			$query = $this->db->update('user', $data, ['email' => $email]);

			$this->db->delete('user_token', ['email' => $email, 'token' => $token]);
			$isi_log = "Password berhasil direset";
			$this->lomo->addLog($isi_log, $this->admo->getDataUserAdminByEmail($email)['id_user']);
			$this->session->set_flashdata('message-success', $isi_log);
			$this->session->unset_userdata('email_reset_password');
			$this->session->unset_userdata('token_reset_password');
			redirect('auth/login');
		}
		else
		{
			redirect('auth/login');
		}
	}


	private function _sendEmail($token, $email)
	{
		$config = [
			'protocol' 	=> 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'laporankabupatenbogor@gmail.com',
			'smtp_pass' => 'aghwjuyrpjoszibb',
			'smtp_port' => 465,
			'mailtype' 	=> 'html',
			'charset' 	=> 'utf-8',
			'newline' 	=> "\r\n"
		];

		$this->load->library('email', $config);
		$this->email->initialize($config);
		$this->email->from('laporankabupatenbogor@gmail.com', 'Laporan Desa Kabupaten Bogor');
		$this->email->to($email);
		$this->email->subject('Reset Password - Laporan Desa Kabupaten Bogor');
		
		$current_hour = date('G');

		if ($current_hour >= 5 && $current_hour < 12) {
		    $greeting = 'Selamat Pagi,';
		} elseif ($current_hour >= 12 && $current_hour < 15) {
		    $greeting = 'Selamat Siang,';
		} elseif ($current_hour >= 15 && $current_hour < 18) {
		    $greeting = 'Selamat Sore,';
		} else {
		    $greeting = 'Selamat Malam,';
		}

		$message = $greeting . '<br><br>' .
       	'Anda telah meminta untuk reset password, klik tombol di bawah untuk membuat password baru:<br>' .
       	'<a href="'. base_url('auth/resetPassword?email=' . $email . '&token=' . urlencode($token)) .'">Reset Password</a><br><br>' .
       	'atau salin url dan buka di tab baru url berikut: <br><a href="'.base_url('auth/resetPassword?email=' . $email . '&token=' . urlencode($token)) .'">'.base_url('auth/resetPassword?email=' . $email . '&token=' . urlencode($token)) .'</a><br><br>' .
       	'Jika Anda tidak meminta untuk reset password, harap abaikan email ini.<br><br>' .
       	'Terima Kasih,<br>' .
       	'Administrator Laporan Desa Kabupaten Bogor';

		$this->email->message($message);
		
		if ($this->email->send()) {
			$this->session->set_flashdata('message-success', 'Cek email untuk mereset password');
			redirect('auth/lupaPassword');
		}
		else
		{
			$this->session->set_flashdata('message-failed', 'Gagal');
			redirect('auth/lupaPassword');
		}
	}
}