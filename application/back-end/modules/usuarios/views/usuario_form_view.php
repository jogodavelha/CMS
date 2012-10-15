<?php $this->load->view('comum/cabecalho_view');?>
    <section id="maincontainer">
      <div id="main" class="container_12">

      <div class="box">
  <div class="box-header">
      <h1><?php echo (!empty ($usuario))?'Editar Usuário':'Novo Usuário'; ?></h1>
  </div>

  <div class="box-content">

      <form action="<?php echo site_url((!empty ($usuario))?'usuarios/edita/'.$usuario->id:'usuarios/inserir'); ?>" method="post">

        <div class="column-left">
          <p>
              <label for="usuario">Usuário <?php echo (!empty ($usuario->usuario))?'(Não é possivel alterar)':''; ?></label>
              <input type="text" id="usuario" name="<?php echo (empty($usuario->usuario))?'campo[usuario]':''; ?>" <?php echo (!empty ($usuario->usuario))?'disabled="true"':''; ?> value="<?php echo (!empty ($usuario->usuario))?$usuario->usuario:''; ?>" placeholder="Usuário" class="{validate:{required:true, minlength:3}}" />
          </p>
          <p>
              <label for="senha">Senha</label>
            <input type="password" name="senha[senha]" id="senha" class="{validate:{ minlength:6}}" />
          </p>
          <p>
            <label for="senha_conf">Confirmar Senha</label>
            <input type="password" name="senha[senha_conf]" id="senha_conf" class="{validate:{equalTo: '#senha'}}" />
            <small>Caso não desejar mudar a senha, deixe os campos de <strong>Senha</strong> e <strong>Confirmar Senha</strong> em branco.</small>
          </p>

          <p>
              <label for="email">Email</label>
            <input type="text" id="email" name="campo[email]" placeholder="Email" value="<?php echo (!empty ($usuario->email))?$usuario->email:''; ?>" class="{validate:{required:true, minlength:3}}" />
          </p>

          <p>
              <label for="nome">Nome</label>
            <input type="text" id="nome" name="campo[nome]" placeholder="Nome" value="<?php echo (!empty ($usuario->nome))?$usuario->nome:''; ?>" class="{validate:{required:true, minlength:3}}" />
          </p>
          <?php if($auser_grupo==1) {?>
          <p>
            <label for="grupo">Grupo de Usuário</label>
            <select name="campo[id_grupo]" id="grupo" pclass="{validate:{required:true}}">
                <?php foreach ($grupos as $grupo){ ?>
                <option value="<?php echo $grupo->id; ?>"><?php echo $grupo->nome; ?></option>
              <?php } ?>
            </select>
          </p>
          <?php } ?>
        </div>

        <div class="clear"></div>

        <div class="action_bar">
          <input type="submit" class="button blue" value="Atualizar Dados" />
          <a href="<?php echo site_url('usuarios'); ?>" class="button">Cancelar</a>
        </div>

      </form>

  </div>
</div>

      </div>
    </section>
<?php $this->load->view('comum/rodape_view');?>