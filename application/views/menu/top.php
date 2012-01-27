<!-- css menu-->
<link
	rel="stylesheet" type="text/css"
	href="<?php echo base_url();?>public/yui/build/menu/assets/skins/sam/menu.css">

<!-- js -->
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/container/container_core-min.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url();?>public/yui/build/menu/menu-min.js"></script>

<style type="text/css">
a.yuimenubaritemlabel,a.yuimenuitemlabel {
	height: 100%;
	cursor: pointer !important;
}
</style>

<script> 
	YAHOO.util.Event.onContentReady("top_menu_utama", function () {
 
                /*
					Instantiate a MenuBar:  The first argument passed to the constructor
					is the id for the Menu element to be created, the second is an 
					object literal of configuration properties.
                */
 
                var oMenuBar = new YAHOO.widget.MenuBar("top_menu_utama", { 
                                                            autosubmenudisplay: true, 
                                                            hidedelay: 750, 
                                                            lazyload: true });
 
                /*
                     Call the "render" method with no arguments since the 
                     markup for this MenuBar instance is already exists in 
                     the page.
                */
 
                oMenuBar.render();
 
   });
</script>

<div id="top_menu_utama" class="yuimenubar yuimenubarnav">
	<div class="bd">
		<ul class="first-of-type">
			<li class="yuimenubaritem first-of-type"><a
				class="yuimenubaritemlabel" href="<?php echo site_url().'/inv';?>">Beranda</a>
			</li>
			
			
			
			
			
			
			
			
			
			<?php if ($this->session->userdata('user_logged_in')): ?>	
			<li class="yuimenubaritem"><a class="yuimenubaritemlabel" href="#menu_master_data">Master Data</a>
								<div id="menu_master_data" class="yuimenu">
					<div class="bd">

						<ul>
						<li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url().'/inv/master_lokasi';?>">Lokasi</a></li>
						</ul>
					</div>
				</div>
							</li>
			<li class="yuimenubaritem"><a class="yuimenubaritemlabel" class="yuimenuitemlabel" href="<?php echo site_url().'/inv/crud_rekap/tambah';?>">Barang Masuk</a></li>
			<li class="yuimenubaritem"><a class="yuimenubaritemlabel" href="#rekapitulasi">Rekapitulasi</a>
				<div id="rekapitulasi" class="yuimenu">
					<div class="bd">
						<ul>
						<li class="yuimenuitem"><a class="yuimenuitemlabel" href="#gedung">Berdasarkan Lokasi</a>
							<div id="gedung" class="yuimenu">
								<div class="bd">
									<ul>
									<?php 
									
									$sql = 'SELECT f_id, f_kode_lokasi, f_nama_lokasi FROM t_master_lokasi
											ORDER BY f_nama_lokasi ASC';
									$query = $this->db->query($sql);
									
									foreach ($query->result_array() as $row):
									
									?>
															<li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url().'/inv/rekap/'.$row['f_id'];?>"><?php echo $row['f_nama_lokasi'];?></a></li>
									<?php endforeach;?>
															</ul>
								</div>
							</div>
						</li>
						<li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url();?>/inv/rekap/t">Barang Terhapus</a>
					</ul>
					</div>
				</div>
			</li>
			<li class="yuimenubaritem"><a class="yuimenubaritemlabel" class="yuimenuitemlabel" href="<?php echo site_url();?>/inv/cari">Cari Data</a></li>
			<li class="yuimenubaritem"><a class="yuimenubaritemlabel" class="yuimenuitemlabel" href="<?php echo site_url();?>/user/logout"><font color="red"><b>Logout</b></font></a></li>
			<?php endif; ?>
		</ul>
	</div>
</div>
