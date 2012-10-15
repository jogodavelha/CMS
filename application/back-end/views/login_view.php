<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="viewport" content="width=1024, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>CMS -DAPHost</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo site_url('css/reset.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/icons.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/formalize.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/checkboxes.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/sourcerer.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/jqueryui.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/tipsy.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/calendar.css');?>" />

    <link rel="stylesheet" href="<?php echo site_url('css/tags.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/fonts.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/selectboxes.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/960.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/main.css');?>" />
    
    <!-- Customização para Jogo da velha -->
    <link rel="stylesheet" href="<?php echo site_url('css/jogo-da-velha.css');?>" />
    
    <link rel="stylesheet" media="all and (orientation:portrait)" href="<?php echo site_url('css/portrait.css');?>" />
    <link rel="apple-touch-icon" href="./apple-touch-icon-precomposed.png" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    
    <!--[if lt IE 9]>
    <script src="<?php echo site_url('js/html5shiv.js'); ?>"></script>
    <script src="<?php echo site_url('js/excanvas.js'); ?>"></script>
    <![endif]-->
    
    <!-- JavaScript -->
    <script src="<?php echo site_url('js/jquery.min.js');?>"></script>
    
    <script src="<?php echo site_url('js/jquery.maskedinput-1.3.min.js'); ?>"></script>
    <script src="<?php echo site_url('js/jquery.maskMoney.js'); ?>"></script>
    <script src="<?php echo site_url('js/colorbox/jquery.colorbox-min.js'); ?>"></script>
    
    <script src="<?php echo site_url('js/jqueryui.min.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.cookies.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.pjax.js');?>"></script>
    <script src="<?php echo site_url('js/formalize.min.js');?>"></script>

    <script src="<?php echo site_url('js/jquery.metadata.js'); ?>"></script>
    <script src="<?php echo site_url('js/jquery.validate.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.checkboxes.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.chosen.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.fileinput.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.datatables.js'); ?>"></script>

    <script src="<?php echo site_url('js/jquery.sourcerer.js"'); ?>"></script>
    <script src="<?php echo site_url('js/jquery.tipsy.js'); ?>"></script>
    <script src="<?php echo site_url('js/jquery.calendar.js'); ?>"></script>
    <script src="<?php echo site_url('js/jquery.inputtags.min.js'); ?>"></script>
    <script src="<?php echo site_url('js/jquery.wymeditor.js'); ?>"></script>
    <script src="<?php echo site_url('js/jquery.livequery.js'); ?>"></script>

    <script src="<?php echo site_url('js/jquery.flot.min.js'); ?>"></script>
    <script src="<?php echo site_url('js/application.js'); ?>"></script>
    <script src="<?php echo site_url('js/myscript.js'); ?>"></script>
  </head>
  
  <body id="login">
  
    <div id="login_container">
        
        <div id="login_form">
            <form method="post" action="<?php echo site_url('login/entrar');?>">
                <p>
                    <input type="text" id="username" name="usuario" placeholder="Usuário" class="{validate: {required: true}}" />
                </p>
                <p>
                    <input type="password" id="password" name="senha" placeholder="Senha" class="{validate: {required: true}}" />
                </p>
                <button type="submit" class="button blue"><span class="glyph key"></span> Entrar </button>
            </form>
        </div>
    </div>
  </body>
</html>