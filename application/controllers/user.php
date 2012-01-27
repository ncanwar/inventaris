<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if (current_url()!=site_url().'/user/login') {
			if (!$this->session->userdata('user_logged_in')) {
				redirect(site_url().'/user/login');
			}
		}
	}

	public function index() {

	}

	//Untuk Login
	public function login() {
		if ($this->session->userdata('user_logged_in')) {
			redirect(site_url().'/inv');
		} else {
			$in['title'] = 'Halaman Login User';
			$in['menu_top'] = 'menu/top';
			$in['content'] = 'module/user_login';
			$this->load->view('template/full', $in);
		}
	}

	//Untuk Logout
	public function logout(){
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_username');
		$this->session->unset_userdata('user_nama');
		$this->session->unset_userdata('user_logged_in');
		$this->session->unset_userdata('login_time');

		$this->session->sess_destroy();
		$this->session->set_flashdata('message', 'Logout Sukses');
		redirect(site_url().'/user/login');
	}

	public function checkuser(){
		$f_username = $this->input->post('f_username', TRUE);
		$f_password = $this->input->post('f_password', TRUE);
		$sql = 'SELECT f_id FROM t_user
			WHERE f_username=?';
		$binds = array($f_username);

		$query = $this->db->query($sql, $binds);

		//Hanya User yang terdaftar yang boleh login
		if ($query->num_rows() > 0) {
			$sql = 'SELECT f_id, f_username, f_nama FROM t_user WHERE f_username=? and f_password = ?';
			$binds = array($f_username, $f_password);
			$query = $this->db->query($sql, $binds);

			if($query->num_rows()==0) {
				$this->session->set_flashdata('message', 'Username atau Password Salah');
				redirect(site_url().'/user/login');
			} else {
				//Berhasil Login
				foreach ($query->result() as $row) {
					$newdata = array(
					'user_id'  => $row->f_id,
					'user_username' => $row->f_username,
					'user_nama' => $row->f_nama,
					'user_logged_in' => TRUE,
					'login_time' => time()
					);
					$this->session->set_userdata($newdata);
				}
				redirect(site_url().'/inv');
			}
		} else {
			$this->form_validation->set_message('checkuser', 'Anda Tidak Diijinkan Login');
			return FALSE;
		}
	}
}