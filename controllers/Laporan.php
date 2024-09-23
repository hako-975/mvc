<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'admo');
		$this->load->model('Laporan_model', 'lamo');
		$this->load->model('JenisLaporan_model', 'jelamo');
		$this->load->model('Kecamatan_model', 'kemo');
		$this->load->model('Kelurahan_model', 'kelmo');
		$this->admo->checkLoginAdmin();
	}

	public function index($nama_jenis_laporan = "")
	{
		$nama_jenis_laporan = urldecode($nama_jenis_laporan);

		$data['dataUser']		= $this->admo->getDataUserAdmin();
		$data['jenis_laporan']	= $this->jelamo->getJenisLaporan();
		$data['jenis_laporan_kabid']	= $this->jelamo->getJenisLaporanByBidangId($data['dataUser']['id_bidang']);
		$data['kelurahan']		= $this->kelmo->getKelurahan();
		$data['kecamatan']		= $this->kemo->getKecamatan();

		$dari_tanggal 		= $this->input->get('dari_tanggal');
		$sampai_tanggal 	= $this->input->get('sampai_tanggal');
		$id_kecamatan 		= $this->input->get('id_kecamatan');
		$id_kelurahan 		= $this->input->get('id_kelurahan');
		
		if ($data['dataUser']['jabatan'] == 'Operator Desa') {
			$id_jenis_laporan 	= $data['dataUser']['id_jenis_laporan'];
		} else {
			$id_jenis_laporan 	= $this->input->get('id_jenis_laporan');
		}
		$status_laporan 	= $this->input->get('status_laporan');

		if (!$dari_tanggal) {
			if ($data['dataUser']['jabatan'] == 'Operator Desa') {
				if ($nama_jenis_laporan != $data['dataUser']['jenis_laporan']) {
					redirect('laporan/index/' . $data['dataUser']['jenis_laporan']);
					exit;
				}
			}

		}
		
		if ($data['dataUser']['jabatan'] == 'Administrator' || $data['dataUser']['jabatan'] == 'Pimpinan') {
			// filter
			if ($dari_tanggal) {
				$data['laporan']	= $this->lamo->getLaporanFilter($dari_tanggal, $sampai_tanggal, $id_kecamatan, $id_kelurahan, $id_jenis_laporan, $status_laporan);
				$data['title']  	= 'Laporan Filter';
			}
			else
			{
				// sidebar
				if ($nama_jenis_laporan) {
					$data['nama_jenis_laporan']	= $nama_jenis_laporan;
					$data['laporan']			= $this->lamo->getLaporanByJenisLaporan($nama_jenis_laporan);
					$data['title']  			= 'Laporan - ' . $nama_jenis_laporan;
				}
				else
				{
					$data['laporan']	= $this->lamo->getLaporan();
					$data['title']  	= 'Semua Laporan';
				}
			}
		}
		elseif ($data['dataUser']['jabatan'] == 'Camat') {
			$id_kecamatan = $data['dataUser']['id_kecamatan'];
			// filter
			if ($dari_tanggal) {
				$data['laporan']	= $this->lamo->getLaporanFilter($dari_tanggal, $sampai_tanggal, $id_kecamatan, $id_kelurahan, $id_jenis_laporan, $status_laporan);
				$data['title']  	= 'Laporan Filter';
			}
			else
			{
				if ($nama_jenis_laporan) {
					$data['nama_jenis_laporan']	= $nama_jenis_laporan;
					$data['laporan'] 	= $this->lamo->getLaporanByIdKecamatan($id_kecamatan, $nama_jenis_laporan);
					$data['title']  	= 'Laporan - ' . $nama_jenis_laporan;
				}
				else
				{
					$data['laporan'] 	= $this->lamo->getLaporanByIdKecamatan($id_kecamatan);
					$data['kelurahan'] 	= $this->kelmo->getKelurahanByKecamatanId($id_kecamatan);
					$data['title']  	= 'Semua Laporan';
				}
			}
		}
		else if ($data['dataUser']['jabatan'] == 'Kepala Bidang') {
			$id_bidang = $data['dataUser']['id_bidang'];
			// filter
			if ($dari_tanggal) {
				$data['laporan']	= $this->lamo->getLaporanFilterByIdBidang($dari_tanggal, $sampai_tanggal, $id_kecamatan, $id_kelurahan, $id_bidang, $id_jenis_laporan, $status_laporan);
				$data['title']  	= 'Laporan Filter';
			}
			else
			{
				if ($nama_jenis_laporan) {
					$data['nama_jenis_laporan']	= $nama_jenis_laporan;
					$data['laporan'] 	= $this->lamo->getLaporanByIdBidang($id_bidang, $id_kecamatan, $id_kelurahan, $nama_jenis_laporan);
					$data['title']  	= 'Laporan - ' . $nama_jenis_laporan;
				}
				else
				{
					$id_bidang = $data['dataUser']['id_bidang'];
					$data['laporan']	= $this->lamo->getLaporanByIdBidang($id_bidang);
					$data['title']  	= 'Semua Laporan Bidang - ' . $data['dataUser']['nama_bidang'];
				}
			}
		}
		else if ($data['dataUser']['jabatan'] == 'Kepala Desa' || $data['dataUser']['jabatan'] == 'Operator Desa') {
			$id_kecamatan = $data['dataUser']['id_kecamatan'];
			$id_kelurahan = $data['dataUser']['id_kelurahan'];

			// filter
			if ($dari_tanggal) {
				$data['laporan']	= $this->lamo->getLaporanFilter($dari_tanggal, $sampai_tanggal, $id_kecamatan, $id_kelurahan, $id_jenis_laporan, $status_laporan);
				$data['title']  	= 'Laporan Filter';
			}
			else
			{
				if ($nama_jenis_laporan) {
					$data['nama_jenis_laporan']	= $nama_jenis_laporan;
					$data['laporan'] 	= $this->lamo->getLaporanByIdKelurahan($id_kelurahan, $nama_jenis_laporan);
					$data['title']  	= 'Laporan - ' . $nama_jenis_laporan;
				}
				else
				{
					$data['laporan'] 	= $this->lamo->getLaporanByIdKelurahan($id_kelurahan);
					$data['kelurahan'] 	= $this->kelmo->getKelurahanByKecamatanId($id_kecamatan);
					$data['title']  	= 'Semua Laporan';
				}
			}
		}

		$this->load->view('templates/header-admin', $data);
		$this->load->view('laporan/index', $data);
		$this->load->view('templates/footer-admin', $data);
	    $this->load->view('templates/include/form_kecamatan', $data);  
	}

	public function print()
	{
	    $dari_tanggal     = $this->input->get('dari_tanggal');
	    $sampai_tanggal   = $this->input->get('sampai_tanggal');
	    $id_kecamatan     = $this->input->get('id_kecamatan');
	    $id_kelurahan     = $this->input->get('id_kelurahan');
	    $id_jenis_laporan = $this->input->get('id_jenis_laporan');
	    $status_laporan   = $this->input->get('status_laporan');
	    $data['jenis_laporan'] = "Semua";
	    $data['dataUser'] = $this->admo->getDataUserAdmin();

	    if ($data['dataUser']['jabatan'] == 'Administrator' || $data['dataUser']['jabatan'] == 'Pimpinan') {
			// filter
			if ($dari_tanggal) {
				$data['laporan']	= $this->lamo->getLaporanFilter($dari_tanggal, $sampai_tanggal, $id_kecamatan, $id_kelurahan, $id_jenis_laporan, $status_laporan);
				if ($id_kecamatan != 0) {
					$data['nama_kecamatan'] = $this->kemo->getKecamatanById($id_kecamatan)['nama_kecamatan'];
				}
				if ($id_kelurahan != 0) {
					$data['nama_kelurahan'] = $this->kelmo->getKelurahanById($id_kelurahan)['nama_kelurahan'];
				}
				if ($id_jenis_laporan != 0) {
					$data['jenis_laporan'] = $this->jelamo->getJenisLaporanById($id_jenis_laporan)['jenis_laporan'];
				}
				$data['status_laporan'] = $status_laporan;
				$data['tanggal_laporan']  	= 'Laporan dari tanggal ' . date('d-M-Y', strtotime($dari_tanggal)) . ' sampai tanggal ' . date('d-M-Y', strtotime($sampai_tanggal));
				$data['title']  	= 'Laporan ' . $data['jenis_laporan'] . ' - ' . $dari_tanggal . ' - ' . $sampai_tanggal;
			}
			else
			{
				$data['laporan']	= $this->lamo->getLaporan();
				$data['title']  	= 'Semua Laporan';
			}
		}
		elseif ($data['dataUser']['jabatan'] == 'Camat') {
			$id_kecamatan = $data['dataUser']['id_kecamatan'];
			// filter
			if ($dari_tanggal) {
				$data['laporan']	= $this->lamo->getLaporanFilter($dari_tanggal, $sampai_tanggal, $id_kecamatan, $id_kelurahan, $id_jenis_laporan, $status_laporan);

				$data['nama_kecamatan'] = $this->kemo->getKecamatanById($id_kecamatan)['nama_kecamatan'];

				if ($id_kelurahan != 0) {
					$data['nama_kelurahan'] = $this->kelmo->getKelurahanById($id_kelurahan)['nama_kelurahan'];
				}
				if ($id_jenis_laporan != 0) {
					$data['jenis_laporan'] = $this->jelamo->getJenisLaporanById($id_jenis_laporan)['jenis_laporan'];
				}
				$data['status_laporan'] = $status_laporan;
				$data['tanggal_laporan']  	= 'Laporan dari tanggal ' . date('d-M-Y', strtotime($dari_tanggal)) . ' sampai tanggal ' . date('d-M-Y', strtotime($sampai_tanggal));
				$data['title']  	= 'Laporan ' . $data['jenis_laporan'] . ' - ' . $dari_tanggal . ' - ' . $sampai_tanggal;
			}
			else
			{
				$data['laporan'] 	= $this->lamo->getLaporanByIdKecamatan($id_kecamatan);
				$data['nama_kecamatan'] 	= $data['dataUser']['nama_kecamatan'];
				$data['nama_kelurahan'] 	= $data['dataUser']['nama_kelurahan'];
				$data['title']  	= 'Semua Laporan';
			}
		}
		else if ($data['dataUser']['jabatan'] == 'Kepala Desa') {
			$id_kecamatan = $data['dataUser']['id_kecamatan'];
			$id_kelurahan = $data['dataUser']['id_kelurahan'];

			// filter
			if ($dari_tanggal) {
				$data['laporan']	= $this->lamo->getLaporanFilter($dari_tanggal, $sampai_tanggal, $id_kecamatan, $id_kelurahan, $id_jenis_laporan, $status_laporan);
				$data['nama_kecamatan'] = $this->kemo->getKecamatanById($id_kecamatan)['nama_kecamatan'];
				$data['nama_kelurahan'] = $this->kelmo->getKelurahanById($id_kelurahan)['nama_kelurahan'];
				if ($id_jenis_laporan != 0) {
					$data['jenis_laporan'] = $this->jelamo->getJenisLaporanById($id_jenis_laporan)['jenis_laporan'];
				}
				$data['status_laporan'] = $status_laporan;
				$data['tanggal_laporan']  	= 'Laporan dari tanggal ' . date('d-M-Y', strtotime($dari_tanggal)) . ' sampai tanggal ' . date('d-M-Y', strtotime($sampai_tanggal));
				$data['title']  	= 'Laporan ' . $data['jenis_laporan'] . ' - ' . $dari_tanggal . ' - ' . $sampai_tanggal;
			}
			else
			{
				$data['laporan'] 	= $this->lamo->getLaporanByIdKelurahan($id_kelurahan);
				$data['nama_kecamatan'] 	= $data['dataUser']['nama_kecamatan'];
				$data['nama_kelurahan'] 	= $data['dataUser']['nama_kelurahan'];
				$data['title']  	= 'Semua Laporan';
			}
		}
		elseif ($data['dataUser']['jabatan'] == 'Operator Desa') {
			$id_kecamatan = $data['dataUser']['id_kecamatan'];
			$id_kelurahan = $data['dataUser']['id_kelurahan'];

			// filter
			if ($dari_tanggal) {
				$data['laporan']	= $this->lamo->getLaporanFilter($dari_tanggal, $sampai_tanggal, $id_kecamatan, $id_kelurahan, $id_jenis_laporan, $status_laporan);
				$data['nama_kecamatan'] = $this->kemo->getKecamatanById($id_kecamatan)['nama_kecamatan'];
				$data['nama_kelurahan'] = $this->kelmo->getKelurahanById($id_kelurahan)['nama_kelurahan'];
				if ($id_jenis_laporan != 0) {
					$data['jenis_laporan'] = $this->jelamo->getJenisLaporanById($id_jenis_laporan)['jenis_laporan'];
				}
				$data['status_laporan'] = $status_laporan;
				$data['tanggal_laporan']  	= 'Laporan dari tanggal ' . date('d-M-Y', strtotime($dari_tanggal)) . ' sampai tanggal ' . date('d-M-Y', strtotime($sampai_tanggal));
				$data['title']  	= 'Laporan ' . $data['jenis_laporan'] . ' - ' . $dari_tanggal . ' - ' . $sampai_tanggal;
			}
			else
			{
				$data['laporan'] 	= $this->lamo->getLaporanByIdKelurahan($id_kelurahan, $data['dataUser']['jenis_laporan']);
				$data['jenis_laporan'] 	= $data['dataUser']['jenis_laporan'];
				$data['nama_kecamatan'] 	= $data['dataUser']['nama_kecamatan'];
				$data['nama_kelurahan'] 	= $data['dataUser']['nama_kelurahan'];
				$data['title']  	= 'Semua Laporan';
			}
		}
		if ($data['dataUser']['jabatan'] == 'Kepala Bidang') {
			$id_bidang = $data['dataUser']['id_bidang'];
			// filter
			if ($dari_tanggal) {
				$data['laporan']	= $this->lamo->getLaporanFilterByIdBidang($dari_tanggal, $sampai_tanggal, $id_kecamatan, $id_kelurahan, $id_bidang, $id_jenis_laporan, $status_laporan);
				if ($id_kecamatan != 0) {
					$data['nama_kecamatan'] = $this->kemo->getKecamatanById($id_kecamatan)['nama_kecamatan'];
				}
				if ($id_kelurahan != 0) {
					$data['nama_kelurahan'] = $this->kelmo->getKelurahanById($id_kelurahan)['nama_kelurahan'];
				}
				if ($id_jenis_laporan != 0) {
					$data['jenis_laporan'] = $this->jelamo->getJenisLaporanById($id_jenis_laporan)['jenis_laporan'];
				}
				$data['status_laporan'] = $status_laporan;
				$data['tanggal_laporan']  	= 'Laporan dari tanggal ' . date('d-M-Y', strtotime($dari_tanggal)) . ' sampai tanggal ' . date('d-M-Y', strtotime($sampai_tanggal));
				$data['title']  	= 'Laporan ' . $data['jenis_laporan'] . ' - ' . $dari_tanggal . ' - ' . $sampai_tanggal;
			}
			else
			{
				$data['laporan']	= $this->lamo->getLaporanByIdBidang($id_bidang);
				$data['title']  	= 'Semua Laporan Bidang - ' . $data['dataUser']['nama_bidang'];
			}
		}
	    // Load the print view
	    $this->load->view('laporan/print', $data);
	}


	public function kelurahanByKecamatanId($id_kecamatan = "")
	{
		if ($id_kecamatan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['kecamatan']	= $this->kemo->getKecamatanById($id_kecamatan);
		$data['kelurahan']	= $this->kelmo->getKelurahanByKecamatanId($id_kecamatan);
		$data['laporan'] 	= $this->lamo->getJmlLaporan($id_kecamatan);

		$data['title']  	= 'Kecamatan - ' . $data['kecamatan']['nama_kecamatan'];
		$this->load->view('templates/header-admin', $data);
		$this->load->view('laporan/kelurahan_by_kecamatan_id', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function detailLaporanByKelurahanId($id_kelurahan = "")
	{
		if ($id_kelurahan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['jenis_laporan']	= $this->jelamo->getJenisLaporan();
		$data['kelurahan']	= $this->kelmo->getKelurahanById($id_kelurahan);
		$data['laporan'] 	= $this->lamo->getJmlLaporanKelurahan($id_kelurahan);

		$data['title']  	= 'Detail Laporan Kelurahan - ' . $data['kelurahan']['nama_kelurahan'];
		$this->load->view('templates/header-admin', $data);
		$this->load->view('laporan/detail_laporan_by_kelurahan_id', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function search()
	{
		$search = $this->input->get('search');

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['jenis_laporan']	= $this->jelamo->getJenisLaporan();
		$data['search'] 	= $search;
		$data['laporan']	= $this->lamo->getLaporanByKeyword($search);
		$data['title']  	= 'Laporan - ' . $search;
		
		$this->load->view('templates/header-admin', $data);
		$this->load->view('laporan/index', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function detailLaporan($id_laporan = "")
	{
		if ($id_laporan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$data['dataUser']			= $this->admo->getDataUserAdmin();
		$data['laporan']			= $this->lamo->getLaporanById($id_laporan);
		$data['validasi_laporan']	= $this->lamo->getValidasiLaporanByLaporanId($id_laporan);
		$data['last_validasi_laporan']	= $this->lamo->getLastValidasiLaporanByLaporanId($id_laporan);
		$data['title']  	= 'Detail Laporan - ' . $data['laporan']['judul_laporan'];

		$this->load->view('templates/header-admin', $data);
		$this->load->view('laporan/detail_laporan', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function validasiLaporan($id_laporan = "")
	{
		if ($id_laporan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}
		
	    $this->lamo->validasiLaporan($id_laporan);
	}

	public function transparansiLaporan($id_laporan = "")
	{
		if ($id_laporan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}
		
	    $this->lamo->transparansiLaporan($id_laporan);
	}

	public function addLaporan($nama_jenis_laporan = "")
	{
		$data['dataUser']		= $this->admo->getDataUserAdmin();
		$data['title'] 			= 'Tambah Laporan';
		$data['jenis_laporan']	= $this->jelamo->getJenisLaporan();
		$data['kelurahan']	= $this->kelmo->getKelurahan();
		$data['kecamatan']	= $this->kemo->getKecamatan();
		
		$nama_jenis_laporan = str_replace('%20', ' ', $nama_jenis_laporan);

		if ($nama_jenis_laporan) {
			$data['nama_jenis_laporan']	= $nama_jenis_laporan;
			$data['id_jenis_laporan']	= $this->jelamo->getJenisLaporanByJenisLaporan($nama_jenis_laporan)['id_jenis_laporan'];
			$data['title']  			= 'Tambah Laporan - ' . $nama_jenis_laporan;
		}
		
		$this->form_validation->set_rules('judul_laporan', 'Judul Laporan', 'required|trim');
		$this->form_validation->set_rules('tgl_laporan', 'Tanggal Laporan', 'required|trim');
		$this->form_validation->set_rules('tahun_kegiatan', 'Tahun Kegiatan', 'required|trim');
		$this->form_validation->set_rules('id_jenis_laporan', 'Jenis Laporan', 'required|trim');
		$this->form_validation->set_rules('id_kelurahan', 'Kelurahan/Desa', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
		    $this->load->view('laporan/add_laporan', $data);
		    $this->load->view('templates/footer-admin', $data);  
		    $this->load->view('templates/include/form_kecamatan', $data);  
		} else {
		    $this->lamo->addLaporan();
		}
	}

	public function editLaporan($id_laporan = "", $revisi = false)
	{
		if ($id_laporan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$data['dataUser']	= $this->admo->getDataUserAdmin();
		$data['laporan'] = $this->lamo->getLaporanById($id_laporan);
		if ($data['dataUser']['jabatan'] == 'Operator Desa') {
		    if ($data['laporan']['id_jenis_laporan'] != $data['dataUser']['id_jenis_laporan']) {
		    	$isi = 'Akses ditolak! Karena Jenis Laporan ' . $data['laporan']['jenis_laporan'] . ' tidak sesuai dengan Pengelola Jenis Laporan! Hubungi Administrator untuk melakukan perubahan';
	            $this->session->set_flashdata('message-failed', $isi);
	            $this->lomo->addLog($isi, $data['dataUser']['id_user']);
	            redirect('laporan/index/' . $data['dataUser']['jenis_laporan']);
	            exit();
		    }
	    }
		
		if ($revisi) {
			$data['revisi'] = true;
		}
		
		$data['file_laporan']	= $this->lamo->getFileLaporanById($id_laporan);
		$data['jenis_laporan']	= $this->jelamo->getJenisLaporan();
		$data['title'] 		= 'Ubah Laporan  - ' . $data['laporan']['judul_laporan'];
		$data['kelurahan']	= $this->kelmo->getKelurahan();
		$data['kecamatan']	= $this->kemo->getKecamatan();
		
		$this->form_validation->set_rules('judul_laporan', 'Judul Laporan', 'required|trim');
		$this->form_validation->set_rules('tgl_laporan', 'Tanggal Laporan', 'required|trim');
		$this->form_validation->set_rules('tahun_kegiatan', 'Tahun Kegiatan', 'required|trim');
		$this->form_validation->set_rules('id_jenis_laporan', 'Jenis Laporan', 'required|trim');
		$this->form_validation->set_rules('id_kelurahan', 'Kelurahan/Desa', 'required|trim');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
		    $this->load->view('laporan/edit_laporan', $data);
		    $this->load->view('templates/footer-admin', $data);  
		    $this->load->view('templates/include/form_kecamatan', $data);  
		} else {
		    $this->lamo->editLaporan($id_laporan);
		}
	}


	public function removeLaporan($id_laporan = "")
	{

		if ($id_laporan == null) {
	        echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}

		$this->lamo->removeLaporan($id_laporan);
	}

	public function download_all_files($id_laporan) {
	    $laporan = $this->db->get_where('laporan', ['id_laporan' => $id_laporan])->row_array();
	    $file_laporan = $this->db->get_where('file_laporan', ['id_laporan' => $id_laporan])->result_array();
	    $fileNames = array();

	    foreach ($file_laporan as $dfl) {
	        $fileNames[] = $dfl['file_laporan'];
	    }

	    $zip = new ZipArchive();
	    $zipFileName = date('d-m-y') . '-' . preg_replace('/[^A-Za-z0-9\-]/', '_', $laporan['judul_laporan']) . '.zip';

	    if ($zip->open(FCPATH . $zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
	        foreach ($fileNames as $fileName) {
	            $filePath = APPPATH . 'private_files/laporan/' . $fileName;
	            if (file_exists($filePath)) {
	                $zip->addFile($filePath, $fileName);
	            }
	        }
	        $zip->close();

	        // Provide the file for download
	        header('Content-Type: application/zip');
	        header('Content-disposition: attachment; filename=' . $zipFileName);
	        header('Content-Length: ' . filesize(FCPATH . $zipFileName));
	        readfile(FCPATH . $zipFileName);

	        // Remove the zip file after download
	        unlink(FCPATH . $zipFileName);
	        exit;
	    } else {
	        echo 'Failed to create zip archive';
	    }
	}

	public function getLaporanBelumDivalidasi()
	{
		$dataUser = $this->admo->getDataUserAdmin();
	    $laporan  = $this->lamo->getLaporanBelumDivalidasi();

	    foreach ($laporan as &$msg) {
	        $msg['tgl_laporan'] = date('d-m-Y, H:i', strtotime($msg['tgl_laporan'])) . ' WIB';
	    }

	    echo json_encode($laporan);
	}

}
