<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lancers!</title>

<link rel="stylesheet" href="<?= base_url(); ?>css/style.css"
	type="text/css" />
	
<link rel="stylesheet" href="<?= base_url(); ?>css/home.css"
	type="text/css" />
	
<!--[if IE 6]><link rel="stylesheet" href="<?= base_url()?>css/style.ie6.css" type="text/css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" href="<?= base_url()?>css/style.ie7.css" type="text/css"/><![endif]-->
	
<link rel="stylesheet"
	href="<?= base_url(); ?>css/theme/jquery-ui-1.10.1.custom.min.css"
	type="text/css" />
	
<script type="text/javascript" src="<?= base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url()?>js/home.js"></script>
<script src="<?= base_url();?>js/jquery-ui-1.10.1.custom.min.js"></script>

<script language="javascript" type="text/javascript"
	src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js"></script>
	
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
					case 'lancer':	?>
							<li><a href="<?= base_url(); ?>Home/c_panel/home"><span class="l"></span><span
									class="r"></span><span class="t"> Main </span> </a>
							</li>
							<li><a href="<?= base_url(); ?>Home/c_panel/la_lancers"><span
									class="l"></span><span class="r"></span><span class="t">
										Projects </span> </a>
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
									<div class="art-post-body">
										<div class="art-post-inner art-article">
											<div class="art-postcontent">