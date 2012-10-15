// jQuery File Tree Plugin
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// Visit http://abeautifulsite.net/notebook.php?article=58 for more information
//
// Usage: $('.fileTreeDemo').fileTree( options, callback )
//
// Options:  root           - root folder to display; default = /
//           script         - location of the serverside AJAX file to use; default = jqueryFileTree.php
//           folderEvent    - event to trigger expand/collapse; default = click
//           expandSpeed    - default = 500 (ms); use -1 for no animation
//           collapseSpeed  - default = 500 (ms); use -1 for no animation
//           expandEasing   - easing function to use on expand (optional)
//           collapseEasing - easing function to use on collapse (optional)
//           multiFolder    - whether or not to limit the browser to one subfolder at a time
//           loadMessage    - Message to display while initial tree loads (can be HTML)
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// TERMS OF USE
// 
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC. 
//
if(jQuery) (function($){
	
	$.extend($.fn, {
		fileTree: function(o, h) {
			// Defaults
			if( !o ) var o = {};
			if( o.root == undefined ) o.root = '/';
			if( o.script == undefined ) o.script = 'fm/arquivos';
			if( o.folderEvent == undefined ) o.folderEvent = 'click';
			if( o.expandSpeed == undefined ) o.expandSpeed= 500;
			if( o.collapseSpeed == undefined ) o.collapseSpeed= 500;
			if( o.expandEasing == undefined ) o.expandEasing = null;
			if( o.collapseEasing == undefined ) o.collapseEasing = null;
			if( o.multiFolder == undefined ) o.multiFolder = true;
			if( o.loadMessage == undefined ) o.loadMessage = 'Carregando...';
                        if( o.palco == undefined ) o.palco = '/';
                        if( o.script_palco == undefined ) o.script_palco = 'fm/palco';
                        if( o.retorno == undefined ) o.retorno = '.action_bar ';
                        if( o.total_marcar == undefined ) o.total_marcar = 1;
			
			$(this).each( function() {
				
				function showTree(c, t) {
					$(c).addClass('wait');
                                        $(o.palco).addClass('wait')
					$(".jqueryFileTree.start").remove();

                                        //Ajax Arquivos
					$.post(o.script, { dir: t }, function(data) {
						$(c).find('.start').html('');
						$(c).removeClass('wait').append(data);
						if( o.root == t ) $(c).find('UL:hidden').show(); else $(c).find('UL:hidden').slideDown({ duration: o.expandSpeed, easing: o.expandEasing });
						bindTree(c);
					});
                                        //Ajax Palco
                                        $.post(o.script_palco, { dir: t }, function(data) {
						$(c).find('.start').html('');
						$(o.palco).removeClass('wait').html(data);
						if( o.root == t ) $(o.palco).find('UL:hidden').show(); else $(o.palco).find('UL:hidden').slideDown({ duration: o.expandSpeed, easing: o.expandEasing });
						bindPalco(o.palco,c);
					});

				}

                                function bindPalco(palco,c){
                                    $(o.palco).find('div.quadro').bind(o.folderEvent, function() {
                                            var objeto = $(this);
                                            var rel = $(this).find('input.rel').attr('value');
                                            var tree = $(c).find('li a[rel="'+rel+'"]');
                                            opentree(tree);
                                            mostrar_valores(objeto);
				    });                                    
                                }

				
				function bindTree(t) {
					$(t).find('LI A').bind(o.folderEvent, function() {
                                            var c = $(this);
                                            opentree(c);
					});
					// Prevent A from triggering the # on non-click events
					if( o.folderEvent.toLowerCase != 'click' ){
                                            $(t).find('LI A').bind('click', function() { return false; });
                                        }
				}

                                function mostrar_valores(objeto) {
                                    
                                    if(objeto.find('input').is(':checked')){
                                        objeto.addClass("marcado");
                                    }else{
                                        objeto.removeClass("marcado");
                                    }
                                    var fields = $("#post_fm :input").serializeArray();
                                    //alert(fields);
                                    $(o.retorno).empty();
                                    jQuery.each(fields, function(i, field){
                                        $(o.retorno).append(field.value + " ");
                                    });
                                    
                                    if(o.total_marcar>0){
                                        var total = $("form#post_fm input:checked").length;
                                        if(o.total_marcar==1){
                                                $("form#post_fm input:checked").attr('checked', false);
                                                $("form#post_fm input:checked").parent().parent().parent().addClass("marcado");
                                                objeto.find('input').attr('checked', true);
                                                //$("form#post_fm input:checked").parent().parent().parent().addClass("marcado");
                                        }else{
                                            if(total>=o.total_marcar){
                                                $("form#post_fm input:not(:checked)").attr('disabled', true);
                                            }else{
                                                $("form#post_fm input:not(:checked)").attr('disabled', false);
                                            }
                                        }
                                    }
                                }

                                function opentree(c){
                                    if( $(c).parent().hasClass('directory') ) {
                                            if( $(c).parent().hasClass('collapsed') ) {
                                                    // Expand
                                                    if( !o.multiFolder ) {
                                                            $(c).parent().parent().find('UL').slideUp({ duration: o.collapseSpeed, easing: o.collapseEasing });
                                                            $(c).parent().parent().find('LI.directory').removeClass('expanded').addClass('collapsed');
                                                    }
                                                    $(c).parent().find('UL').remove(); // cleanup
                                                    showTree( $(c).parent(), escape($(c).attr('rel').match( /.*\// )) );
                                                    $(c).parent().removeClass('collapsed').addClass('expanded');
                                            } else {
                                                    // Collapse
                                                    $(c).parent().find('UL').slideUp({ duration: o.collapseSpeed, easing: o.collapseEasing });
                                                    $(c).parent().removeClass('expanded').addClass('collapsed');
                                            }
                                    } else {
                                            var rel = $(c).attr('rel');
                                            var quadro = $(o.palco).find('input[value="'+rel+'"]');
                                            
                                    }
                                    return false;
                                }
				// Loading message
				$(this).html('<ul class="jqueryFileTree start"><li class="wait">' + o.loadMessage + '<li></ul>');
				// Get the initial file list
				showTree( $(this), escape(o.root) );
			});
		}
	});
	
})(jQuery);