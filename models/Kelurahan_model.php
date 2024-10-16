<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelurahan_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('Log_model', 'lomo');
	}

	public function getKelurahan()
	{
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan');
		$this->db->order_by('nama_kelurahan', 'asc');
		return $this->db->get('kelurahan')->result_array();
	}

	public function getKelurahanByKecamatanId($id_kecamatan)
	{
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan');
		return $this->db->get_where('kelurahan', ['kelurahan.id_kecamatan' => $id_kecamatan])->result_array();	
	}

	public function getKelurahanById($id_kelurahan)
	{
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan');
		return $this->db->get_where('kelurahan', ['id_kelurahan' => $id_kelurahan])->row_array();	
	}

	public function addKelurahan()
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba menambahkan kelurahan';
		$this->admo->userPrivilege('kelurahan', $isi_log_2);

		$id_kecamatan = $this->input->post('id_kecamatan', true);
	    
	    if ($id_kecamatan == 0) {
	        $this->session->set_flashdata('message-failed', 'Kecamatan harus dipilih');
	        echo "
				<script>
					window.history.back();
				</script>
			";
	        exit;
	    }

		$data = [
			'nama_kelurahan' => ucwords(strtolower(htmlspecialchars($this->input->post('nama_kelurahan', true)))),
			'id_kecamatan'	 => $id_kecamatan
		];

		$this->db->insert('kelurahan', $data);

		$isi_log = 'Kelurahan/Desa ' . $data['nama_kelurahan'] . ' berhasil ditambahkan';
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('kelurahan');
	}

	public function editKelurahan($id_kelurahan)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba mengubah kelurahan dengan id ' . $id_kelurahan;
		$this->admo->userPrivilege('kelurahan', $isi_log_2);

		$data_kelurahan = $this->getKelurahanById($id_kelurahan);
		$nama_kelurahan = $data_kelurahan['nama_kelurahan'];
		
		$id_kecamatan = $this->input->post('id_kecamatan', true);
	    
	    if ($id_kecamatan == 0) {
	        $this->session->set_flashdata('message-failed', 'Kecamatan harus dipilih');
	        echo "
				<script>
					window.history.back();
				</script>
			";
	        exit;
	    }

		$data = [
			'nama_kelurahan' => ucwords(strtolower(htmlspecialchars($this->input->post('nama_kelurahan', true)))),
			'id_kecamatan'	 => $id_kecamatan
		];

		$this->db->update('kelurahan', $data, ['id_kelurahan' => $id_kelurahan]);

		$isi_log = 'Kelurahan/Desa ' . $nama_kelurahan . ' berhasil diubah menjadi ' . $data['nama_kelurahan'];
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('kelurahan');
	}

	public function removeKelurahan($id_kelurahan)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba menghapus kelurahan dengan id ' . $id_kelurahan;
		$this->admo->userPrivilege('kelurahan', $isi_log_2);

		$data_kelurahan = $this->getKelurahanById($id_kelurahan);
		$nama_kelurahan  = $data_kelurahan['nama_kelurahan'];
		
		if (!$this->db->delete('kelurahan', ['id_kelurahan' => $id_kelurahan])) {
			$isi_log = 'Kelurahan/Desa ' . $nama_kelurahan . ' gagal dihapus. Ada Laporan terkait';
			$this->lomo->addLog($isi_log, $dataUser['id_user']);
			$this->session->set_flashdata('message-failed', $isi_log);
		}
		else
		{
			$isi_log = 'Kelurahan/Desa ' . $nama_kelurahan . ' berhasil dihapus';
			$this->lomo->addLog($isi_log, $dataUser['id_user']);
			$this->session->set_flashdata('message-success', $isi_log);
		}
		redirect('kelurahan'); 
	}
}
