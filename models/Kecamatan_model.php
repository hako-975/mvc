<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('Log_model', 'lomo');
	}

	public function getKecamatan()
	{
		$this->db->order_by('nama_kecamatan', 'asc');
		return $this->db->get('kecamatan')->result_array();	
	}

	public function getKecamatanById($id_kecamatan)
	{
		return $this->db->get_where('kecamatan', ['id_kecamatan' => $id_kecamatan])->row_array();	
	}

	public function addKecamatan()
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba menambahkan kecamatan';
		$this->admo->userPrivilege('kecamatan', $isi_log_2);

		$data = [
			'nama_kecamatan' => ucwords(strtolower(htmlspecialchars($this->input->post('nama_kecamatan', true))))
		];

		$this->db->insert('kecamatan', $data);

		$isi_log = 'Kecamatan ' . $data['nama_kecamatan'] . ' berhasil ditambahkan';
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('kecamatan');
	}

	public function editKecamatan($id_kecamatan)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba mengubah kecamatan dengan id ' . $id_kecamatan;
		$this->admo->userPrivilege('kecamatan', $isi_log_2);

		$data_kecamatan = $this->getKecamatanById($id_kecamatan);
		$nama_kecamatan  = $data_kecamatan['nama_kecamatan'];
		$data = [
			'nama_kecamatan' => ucwords(strtolower(htmlspecialchars($this->input->post('nama_kecamatan', true))))
		];

		$this->db->update('kecamatan', $data, ['id_kecamatan' => $id_kecamatan]);

		$isi_log = 'Kecamatan ' . $nama_kecamatan . ' berhasil diubah menjadi ' . $data['nama_kecamatan'];
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('kecamatan');
	}

	public function removeKecamatan($id_kecamatan)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba menghapus kecamatan dengan id ' . $id_kecamatan;
		$this->admo->userPrivilege('kecamatan', $isi_log_2);

		$data_kecamatan = $this->getKecamatanById($id_kecamatan);
		$nama_kecamatan = $data_kecamatan['nama_kecamatan'];

		if (!$this->db->delete('kecamatan', ['id_kecamatan' => $id_kecamatan])) {
		    $isi_log = 'Kecamatan ' . $nama_kecamatan . ' gagal dihapus. Ada Kelurahan terkait';
		    $this->lomo->addLog($isi_log, $dataUser['id_user']);
		    $this->session->set_flashdata('message-failed', $isi_log);
		} else {
		    $isi_log = 'Kecamatan ' . $nama_kecamatan . ' berhasil dihapus';
		    $this->lomo->addLog($isi_log, $dataUser['id_user']);
		    $this->session->set_flashdata('message-success', $isi_log);
		}

		redirect('kecamatan'); 
	}
}