<?php $this->load->view('comum/cabecalho_view');?>
    <section id="maincontainer">
      <div id="main" class="container_12">
<div class="quick-actions">
    <a href="<?php echo site_url('grupos/novo');?>">
    <span class="glyph group"></span>
    Novo Grupo
  </a>
    </div>
      <div class="box">
  <div class="box-header">
    <h1>Grupos</h1>
  </div>
  <table class="datatable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach($grupos as $grupo){ ?>
      <tr>
        <td><?php echo $grupo->id;?></td>
        <td><?php echo $grupo->nome;?></td>
        <td>
            <?php if($grupo->id!=1){ ?>
            <a href="<?php echo site_url('grupos/editar/'.$grupo->id);    ?>" class="button plain disabled">Editar</a>
            <a href="#" class="button plain disabled">Deletar</a>
            <?php }else{ ?>
            Você não pode apagar e nem editar este grupo.
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