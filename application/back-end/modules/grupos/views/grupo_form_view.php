<?php $this->load->view('comum/cabecalho_view');?>
<section id="maincontainer">
      <div id="main" class="container_12">

      <div class="box">
  <div class="box-header">
    <h1><?php echo (!empty ($grupo))?'Editar Grupo':'Novo Grupo'; ?></h1>
  </div>

  <div class="box-content">
      <form action="<?php echo site_url((!empty($grupo))?'grupos/salvar/'.$grupo->id:'grupos/salvar');; ?>" method="post">
        <div class="column-left">
          <p>
              <input type="text" id="nome" name="nome" placeholder="Nome" value="<?php echo (!empty ($grupo->nome))?$grupo->nome:''; ?>" class="{validate:{required:true, minlength:3}}" />
          </p>
        </div>

        <div class="column-right">
          <div class="column-left">
              <h5>Permissões de Acesso:</h5>
            <?php foreach ($acessar as $metodo=>$marcado){?>
            <p>
                <input type="checkbox" <?php echo ($marcado==true)?'checked="true"':''?> name="acesso[]" value="<?php echo $metodo; ?>" id="<?php echo 'acesso_'.$metodo; ?>" />
              <label for="<?php echo 'acesso_'.$metodo; ?>"><?php echo $metodo; ?></label>
            </p>
            <?php } ?>
          </div>

          <div class="column-right">
              <h5>Permissões de Modificação:</h5>
              <?php foreach ($modificar as $metodo=>$marcado){?>
            <p>
                <input type="checkbox" <?php echo ($marcado==true)?'checked="true"':''?> name="modificar[]" value="<?php echo $metodo; ?>" id="<?php echo 'modificar_'.$metodo; ?>" />
              <label for="<?php echo 'modificar_'.$metodo; ?>"><?php echo $metodo; ?></label>
            </p>
            <?php } ?>
          </div>
        </div>

        <div class="clear"></div>

        <div class="action_bar">
          <input type="submit" class="button blue" value="Salvar" />
          <a href="<?php echo site_url('grupos');?>" class="button">Cancelar</a>
        </div>

      </form>
  </div>
</div>
      </div>
    </section>
<?php $this->load->view('comum/rodape_view');?>