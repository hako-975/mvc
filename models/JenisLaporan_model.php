<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JenisLaporan_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('Log_model', 'lomo');
	}

	public function getJenisLaporan()
	{
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang');
		$this->db->order_by('jenis_laporan', 'asc');
		return $this->db->get('jenis_laporan')->result_array();	
	}

	public function getJenisLaporanById($id_jenis_laporan)
	{
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang');
		return $this->db->get_where('jenis_laporan', ['jenis_laporan.id_jenis_laporan' => $id_jenis_laporan])->row_array();	
	}

	public function getJenisLaporanByJenisLaporan($jenis_laporan)
	{
		return $this->db->get_where('jenis_laporan', ['jenis_laporan' => $jenis_laporan])->row_array();	
	}

	public function getJenisLaporanByBidangId($id_bidang)
	{
		$this->db->order_by('jenis_laporan', 'asc');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang');
		return $this->db->get_where('jenis_laporan', ['jenis_laporan.id_bidang' => $id_bidang])->result_array();	
	}

	public function addJenisLaporan()
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba menambahkan jenis_laporan';
		$this->admo->userPrivilege('jenis_laporan', $isi_log_2);
		
		$id_bidang = $this->input->post('id_bidang', true);
	    
	    if ($id_bidang == 0) {
	        $this->session->set_flashdata('message-failed', 'Bidang harus dipilih');
	        echo "
				<script>
					window.history.back();
				</script>
			";
	        exit;
	    }

		$data = [
			'jenis_laporan' => htmlspecialchars($this->input->post('jenis_laporan', true)),
			'id_bidang' => $id_bidang
		];

		$this->db->insert('jenis_laporan', $data);

		$isi_log = 'Jenis Laporan ' . $data['jenis_laporan'] . ' berhasil ditambahkan';
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('jenisLaporan');
	}

	public function editJenisLaporan($id_jenis_laporan)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba mengubah jenis_laporan dengan id ' . $id_jenis_laporan;
		$this->admo->userPrivilege('jenis_laporan', $isi_log_2);

		$data_jenis_laporan = $this->getJenisLaporanById($id_jenis_laporan);
		$jenis_laporan  = $data_jenis_laporan['jenis_laporan'];

		$id_bidang = $this->input->post('id_bidang', true);
	    
	    if ($id_bidang == 0) {
	        $this->session->set_flashdata('message-failed', 'Bidang harus dipilih');
	        echo "
				<script>
					window.history.back();
				</script>
			";
	        exit;
	    }

		$data = [
			'jenis_laporan'	=> htmlspecialchars($this->input->post('jenis_laporan', true)),
			'id_bidang' => $id_bidang
		];

		$this->db->update('jenis_laporan', $data, ['id_jenis_laporan' => $id_jenis_laporan]);

		$isi_log = 'Jenis Laporan ' . $jenis_laporan . ' berhasil diubah menjadi ' . $data['jenis_laporan'];
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('jenisLaporan');
	}

	public function removeJenisLaporan($id_jenis_laporan)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba menghapus Jenis Laporan dengan id ' . $id_jenis_laporan;
		$this->admo->userPrivilege('jenis_laporan', $isi_log_2);

		$data_jenis_laporan = $this->getJenisLaporanById($id_jenis_laporan);
		$jenis_laporan  = $data_jenis_laporan['jenis_laporan'];
		
		if (!$this->db->delete('jenis_laporan', ['id_jenis_laporan' => $id_jenis_laporan])) {
			$isi_log = 'Jenis Laporan ' . $jenis_laporan . ' gagal dihapus. Ada Laporan terkait';
			$this->lomo->addLog($isi_log, $dataUser['id_user']);
			$this->session->set_flashdata('message-failed', $isi_log);
		} else {
			$isi_log = 'Jenis Laporan ' . $jenis_laporan . ' berhasil dihapus';
			$this->lomo->addLog($isi_log, $dataUser['id_user']);
			$this->session->set_flashdata('message-success', $isi_log);
		}

		redirect('jenisLaporan'); 
	}
}