<!DOCTYPE html>
<html dir="rtl" lang="fa" xml:lang="fa" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?=$C->SITE_TITLE?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
		<script src="<?=$C->SITE_URL?>templates/<?=$C->template?>/js/jquery.min.js" ></script>
		<!--logged-->
		<script>
			var SITE_URL = "<?=$C->SITE_URL?>";
			var SITE_PATH = "panel/";
		</script>
		<script src="<?=$C->SITE_URL?>templates/<?=$C->template?>/plugins/jquery-ui/jquery-ui.js"></script>
		<link href="<?=$C->SITE_URL?>templates/<?=$C->template?>/plugins/jquery-ui/jquery-ui.css" rel="stylesheet">
		<script src="<?=$C->SITE_URL?>templates/<?=$C->template?>/js/uploader.js" ></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		
		<link rel="preload stylesheet" href="<?=$C->SITE_URL?>templates/<?=$C->template?>/css/home.css" as="style" media="all">
	</head>
	<body>
<?php if(!isset($D->disable_header_template)){ ?>
			<header>
			<div class="container">
			<div class="header">
				<nav>
				<ul class="navbar">
					<li onclick="menu_opener()" class="menu-opener">☰</li>
					<li class="logo"><a href="<?=$C->SITE_URL?>"><?=$C->SITE_TITLE?></a></li>
					<?php if($this->user->check_login()){ ?>
					<li><a href="<?=$C->SITE_URL?>panel/settings/"><i class="fa-solid fa-gear"></i></a></li>
					<?php } ?>
					<li class="signin"><a href="<?=$C->SITE_URL?>authentication/" id="panelButton"><?=$this->lang("account")?></a></li>
					<?php if($this->user->check_login()){ ?>
					<li class="signin newPost"><a href="<?=$C->SITE_URL?>panel/post/"><?=$this->lang("new post")?></a></li>
					<?php } ?>
					<?php if($this->user->check_login()){ ?>
					<li class="signin newPost"><a href="<?=$C->SITE_URL?>logout/"><?=$this->lang("logout")?></a></li>
					<?php } ?>
					<?php if($this->user->check_admin()){ ?>
						<li class="signin newPost"><a href="<?=$C->SITE_URL?>admin/"><?=$this->lang("admin")?></a></li>
					<?php } ?>
				</ul>
				</nav>
			</div>
			<script>
			function show_hide(id){
				var x = document.getElementById(id);
				if (x.style.display != "block"&&x.style.display != "inline-block") {
					x.style.display = "block";
				} else {
					x.style.display = "none";
				}
			}
			function menu_opener(){
				show_hide("menu");
			}
			</script>
			</div>
			</header>
<?php } ?>
		<div class="container">
<?php if(isset($D->breadcrumb)&&count($D->breadcrumb)>0){ ?>
	<div class="breadcrumb_container">
	<ul class="breadcrumb">
		<?php foreach($D->breadcrumb as $item){ ?>
		<li><a href="<?=$item->url?>"><?=$this->lang($item->label)?></a></li>	
		<?php } ?>
	</ul>
	</div>
<?php } ?>
			<main class="content" id="<?=implode("_",$this->request)?>">