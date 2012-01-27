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
			{key:"no",label:"No.", sortable:true},
			{key:"nama_barang",label:"Nama Barang", sortable:true},
			{key:"tipe_barang",label:"Tipe Barang", sortable:true},
            {key:"kode_barang",label:"Kode Barang", sortable:false},
            {label:"Kondisi Barang",
            	children: 	[
							{key:"kondisi_baik", label:"Baik", sortable:false},
							{key:"kondisi_rusak", label:"Rusak", sortable:false}
							]
                },
            {key:"tanggal_masuk",label:"Tanggal Masuk", formatter:YAHOO.widget.DataTable.formatDate, sortable:true},
            {key:"operasi",label:"Operasi", sortable:false},
        ];

        var myDataSource = new YAHOO.util.DataSource(YAHOO.util.Dom.get("accounts"));
        myDataSource.responseType = YAHOO.util.DataSource.TYPE_HTMLTABLE;
        myDataSource.responseSchema = {
            fields: [{key:"no"},
                    {key:"nama_barang"},
                    {key:"tipe_barang"},
                    {key:"kode_barang"},
                    {key:"kondisi_baik"},
                    {key:"kondisi_rusak"},
                    {key:"tanggal_masuk"},
                    {key:"operasi"},
            ]
        };
        <?php 
		
		if ($this->uri->segment(3) == 't') {
			$rekap = 'Barang Terhapus';
		} else {
			$sql = 'SELECT f_nama_lokasi, f_kode_lokasi  FROM t_master_lokasi WHERE f_id=?';
			$binds = array($this->uri->segment(3));
			$row = $this->db->query($sql, $binds)->row_array();
			
			$rekap = $row['f_nama_lokasi'].' ('.$row['f_kode_lokasi'].'). <a href=\"'.site_url().'/inv/download_rekap/'.$this->uri->segment(3).'/'.$row['f_kode_lokasi'].'\">Download</a>';
		}
		
		?>
		
        var myDataTable = new YAHOO.widget.DataTable("markup", myColumnDefs, myDataSource,
                {caption:"Rekapitulasi: <?php echo $rekap; ?>",
                sortedBy:{key:"no",dir:"asc"}}
        );
        
        return {
            oDS: myDataSource,
            oDT: myDataTable
        };
    }();
});
</script>
<?php
if ($this->session->flashdata('message')) {
echo '<div id="message">'.$this->session->flashdata('message').'</div>';
}
?>
<div id="markup">
	<table id="accounts">
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama Barang</th>
				<th>Tipe Barang</th>
				<th>Kode Barang</th>
				<th>Baik</th>
				<th>Rusak</th>
				<th>Tanggal Masuk</th>
				<th>Operasi</th>
			</tr>
		</thead>
		<tbody>
			
			
		<?php
		if ($this->uri->segment(3) == 't') {
			$sql = 'SELECT t_list_barang.f_id, f_kode, f_nama_barang, f_tipe_barang, f_jumlah,
					f_jumlah_kondisi_baik, f_tanggal_masuk
					FROM t_list_barang
					WHERE f_status_hapus=?';
			$binds = array($this->uri->segment(3));
			
		} else {
			$sql = 'SELECT t_list_barang.f_id, f_kode, f_nama_barang, f_tipe_barang, f_jumlah,
			       	f_jumlah_kondisi_baik, f_tanggal_masuk
			  		FROM t_list_barang
					WHERE ref_master_lokasi_f_id=? AND f_status_hapus=?';
			$binds = array($this->uri->segment(3), 'f');
		}
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result_array() as $row) {
				if ($this->uri->segment(3) == 't') {
					$hapus_restore = '<li><a href="'.site_url().'/inv/crud_rekap/balikin/'.$row['f_id'].'" title="Restore Data" onclick="return confirm(\'Anda Yakin Ingin Merestore Record Ini ?\');">restore</a></li>';
				} else {
					$hapus_restore = '<li><a href="'.site_url().'/inv/crud_rekap/hapus/'.$row['f_id'].'" title="Hapus" onclick="return confirm(\'Anda Yakin Ingin Hapus Record Ini ?\');">hapus</a></li>';
				}
				
				$kondisi_rusak = $row['f_jumlah'] - $row['f_jumlah_kondisi_baik'];
				$i++;
				echo '<tr><td>'.$i.'</td><td>'.$row['f_nama_barang'].'</td><td>'.$row['f_tipe_barang'].'</td><td>'.$row['f_kode'].'</td>
				<td>'.$row['f_jumlah_kondisi_baik'].'</td><td>'.$kondisi_rusak.'</td><td>'.date('d M Y', strtotime($row['f_tanggal_masuk'])).'</td>
				<td><ul id="actionlist">
				<li><a href="'.site_url().'/inv/crud_rekap/ubah/'.$row['f_id'].'" title="Ubah">ubah</a></li>
				<li>|</li>'.$hapus_restore.'
				</ul></td></tr>';
			}
		} else { echo '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>';
		}
		?>
		</tbody>
	</table>
</div>
