<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inv extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if (current_url()!=site_url().'/user/login') {
			if (!$this->session->userdata('user_logged_in')) {
				redirect(site_url().'/user/login');
			}
		}
	}

	public function index() {
		$in['title'] = 'Beranda';
		$in['menu_top'] = 'menu/top';
		$in['content'] = 'module/beranda';
		$this->load->view('template/full', $in);
	}

	public function master_lokasi() {
		$in['title'] = 'Master Lokasi';
		$in['menu_top'] = 'menu/top';
		$in['content'] = 'module/master_lokasi';
		$this->load->view('template/full', $in);
	}

	public function crud_master_lokasi() {
		if ($this->uri->segment(3)) {
			$this->load->view('module/crud_master_lokasi');
		} else { redirect(base_url());
		}
	}

	public function rekap() {
		$in['title'] = 'Rekapitulasi';
		$in['menu_top'] = 'menu/top';
		$in['content'] = 'module/rekap';
		$this->load->view('template/full', $in);
	}

	public function crud_rekap() {
		$in['title'] = 'Ubah Rekapitulasi';
		$in['menu_top'] = 'menu/top';
		$in['content'] = 'module/crud_rekap';
		$this->load->view('template/full', $in);
	}
	
	public function download_rekap($lokasi, $kode_tempat) {
		$this->load->dbutil(); //Database utility
		
		$sql = 'SELECT f_nama_barang AS nama_barang, f_tipe_barang AS tipe_barang, f_kode AS kode_barang,
				t_master_lokasi.f_kode_lokasi AS kode_lokasi, f_jumlah AS jumlah_barang,
	       		f_jumlah_kondisi_baik AS kondisi_baik, f_tanggal_masuk as tanggal_masuk
	  			FROM t_list_barang
	  			INNER JOIN t_master_lokasi ON t_master_lokasi.f_id = t_list_barang.ref_master_lokasi_f_id
				WHERE (ref_master_lokasi_f_id=? AND f_status_hapus=?)';
		$binds = array($lokasi, 'f');
		$query = $this->db->query($sql, $binds);
		$data =  $this->dbutil->csv_from_result($query);
		$name = $kode_tempat.'_export_invelektro'.date('Ymd').'.csv';
		force_download($name, $data);
	}

	public function kecildarijumlah() {
		$jumlah_barang = $this->input->post('f_jumlah');
		$barang_kondisi_baik = $this->input->post('f_jumlah_kondisi_baik');

		if ($jumlah_barang >= $barang_kondisi_baik) {
			return TRUE;
		} else {
			$this->form_validation->set_message('kecildarijumlah', 'Jumlah Kondisi Baik LEBIH KECIL atau SAMA DENGAN Jumlah Barang');
			return FALSE;
		}
	}

	public function cari() {
		$in['title'] = 'Cari Data';
		$in['menu_top'] = 'menu/top';
		$in['content'] = 'module/cari';
		$this->load->view('template/full', $in);
	}
}