<?php $this->load->view('comum/cabecalho_view');?>
<script>
    $(function(){
        $('#controle_padrao').change(function(){
                    if($(this).is(':checked')){
                        $('#controle').attr('disabled','disabled');
                    }else{
                        $('#controle').removeAttr('disabled');
                    }
                });
    });
</script>
    <section id="maincontainer">
    <div id="main" class="container_12">
        <div class="quick-actions">
    <a href="<?php echo site_url('paginas');?>">
        <span class="glyph note"></span>
        Páginas
    </a>
    </div>
        <div class="box">
            <div class="box-header">
                <h1><?php echo (!empty ($dados))?'Editar Texto':'Novo Texto'?></h1>
            </div>
            <div class="box-content">
                <form method="post" action="<?php echo site_url((!empty($dados))?'paginas/edita/'.$dados->id:'paginas/criar_pagina'); ?>">
                        <p>
                            <input type="checkbox" name="campo[menu]" value="sim" id="menus" <?php if(!empty($dados->menu)){ echo ($dados->menu=='sim')?'checked':'';}?>/>
                            <label for="menus">Exibir como Menu no Front-End</label>
                            
                            <input type="checkbox" name="campo[padrao]" value="sim" id="padrao" <?php if(!empty($dados->padrao)){ echo ($dados->padrao=='sim')?'checked':'';}?>/>
                            <label for="padrao">Página Principal  (Ex: Home)</label>
                            
                            <input type="checkbox" name="campo[apagar]" value="sim" id="apagar" <?php if(!empty($dados->apagar)){ echo ($dados->apagar=='sim')?'checked':'';}?>/>
                            <label for="apagar">Permitir DELETAR</label>
                        </p>
                        <p>
                            <label for="titulo">Título</label>
                            <input type="text" id="titulo" name="campo[titulo]" value="<?php echo (!empty ($dados->titulo))?$dados->titulo:''?>" class="{validate:{required:true, minlength:3}} titulo" />
                        </p>
                        <p>
                            <label for="uri">URI (URL Amigável)</label>
                            <input type="text" id="uri" name="campo[uri]" value="<?php echo (!empty ($dados->uri))?$dados->uri:''?>" class="uri" />
                            <small>Uma <a target="_blank" href="http://codeigniter.com/user_guide/general/routing.html">referência</a>. Ex: url-amigavel/(:any)/(:num)</small>
                        </p>
                        
                        <p>
                            <p>
                                <input type="checkbox" name="campo[controle_padrao]" value="sim" id="controle_padrao" />
                                <label for="controle_padrao">Usar Controle Padrão</label>
                            </p>
                            <input type="text" id="controle" name="campo[controle]" value="<?php echo (!empty ($dados->controle))?$dados->controle:''?>" class="{validate:{required:true, minlength:3}}" />
                            <small>Uma <a target="_blank" href="http://codeigniter.com/user_guide/general/routing.html">referência</a>. Ex: controller/index/$1/$2</small>
                        </p>
                        <p>
                            <label for="layout">Layout</label>
                            <select name="campo[layout]" id="layout">
                                <?php foreach($layouts as $layout){ ?>
                                <option value="<?php echo $layout; ?>"><?php echo ucfirst($layout);?></option>
                                <?php } ?>
                            </select>
                        </p>
                        <p>
                            <label for="view">View</label>
                            <input type="text" id="view" value="<?php echo (!empty ($dados->view))?$dados->view:''?>" name="campo[view]" />
                        </p>
                        <div class="clear"></div>
                        <div class="action_bar">
                                        <input type="submit" id="submit" value="Salvar" class="button blue" />
                        </div>
                    </form>
            </div>
        </div>
    </div>
    </section>
<?php $this->load->view('comum/rodape_view');?>