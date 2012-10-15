<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Busca dados em quanquer tabela com qualquer condição
 * Padrão ID; Alternativa: Array('id'=>2) ou Array('campo !=',4);
 * Limite vazio: ROW(), Limite 0: Sem limite result(), Limite x: o limite result()
 * retorno: objeto;
 */
if ( ! function_exists('pdados')){
	function pdados($condicao, $tabela,$limite=''){
            $ci=& get_instance();
            $ci->load->model('padrao_model','padrao');
            return $ci->padrao->dados($condicao,$tabela,$limite);
	}
}
/*
 * Com paginacao
 */
if ( ! function_exists('pdadosPaginado')){
	function pdadosPaginado($tabela,$segmento=1,$qtd=5,$condicao=array()){
            $ci=& get_instance();
            $ci->load->model('padrao_model','padrao');
            return $ci->padrao->dadosPaginado($tabela,$segmento,$qtd,$condicao);
	}
}

/*
 * Pegar dados CMS_CONFIG
 * Padrão ID; Alternativa: Array('id'=>2) ou Array('campo !=',4);
 */
if ( ! function_exists('pconfig')){
    function pconfig($chave){
        $ci=& get_instance();
        $ci->load->model('padrao_model','padrao');
        return $ci->padrao->pegarConfiguracao($chave);
    }
}

/*
 * Recortar Imagem
 * Padrão ID; Alternativa: Array('id'=>2) ou Array('campo !=',4);
 */
if ( ! function_exists('pimagem')){
	function pimagem($arqOriginal,$width=0,$height=0){
            $ci=& get_instance();
            $ci->load->model('padrao_model','padrao');
            return $ci->padrao->imagem($arqOriginal,$width,$height);
	}
}

/*
 * Pegar e Montar menu
 * Monta menu
 */
if ( ! function_exists('pmenu')){
    function pmenu($parent_id = 0,$config=array()) {
        $ci =& get_instance();
        $ci->load->model('padrao_model','padrao');
        return $ci->padrao->lista_menu($parent_id,$config);
    }
}

/*
 * Lista banners
 * Padrão ID; Alternativa: Array('id'=>2) ou Array('campo !=',4);
 */
if ( ! function_exists('pbanners')){
    function pbanners($local,$limite=0){
        $ci =& get_instance();
        $ci->load->model('padrao_model','padrao');
        return $ci->padrao->pegarBanners($local,$limite=0);
    }
}

/*
 * Lista Galerias Imagens
 * Padrão ID; Alternativa: Array('id'=>2) ou Array('campo !=',4);
 */
if ( ! function_exists('pgaleria')){
    function pgaleria($id,$limite=0){
        $ci=& get_instance();
        $ci->load->model('padrao_model','padrao');
        return $ci->padrao->pegarGaleria($id,$limite);
    }
}



/*
 * Pegar lsita de galerias
 * Monta menu
 */
if ( ! function_exists('pgalerias')){
    function pgalerias() {
        $ci =& get_instance();
        $ci->load->model('padrao_model','padrao');
        return $ci->padrao->pegarGalerias();
    }
}

/*
 * Pegar lsita de galerias
 * Monta menu
 */
if ( ! function_exists('pGaleriaInfo')){
    function pGaleriaInfo($id) {
        $ci =& get_instance();
        $ci->load->model('padrao_model','padrao');
        return $ci->padrao->galeriaInfo($id);
    }
}