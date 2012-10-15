<?php
class Menu_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function instalarModulo($id_menu,$modulo,$titulo=''){
        $this->db->from('cms_menu_modules');
        $this->db->where('modulo',$modulo);
        $modulos = $this->db->get();
        if($modulos->num_rows()>0)
            return '';
        
        $data['id_menu'] = $id_menu;
        $data['titulo']  = (!empty($titulo))?$titulo:ucfirst($modulo);
        $data['modulo']  = $modulo;
        $data['ativo']   = 'sim';
        $this->db->insert('cms_menu_modules',$data);
        $this->permissaoModulo($modulo);
        $this->session->set_flashdata('sucesso', 'Módulo instalado com sucesso!');
    }
    
    function permissaoModulo($modulo){
        
        $data['id_grupo'] = 1;
        $data['classe'] = $modulo;
        
        if($this->verificaPermissao($modulo,'modificar')){
            $data['permissao'] = 'modificar';
            $this->db->insert('cms_grupos_permissoes',$data);
        }
        
        if($this->verificaPermissao($modulo,'acessar')){
            $data['permissao'] = 'acessar';
            $this->db->insert('cms_grupos_permissoes',$data);
        }
    }
    
    function verificaPermissao($modulo,$permissao){
        //echo $modulo;
        $this->db->from('cms_grupos_permissoes');
        $this->db->where('id_grupo',1);
        $this->db->where('classe',$modulo);
        $this->db->where('permissao',$permissao);
        $total = $this->db->get();
        if($total->num_rows==0)
            return true;
        return false;
    }
    
    function verificaMenu($id_menu,$modulo){
        $this->db->from('cms_menu_modules');
        $this->db->where('id_menu',$id_menu);
        $this->db->where('modulo',$modulo);
        $resultado = $this->db->get()->row();
        if(count($resultado)>0){
            return true;
        }
        return false;
    }
    
    function listaMenu(){
        $this->db->from('cms_menu');
        $this->db->where('ativo', 'sim');
        $this->db->order_by('ordem'); 
        return $menus = $this->db->get()->result();
    }
    
    function listaSubMenu(){
        $id_menu = $this->pegarIdMenu();
        
        $this->db->from('cms_menu_modules');
        $this->db->where('ativo', 'sim');
        $this->db->where('id_menu', $id_menu);
        $this->db->order_by('ordem');
        return $menus = $this->db->get()->result();
    }
    
    function pegarIdMenu(){
        $uri = $this->uri->segment(1);
        if(empty($uri)){
            $this->db->from('cms_menu');
            $this->db->where('link',NULL);
            $dado = $this->db->get()->row();
            return $dado->id;
        }elseif(is_numeric($uri)){
            return $uri;
        }elseif(is_string($uri)){
            $this->db->select('');
            $this->db->from('cms_menu_modules');
            $this->db->where('modulo', $uri);
            $dado = $this->db->get()->row();
            return (!empty($dado->id_menu))?$dado->id_menu:'';
        }
    }
    
}