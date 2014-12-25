<?php
	session_start();

	if (isset($_GET['lang'])){
		$_SESSION['langguage']=$_GET['lang'];
	}

	$base_url = str_replace(basename(__FILE__), '', $_SERVER['PHP_SELF']);
	$parsedUrl = parse_url($_SERVER['REQUEST_URI']);
	$resource = explode('/', $_GET['resource']);
	$page = $resource[0];
	if ( empty($page)){
		$page = 'index';
	}
	//if (isset($_SESSION['inloggning'])){
		if ($_SESSION['langguage']=='sv') {
				$htmdir = "content/sv_htm/";
				$draftdir = "content/sv_draft/";
				$lang = '<a href="index?lang=en">English</a>';
		} else if ($_SESSION['langguage']=='en') {
				$htmdir = "content/en_htm/";
				$draftdir = "content/en_draft/";
				$lang = '<a href="index?lang=sv">Svenska</a>';
		} else {
				$htmdir = "content/sv_htm/";
				$draftdir = "content/sv_draft/";
				$lang = '<a href="index.php?lang=en">English</a>';
				$_SESSION['langguage']='sv';
		}

	if (isset($_SESSION["inloggning"])) { //om inloggning är sant visa rediger länken
		$htmdir = $draftdir;
		$needPublish = $_SESSION[$_SESSION['langguage']."_edited"] == true ? 'bg-danger' : '';
		$edithtml = '<div class="edit"> <a href="app/redigera.php?aktivid='.$page.'&file='.$htmdir.$page.'.php"></a> </div>';
		$editaside = '<div class="edit"><a href="app/redigera.php?aktivid='.$page.'&file='.$htmdir.$page.'_aside.php" class="edit"></a></div>';
		$editLeft = '<div class="edit"><a href="app/redigera.php?aktivid='.$page.'&file='.$htmdir.$page.'_left.php" class="edit"></a></div>';
		$editBottom = '<div class="edit"><a href="app/redigera.php?aktivid='.$page.'&file='.$htmdir.$page.'_bottom.php" class="edit"></a></div>';
		$editmenu = '<div class="edit"><a href="app/redigera.php?aktivid=index&file='.$htmdir.'menu.php" class="edit"></a> </div>';
		$editlogo = '<div class="edit"><a href="app/redigera.php?aktivid=index&file='.$htmdir.'logo.php" class="edit"></a> </div>';
		$editfooter = '<div class="edit"><a href="app/redigera.php?aktivid=index&file='.$htmdir.'footer.php" class="edit"></a></div>';
		$logout = '<span class=""> <a href="app/logout.php"> Logga ut </a> </span>';
		$publicera = ' | <span class="'.$needPublish.'"> <a href="app/publish.php"> Publicera </a> </span>';


	} else {
		$edithtml = "";
		$editmenu = '';
		$editlogo = '';
		$editaside = '';
		$editlogout = '';
		$logout = '';
		$editLeft = '';
		$editBottom = '';
	}

	$logosrc = $htmdir.'logo.php';
	$aside = $htmdir.$page.'_aside.php';
	$leftsrc = $htmdir.$page.'_left.php';
	$bottomsrc = $htmdir.$page.'_bottom.php';
	$contentsrc = $htmdir.$page.".php";
	$menusrc = $htmdir.'menu.php';
	$footersrc = $htmdir."footer.php";
	$stylecss = $base_url.'styles/style.css';
	$menucss = $base_url.'styles/menu.css';

	function writeContent($contentsrc){
		if (file_exists($contentsrc)){
			echo file_get_contents($contentsrc);
		} else {
			if (isset($_SESSION["inloggning"])){
				echo 'File missing';
			} else {
				echo '';
			}
		}
	};


?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<title>Interact Competence and Culture - <?php echo $page ?></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		<base href="http://<?php echo $_SERVER['HTTP_HOST'].$base_url?>">
		<link rel="shortcut icon" href="/favicon.ico">
		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

		<!-- build:css app/styles/vendor.css -->
		<!-- bower:css -->
		<!-- endbower -->
		<!-- endbuild -->

		<!-- build:css app/css/main.css -->
		<link rel="stylesheet" type="text/css" href="app/css/main.css" />
		<!-- endbuild -->

	</head>
	<body>
		<div class='adminbar' style="color:#fff;">
		<?php echo $logout?><?php echo $publicera ?>
		</div>
		<header class="header border-bottom">	<!--[if lt IE 10]>
				<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
			<![endif]-->
			<div class="container">
				<div class="row">
					<div id="logo" class="col-md-10 col-sm-10">
						<!-- <img src="app/images/logga-InterAct-long2.png" alt="InterAct competence - Logo"> -->
						<img src="app/images/logga-InterAct-long-H150.png" alt="InterAct competence - Logo">

						<?php #echo $editlogo; ?>
						<?php #(file_exists ($logosrc))? include_once $logosrc: (isset($_SESSION["inloggning"]) ? '': ''); ?>
					</div>
					<div id="language" class="col-md-2 col-sm-2">
						<p><strong><?php echo $lang  ?></strong></p>
					</div>
				</div>
			</div>
		</header>
		<div class="nav">
			<div class="container">
				<div class="row">
					<nav id="menu" class="navbar navbar-default" role="navigation" >
						<button class="navbar-toggle" data-toggle="collapse" data-target = ".navHeadercollapse" >
							<span class=icon-bar></span>
							<span class=icon-bar></span>
							<span class=icon-bar></span>
						</button>
						<div class="collapse navbar-collapse navHeadercollapse" >
							<?php echo $editmenu; ?>
							<?php writeContent($menusrc);?>
						</div>
					</nav>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<main id="content" class="col-md-12 col-sm-12">
					<?php echo $edithtml; ?>
					<?php writeContent($contentsrc);?>
				</main>
				<section id="left" class="col-md-6 col-sm-6">
					<?php echo $editLeft; ?>
					<?php writeContent($leftsrc);?>
				</section>
				<section class="col-md-6 col-sm-6">
					<?php echo $editaside; ?>
					<?php writeContent($aside);?>
				</section>
				<section class="col-md-12 col-sm-12">
					<?php echo $editBottom; ?>
					<?php writeContent($bottomsrc);?>
				</section>
			</div>
		</div>
		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						 <?php echo $editfooter; ?>
						 <?php writeContent($footersrc);?>
					</div>
				</div>
			</div>
		</footer>

		<!-- build:js app/js/vendor.js -->
		<!-- bower:js -->
		<script src="bower_components/jquery/dist/jquery.js"></script>
		<script src="bower_components/modernizr/modernizr.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap.js"></script>
		<!-- endbower -->
		<!-- endbuild -->


		<!-- build:js app/js/plugins.js -->
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/affix.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/dropdown.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tooltip.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/modal.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/transition.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/button.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/popover.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/carousel.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/scrollspy.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/collapse.js"></script>
		<script src="bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tab.js"></script>
		<!-- endbuild -->

		<!-- build:js app/js/main.js -->
		<script src="app/js/main.js"></script>
		<!-- endbuild -->

		<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
		<script>
			(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
			function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
			e=o.createElement(i);r=o.getElementsByTagName(i)[0];
			e.src='//www.google-analytics.com/analytics.js';
			r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
			ga('create','UA-XXXXX-X');ga('send','pageview');
		</script>

	</body>
</html>