<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>Lancers!</title>
<script type="text/javascript" src="<?= base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url();?>js/jquery-ui-1.10.1.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url();?>js/jquery.uploadify.min.js" ></script>
<script  type="text/javascript"
	src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>js/home.js"></script>
	
<link rel="stylesheet"
	href="<?= base_url(); ?>css/theme/jquery-ui-1.10.1.custom.min.css"
	type="text/css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/uploadify.css"/>

<link rel="stylesheet" href="<?= base_url(); ?>css/style.css"
	type="text/css" />
	
<link rel="stylesheet" href="<?= base_url(); ?>css/home.css"
	type="text/css" />

	
<!--[if IE 6]><link rel="stylesheet" href="<?= base_url()?>css/style.ie6.css" type="text/css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" href="<?= base_url()?>css/style.ie7.css" type="text/css"/><![endif]-->

		<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'fileTypeDesc' : 'Image Files',
				'swf'      : '<?= base_url() ?>uploadify/uploadify.swf',
				'uploader' : '<?= base_url() ?>uploadify/uploadify.php',
				'onUploadComplete' : function(file) {
					
				var filename= file.name;
				var new_filename = filename.split('.',1).pop() + '_' + <?= $timestamp;?>+ '.' +filename.split('.',2).pop();
			$('<input/>').attr({ type: 'hidden', name: 'comment_files[]', value: '<?= base_url()?>files/' 
				+ new_filename
			}).appendTo("#comment_td");		
			$("<a>"+filename+"</a><br/>").attr({ href: '<?= base_url()?>files/' + new_filename, target: "_blank"}).appendTo("#comment_td");
	        }
		         
				
			});
		});
	</script>
	
	


</head>
<body>
	<div id="art-page-background-middle-texture">
		<div id="art-main">
			<div class="art-sheet">
				<div class="art-sheet-tl"></div>
				<div class="art-sheet-tr"></div>
				<div class="art-sheet-bl"></div>
				<div class="art-sheet-br"></div>
				<div class="art-sheet-tc"></div>
				<div class="art-sheet-bc"></div>
				<div class="art-sheet-cl"></div>
				<div class="art-sheet-cr"></div>
				<div class="art-sheet-cc"></div>
				<div class="art-sheet-body">
					<div class="art-nav">
						<div class="l"></div>
						<div class="r"></div>
						<ul class="art-menu">
							<?php 
							echo "<div class='logout_div'>";
							echo ' Mr.'.$this->session->userdata('user_name');
							echo '<a href='.base_url().'home/do_logout>Log out</a>';
							echo '</div>';

							$user_role=$this->session->userdata('user_role');

							switch($user_role)
							{
								case 'admin':
									?>
							<li><a href="<?= base_url(); ?>home/c_panel/main"><span class="l"></span><span
									class="r"></span><span class="t">Main</span> </a>
							</li>
							<li><a href="<?= base_url(); ?>home/c_panel/la_admins"><span
									class="l"></span><span class="r"></span><span class="t">Admins</span>
							</a>
							</li>
							<li><a href="<?= base_url(); ?>home/c_panel/la_lancers"><span
									class="l"></span><span class="r"></span><span class="t">Lancers</span>
							</a>
							</li>
							<li><a href="<?= base_url(); ?>home/c_panel/la_projects"><span
									class="l"></span><span class="r"></span><span class="t">Projects</span>
							</a>
							</li>

							<?php 
							break;
					case 'user':	?>
							<li><a href="<?= base_url(); ?>Home/c_panel/main"><span class="l"></span><span
									class="r"></span><span class="t"> Main </span> </a>
							</li>
							<li><a href="<?= base_url(); ?>Home/c_panel/la_projects"><span
									class="l"></span><span class="r"></span><span class="t">
										Projects </span></a>
							</li>
							<?php
							break;

					} ?>

					
						</ul>
					</div>
					
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-tl"></div>
				<div class="art-post-tr"></div>
				<div class="art-post-bl"></div>
				<div class="art-post-br"></div>
				<div class="art-post-tc"></div>
				<div class="art-post-bc"></div>
				<div class="art-post-cl"></div>
				<div class="art-post-cr"></div>
				<div class="art-post-cc"></div>
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<h2 class="art-postheader">
							<? ?>
						</h2>
						<div class="art-postcontent">
					