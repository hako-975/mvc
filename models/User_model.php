<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('Log_model', 'lomo');
	}

	public function getUser()
	{
		$this->db->join('kelurahan', 'user.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'user.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('jenis_laporan', 'user.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->order_by('jabatan', 'asc');
		return $this->db->get('user')->result_array();

	}

	public function getUserByKecamatanId($id_kecamatan = "")
	{
		$this->db->join('kelurahan', 'user.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'user.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('jenis_laporan', 'user.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->order_by('jabatan', 'asc');
		return $this->db->get_where('user', ['kecamatan.id_kecamatan' => $id_kecamatan])->result_array();
	}

	public function getUserByKelurahanId($id_kelurahan = "")
	{
		$this->db->join('kelurahan', 'user.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('jenis_laporan', 'user.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->order_by('jabatan', 'asc');
		return $this->db->get_where('user', ['kelurahan.id_kelurahan' => $id_kelurahan])->result_array();
	}

	public function getUserById($id_user)
	{
		$this->db->join('kelurahan', 'user.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'user.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('jenis_laporan', 'user.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		return $this->db->get_where('user', ['id_user' => $id_user])->row_array();	
	}

	public function addUser()
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'Pengguna ' . $dataUser['username'] . ' mencoba menambahkan user';
		$this->admo->userPrivilegeDesa('user', $isi_log_2);
		
		$is_active = 0;
		if ($this->input->post('is_active', true) == "on") {
			$is_active = 1;
		}
		else
		{
			$is_active = 0;
		}

		$jabatan = htmlspecialchars($this->input->post('jabatan', true));

		if ($dataUser['jabatan'] == 'Kepala Desa') {
			$id_kecamatan = $dataUser['id_kecamatan'];
	    	$id_kelurahan = $dataUser['id_kelurahan'];
		} else {
			$id_kecamatan = htmlspecialchars($this->input->post('id_kecamatan', true));
	    	$id_kelurahan = htmlspecialchars($this->input->post('id_kelurahan', true));
	    	$id_bidang = htmlspecialchars($this->input->post('id_bidang', true));
		}

	    $id_jenis_laporan = htmlspecialchars($this->input->post('id_jenis_laporan', true));

    	if ($jabatan == "0") {
	        $this->session->set_flashdata('message-failed', 'Jabatan harus dipilih');
	        echo "
				<script>
					window.history.back();
				</script>
			";
	        exit;
	    }

	    if ($jabatan == "Kepala Bidang") {
			if ($id_bidang == 0) {
		        $this->session->set_flashdata('message-failed', 'Bidang harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }
		}


		if ($jabatan == "Operator Desa") {
			if ($id_kecamatan == 0) {
		        $this->session->set_flashdata('message-failed', 'Kecamatan harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }

			if ($id_kelurahan == 0) {
		        $this->session->set_flashdata('message-failed', 'Kelurahan/Desa harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }

			if ($id_jenis_laporan == 0) {
		        $this->session->set_flashdata('message-failed', 'Jenis Laporan harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }
		}

		if ($jabatan == "Kepala Desa") {
			if ($id_kecamatan == 0) {
		        $this->session->set_flashdata('message-failed', 'Kecamatan harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }

			if ($id_kelurahan == 0) {
		        $this->session->set_flashdata('message-failed', 'Kelurahan/Desa harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }
		}

		if ($jabatan == "Camat") {
			if ($id_kecamatan == 0) {
		        $this->session->set_flashdata('message-failed', 'Kecamatan harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }
		}


		$data = [
			'nama_lengkap' 	=> ucwords($this->input->post('nama_lengkap', true)),
			'username' 		=> htmlspecialchars($this->input->post('username', true)),
			'password'		=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
			'no_telepon'	=> htmlspecialchars($this->input->post('no_telepon', true)),
			'email'			=> htmlspecialchars($this->input->post('email', true)),
			'jabatan'		=> $jabatan,
			'id_kecamatan'	=> $id_kecamatan,
			'id_kelurahan'	=> $id_kelurahan,
			'id_bidang'		=> $id_bidang,
			'id_jenis_laporan'	=> $id_jenis_laporan,
			'is_active' 	=> $is_active
		];

		$this->db->insert('user', $data);

		$isi_log = 'Pengguna ' . $data['username'] . ' dengan jabatan ' . $data['jabatan'] . ' berhasil ditambahkan';
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('user');
	}

	public function editUser($id_user)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'Pengguna ' . $dataUser['username'] . ' mencoba mengubah user dengan id ' . $id_user;
		$this->admo->userPrivilegeDesa('user', $isi_log_2);

		$data_user = $this->getUserById($id_user);
		$username  = $data_user['username'];

		$is_active = 0;
		if ($this->input->post('is_active', true) == "on") {
			$is_active = 1;
		}
		else
		{
			$is_active = 0;
		}

		$jabatan = htmlspecialchars($this->input->post('jabatan', true));

		$id_kecamatan = htmlspecialchars($this->input->post('id_kecamatan', true));
	    $id_kelurahan = htmlspecialchars($this->input->post('id_kelurahan', true));
	    $id_jenis_laporan = htmlspecialchars($this->input->post('id_jenis_laporan', true));

		if ($jabatan == "Operator Desa") {
			if ($id_kecamatan == 0) {
		        $this->session->set_flashdata('message-failed', 'Kecamatan harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }

			if ($id_kelurahan == 0) {
		        $this->session->set_flashdata('message-failed', 'Kelurahan/Desa harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }

			if ($id_jenis_laporan == 0) {
		        $this->session->set_flashdata('message-failed', 'Jenis Laporan harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }
		}

		if ($jabatan == "Kepala Desa") {
			if ($id_kecamatan == 0) {
		        $this->session->set_flashdata('message-failed', 'Kecamatan harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }

			if ($id_kelurahan == 0) {
		        $this->session->set_flashdata('message-failed', 'Kelurahan/Desa harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }
		}

		if ($jabatan == "Camat") {
			if ($id_kecamatan == 0) {
		        $this->session->set_flashdata('message-failed', 'Kecamatan harus dipilih');
		        echo "
					<script>
						window.history.back();
					</script>
				";
		        exit;
		    }
		}
		
		$data = [
			'nama_lengkap' 	=> ucwords($this->input->post('nama_lengkap', true)),
			'username' 		=> htmlspecialchars($this->input->post('username', true)),
			'no_telepon'	=> htmlspecialchars($this->input->post('no_telepon', true)),
			'email'			=> htmlspecialchars($this->input->post('email', true)),
			'jabatan'		=> $jabatan,
			'id_kecamatan'	=> $id_kecamatan,
			'id_kelurahan'	=> $id_kelurahan,
			'id_jenis_laporan'	=> $id_jenis_laporan,
			'is_active' 	=> $is_active
		];

		$this->db->update('user', $data, ['id_user' => $id_user]);

		$isi_log = 'Pengguna ' . $username . ' berhasil diubah';
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('user');
	}

	public function removeUser($id_user)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'Pengguna ' . $dataUser['username'] . ' mencoba menghapus user dengan id ' . $id_user;
		$this->admo->userPrivilege('user', $isi_log_2);

		
		$data_user = $this->getUserById($id_user);
		$username  = $data_user['username'];

		if (!$this->db->delete('user', ['id_user' => $id_user])) {
		    $isi_log = 'Pengguna ' . $username . ' gagal dihapus. Ada Laporan terkait';
			$this->lomo->addLog($isi_log, $dataUser['id_user']);
			$this->session->set_flashdata('message-failed', $isi_log);
		} else {
			$isi_log = 'Pengguna ' . $username . ' berhasil dihapus';
			$this->lomo->addLog($isi_log, $dataUser['id_user']);
			$this->session->set_flashdata('message-success', $isi_log);
		}

		redirect('user'); 
	}
}