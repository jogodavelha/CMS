<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Menu CMS
 */
if ( ! function_exists('cmsPegaMenu')){
	function cmsPegaMenu(){
                $ci=& get_instance();
                return $ci->menu_model->listaMenu();
	}
}

/*
 * Menu CMS
 */
if ( ! function_exists('cmsPegaSubMenu')){
	function cmsPegaSubMenu(){
                $ci=& get_instance();
                return $ci->menu_model->listaSubMenu();
	}
}

/*
 * Menu CMS
 */
if ( ! function_exists('cmsVerificaMenu')){
	function cmsVerificaMenu($id_menu,$modulo){
                $ci=& get_instance();
                return $ci->menu_model->verificaMenu($id_menu,$modulo);
	}
}

/*
 * Lista de dados na tabela com confições
 * Padrão ID; Alternativa: Array('id'=>2) ou Array('campo !=',4);
 */
if ( ! function_exists('cms_lista')){
	function cms_lista($tabela,$campo=array(),$limite=0){
                $ci=& get_instance();
		if(is_array($campo)){
                    foreach ($campo as $coluna=>$valor){
                        $ci->db->where($coluna, $valor);
                    }
                }
                if($limite>0){
                    $ci->db->limit($limite);
                }
                $ci->db->from($tabela);
                return $ci->db->get()->result();
	}
}

/*
 * Lista Galerias Imagens
 * Padrão ID; Alternativa: Array('id'=>2) ou Array('campo !=',4);
 */
if ( ! function_exists('cms_galerias')){
	function cms_galerias($id,$limite=0){
                $ci=& get_instance();
                $ci->db->select('gi.*,g.local as galeria');
                $ci->db->from('galerias g');
                $ci->db->join('galerias_imagens gi','gi.id_galeria = g.id');
                $ci->db->where('g.id', $id);
                if($limite>0){
                    $ci->db->limit($limite);
                }
                return $ci->db->get()->result();
	}
}

/*
 * Pegar dados CMS_CONFIG
 * Padrão ID; Alternativa: Array('id'=>2) ou Array('campo !=',4);
 */
if ( ! function_exists('cms_config')){
	function cms_config($chave){
                $ci=& get_instance();
                $ci->db->select('valor');
                $ci->db->from('cms_config');
                $ci->db->where('chave', $chave);
                $dado = $ci->db->get()->row();
                return (!empty ($dado->valor))?$dado->valor:'';
	}
}


/*
 * Pegar e Montar menu
 * Monta menu
 */
if ( ! function_exists('cms_lista_menu')){
	function cms_lista_menu($parent_id = 0) {
                $CI =& get_instance();
		return $CI->cms_model->cms_lista_menu($parent_id);
   }
}