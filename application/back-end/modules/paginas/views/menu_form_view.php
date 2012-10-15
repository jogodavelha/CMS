<?php $this->load->view('comum/cabecalho_view');?>
<?php $this->load->view('comum/menu_primeiro_view');?>
<?php $this->load->view('comum/menu_segundo_view');?>
<section id="maincontainer">
    <div id="main">
        <div class="quick-actions">
    <a href="<?php echo site_url('paginas');?>">
        <span class="glyph note"></span>
        Menus
    </a>
    </div>
        <div class="box">
            <div class="box-header">
                <h1><?php echo (!empty ($video))?'Editar Menu':'Novo Menu'?></h1>
            </div>
            <div class="box-content">
                <form method="post" action="<?php echo site_url((!empty($video->id))?'paginas/edita/'.$video->id:'paginas/inserir');?>">
                    <div class="clear"></div>
                        <p>
                            <label for="titulo">Titulo</label>
                            <input type="text" id="titulo" name="campo[titulo]" value="<?php echo (!empty ($video->titulo))?$video->titulo:''?>" class="{validate:{required:true, minlength:3}}" />
                        </p>
            </div>

        <div class="column-right">


        </div>

        <div class="clear"></div>

        <div class="action_bar">
                        <input type="submit" id="submit" value="Salvar" class="button blue" />
                        <a href="<?php echo site_url('noticias');?>" class="button">Cancelar</a>
        </div>
                </form>
            </div>
        </div>
    </div>
    </section>
<?php $this->load->view('comum/rodape_view');?>