<link rel="stylesheet" type="text/css"
	href="<?=base_url()?>public/css/style.css">



	<?php
	switch ($this->uri->segment(3)) {
		case 'hapus':
			$sql = 'DELETE FROM t_master_lokasi WHERE f_id=?';
			$binds = array($this->uri->segment(4));
			$query = $this->db->query($sql, $binds);
			redirect($_SERVER['HTTP_REFERER']);
			break; //end case hapus
		case 'tambah' OR 'ubah':
			//Untuk Mengambil Data
			$sql = 'SELECT f_kode_lokasi, f_nama_lokasi FROM t_master_lokasi WHERE f_id=? ORDER BY f_kode_lokasi ASC';
			$binds = array($id = $this->uri->segment(4));

			$query = $this->db->query($sql, $binds);

			$default = $query->row_array();

			$this->form_validation->set_rules('f_kode_lokasi', 'Kode Lokasi', 'trim|xss_clean|encode_php_tags|required|callback_cekkodelokasiexist');
			$this->form_validation->set_rules('f_nama_lokasi', 'Nama Lokasi', 'trim|xss_clean|encode_php_tags|required|callback_ceknamaexist');


			if ($this->form_validation->run() == TRUE) {

				$f_kode_lokasi = strtoupper($this->input->post('f_kode_lokasi'));
				$f_nama_lokasi = strtoupper($this->input->post('f_nama_lokasi'));
				$f_id = $this->uri->segment(4);

				switch ($this->uri->segment(3)) {
					case 'tambah':
						$sql = 'INSERT INTO t_master_lokasi(f_kode_lokasi, f_nama_lokasi)
								VALUES (?, ?)';
						$binds = array($f_kode_lokasi, $f_nama_lokasi);
							
						$query = $this->db->query($sql, $binds);
							
						if ($query) {
							echo '<script type="text/javascript">parent.parent.GB_hide();</script>';
						} else { echo 'Data Gagal Diinput<br /><input type="button" onclick="refreshParent();" value="Tutup Form Ini">';
						}
						break;

					case 'ubah':
						$sql = 'UPDATE t_master_lokasi set f_kode_lokasi=?, f_nama_lokasi=?
								WHERE f_id=?';
						$binds = array($f_kode_lokasi, $f_nama_lokasi, $f_id);
							
						$query = $this->db->query($sql, $binds);
							
						if ($query) {
							echo '<script type="text/javascript">parent.parent.GB_hide();</script>';
						} else { echo 'Data Gagal Diupdate<br /><input type="button" onclick="refreshParent();" value="Tutup Form Ini">';
						}
						break;

					case 'hapus':
						$sql = 'DELETE FROM t_master_lokasi WHERE f_id=?';
						$binds = array($f_id);
							
						$query = $this->db->query($sql, $binds);

						if ($query) {
							echo '<script type="text/javascript">parent.parent.GB_hide();</script>';
						} else { echo 'Data Gagal Dihapus<br /><input type="button" onclick="refreshParent();" value="Tutup Form Ini">';
						}
						break;
				}

			} else {

				echo form_open(current_url());

				$f_kode_lokasi = array(
				'name' => 'f_kode_lokasi',
				'maxlength' => '20',
				'value' => set_value('f_kode_lokasi', isset($default['f_kode_lokasi']) ? $default['f_kode_lokasi'] : '')
				);
				echo '<p><label>Kode Lokasi :</label>'.form_input($f_kode_lokasi).form_error('f_kode_lokasi', '<small><i>', '</i></small>').'</p>';

				$f_nama_lokasi = array(
				'name' => 'f_nama_lokasi',
				'value' => set_value('f_nama_lokasi', isset($default['f_nama_lokasi']) ? $default['f_nama_lokasi'] : '')
				);
				echo '<p><label>Nama Lokasi :</label>'.form_input($f_nama_lokasi).form_error('f_nama_lokasi', '<small><i>', '</i></small>').'</p>';

				echo '<p class="submit">'.form_submit($this->uri->segment(3), strtoupper($this->uri->segment(3))).'</p>';

				echo form_close();
			}
			break; //end case tambah or ubah

	}