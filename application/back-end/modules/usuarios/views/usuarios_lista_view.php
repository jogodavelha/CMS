<?php $this->load->view('comum/cabecalho_view');?>
    <section id="maincontainer">
      <div id="main" class="container_12">
<div class="quick-actions">
    <a href="<?php echo site_url('usuarios/novo');?>">
    <span class="glyph user"></span>
    Novo Usuario
  </a>
</div>
      <div class="box">
  <div class="box-header">
      <h1>Usuários <?php echo $auser_id; ?></h1>
  </div>
  <table class="datatable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Grupo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach($usuarios as $usuario){ ?>
      <tr>
        <td><?php echo $usuario->id;?></td>
        <td><?php echo $usuario->nome;?></td>
        <td><?php echo (!empty ($usuario->grupo))?$usuario->grupo:'Sem Grupo';?></td>
        <td>
          <?php if($auser_id==$usuario->id || $auser_grupo==1){ ?>
          <a href="<?php echo site_url('usuarios/editar/'.$usuario->id);?>" class="button plain disabled">Editar</a>
          <?php } ?>
          <?php if($usuario->id!=1 && $usuario->id!=$auser_id){ ?>
          <a href="<?php echo site_url('usuarios/apagar/'.$usuario->id);?>" class="button plain disabled">Deletar</a>
          <?php } ?>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
      </div>
    </section>
<?php $this->load->view('comum/rodape_view');?>