<?php
require_once('app/index.php');
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <title><?php echo $properties['pageTitle'] ?></title>
<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="<?php echo $properties['metaDescription'] ?>">
<meta name="keywords" content="<?php echo $properties['keywords'] ?>">
<meta name="viewport" content="width=device-width">
<base href="http://<?php echo $_SERVER['HTTP_HOST'].$base_url?>">
<link rel="shortcut icon" href="/favicon.ico">
<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
<!-- build:app/css/main.css -->
<link rel="stylesheet" type="text/css" href="/app/css/main.css" />
<!-- endbuild -->

</head>
<body>
<?php adminbar() ?>
<header class="header border-bottom">
    <div class="container">
        <div class="row">
            <div class="logo-wrapper">
                <div id="h-blue"><div></div></div>
                <div id="h-dark-blue">
                    <span class="line"></span>
                    <a href="/"><img src="app/images/brandInterAct-small.svg" alt="InterAct competence" onerror="this.src='brandInterAct-small.png'"></a>
                </div>
                <div id="h-orange-start"></div>
                <div id="h-orange-end"></div>
                <div id="v-green"></div>
                <div id="v-blue-start"></div>
                <div id="v-blue-end"></div>
            </div>
        </div>
        <div id="language" class="pull-right">
            <p><strong><?php echo $lang ?></strong></p>
        </div>
    </div>
    <div class="nav-container">
        <div class="container">
            <div class="row">
                <nav id="menu" class="navbar navbar-default" role="navigation" >
                    <button class="navbar-toggle" data-toggle="collapse" data-target = ".navHeadercollapse" >
                        <span class=icon-bar></span>
                        <span class=icon-bar></span>
                        <span class=icon-bar></span>
                    </button>
                    <a class="navbar-brand" href="/"><img class="inline" src="app/images/brandInterAct.svg" alt="InterAct competence" onerror="this.src='brandInterAct.png'"></a>
                    <div class="collapse navbar-collapse navHeadercollapse" >
                        <?php globalSection("mainNav", "nav-wrapper"); ?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

<main class="container">
    <div class="row">
        <section id="content" class="col-md-12 col-sm-12">
            <?php pageSection('top'); ?>
        </section>
    </div>
    <div class="row">
        <section id="left" class="col-md-6 col-sm-6">
            <?php pageSection('left'); ?>
        </section>
        <section class="col-md-6 col-sm-6">
            <?php pageSection('right'); ?>
        </section>
    </div>
    <div class="row">
        <section class="col-md-12 col-sm-12">
            <?php pageSection('bottom'); ?>
        </section>
    </div>
</main>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div>
                <?php globalSection('footer'); ?>
            </div>
        </div>
    </div>
</footer>

<!-- build:js app/js/vendor.js -->
<script src="/bower_components/jquery/dist/jquery.js"></script>
<script src="/bower_components/modernizr/modernizr.js"></script>
<script src="/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap.js"></script>
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

<script src="tinymce/jquery.tinymce.min.js"></script>

<!-- build:js app/js/main.js -->
<script src="app/js/main.js"></script>
<!-- endbuild -->

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-83671291-1', 'auto');
    ga('send', 'pageview');

</script>
<?php metadata() ?>
</body>
</html>
