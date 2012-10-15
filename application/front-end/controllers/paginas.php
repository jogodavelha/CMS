<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paginas extends CI_Controller {
    public $layout = 'padrao';    
    
    public function index($id){
        $this->db->from('cms_paginas');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $info = $this->db->get()->row();
        if(!empty($info->layout)){
            $this->layout = $info->layout;
        }
        $data['dados'] = $info;
        if($info->padrao!='sim'){
            $data['titulo'] = $info->titulo;
        }
        $this->load->view($info->view,$data);
    }
    
    public function texto($id){
        $data = array();
        $this->db->from('cms_paginas');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $info = $this->db->get()->row();
        if(!empty($info->layout)){
            $this->layout = $info->layout;
        }
        $data['texto'] = $this->textos_fe->pegar($info->id_referencia);
        $this->load->view($info->view);
    }
        
}