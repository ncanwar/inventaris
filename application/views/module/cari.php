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



	<?php
	$attributes = array ( 'name' => 'cari_data', 'method' => 'get');

	echo form_open(current_url(), $attributes);
	$cari_data = array(
	'name' => 'cari_data',
	'id' => 'cari_data',
	'maxlength' => '100',
	'value' => strip_tags(trim($this->input->get('cari_data')))
	);
	echo '<p><label>Kata Kunci : </label><div id="myAutoComplete">'.form_input($cari_data).'<div id="cari_data_container"></div></div></p>';

	$sql = 'SELECT DISTINCT f_kode FROM t_list_barang';
	$kode_barang = $this->db->query($sql);
	
	$sql = 'SELECT DISTINCT f_nama_barang FROM t_list_barang';
	$nama_barang = $this->db->query($sql);
	
	$sql = 'SELECT DISTINCT f_tipe_barang FROM t_list_barang';
	$tipe_barang = $this->db->query($sql);
	

	?>

<script type="text/javascript">
	YAHOO.example.Data = {
			arrayStates: [
							<?php
							foreach ($kode_barang->result_array() as $row){
								echo '"'.$row['f_kode'].'",';
							}
							foreach ($nama_barang->result_array() as $row){
								echo '"'.$row['f_nama_barang'].'",';
							}
							foreach ($tipe_barang->result_array() as $row){
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
			var oAC = new YAHOO.widget.AutoComplete("cari_data", "cari_data_container", oDS);
			oAC.prehighlightClassName = "yui-ac-prehighlight";
			oAC.useShadow = true;
	
			return {
				oDS: oDS,
				oAC: oAC
			};
	}();
	</script>


	<?php
	echo '<p class="submit">'.form_submit('cari', ' Cari ').'</p>';
	echo form_close();

	if ($this->input->get('cari') && trim($this->input->get('cari_data'))) {
		$keyword = '%'.strtoupper(strip_tags(trim($this->input->get('cari_data')))).'%';
		?>
<!-- css table-->
<link
	rel="stylesheet" type="text/css"
	href="<?php echo base_url();?>public/yui/build/datatable/assets/skins/sam/datatable.css" />

<!-- js -->
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/element/element-min.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/datasource/datasource-min.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/event-delegate/event-delegate-min.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/datatable/datatable-min.js"></script>

<script type="text/javascript">
	YAHOO.util.Event.addListener(window, "load", function() {
		YAHOO.example.EnhanceFromMarkup = function() {
	
			var myColumnDefs = [
			{
				key:"no",label:"No.", sortable:true},
				{
					key:"nama_barang",label:"Nama Barang", sortable:true},
					{
						key:"tipe_barang",label:"Tipe Barang", sortable:true},
						{
							key:"kode_barang",label:"Kode Barang", sortable:false},
							{
								key:"kode_lokasi",label:"Kode Lokasi", sortable:true},
							{
								label:"Kondisi Barang",
								children: 	[
								{
									key:"kondisi_baik", label:"Baik", sortable:false},
									{
										key:"kondisi_rusak", label:"Rusak", sortable:false}
										]
							},
							{
								key:"tanggal_masuk",label:"Tanggal Masuk", sortable:true},
								{
									key:"operasi",label:"Operasi", sortable:false},
									];
	
									var myDataSource = new YAHOO.util.DataSource(YAHOO.util.Dom.get("accounts"));
									myDataSource.responseType = YAHOO.util.DataSource.TYPE_HTMLTABLE;
									myDataSource.responseSchema = {
										fields: [{
											key:"no"},
											{
												key:"nama_barang"},
												{
													key:"tipe_barang"},
													{
														key:"kode_barang"},
														{
															key:"kode_lokasi"},
														{
															key:"kondisi_baik"},
															{
																key:"kondisi_rusak"},
																{
																	key:"tanggal_masuk"},
																	{
																		key:"operasi"},
																		]
									};
			
	        var myDataTable = new YAHOO.widget.DataTable("markup", myColumnDefs, myDataSource,
	                {caption:"Hasil Pencarian",
	                sortedBy:{key:"no",dir:"asc"}}
	        );
	        
	        return {
	            oDS: myDataSource,
	            oDT: myDataTable
	        };
	    }();
	});
	</script>

<div id="markup">
	<table id="accounts">
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama Barang</th>
				<th>Tipe Barang</th>
				<th>Kode Barang</th>
				<th>Kode Lokasi</th>
				<th>Baik</th>
				<th>Rusak</th>
				<th>Tanggal Masuk</th>
				<th>Operasi</th>
			</tr>
		</thead>
		<tbody>
			
			


		<?php
		$sql = 'SELECT t_list_barang.f_id, f_kode, f_nama_barang, f_tipe_barang, f_jumlah, t_master_lokasi.f_kode_lokasi,
	       		f_jumlah_kondisi_baik, f_tanggal_masuk
	  			FROM t_list_barang
	  			INNER JOIN t_master_lokasi ON t_master_lokasi.f_id = t_list_barang.ref_master_lokasi_f_id
				WHERE ((f_nama_barang LIKE ? OR f_tipe_barang LIKE ? OR f_kode LIKE ?) AND (f_status_hapus=?))';
		$binds = array($keyword, $keyword, $keyword, 'f');
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result_array() as $row) {
				$kondisi_rusak = $row['f_jumlah'] - $row['f_jumlah_kondisi_baik'];
				$i++;
				echo '<tr><td>'.$i.'</td><td>'.$row['f_nama_barang'].'</td><td>'.$row['f_tipe_barang'].'</td><td>'.$row['f_kode'].'</td>
					<td>'.$row['f_kode_lokasi'].'</td><td>'.$row['f_jumlah_kondisi_baik'].'</td><td>'.$kondisi_rusak.'</td><td>'.date('d M Y', strtotime($row['f_tanggal_masuk'])).'</td>
					<td><ul id="actionlist">
					<li><a href="'.site_url().'/inv/crud_rekap/ubah/'.$row['f_id'].'" title="Ubah">ubah</a></li>
					<li>|</li>
					<li><a href="'.site_url().'/inv/crud_rekap/hapus/'.$row['f_id'].'" title="Hapus" onclick="return confirm(\'Anda Yakin Ingin Hapus Record Ini ?\');">hapus</a></li>
					</ul></td></tr>';
			}
		} else { echo '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>';
		}
		?>
		</tbody>
	</table>
</div>

<?php
	}