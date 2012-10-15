<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="viewport" content="width=1024, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <title>DAPHost.com.br</title>
    
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
    
    <link rel="stylesheet" href="<?php echo site_url('css/filemanager.css?'.time());?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/filetree/jqueryFileTree.css?'.time());?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/jquery.fileupload-ui.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('css/my_css.css');?>" />
    
    <!-- Customização para Jogo da velha -->
    <link rel="stylesheet" href="<?php echo site_url('css/jogo-da-velha.css');?>" />
    
    <link rel="stylesheet" media="all and (orientation:portrait)" href="<?php echo site_url('css/portrait.css');?>" />
    <link rel="apple-touch-icon" href="<?php echo site_url('apple-touch-icon-precomposed.png');  ?>" />
    <link rel="shortcut icon" href="<?php echo site_url('favicon.ico');?>" type="image/x-icon" />
    
    <!--[if lt IE 9]>
    <script src="<?php echo site_url('js/html5shiv.js'); ?>"></script>
    <script src="<?php echo site_url('js/excanvas.js'); ?>"></script>
    <![endif]-->
    <!-- JavaScript -->
    <script src="<?php echo site_url('js/jquery.min.js');?>"></script>
    <script src="<?php echo site_url('js/jquery-ui-1.8.17.custom.min.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.cookies.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.pjax.js');?>"></script>
    <script src="<?php echo site_url('js/formalize.min.js');?>"></script>

    <script src="<?php echo site_url('js/jquery.metadata.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.validate.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.checkboxes.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.chosen.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.fileinput.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.datatables.js');?>"></script>

    <script src="<?php echo site_url('js/jquery.sourcerer.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.tipsy.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.calendar.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.inputtags.min.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.wymeditor.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.livequery.js');?>"></script>

    <script src="<?php echo site_url('js/jquery.flot.min.js');?>"></script>
    <script src="<?php echo site_url('js/application.js');?>"></script>
    
    <script src="<?php echo site_url('js/jquery.maskMoney.js');?>"></script>
    <script src="<?php echo base_url('js/jquery.maskedinput-1.3.min.js');?>"></script>
    
    <script src="<?php echo site_url('js/myscript.js'); ?>"></script>
    
    <script src="<?php echo site_url('js/fileupload/jquery.fileupload.js');?>"></script>
    <script src="<?php echo site_url('js/fileupload/jquery.iframe-transport.js');?>"></script>
    <script src="<?php echo site_url('js/fileupload/json_parse.js');?>"></script>
    
    <script src="<?php echo site_url('js/jquery.ui.nestedSortable.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.cooki.js');?>"></script>
    
    
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script> 
    <script src="<?php echo site_url('js/jquery.gomap-1.3.2.min.js');?>"></script>
    
    <script src="<?php echo site_url('js/filetree/jqueryFileTree.js?'.time());?>"></script>
    <script src="<?php echo site_url('js/jquery.ui.nestedSortable.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.cooki.js');?>"></script>

    
  </head>
  
  <body>
      <div id="visualsite">
          <span>Olá, <a href="<?php echo site_url('usuarios/editar/1');?>"><?php echo $auser_nome; ?></a></span>
          <a class="button plain" target="_blank" href="<?php echo site_url('../'); ?>">Visualizar o site</a>
      </div>
      <!-- Primary navigation -->
<nav id="primary">
      <ul>
        <?php $pagina_atual = $this->uri->segment(1); ?>
        <?php   $menus = cmsPegaMenu();
                
                foreach($menus as $linha){
                ?>
        <li class="<?php echo ($pagina_atual==$linha->link || $pagina_atual==$linha->id || cmsVerificaMenu($linha->id,$pagina_atual))?'active':''; ?>">
            <a href="<?php echo site_url($linha->id);?>">
            <span class="glyph <?php echo $linha->icone; ?>"></span>
            <?php echo $linha->titulo; ?>
          </a>
        </li>
            <?php } ?>
        <li class="bottom">
            <a href="<?php echo site_url('login/sair'); ?>">
            <span class="glyph quit"></span>
            Sair
          </a>
        </li>
      </ul>
</nav>
<!-- Secondary navigation -->
<nav id="secondary">
    <ul>
        <?php 
            //tabela 2
            $pagina_atual = $this->uri->segment(1);
              $referencia = (!empty ($_GET['referencia']))?$_GET['referencia']:'';
              $submenu = cmsPegaSubMenu();
              if(!empty($submenu)){ 
              foreach($submenu as $linha){
        ?>
        <li class="<?php echo ($pagina_atual==$linha->modulo)?'active':''; ?>"><a href="<?php echo site_url($linha->modulo);?>"><?php echo $linha->titulo?></a></li>
            <?php } }else{ ?>
        <li class="active"><a href="<?php echo site_url('modulos');?>">Precisa instalar um módulo</a></li>
        <?php } ?>
    </ul>
    <div id="notifications">
        <ul>

        </ul>
    </div>
</nav>
<?php $erro = $this->session->flashdata('erro');
if(!empty($erro)){?>
    <div id="alerta">
        <b>Erro:</b>
        <?php echo $erro; ?>
        <a class="close tips" href="#" original-title="close">fechar</a>
    </div>
<?php } ?>

<?php $sucesso = $this->session->flashdata('sucesso');
if(!empty($sucesso)){?>
    <div class="albox" id="sucesso">
        <b>Sucesso:</b>
    <?php echo $sucesso; ?>
        <a class="close tips" href="#" original-title="close">fechar</a>
    </div>
<?php } ?>
