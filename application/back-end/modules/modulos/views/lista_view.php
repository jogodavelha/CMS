<?php $this->load->view('comum/cabecalho_view');?>
<script>
    $().ready(function() {
        $('.desinstalar').click(function(){
            var answer = confirm('Tem certeza que deseja Desinstalar este Módulo?');
            return answer // answer is a boolean
        });
    });
</script>
    <section id="maincontainer">
      <div id="main" class="container_12">
      <div class="box">
  <div class="box-header">
    <h1>Módulos</h1>
  </div>
  <table class="datatable">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Ações</th>
        <th>Info<tb>
      </tr>
    </thead>
    <tbody>
        <?php
        $doSistema = array('grupos','menus','modulos','usuarios','paginas');
        foreach($modulos as $modulo=>$dados){ 
            if(!in_array($modulo,$doSistema)){ ?>
      <tr>
        <td><?php echo ucfirst($modulo); ?></td>
        <td>
            <?php
            $instalado = (!empty($dados['instalado']))?$dados['instalado']:false;
            if(!$instalado){ ?>
            <a href="<?php echo site_url($modulo.'/instalar');    ?>" class="button plain">Instalar</a>
            <?php }else{ ?>
            <a href="<?php echo site_url('modulos/desinstalar/'.$dados['id']);    ?>" class="button plain desinstalar">Desinstalar</a>
            <?php } ?>
        </td>
        <td>
            <?php echo $dados['info']; ?>
        </td>
      </tr>
      <?php } } ?>
    </tbody>
  </table>
</div>
      </div>
    </section>
<?php $this->load->view('comum/rodape_view');?>