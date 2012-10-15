<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelos {
    
    function __construct(){
        $this->ci = $CI =& get_instance();
    }
    
    
    function Carrega(){
        $this->ci->db->from('cms_menu_modules');
        $modulos = $this->ci->db->get()->result();
        foreach($modulos as $modulo){
            $nome_modulo = $modulo->modulo;
            $arquivo = realpath(APPPATH.'../back-end/modules/'.$nome_modulo.'/models/'.$nome_modulo.'_fe.php');
            if(file_exists($arquivo)){
                $this->ci->load->model_modules($nome_modulo);                
            }
        }
        
    }
}
