<?php $this->load->view('comum/cabecalho_view');?>
<?php $this->load->view('comum/menu_primeiro_view');?>
<?php $this->load->view('comum/menu_segundo_view');?>
<script>
    $().ready(function() {
        $('.apagar').click(function(){
            var answer = confirm('Tem certeza que deseja apagar esta notícia?');
            return answer // answer is a boolean
        });
    });
</script>
    <section id="maincontainer">
      <div id="main">
<div class="quick-actions">
    <a href="<?php echo site_url('paginas/novo');?>">
        <span class="glyph pencil"></span>
        Novo Menu
    </a>
    </div>
      <div class="box">
  <div class="box-header">
    <h1>Menu</h1>
    <ul>
        <li class="active">
            <a href="#menu">Menu</a>
        </li>
        <li class="">
            <a href="#rota">Criar Página</a>
        </li>
    </ul>
  </div>
  <table class="datatable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Titulo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach($menus as $linha){ ?>
              <tr>
                <td><?php echo $linha->id;?></td>
                <td><?php echo $linha->titulo;?></td>
                <td>
                    <a href="<?php echo site_url('paginas/editar/'.$linha->id);?>" class="button plain">Editar</a>
                    <a href="<?php echo site_url('paginas/elementos/'.$linha->id);?>" class="button plain">Elementos</a>
                    <a href="<?php echo site_url('paginas/apagar/'.$linha->id);?>" class="button plain apagar">Deletar</a>
                </td>
              </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
      </div>
   </section>
<?php $this->load->view('comum/rodape_view');?>