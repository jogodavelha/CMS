<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php echo (!empty($titulo))?$titulo:'Mudar Título'; ?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width">

        <link rel="stylesheet/less" href="<?php echo base_url('less/style.less');?>">
        <script src="<?php echo base_url('js/libs/less-1.3.0.min.js');?>"></script>
	
	<!-- Use SimpLESS (Win/Linux/Mac) or LESS.app (Mac) to compile your .less files
	to style.css, and replace the 2 lines above by this one:

	<link rel="stylesheet" href="<?php echo base_url('less/style.css'); ?>">
	 -->

         <script src="<?php echo base_url('js/libs/modernizr-2.5.3-respond-1.1.0.min.js'); ?>"></script>
</head>
<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

	<div id="header-container">
            <header class="wrapper clearfix">
                <h1 id="title">h1#titulo</h1>
                <nav>
                    <ul>
                        <li><a href="#">nav ul li a</a></li>
                        <li><a href="#">nav ul li a</a></li>
                        <li><a href="#">nav ul li a</a></li>
                    </ul>
                </nav>
            </header>
	</div>
	<div id="main-container">
            {yield}
	</div> <!-- #main-container -->

	<div id="footer-container">
            <footer class="wrapper">
                <h3>rodapé</h3>
            </footer>
	</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo base_url('js/libs/jquery-1.7.2.min.js'); ?>"><\/script>')</script>

<script src="<?php echo base_url('js/plugins.js');?>"></script>
<script src="<?php echo base_url('js/script.js');?>"></script>
<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>
