<!--
Author: "Nur Cholikul Anwar" <nc.anwar@jaringankantor.com>
Web: JaringanKantor.Com
 -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title><?php echo isset($title) ? $title : ''?></title>
<link rel="stylesheet"
	href="<?php echo base_url();?>public/yui/build/reset-fonts-grids/reset-fonts-grids.css"
	type="text/css">
<link rel="stylesheet"
	href="<?php echo base_url();?>public/css/style.css" type="text/css">

<script src="<?=base_url();?>public/js/jquery-1.5.2.min.js"
	type="text/javascript"></script>

<script type="text/javascript"> 
    var GB_ROOT_DIR = "<?=base_url();?>public/greybox/";
</script>

<script type="text/javascript"
	src="<?=base_url();?>public/greybox/AJS.js"></script>
<script type="text/javascript"
	src="<?=base_url();?>public/greybox/AJS_fx.js"></script>
<script type="text/javascript"
	src="<?=base_url();?>public/greybox/gb_scripts.js"></script>
<link href="<?=base_url();?>public/greybox/gb_styles.css"
	rel="stylesheet" type="text/css" />

<script type="text/javascript">
GB_myShow = function(caption, url, height, width, is_reload_on_close) {
	var options = {
		caption: caption,
		height: height || 500,
		width: width || 500,
		fullscreen: false,
		overlay_click_close: true,
		show_loading: true,
		reload_on_close: is_reload_on_close || false
	}
	var
	win = new GB_Window(options);
	return win.show(url);
}
</script>

</head>
<body class="yui-skin-sam">
	<div id="doc3" class="yui-t7">
		<div id="hd">
			<img src="<?php echo base_url();?>public/images/logo_pnj_small.JPG"
				border="0px" align="left" id="logo_pnj" />
			<h2 class="pnj_header_text">Teknik Elektro PNJ</h2>
			<h6 class="pnj_header_slogan">
				<i>sistem inventaris barang</i>
			</h6>
		</div>
		<div id="bd">
			
			
		<?php echo isset($menu_top) ? $this->load->view($menu_top) : ''?>
			<div class="yui-g">




			<?php echo isset($content) ? $this->load->view($content) : ''?>
			</div>
		</div>
		<div id="ft">
			<p>&nbsp;</p>
			<hr />
			<p align="right">
				<small><i>Copyright &copy; 2011 Teknik Elektro PNJ. All Rights Reserved.&nbsp;</i> </small>
			</p>
		</div>
	</div>
</body>
</html>
