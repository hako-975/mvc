<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('Log_model', 'lomo');
	}

	public function getLaporan()
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->order_by('tgl_laporan', 'desc');
		return $this->db->get('laporan')->result_array();
	}

	public function getLaporanBelumDivalidasi()
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->order_by('tgl_laporan', 'desc');
		$this->db->where('laporan.status_laporan', 'Belum Divalidasi');
		return $this->db->get('laporan')->result_array();
	}

	public function getLaporanTerbuka($keyword = '')
	{
	    $this->db->select('laporan.*, user.username, jenis_laporan.jenis_laporan, kelurahan.nama_kelurahan, kecamatan.nama_kecamatan, bidang.nama_bidang, transparansi_laporan.tgl_transparansi_laporan');
	    $this->db->from('laporan');
	    $this->db->join('user', 'laporan.id_user=user.id_user', 'left');
	    $this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
	    $this->db->join('transparansi_laporan', 'laporan.id_laporan=transparansi_laporan.id_laporan', 'left');
	    $this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
	    $this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
	    $this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
	    
	    // Apply keyword search
	    if ($keyword != '') {
	        $this->db->group_start(); // Open group
	        $this->db->like('laporan.judul_laporan', $keyword);
	        $this->db->or_like('laporan.uraian_laporan', $keyword);
	        $this->db->or_like('user.username', $keyword);
	        $this->db->or_like('jenis_laporan.jenis_laporan', $keyword);
	        $this->db->or_like('kelurahan.nama_kelurahan', $keyword);
	        $this->db->or_like('kecamatan.nama_kecamatan', $keyword);
	        $this->db->or_like('bidang.nama_bidang', $keyword);
	        $this->db->or_like('laporan.tgl_laporan', $keyword);
	        $this->db->group_end(); // Close group
	    }

	    // Apply where conditions
	    $this->db->where('laporan.status_laporan', 'Valid');
	    $this->db->where('laporan.transparansi_laporan', 'Terbuka');
	    
	    // Order by and group by
	    $this->db->order_by('transparansi_laporan.tgl_transparansi_laporan', 'desc');
	    $this->db->group_by('laporan.id_laporan');
	    
	    // Execute the query
	    return $this->db->get()->result_array();
	}


	public function getLaporanTerbukaJenisLaporan()
	{
	    $this->db->join('user', 'laporan.id_user=user.id_user', 'left');
	    $this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
	    $this->db->join('transparansi_laporan', 'laporan.id_laporan=transparansi_laporan.id_laporan', 'left');
	    $this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
	    $this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
	    $this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
	    $this->db->where(['laporan.status_laporan' => 'Valid', 'laporan.transparansi_laporan' => 'Terbuka']);
	    $this->db->order_by('jenis_laporan.jenis_laporan', 'asc');
	    $this->db->group_by('jenis_laporan.id_jenis_laporan');

	    return $this->db->get('laporan')->result_array();
	}

	public function getFileLaporanById($id_laporan)
	{
		return $this->db->get_where('file_laporan', ['id_laporan' => $id_laporan])->result_array();
	}

	public function getLaporanByIdKecamatan($id_kecamatan = "", $nama_jenis_laporan = "")
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->order_by('tgl_laporan', 'desc');
		
		if ($id_kecamatan != "") {
	        $this->db->where('kecamatan.id_kecamatan', $id_kecamatan);
	    }
	    if ($nama_jenis_laporan != "") {
	        $this->db->where('jenis_laporan.jenis_laporan', $nama_jenis_laporan);
	    }

		return $this->db->get('laporan')->result_array();
	}

	public function getLaporanBelumDivalidasiByIdKecamatan($id_kecamatan = "", $nama_jenis_laporan = "")
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->where('laporan.status_laporan', 'Belum Divalidasi');
		$this->db->order_by('tgl_laporan', 'desc');
		
		if ($id_kecamatan != "") {
	        $this->db->where('kecamatan.id_kecamatan', $id_kecamatan);
	    }
	    if ($nama_jenis_laporan != "") {
	        $this->db->where('jenis_laporan.jenis_laporan', $nama_jenis_laporan);
	    }

		return $this->db->get('laporan')->result_array();
	}

	public function getLaporanByIdKelurahan($id_kelurahan = "", $nama_jenis_laporan = "")
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->order_by('tgl_laporan', 'desc');
		
		if ($id_kelurahan != "") {
	        $this->db->where('kelurahan.id_kelurahan', $id_kelurahan);
	    }
	    if ($nama_jenis_laporan != "") {
	        $this->db->where('jenis_laporan.jenis_laporan', $nama_jenis_laporan);
	    }

		return $this->db->get('laporan')->result_array();
	}

	public function getLaporanBelumDivalidasiByIdKelurahan($id_kelurahan = "", $nama_jenis_laporan = "")
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->order_by('tgl_laporan', 'desc');
		
		if ($id_kelurahan != "") {
	        $this->db->where('kelurahan.id_kelurahan', $id_kelurahan);
	    }
	    if ($nama_jenis_laporan != "") {
	        $this->db->where('jenis_laporan.jenis_laporan', $nama_jenis_laporan);
	    }

		$this->db->where('laporan.status_laporan', 'Belum Divalidasi');

		return $this->db->get('laporan')->result_array();
	}


	public function getLaporanByIdUser($id_user = "", $id_kelurahan = "", $nama_jenis_laporan = "")
	{
	    $this->db->join('user', 'laporan.id_user=user.id_user', 'left');
	    $this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
	    $this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
	    $this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
	    $this->db->order_by('tgl_laporan', 'desc');

	    if ($id_kelurahan != "") {
	        $this->db->where('kelurahan.id_kelurahan', $id_kelurahan);
	    }
	    if ($nama_jenis_laporan != "") {
	        $this->db->where('jenis_laporan.jenis_laporan', $nama_jenis_laporan);
	    }
	    if ($id_user != "") {
	        $this->db->where('laporan.id_user', $id_user);
	    }

	    return $this->db->get('laporan')->result_array();
	}

	public function getLaporanByIdBidang($id_bidang, $id_kecamatan = "", $id_kelurahan = "", $nama_jenis_laporan = "")
	{
	    $this->db->join('user', 'laporan.id_user=user.id_user', 'left');
	    $this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
	    $this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
	    $this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
	    $this->db->order_by('tgl_laporan', 'desc');

	    if ($id_bidang != "") {
	        $this->db->where('jenis_laporan.id_bidang', $id_bidang);
	    }

	    if ($id_kecamatan != "") {
	        $this->db->where('kecamatan.id_kecamatan', $id_kecamatan);
	    }
	    
	    if ($id_kelurahan != "") {
	        $this->db->where('kelurahan.id_kelurahan', $id_kelurahan);
	    }

	    if ($nama_jenis_laporan != "") {
	        $this->db->where('jenis_laporan.jenis_laporan', $nama_jenis_laporan);
	    }

	    return $this->db->get('laporan')->result_array();
	}

	public function getLaporanBelumDivalidasiByIdBidang($id_bidang, $id_kecamatan = "", $id_kelurahan = "", $nama_jenis_laporan = "")
	{
	    $this->db->join('user', 'laporan.id_user=user.id_user', 'left');
	    $this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
	    $this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
	    $this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
	    $this->db->order_by('tgl_laporan', 'desc');

	    if ($id_bidang != "") {
	        $this->db->where('jenis_laporan.id_bidang', $id_bidang);
	    }

	    if ($id_kecamatan != "") {
	        $this->db->where('kecamatan.id_kecamatan', $id_kecamatan);
	    }
	    
	    if ($id_kelurahan != "") {
	        $this->db->where('kelurahan.id_kelurahan', $id_kelurahan);
	    }

	    if ($nama_jenis_laporan != "") {
	        $this->db->where('jenis_laporan.jenis_laporan', $nama_jenis_laporan);
	    }

		$this->db->where('laporan.status_laporan', 'Belum Divalidasi');

	    return $this->db->get('laporan')->result_array();
	}

	public function getLaporanFilter($dari_tgl, $sampai_tgl, $id_kecamatan, $id_kelurahan, $id_jenis_laporan, $status_laporan)
	{
		$dari_tgl = date("Y-m-d\T00:00:01", strtotime($dari_tgl));
		$sampai_tgl = date("Y-m-d\T23:59:59", strtotime($sampai_tgl));

		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->order_by('id_laporan', 'desc');

		$filter_conditions = [
		    'tgl_laporan >=' => $dari_tgl,
		    'tgl_laporan <=' => $sampai_tgl
		];

		if ($id_kecamatan != 0) {
		    $filter_conditions['kecamatan.id_kecamatan'] = $id_kecamatan;
		}

		if ($id_kelurahan != 0) {
		    $filter_conditions['laporan.id_kelurahan'] = $id_kelurahan;
		}

		if ($id_jenis_laporan != 0) {
		    $filter_conditions['laporan.id_jenis_laporan'] = $id_jenis_laporan;
		}

		if ($status_laporan != "Semua") {
		    $filter_conditions['status_laporan'] = $status_laporan;
		}

		return $this->db->get_where('laporan', $filter_conditions)->result_array();
	}

	public function getLaporanFilterByIdUser($id_user, $dari_tgl, $sampai_tgl, $id_kecamatan, $id_kelurahan, $id_jenis_laporan, $status_laporan)
	{
		$dari_tgl = date("Y-m-d\T00:00:01", strtotime($dari_tgl));
		$sampai_tgl = date("Y-m-d\T23:59:59", strtotime($sampai_tgl));

		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->order_by('id_laporan', 'desc');

		$filter_conditions = [
		    'tgl_laporan >=' => $dari_tgl,
		    'tgl_laporan <=' => $sampai_tgl,
		    'laporan.id_user' => $id_user
		];

		if ($id_kecamatan != 0) {
		    $filter_conditions['kecamatan.id_kecamatan'] = $id_kecamatan;
		}

		if ($id_kelurahan != 0) {
		    $filter_conditions['laporan.id_kelurahan'] = $id_kelurahan;
		}

		if ($id_jenis_laporan != 0) {
		    $filter_conditions['laporan.id_jenis_laporan'] = $id_jenis_laporan;
		}

		if ($status_laporan != "Semua") {
		    $filter_conditions['status_laporan'] = $status_laporan;
		}

		return $this->db->get_where('laporan', $filter_conditions)->result_array();

	}

	public function getLaporanFilterByIdBidang($dari_tgl, $sampai_tgl, $id_kecamatan, $id_kelurahan, $id_bidang, $id_jenis_laporan, $status_laporan)
	{
		$dari_tgl = date("Y-m-d\T00:00:01", strtotime($dari_tgl));
		$sampai_tgl = date("Y-m-d\T23:59:59", strtotime($sampai_tgl));

		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->order_by('id_laporan', 'desc');

		$filter_conditions = [
		    'tgl_laporan >=' => $dari_tgl,
		    'tgl_laporan <=' => $sampai_tgl,
		    'jenis_laporan.id_bidang' => $id_bidang
		];

		if ($id_kecamatan != 0) {
		    $filter_conditions['kecamatan.id_kecamatan'] = $id_kecamatan;
		}

		if ($id_kelurahan != 0) {
		    $filter_conditions['laporan.id_kelurahan'] = $id_kelurahan;
		}

		if ($id_jenis_laporan != 0) {
		    $filter_conditions['laporan.id_jenis_laporan'] = $id_jenis_laporan;
		}

		if ($status_laporan != "Semua") {
		    $filter_conditions['status_laporan'] = $status_laporan;
		}

		return $this->db->get_where('laporan', $filter_conditions)->result_array();

	}

	public function getLaporanById($id_laporan)
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->order_by('tgl_laporan', 'desc');
		return $this->db->get_where('laporan', ['id_laporan' => $id_laporan])->row_array();	
	}

	public function getRevisiLaporanById($id_laporan)
	{
		$this->db->join('user', 'revisi_laporan.id_user=user.id_user', 'left');
		$this->db->order_by('id_revisi_laporan', 'asc');
		return $this->db->get_where('revisi_laporan', ['id_laporan' => $id_laporan])->result_array();
	}

	public function getValidasiLaporanById($id_laporan)
	{
		$this->db->join('user', 'validasi_laporan.id_user=user.id_user', 'left');
		$this->db->order_by('id_validasi_laporan', 'asc');
		return $this->db->get_where('validasi_laporan', ['id_laporan' => $id_laporan])->row_array();
	}

	public function getLaporanByKeyword($search)
	{
	    $this->db->join('user', 'laporan.id_user=user.id_user', 'left');
	    $this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
	    $this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
	    $this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
	    $this->db->join('file_laporan', 'laporan.id_laporan=file_laporan.id_laporan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');


	    $this->db->like('laporan.id_laporan', $search);
	    $this->db->or_like('judul_laporan', $search);
	    $this->db->or_like('tgl_laporan', $search);
	    $this->db->or_like('tahun_kegiatan', $search);
	    $this->db->or_like('status_laporan', $search);
	    $this->db->or_like('jenis_laporan.jenis_laporan', $search);
	    $this->db->or_like('file_laporan.file_laporan', $search);
	    $this->db->or_like('kelurahan.nama_kelurahan', $search);
	    $this->db->or_like('kecamatan.nama_kecamatan', $search);
	    $this->db->or_like('user.username', $search);
		$this->db->order_by('tgl_laporan', 'desc');

	    return $this->db->get('laporan')->result_array();
	}

	public function getLaporanByJenisLaporan($jenis_laporan)
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->order_by('tgl_laporan', 'desc');
		return $this->db->get_where('laporan', ['jenis_laporan' => $jenis_laporan])->result_array();	
	}

	public function getLaporanTransparansiByJenisLaporan($jenis_laporan)
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->join('transparansi_laporan', 'laporan.id_laporan=transparansi_laporan.id_laporan', 'left');
		$this->db->order_by('transparansi_laporan.tgl_transparansi_laporan', 'desc');
		$this->db->group_by('laporan.id_laporan');
		return $this->db->get_where('laporan', ['jenis_laporan' => $jenis_laporan, 'transparansi_laporan' => 'Terbuka'])->result_array();	
	}

	public function getLaporanTransparansiByNamaKecamatan($nama_kecamatan)
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->join('transparansi_laporan', 'laporan.id_laporan=transparansi_laporan.id_laporan', 'left');
		$this->db->order_by('transparansi_laporan.tgl_transparansi_laporan', 'desc');
		$this->db->group_by('laporan.id_laporan');
		return $this->db->get_where('laporan', ['kecamatan.nama_kecamatan' => $nama_kecamatan, 'transparansi_laporan' => 'Terbuka'])->result_array();	
	}

	public function getLaporanTransparansiByIdBidang($id_bidang)
	{
		$this->db->join('user', 'laporan.id_user=user.id_user', 'left');
		$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan=jenis_laporan.id_jenis_laporan', 'left');
		$this->db->join('kelurahan', 'laporan.id_kelurahan=kelurahan.id_kelurahan', 'left');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'left');
		$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang', 'left');
		$this->db->join('transparansi_laporan', 'laporan.id_laporan=transparansi_laporan.id_laporan', 'left');
		$this->db->order_by('transparansi_laporan.tgl_transparansi_laporan', 'desc');
		$this->db->group_by('laporan.id_laporan');
		return $this->db->get_where('laporan', ['bidang.id_bidang' => $id_bidang, 'transparansi_laporan' => 'Terbuka'])->result_array();	
	}




	public function getJmlLaporan($id_kecamatan = "")
	{
		$this->db->select('kecamatan.*');
		$this->db->select('kelurahan.*');
		$this->db->select('COUNT(laporan.id_laporan) as jumlah_laporan');

		$this->db->select('SUM(CASE WHEN laporan.status_laporan = "Belum Divalidasi" THEN 1 ELSE 0 END) AS jumlah_laporan_belum_divalidasi');
		$this->db->select('SUM(CASE WHEN laporan.status_laporan = "Valid" THEN 1 ELSE 0 END) AS jumlah_laporan_valid');
		$this->db->select('SUM(CASE WHEN laporan.status_laporan = "Tidak Valid" THEN 1 ELSE 0 END) AS jumlah_laporan_tidak_valid');

		$this->db->join('kelurahan', 'kecamatan.id_kecamatan = kelurahan.id_kecamatan', 'left');
		$this->db->join('laporan', 'kelurahan.id_kelurahan = laporan.id_kelurahan', 'left');
		$this->db->group_by('kecamatan.id_kecamatan');

		if ($id_kecamatan != "") {
			$this->db->group_by('kelurahan.id_kelurahan');
	        $this->db->where('kecamatan.id_kecamatan', $id_kecamatan);
	    }
		$this->db->order_by('tgl_laporan', 'desc');

		return $this->db->get('kecamatan')->result_array();
	}

	public function getJmlLaporanKelurahan($id_kelurahan = "")
	{
		$this->db->select('kelurahan.*');
		$this->db->select('laporan.*');
		$this->db->select('COUNT(laporan.id_laporan) as jumlah_laporan');
		$this->db->select('SUM(CASE WHEN laporan.status_laporan = "Belum Divalidasi" THEN 1 ELSE 0 END) AS jumlah_laporan_belum_divalidasi');
		$this->db->select('SUM(CASE WHEN laporan.status_laporan = "Valid" THEN 1 ELSE 0 END) AS jumlah_laporan_valid');
		$this->db->select('SUM(CASE WHEN laporan.status_laporan = "Tidak Valid" THEN 1 ELSE 0 END) AS jumlah_laporan_tidak_valid');

		$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
		$this->db->group_by('laporan.id_laporan');

		$this->db->order_by('tgl_laporan', 'desc');
		return $this->db->get_where('laporan', ['laporan.id_kelurahan' => $id_kelurahan])->result_array();
	}

	public function transparansiLaporan($id_laporan)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		
		$data_status = [
			'transparansi_laporan' => $this->input->post('transparansi_laporan', true)
		];

		$this->db->update('laporan', $data_status, ['id_laporan' => $id_laporan]);

		$data = [
			'tgl_transparansi_laporan' 	=> date('Y-m-d\TH:i:s'),
			'id_laporan' 			=> $id_laporan,
			'id_user'				=> $dataUser['id_user']
		];
		
		$this->db->insert('transparansi_laporan', $data);

		$isi_log = 'Laporan ' . $data['judul_laporan'] . ' berhasil ditransparansi oleh ' . $dataUser['username'];
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('laporan/detailLaporan/' . $id_laporan);
	}

	public function addLaporan()
	{
	    $dataUser = $this->admo->getDataUserAdmin();
	    $isi_log_2 = 'Pengguna ' . $dataUser['username'] . ' mencoba menambahkan laporan';
	    $this->admo->userPrivilegeDesa('admin', $isi_log_2);

	    $id_jenis_laporan = $this->input->post('id_jenis_laporan', true);

	    if ($id_jenis_laporan == 0) {
	        $this->session->set_flashdata('message-failed', 'Jenis Laporan harus dipilih');
	        echo "
	            <script>
	                window.history.back();
	            </script>
	        ";
	        exit;
	    }

	    $id_kelurahan = $this->input->post('id_kelurahan', true);

	    if ($id_kelurahan == 0) {
	        $this->session->set_flashdata('message-failed', 'Kelurahan harus dipilih');
	        echo "
	            <script>
	                window.history.back();
	            </script>
	        ";
	        exit;
	    }

	    $data = [
	        'judul_laporan'    => htmlspecialchars($this->input->post('judul_laporan', true)),
	        'uraian_laporan'   => htmlspecialchars($this->input->post('uraian_laporan', true)),
	        'tgl_laporan'      => htmlspecialchars($this->input->post('tgl_laporan', true)),
	        'tahun_kegiatan'   => htmlspecialchars($this->input->post('tahun_kegiatan', true)),
	        'id_jenis_laporan' => $id_jenis_laporan,
	        'id_kelurahan'     => $id_kelurahan,
	        'id_user'          => $dataUser['id_user']
	    ];

	    $countFiles = count($_FILES['file_laporan']['name']);
	    $uploadedFiles = [];

	    for($i = 0; $i < $countFiles; $i++) {
	        $_FILES['uploadFile']['name'] = $_FILES['file_laporan']['name'][$i]; 
	        $_FILES['uploadFile']['type'] = $_FILES['file_laporan']['type'][$i];
	        $_FILES['uploadFile']['size'] = $_FILES['file_laporan']['size'][$i];
	        $_FILES['uploadFile']['tmp_name'] = $_FILES['file_laporan']['tmp_name'][$i];
	        $_FILES['uploadFile']['error'] = $_FILES['file_laporan']['error'][$i];

	        $uploadStatus = $this->uploadFile('uploadFile');
	        if($uploadStatus != false) {
	            $uploadedFiles[] = $uploadStatus;
	        } else {
	            $this->session->set_flashdata('message-failed', 'File upload failed');
	            echo "
	                <script>
	                    window.history.back();
	                </script>
	            ";
	            exit;
	        }
	    }

	    $this->db->insert('laporan', $data);
	    $id_laporan = $this->db->insert_id();

	    foreach ($uploadedFiles as $file) {
	        $data_laporan = [
	            'file_laporan' => $file,
	            'id_laporan'   => $id_laporan
	        ];
	        $this->db->insert('file_laporan', $data_laporan);
	    }

	    $isi_log = 'Laporan ' . $data['judul_laporan'] . ' berhasil ditambahkan';
	    $this->lomo->addLog($isi_log, $dataUser['id_user']);
	    $this->session->set_flashdata('message-success', $isi_log);

	    if ($dataUser['jabatan'] == 'Operator Desa') {
		    redirect('laporan' . '/index/' . $dataUser['jenis_laporan']);
	    }
	    else
	    {
		    redirect('laporan');
	    }
	}


	function uploadFile($name)
	{
	    $dataUser = $this->admo->getDataUserAdmin();
	    $uploadPath = APPPATH . 'private_files/laporan';

	    if (!is_dir($uploadPath)) {
	        mkdir($uploadPath, 0777, true);
	    }

	    $config['upload_path'] = $uploadPath;
	    $config['allowed_types'] = 'jpg|png|jpeg|pdf|JPG|PNG|JPEG|PDF';
	    
	    // Generate a safe file name
	    $file_name = time() . uniqid() . '-' . $_FILES['uploadFile']['name'];
	    $config['file_name'] = $file_name;
	    
	    // Set maximum file size
	    $config['max_size'] = 153600;

	    $this->load->library('upload', $config);
	    $this->upload->initialize($config);

	    if ($this->upload->do_upload($name)) {
	        $fileData = $this->upload->data();
	        chmod($fileData['full_path'], 0755);
	        return $fileData['file_name'];
	    } else {
	        $isi_log = strip_tags($this->upload->display_errors());
	        $this->lomo->addLog($isi_log, $dataUser['id_user']);
	        $this->session->set_flashdata('message-failed', $isi_log);
	        echo "<script>window.history.back();</script>";
	        exit;
	    }
	}

	public function editLaporan($id_laporan)
	{
	    $dataUser = $this->admo->getDataUserAdmin();
	    $isi_log_2 = 'Pengguna ' . $dataUser['username'] . ' mencoba mengubah laporan dengan id ' . $id_laporan;
	    $this->admo->userPrivilegeDesa('admin', $isi_log_2);

	    $data_laporan = $this->getLaporanById($id_laporan);
	    
	    if ($dataUser['jabatan'] == 'Operator Desa') {
		    if ($data_laporan['id_jenis_laporan'] != $dataUser['id_jenis_laporan']) {
		    	$isi = 'Akses ditolak! Karena Jenis Laporan ' . $data_laporan['jenis_laporan'] . ' tidak sesuai dengan Pengelola Jenis Laporan! Hubungi Administrator untuk melakukan perubahan';
	            $this->session->set_flashdata('message-failed', $isi);
	            $this->lomo->addLog($isi, $dataUser['id_user']);
	            redirect('laporan/index/' . $dataUser['jenis_laporan']);
	            exit();
		    }
	    }

	    if ($data_laporan['status_laporan'] == 'Valid') {
	        if ($dataUser['jabatan'] != 'Administrator') {
	            $isi = 'Akses ditolak! Karena status laporan ' . $data_laporan['status_laporan'] . '! Hubungi Administrator untuk melakukan perubahan';
	            $this->session->set_flashdata('message-failed', $isi);
	            $this->lomo->addLog($isi, $dataUser['id_user']);
	            redirect('laporan/detailLaporan/' . $id_laporan);
	            exit();
	        }
	    }

	    $id_jenis_laporan = $this->input->post('id_jenis_laporan', true);
	    if ($id_jenis_laporan == 0) {
	        $this->session->set_flashdata('message-failed', 'Jenis Laporan harus dipilih');
	        echo "<script>window.history.back();</script>";
	        exit;
	    }

	    $id_kelurahan = $this->input->post('id_kelurahan', true);
	    if ($id_kelurahan == 0) {
	        $this->session->set_flashdata('message-failed', 'Kelurahan harus dipilih');
	        echo "<script>window.history.back();</script>";
	        exit;
	    }

	    $data = [
	        'judul_laporan'    => htmlspecialchars($this->input->post('judul_laporan', true)),
	        'uraian_laporan'   => htmlspecialchars($this->input->post('uraian_laporan', true)),
	        'tgl_laporan'      => htmlspecialchars($this->input->post('tgl_laporan', true)),
	        'tahun_kegiatan'   => htmlspecialchars($this->input->post('tahun_kegiatan', true)),
	        'status_laporan'   => $data_laporan['status_laporan'],
	        'id_jenis_laporan' => $id_jenis_laporan,
	        'id_kelurahan'     => $id_kelurahan,
	        'id_user'          => $dataUser['id_user']
	    ];

	    if ($_FILES['file_laporan']['name'][0] != '') {
	        $countFiles = count($_FILES['file_laporan']['name']);
	        $uploadedFiles = [];

	        for ($i = 0; $i < $countFiles; $i++) {
	            $_FILES['uploadFile']['name'] = $_FILES['file_laporan']['name'][$i]; 
	            $_FILES['uploadFile']['type'] = $_FILES['file_laporan']['type'][$i];
	            $_FILES['uploadFile']['size'] = $_FILES['file_laporan']['size'][$i];
	            $_FILES['uploadFile']['tmp_name'] = $_FILES['file_laporan']['tmp_name'][$i];
	            $_FILES['uploadFile']['error'] = $_FILES['file_laporan']['error'][$i];

	            $uploadStatus = $this->uploadFile('uploadFile');
	            if ($uploadStatus != false) {
	                $uploadedFiles[] = $uploadStatus;
	            } else {
	                $this->session->set_flashdata('message-failed', 'File upload failed');
	                echo "<script>window.history.back();</script>";
	                exit;
	            }
	        }

	        $file_laporan = $this->db->get_where('file_laporan', ['id_laporan' => $id_laporan])->result_array();
	        foreach ($file_laporan as $dfl) {
	            if ($dfl['file_laporan'] != 'default.jpeg') {
	                $file_path = APPPATH . 'private_files/laporan/' . $dfl['file_laporan'];
	                if (file_exists($file_path)) {
	                    unlink($file_path);
	                }
	            }
	        }
	        $this->db->delete('file_laporan', ['id_laporan' => $id_laporan]);

	        foreach ($uploadedFiles as $file) {
	            $dataFile = [
	                'file_laporan' => $file,
	                'id_laporan'   => $id_laporan
	            ];
	            $this->db->insert('file_laporan', $dataFile);
	        }
	    }

	    $this->db->update('laporan', $data, ['id_laporan' => $id_laporan]);

	    $isi_log = 'Laporan ' . $data['judul_laporan'] . ' berhasil diubah';
	    $this->lomo->addLog($isi_log, $dataUser['id_user']);
	    $this->session->set_flashdata('message-success', $isi_log);
	    redirect('laporan/detailLaporan/' . $id_laporan);
	    exit;
	}

	public function revisiLaporan($id_laporan)
	{
	    $dataUser = $this->admo->getDataUserAdmin();
	    $isi_log_2 = 'Pengguna ' . $dataUser['username'] . ' mencoba mengubah laporan dengan id ' . $id_laporan;
	    $this->admo->userPrivilegeDesa('admin', $isi_log_2);

	    $data_laporan = $this->getLaporanById($id_laporan);
	    
	    if ($dataUser['jabatan'] == 'Operator Desa') {
		    if ($data_laporan['id_jenis_laporan'] != $dataUser['id_jenis_laporan']) {
		    	$isi = 'Akses ditolak! Karena Jenis Laporan ' . $data_laporan['jenis_laporan'] . ' tidak sesuai dengan Pengelola Jenis Laporan! Hubungi Administrator untuk melakukan perubahan';
	            $this->session->set_flashdata('message-failed', $isi);
	            $this->lomo->addLog($isi, $dataUser['id_user']);
	            redirect('laporan/index/' . $dataUser['jenis_laporan']);
	            exit();
		    }
	    }

	    if ($data_laporan['status_laporan'] == 'Valid') {
	        if ($dataUser['jabatan'] != 'Administrator') {
	            $isi = 'Akses ditolak! Karena status laporan ' . $data_laporan['status_laporan'] . '! Hubungi Administrator untuk melakukan perubahan';
	            $this->session->set_flashdata('message-failed', $isi);
	            $this->lomo->addLog($isi, $dataUser['id_user']);
	            redirect('laporan/detailLaporan/' . $id_laporan);
	            exit();
	        }
	    }

	    $id_jenis_laporan = $this->input->post('id_jenis_laporan', true);
	    if ($id_jenis_laporan == 0) {
	        $this->session->set_flashdata('message-failed', 'Jenis Laporan harus dipilih');
	        echo "<script>window.history.back();</script>";
	        exit;
	    }

	    $id_kelurahan = $this->input->post('id_kelurahan', true);
	    if ($id_kelurahan == 0) {
	        $this->session->set_flashdata('message-failed', 'Kelurahan harus dipilih');
	        echo "<script>window.history.back();</script>";
	        exit;
	    }

	    $data_revisi = [
	    	'tgl_revisi_laporan' => date("Y-m-d H:i:s"),
	    	'id_laporan' 		 => $id_laporan,
			'id_user'			 => $dataUser['id_user']
	    ];

	    $this->db->insert('revisi_laporan', $data_revisi);
	    $id_revisi_laporan = $this->db->insert_id();

	    $data = [
	        'judul_laporan'    => htmlspecialchars($this->input->post('judul_laporan', true)),
	        'uraian_laporan'   => htmlspecialchars($this->input->post('uraian_laporan', true)),
	        'tgl_laporan'      => htmlspecialchars($this->input->post('tgl_laporan', true)),
	        'tahun_kegiatan'   => htmlspecialchars($this->input->post('tahun_kegiatan', true)),
	        'status_laporan'   => 'Belum Divalidasi',
	        'id_jenis_laporan' => $id_jenis_laporan,
	        'id_kelurahan'     => $id_kelurahan,
	        'id_user'          => $dataUser['id_user']
	    ];

	    if ($_FILES['file_laporan']['name'][0] != '') {
	        $countFiles = count($_FILES['file_laporan']['name']);
	        $uploadedFiles = [];

	        for ($i = 0; $i < $countFiles; $i++) {
	            $_FILES['uploadFile']['name'] = $_FILES['file_laporan']['name'][$i]; 
	            $_FILES['uploadFile']['type'] = $_FILES['file_laporan']['type'][$i];
	            $_FILES['uploadFile']['size'] = $_FILES['file_laporan']['size'][$i];
	            $_FILES['uploadFile']['tmp_name'] = $_FILES['file_laporan']['tmp_name'][$i];
	            $_FILES['uploadFile']['error'] = $_FILES['file_laporan']['error'][$i];

	            $uploadStatus = $this->uploadFile('uploadFile');
	            if ($uploadStatus != false) {
	                $uploadedFiles[] = $uploadStatus;
	            } else {
	                $this->session->set_flashdata('message-failed', 'File upload failed');
	                echo "<script>window.history.back();</script>";
	                exit;
	            }
	        }

	        $file_laporan = $this->db->get_where('file_laporan', ['id_laporan' => $id_laporan])->result_array();

	        // Backup data ke tabel file_laporan_lama
			foreach ($file_laporan as $dfl) {
			    $data_file_laporan_lama = [
			        'file_laporan_lama' => $dfl['file_laporan'],
			        'id_revisi_laporan' => $id_revisi_laporan
			    ];
			    
			    $this->db->insert('file_laporan_lama', $data_file_laporan_lama);
			}

	        $this->db->delete('file_laporan', ['id_laporan' => $id_laporan]);

	        foreach ($uploadedFiles as $file) {
	            $dataFile = [
	                'file_laporan' => $file,
	                'id_laporan'   => $id_laporan
	            ];
	            $this->db->insert('file_laporan', $dataFile);
	        }
	    }

	    $this->db->update('laporan', $data, ['id_laporan' => $id_laporan]);

	    $isi_log = 'Laporan ' . $data['judul_laporan'] . ' berhasil diubah';
	    $this->lomo->addLog($isi_log, $dataUser['id_user']);
	    $this->session->set_flashdata('message-success', $isi_log);
	    redirect('laporan/detailLaporan/' . $id_laporan);
	}

	public function validasiLaporan($id_laporan)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		
		$data_status = [
			'status_laporan' => $this->input->post('status_laporan', true)
		];

		$this->db->update('laporan', $data_status, ['id_laporan' => $id_laporan]);

		$data = [
			'tgl_validasi_laporan' 	=> date('Y-m-d\TH:i:s'),
			'catatan_validasi' 		=> $this->input->post('catatan_validasi', true),
			'id_laporan' 			=> $id_laporan,
			'id_user'				=> $dataUser['id_user']
		];
		
		if ($this->getValidasiLaporanById($id_laporan)) {
		    $this->db->update('validasi_laporan', $data, ['id_laporan' => $id_laporan]);
		} else {
		    $this->db->insert('validasi_laporan', $data);
		}

		$isi_log = 'Laporan ' . $data['judul_laporan'] . ' berhasil divalidasi oleh ' . $dataUser['username'];
		$this->lomo->addLog($isi_log, $dataUser['id_user']);
		$this->session->set_flashdata('message-success', $isi_log);
		redirect('laporan/detailLaporan/' . $id_laporan);
	}

	public function removeLaporan($id_laporan)
	{
		$dataUser = $this->admo->getDataUserAdmin();
		$isi_log_2 = 'User ' . $dataUser['username'] . ' mencoba menghapus laporan apbdes dengan id ' . $id_laporan;
		$this->admo->userPrivilegeDesa('laporan', $isi_log_2);

		$data_laporan = $this->getLaporanById($id_laporan);
		$laporan  = $data_laporan['judul_laporan'];
		
		if ($dataUser['jabatan'] == 'Operator Desa') {
		    if ($data_laporan['id_jenis_laporan'] != $dataUser['id_jenis_laporan']) {
		    	$isi = 'Akses ditolak! Karena Jenis Laporan ' . $data_laporan['jenis_laporan'] . ' tidak sesuai dengan Pengelola Jenis Laporan! Hubungi Administrator untuk melakukan perubahan';
	            $this->session->set_flashdata('message-failed', $isi);
	            $this->lomo->addLog($isi, $dataUser['id_user']);
	            redirect('laporan/index/' . $dataUser['jenis_laporan']);
	            exit();
		    }
	    }

		if ($data_laporan['status_laporan'] == 'Valid') {
			if ($dataUser['jabatan'] != 'Administrator') {
				$isi = 'Akses ditolak! Karena status laporan '.$data_laporan['status_laporan'].'! Hubungi Administrator untuk melakukan perubahan';
				$isi .= ucfirst($isi2);

				$this->session->set_flashdata('message-failed', $isi);
				
				$id_user = $dataUser['id_user'];
				$this->lomo->addLog($isi, $id_user);
				redirect('laporan/detailLaporan/' . $id_laporan);
				exit();
			}
		}
		
		$file_laporan = $this->db->get_where('file_laporan', ['id_laporan' => $id_laporan])->result_array();
	
		foreach ($file_laporan as $dfl) {
			if ($dfl['file_laporan'] != 'default.jpeg') {
				$file_path = APPPATH . 'private_files/laporan/' . $dfl['file_laporan'];
				if (file_exists($file_path)) {
					unlink($file_path);
					$this->db->delete('file_laporan', ['id_laporan' => $id_laporan]);
				}
			}
		}

		$this->db->delete('file_laporan', ['id_laporan' => $id_laporan]);
		
		if (!$this->db->delete('laporan', ['id_laporan' => $id_laporan])) {
			$isi_log = 'Laporan ' . $laporan . ' gagal dihapus';
			$this->lomo->addLog($isi_log, $dataUser['id_user']);
			$this->session->set_flashdata('message-failed', $isi_log);
		}
		else
		{
			$isi_log = 'Laporan ' . $laporan . ' berhasil dihapus';
			$this->lomo->addLog($isi_log, $dataUser['id_user']);
			$this->session->set_flashdata('message-success', $isi_log);
		}

		if ($dataUser['jabatan'] == 'Operator Desa') {
		    redirect('laporan' . '/index/' . $dataUser['jenis_laporan']);
	    }
	    else
	    {
		    redirect('laporan');
	    }
	}
}
