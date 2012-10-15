<?php 
//print_r($dados->referencia_id);
$texto = $this->textos_fe->get($dados->referencia_id,$dados->uri);
?>
<div class="titulo">
    <h2><?php echo $texto->titulo; ?></h2>
</div>
<div class="textos_institucionais">
    <?php echo $texto->conteudo;  ?>
</div>