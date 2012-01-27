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
            {key:"kode_lokasi",label:"Kode Lokasi", sortable:true},
            {key:"nama_lokasi",label:"Nama Lokasi", sortable:true},
            {key:"operasi",label:"Operasi", sortable:false},
        ];

        var myDataSource = new YAHOO.util.DataSource(YAHOO.util.Dom.get("accounts"));
        myDataSource.responseType = YAHOO.util.DataSource.TYPE_HTMLTABLE;
        myDataSource.responseSchema = {
            fields: [{key:"no"},
                    {key:"kode_lokasi"},
                    {key:"nama_lokasi"},
                    {key:"operasi"},
            ]
        };

        var myDataTable = new YAHOO.widget.DataTable("markup", myColumnDefs, myDataSource,
                {caption:"Master Data Lokasi. <a href=\"<?php echo site_url().'/inv/crud_master_lokasi/tambah';?>\" onclick=\"return GB_myShow('Tambah', this.href, 300,700, true)\" title=\"Tambah\">(+)Tambah</a>",
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
				<th>Kode Lokasi</th>
				<th>Nama Lokasi</th>
				<th>Operasi</th>
			</tr>
		</thead>
		<tbody>
			
			
			
			
			
		<?php
		$sql = 'SELECT f_id, f_kode_lokasi, f_nama_lokasi FROM t_master_lokasi ORDER BY f_kode_lokasi ASC';
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result_array() as $row) {
				$i++;
				echo '<tr><td>'.$i.'</td><td>'.$row['f_kode_lokasi'].'</td><td>'.$row['f_nama_lokasi'].'</td><td>
				<ul id="actionlist">
				<li><a href="'.site_url().'/inv/crud_master_lokasi/ubah/'.$row['f_id'].'" onclick="return GB_myShow(\'Ubah\', this.href, 300,700, true)" title="Ubah">ubah</a></li>
				<li>|</li>
				<li><a href="'.site_url().'/inv/crud_master_lokasi/hapus/'.$row['f_id'].'" title="Hapus" onclick="return confirm(\'Anda Yakin Ingin Hapus Record Ini ?\');">hapus</a></li>
				</ul></td></tr>';
			}
		} else { echo '<tr><td colspan="99">Data tidak ditemukan.</td></tr>';
		}
		?>
		</tbody>
	</table>
</div>
