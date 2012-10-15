<?php
class Modulos_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function listaModulos(){
        //Buscando os modulos
        //Elimina módulos privados da lista
        $privado = array(".", "..",'fm','index.html');
        //Diretorio de módulos
        $dir = APPPATH."modules";
        $modulos = array();
        $dirhandle = opendir($dir);
        $i=0;
        while ($file = readdir($dirhandle)) {
            if(!in_array($file,$privado)){
                $modulos[$file] = '';
                $i++;
                $modulos[$file]['info'] = 'Sem Informação.';
                $arquivo_info = $dir.'/'.$file.'/info.txt';
                if(is_file($arquivo_info)){
                   $info = file_get_contents($arquivo_info);
                   $modulos[$file]['info'] = $info;
                }
            }
        }
        closedir($dirhandle);
        
        $this->db->from('cms_menu_modules');
        $mi = $this->db->get()->result();
        
        foreach($mi as $m){
            $modulos[$m->modulo]['instalado']   = true;
            $modulos[$m->modulo]['id']          = $m->id;
        }
        
        return $modulos;
    }
    
    function desistala($id){
        $this->db->where('id',$id);
        $this->db->delete('cms_menu_modules');
        $this->session->set_flashdata('sucesso', 'Módulo desinstalado com sucesso!');
    }
}