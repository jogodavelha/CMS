<?php $this->load->view('comum/cabecalho_view');?>
<script type="text/javascript">
    (function($) {

	$(function() {
            // show/hide the children when clicking on an <li>
		/*$('#lista-links li a.editar').live('click', function()
		{
			var id_dados = $(this).attr('rel');
                        //alert(id_dados);
                        $.get('<?php echo site_url('paginas/ajax_dados'); ?>/'+id_dados, function(data) {
                            $('#info_link').html(data);
                        });
			 return false;
		});*/
                
                
                
                
                //$('#lista-links ol:not(.sortable)').children().hide();
                $('ol.sortable').nestedSortable({
			disableNesting: '.no-nest',
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			maxLevels: 0,
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
                        stop: function(event, ui) {
                                // create the array using the toHierarchy method
				ordem = $(this).nestedSortable('toArray');

				// get the group id
				var grupo = $(this).parents('section').attr('rel');
				//alert('opa');
				//setTimeout(atualizar_menu, 5);
                                $.post('<?php echo site_url('paginas/ajax_ordem'); ?>', { 'ordem': ordem, 'grupo': grupo } );
			}
		});
                
	});

})(jQuery);
</script>
<section id="maincontainer">
    <div id="main" class="container_12">
        <div class="quick-actions">
            <a href="<?php echo site_url('paginas/novo');?>">
            <span class="glyph pencil"></span>
              Criar Página
            </a>
        </div>
        <div class="box">
            <div class="box-header">
                <h1>Menu</h1>
            </div>
            <div class="box-content">
                    <div class="column-left">
                        <h2>Menu</h2>
                        <div class="lista-links">
                            <?php echo $lista_menu; ?>
                        </div>
                    </div>
                    <div class="column-right">
                        <h2>Rotas</h2>
                        <div class="lista-links">
                            <?php echo $lista_rotas; ?>
                        </div>    
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="action_bar">

                    </div>
            </div>
        </div>
    </div>
    </section>
<?php $this->load->view('comum/rodape_view');?>