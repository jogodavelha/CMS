<?php //print_r($ga);?>
<?php $this->load->view('comum/cabecalho_view');?>
    <section id="maincontainer">
      <div id="main" class="container_12">

      <div class="quick-actions">
</div>
<?php if(!empty ($ga) && isset($ga)){ ?>
          <?php
          $datas = '';
          $pageviews = '';
          $visits = '';
          $newVisits = '';
          $totalNvisitantes = 0;
          $totalPV = 0;
          $taxaRejeicao = 0;
          $i = 0;
          foreach($ga as $g){
              $adata = $g->getDate();
              $adata = $adata[6].$adata[7].'/'.$adata[4].$adata[5].'/'.$adata[0].$adata[1].$adata[2].$adata[3];
              $datas .= ($i>0?',':'')."'".($adata)."'";
              $pageviews .= ($i>0?',':'')."".($g->getPageviews())."";
              $visits .= ($i>0?',':'')."".($g->getVisits())."";
              $newVisits .= ($i>0?',':'')."".($g->getNewVisits())."";
              $totalNvisitantes += $g->getNewVisits();
              $totalPV += $g->getPageviews();
              $taxaRejeicao += $g->getBounces();
              $i++;
          }
          $taxaRejeicao = $taxaRejeicao/$i;
          ?>

<script type="text/javascript">
    /********
    Dashboard chart
  ********/
 $(document).ready(function() {
        if($('#dashboardchart').length > 0) {
    chart1 = new Highcharts.Chart({
       chart: {
          renderTo: 'dashboardchart',
          type: 'column',
          marginRight: '24',
          marginLeft: '36',
          marginTop: '24'
       },
       title: {
          text: ''
       },
       xAxis: {
            categories: [<?php echo $datas; ?>]
       },
       yAxis: {
          title: {
             text: ''
          },
          plotLines: [{
             value: 0,
             width: 1,
             color: '#808080'
          }]
       },
       legend: {
         borderWidth: 0,
       },
       series: [{
          name: 'Pageviews',
          data: [<?php echo $pageviews ?>]
       }, {
          name: 'Visitas',
          data: [<?php echo $visits ?>]
       }, {
          name: 'Novas Visitas',
          data: [<?php echo $newVisits ?>]
       }]
    });
  }
    });

</script>
<div class="box">
  <div class="box-header">
    <h1>Relatório de Visitas</h1>
  </div>

  <div id="dashboardchart">
  </div>
</div>
<div class="box column-left">
  <div class="box-header">
    <span class="glyph chart"></span><h1>Statistics</h1>
  </div>

  <ul class="statistics">
    <li>
      <a href="#">
          <span><?php echo $totalNvisitantes; ?></span>
        Novos Visitantes
      </a>
    </li>
    <li>
      <a href="#">
          <span><?php echo round($taxaRejeicao,1); ?>%</span>
        Taxa de Rejeição
      </a>
    </li>
    <li>
      <a href="#">
          <span><?php echo $totalPV; ?></span>
        Pageviews
      </a>
    </li>
  </ul>
</div>
<?php } ?>
<!--<div class="grid_6 alpha">
<div class="box">
  <div class="box-header">
    <h1>Informações</h1>
  </div>
    <div>
        
    </div>
</div>
</div>-->
<div class="grid_6 omega">
    <div class="box">
    <div class="box-header">
        <h1>Hospedagem</h1>
    </div>

    <table>
        <tbody>
        <tr>
            <td>Hospedagem:</td>
            <td><strong><a target="_blank" href="http://jogodavelhadigital.com.br">Jogo da Velha Digital</a></strong></td>
        </tr>
        <tr>
            <td>Espaço em Uso do site:</td>
            <td><?php echo $total_site; ?></td>
        </tr>
        <tr>
            <td>Total de Diretórios:</td>
            <td><?php echo $total_diretorios; ?></td>
        </tr>
        <tr>
            <td>Total de Arquivos:</td>
            <td><?php echo $total_arquivos; ?></td>
        </tr>
        <tr>
            <td>Usados no diretório 'Uploads':</td>
            <td class="red"><?php echo $total_uploads; ?></td>
        </tr>
        </tbody>
    </table>
    </div>
</div>

      </div>
    </section>
<?php $this->load->view('comum/rodape_view');?>