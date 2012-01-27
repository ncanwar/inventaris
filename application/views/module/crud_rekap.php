<link rel="stylesheet" type="text/css"
	href="<?php echo base_url();?>public/yui/build/autocomplete/assets/skins/sam/autocomplete.css" />
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/animation/animation-min.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/datasource/datasource-min.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/autocomplete/autocomplete-min.js"></script>
<link
	rel="stylesheet"
	href="<?=base_url().'public/css/smoothness/jquery-ui-1.8.11.custom.css'?>">
<script
	src="<?=base_url().'public/js/jquery-1.5.2.min.js'?>"></script>
<script
	src="<?=base_url().'public/js/jquery-ui-1.8.11.custom.min.js'?>"></script>

<!-- Untuk Menampilkan tanggal -->
<script>
	$(function() {
		$( "#datepicker" ).datepicker( {
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		
	});
</script>



<?php
switch ($this->uri->segment(3)) {
	case 'balikin':
		$sql = 'UPDATE t_list_barang SET f_status_hapus=? WHERE f_id=?';
		$binds = array('f', $this->uri->segment(4));
		$query = $this->db->query($sql, $binds);
		redirect($_SERVER['HTTP_REFERER']);
		break; //end case balikin
	case 'hapus':
		$sql = 'SELECT f_jumlah_kondisi_baik FROM t_list_barang WHERE f_id=?';
		$binds = array($this->uri->segment(4));
		$row = $this->db->query($sql, $binds)->row_array();
		
		if ($row['f_jumlah_kondisi_baik'] == 0) {
			$sql = 'UPDATE t_list_barang SET f_status_hapus=? WHERE f_id=?';
			$binds = array('t', $this->uri->segment(4));
			$query = $this->db->query($sql, $binds);
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata('message', 'Data Ini Tidak Boleh Dihapus Karena Belum Semua Barang Rusak');
			redirect($_SERVER['HTTP_REFERER']);
		}
		break; //end case hapus
	case 'tambah' OR 'ubah':
		$this->form_validation->set_rules('f_kode', 'Kode Barang', 'trim|xss_clean|encode_php_tags|required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('f_nama_barang', 'Nama Barang', 'trim|xss_clean|encode_php_tags|required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('f_tipe_barang', 'Tipe Barang', 'trim|xss_clean|encode_php_tags|max_length[100]');
		$this->form_validation->set_rules('f_jumlah', 'Jumlah Barang', 'trim|xss_clean|encode_php_tags|required|is_natural_no_zero');

		if ($this->uri->segment(3) == 'ubah') {
			$this->form_validation->set_rules('f_jumlah_kondisi_baik', 'Jumlah Kondisi Baik', 'trim|xss_clean|encode_php_tags|required|is_natural|callback_kecildarijumlah');
		}

		$this->form_validation->set_rules('f_tanggal_masuk', 'Tanggal Masuk', 'trim|xss_clean|encode_php_tags|required|exact_length[10]');

		if ($this->form_validation->run() == TRUE) {
			$f_kode = strtoupper($this->input->post('f_kode', TRUE));
			$f_nama_barang = strtoupper($this->input->post('f_nama_barang', TRUE));
			$f_tipe_barang = strtoupper($this->input->post('f_tipe_barang', TRUE));
			$f_jumlah = $this->input->post('f_jumlah', TRUE);

			if ($this->uri->segment(3) == 'ubah' OR $this->uri->segment(3) == 'hapus') {
				$f_id = $this->uri->segment(4);
			}

			if ($this->uri->segment(3) == 'ubah') {
				$f_jumlah_kondisi_baik = $this->input->post('f_jumlah_kondisi_baik', TRUE);
			}

			$ref_master_lokasi_f_id = strtoupper($this->input->post('ref_master_lokasi_f_id', TRUE));
			$f_tanggal_masuk = strtoupper($this->input->post('f_tanggal_masuk', TRUE));

			switch ($this->uri->segment(3)) {
				case 'tambah':
					$sql = 'INSERT INTO t_list_barang(f_kode, f_nama_barang, f_tipe_barang, f_jumlah, ref_master_lokasi_f_id, f_jumlah_kondisi_baik, f_tanggal_masuk) VALUES(?, ?, ?, ?, ?, ?, ?)';
					$binds = array($f_kode, $f_nama_barang, $f_tipe_barang, $f_jumlah, $ref_master_lokasi_f_id, $f_jumlah, $f_tanggal_masuk);

					$query = $this->db->query($sql, $binds);

					if ($query) {
						$this->session->set_flashdata('message', 'Data Berhasil Diinput');
						redirect(site_url().'/inv/crud_rekap/tambah');
					} else {
						$this->session->set_flashdata('message', '<b><u>DATA GAGAL DIINPUT, SILAHKAN ULANGI</u><b>');
						redirect(site_url().'/inv/crud_rekap/tambah');
					}
					break;

				case 'ubah':
					$sql = 'UPDATE t_list_barang
   					SET f_kode=?, f_nama_barang=?, f_tipe_barang=?, f_jumlah=?, 
       				ref_master_lokasi_f_id=?, f_jumlah_kondisi_baik=?, f_tanggal_masuk=?
					WHERE f_id=?';
					$binds = array($f_kode, $f_nama_barang, $f_tipe_barang, $f_jumlah, $ref_master_lokasi_f_id, $f_jumlah_kondisi_baik, $f_tanggal_masuk, $f_id);

					$query = $this->db->query($sql, $binds);

					if ($query) {
						$this->session->set_flashdata('message', 'Data Berhasil Diupdate');
						redirect($_SERVER['HTTP_REFERER']);
					} else {
						$this->session->set_flashdata('message', '<b><u>DATA GAGAL DIINPUT, SILAHKAN ULANGI</u><b>');
						redirect($_SERVER['HTTP_REFERER']);
					}
					break;
			}

		} else {

			if ($this->uri->segment(3) == 'ubah') {
				$sql = 'SELECT f_kode, f_nama_barang, f_tipe_barang, f_jumlah, ref_master_lokasi_f_id,
       			f_jumlah_kondisi_baik, f_tanggal_masuk
  				FROM t_list_barang
				WHERE f_id=?';
				$binds = array($this->uri->segment(4));

				$query = $this->db->query($sql, $binds);

				$default = $query->row_array();

			}

			if(form_error('f_kode') || form_error('f_nama_barang') || form_error('f_tipe_barang')  || form_error('f_jumlah') || form_error('f_jumlah_kondisi_baik') || form_error('f_tanggal_masuk') || $this->session->flashdata('message')) {
				$flashmessage['f_kode']=form_error('f_kode', '<i>', '</i>');
				$flashmessage['f_nama_barang']=form_error('f_nama_barang', '<i>', '</i>');
				$flashmessage['f_tipe_barang']=form_error('f_tipe_barang', '<i>', '</i>');
				$flashmessage['f_jumlah']=form_error('f_jumlah', '<i>', '</i>');
				$flashmessage['f_jumlah_kondisi_baik']=form_error('f_jumlah_kondisi_baik', '<i>', '</i>');
				$flashmessage['f_tanggal_masuk']=form_error('f_tanggal_masuk', '<i>', '</i>');
				$flashmessage['message']=$this->session->flashdata('message');
				echo '<div id="message"><ul>';
				foreach ($flashmessage as $key => $value){
					echo !empty($flashmessage[$key]) ? '<li>'.$flashmessage[$key].'</li>' : '';
				}
				echo '</ul></div>';
			}

			echo form_open(current_url());

			$f_kode = array(
			'name' => 'f_kode',
			'maxlength' => '50',
			'value' => set_value('f_kode', isset($default['f_kode']) ? $default['f_kode'] : '')
			);
			echo '<p class="baris_form"><label>Kode Barang : </label>'.form_input($f_kode).'</p>';

			$f_nama_barang = array(
			'name' => 'f_nama_barang',
			'id' => 'f_nama_barang',
			'maxlength' => '100',
			'value' => set_value('f_nama_barang', isset($default['f_nama_barang']) ? $default['f_nama_barang'] : '')
			);
			echo '<p><label>Nama Barang : </label><div id="myAutoComplete">'.form_input($f_nama_barang).'<div id="f_nama_barang_container"></div></div></p>';

			$sql = 'SELECT DISTINCT f_nama_barang FROM t_list_barang';
			$query = $this->db->query($sql);

			?>
<script type="text/javascript">
	YAHOO.example.Data = {
		arrayStates: [
						<?php foreach ($query->result_array() as $row){
							echo '"'.$row['f_nama_barang'].'",';
						}
						?>		]
	};
	</script>
<script type="text/javascript">
	YAHOO.example.BasicLocal = function() {
		// Use a LocalDataSource
		var oDS = new YAHOO.util.LocalDataSource(YAHOO.example.Data.arrayStates);
		// Optional to define fields for single-dimensional array
		oDS.responseSchema = {
			fields : ["state"]};
	
			// Instantiate the AutoComplete
			var oAC = new YAHOO.widget.AutoComplete("f_nama_barang", "f_nama_barang_container", oDS);
			oAC.prehighlightClassName = "yui-ac-prehighlight";
			oAC.useShadow = true;
	
			return {
				oDS: oDS,
				oAC: oAC
			};
	}();
	</script>


	<?php

	$f_tipe_barang = array(
	'name' => 'f_tipe_barang',
	'id' => 'f_tipe_barang',
	'maxlength' => '100',
	'value' => set_value('f_tipe_barang', isset($default['f_tipe_barang']) ? $default['f_tipe_barang'] : '')
	);
	echo '<p><label>Tipe Barang : </label><div id="myAutoComplete">'.form_input($f_tipe_barang).'<div id="f_tipe_barang_container"></div></div></p>';

	$sql = 'SELECT DISTINCT f_tipe_barang FROM t_list_barang';
	$query = $this->db->query($sql);

	?>

<script type="text/javascript">
	YAHOO.example.Data = {
			arrayStates: [
							<?php foreach ($query->result_array() as $row){
								echo '"'.$row['f_tipe_barang'].'",';
							}
							?>		]
		};
	</script>
<script type="text/javascript">
	YAHOO.example.BasicLocal = function() {
		// Use a LocalDataSource
		var oDS = new YAHOO.util.LocalDataSource(YAHOO.example.Data.arrayStates);
		// Optional to define fields for single-dimensional array
		oDS.responseSchema = {
			fields : ["state"]};
	
			// Instantiate the AutoComplete
			var oAC = new YAHOO.widget.AutoComplete("f_tipe_barang", "f_tipe_barang_container", oDS);
			oAC.prehighlightClassName = "yui-ac-prehighlight";
			oAC.useShadow = true;
	
			return {
				oDS: oDS,
				oAC: oAC
			};
	}();
	</script>









	<?php
	$f_jumlah = array(
		'name' => 'f_jumlah',
		'maxlength' => '15',
		'value' => set_value('f_jumlah', isset($default['f_jumlah']) ? $default['f_jumlah'] : '')
	);
	echo '<p class="baris_form"><label>Jumlah Barang : </label>'.form_input($f_jumlah).'</p>';


	if ($this->uri->segment(3) == 'ubah') {
		$f_jumlah_kondisi_baik = array(
		'name' => 'f_jumlah_kondisi_baik',
		'maxlength' => '15',
		'value' => set_value('f_jumlah_kondisi_baik', isset($default['f_jumlah_kondisi_baik']) ? $default['f_jumlah_kondisi_baik'] : '')
		);
		echo '<p class="baris_form"><label>Kondisi Baik : </label>'.form_input($f_jumlah_kondisi_baik).'</p>';
	}

	$sql = 'SELECT f_id, f_kode_lokasi, f_nama_lokasi FROM t_master_lokasi
			ORDER BY f_kode_lokasi ASC';
	$query = $this->db->query($sql);

	$ref_master_lokasi_f_id = array();
	foreach ($query->result_array() as $row) {
		$ref_master_lokasi_f_id[$row['f_id']] = '('.$row['f_kode_lokasi'].') '.$row['f_nama_lokasi'];
	}
	echo '<p class="baris_form"><label>Lokasi Barang :</label>'.form_dropdown('ref_master_lokasi_f_id', $ref_master_lokasi_f_id, isset($default['ref_master_lokasi_f_id']) ? $default['ref_master_lokasi_f_id'] : '').'</p>';


	if ($this->uri->segment(3) == 'tambah') {
		$default['f_tanggal_masuk'] = date('Y-m-d');
	}

	$f_tanggal_masuk = array(
		'name' => 'f_tanggal_masuk',
		'id' => 'datepicker',
		'maxlength' => '10',
		'value' => set_value('f_tanggal_masuk', isset($default['f_tanggal_masuk']) ? $default['f_tanggal_masuk'] : '')
	);
	echo '<p class="baris_form"><label>Tanggal Masuk : </label>'.form_input($f_tanggal_masuk).'</p>';

	echo '<p class="baris_form"><label>&nbsp;</label>Format: YYYY-MM-DD</p>';

	echo '<p class="submit">'.form_submit($this->uri->segment(3), ' '.strtoupper($this->uri->segment(3)).' ').'</p>';

	echo form_close();
}
break; //end case tambah or ubah
}