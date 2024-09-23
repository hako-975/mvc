<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidang_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('Log_model', 'lomo');
	}

	public function getBidang()
	{
		$this->db->order_by('nama_bidang', 'asc');
		return $this->db->get('bidang')->result_array();	
	}

	public function getBidangById($id_bidang)
	{
		return $this->db->get_where('bidang', ['id_bidang' => $id_bidang])->row_array();	
	}

	public function addBidang()
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba menambahkan bidang';
		$this->admo->userPrivilege('bidang', $isi_log_2);

		$data = [
			'nama_bidang' => htmlspecialchars($this->input->post('nama_bidang', true))
		];

		$this->db->insert('bidang', $data);

		$isi_log = 'Bidang ' . $data['nama_bidang'] . ' berhasil ditambahkan';
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('bidang');
	}

	public function editBidang($id_bidang)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba mengubah bidang dengan id ' . $id_bidang;
		$this->admo->userPrivilege('bidang', $isi_log_2);

		$data_bidang = $this->getBidangById($id_bidang);
		$nama_bidang  = $data_bidang['nama_bidang'];
		$data = [
			'nama_bidang' => htmlspecialchars($this->input->post('nama_bidang', true))
		];

		$this->db->update('bidang', $data, ['id_bidang' => $id_bidang]);

		$isi_log = 'Bidang ' . $nama_bidang . ' berhasil diubah menjadi ' . $data['nama_bidang'];
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('bidang');
	}

	public function removeBidang($id_bidang)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba menghapus bidang dengan id ' . $id_bidang;
		$this->admo->userPrivilege('bidang', $isi_log_2);

		$data_bidang = $this->getBidangById($id_bidang);
		$nama_bidang = $data_bidang['nama_bidang'];

		if (!$this->db->delete('bidang', ['id_bidang' => $id_bidang])) {
		    $isi_log = 'Bidang ' . $nama_bidang . ' gagal dihapus. Ada jenis laporan terkait';
		    $this->lomo->addLog($isi_log, $dataUser['id_user']);
		    $this->session->set_flashdata('message-failed', $isi_log);
		} else {
		    $isi_log = 'Bidang ' . $nama_bidang . ' berhasil dihapus';
		    $this->lomo->addLog($isi_log, $dataUser['id_user']);
		    $this->session->set_flashdata('message-success', $isi_log);
		}

		redirect('bidang'); 
	}
}