<?php
class Rota_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function criar_menu($titulo,$uri,$controle,$id,$tabela){
        $data = array(
            'titulo'=>$titulo,
            'uri' => $uri,
            'controle' => $controle,
            'id_referencia' => $id,
            'tbl_referencia' => $tabela
        );
        $this->db->insert('cms_rotas', $data); 
    }
    
    function inserir($id,$tabela,$titulo,$uri,$campos){
        if(!empty($campos['menu'])){
            if($campos['menu']=='sim'){
                $data = array(
                    'menu'=>'sim',
                    'apagar'=>'sim',
                    'titulo'=>$titulo,
                    'uri'=>$uri,
                    'controle'=>$campos['controle'].'/'.$uri,
                    'id_pai'=>0
                );
                if($this->verifica_rota($id,$tabela)){
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $this->db->where('id_referencia', $id);
                    $this->db->where('tbl_referencia', $tabela);
                    $this->db->update('cms_rotas', $data);
                }else{
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['id_referencia'] = $id;
                    $data['tbl_referencia'] = $tabela;
                    $this->db->insert('cms_rotas', $data); 
                }
            }elseif($campos['menu']=='nao'){
                $this->db->where('id_referencia', $id);
                $this->db->where('tbl_referencia', $tabela);
                $this->db->delete('cms_rotas'); 
            }
        }
    }
    
    
    function apagar($id,$tabela){
        $this->db->where('id_referencia', $id);
        $this->db->where('tbl_referencia', $tabela);
        $this->db->delete('cms_rotas'); 
    }
    
    public function litar_menu($parent_id=0) {
		 $category_data = array();
                 $this->db->from('cms_rotas');
                 $this->db->where('id_pai', $parent_id);
                 $this->db->where('menu', 'sim');
                 $this->db->order_by('titulo');
                 $resultado = $this->db->get()->result();
                
		 foreach ($resultado as $dado) {
                     
                     $objeto->id = $dado->id;
                     $objeto->titulo = $this->pegaNome($dado->id);
                     $category_data[] = $objeto;
	             $category_data = array_merge($category_data, $this->litar_menu($dado->id));
                  }


		return $category_data;
   }

   public function pegaNome($id ){
       
                $this->db->select('titulo,id_pai');
                $this->db->from('cms_rotas');
                $this->db->where('id', $id);
                $this->db->where('menu', 'sim');
                $this->db->order_by('titulo');
                $dados = $this->db->get()->row();
                
		if ($dados->id_pai) {
		   return $this->pegaNome($dados->id_pai) .'/'.ucfirst($dados->titulo);
		} else {
		    return ucfirst($dados->titulo);
		}
  }
  
  /********************************************************
   * NOVOS MÉTODOS
   */
  public $id_pai = 0;
  public $referencia_modulo = '';
  public $referencia_id = 0;
  public $titulo = 'Sem Título';
  public $uri = 'erro';
  public $controle = '';
  public $menu = 'nao';
  public $apagar = 'nao';
  public $layout = 'padrao';
  public $view = '';
  public function inserirRota(){
      $data = array();
      $data['id_pai'] = $this->id_pai;
      $data['referencia_modulo'] = $this->referencia_modulo;
      $data['referencia_id'] = $this->referencia_id;
      $data['titulo'] = $this->titulo;
      $data['uri'] = $this->uri;
      $data['uri'] = $this->uri;
      $data['menu'] = $this->menu;
      $data['apagar'] = $this->apagar;
      $data['layout'] = $this->layout;
      $data['view'] = $this->view;
      $data['created_at'] = date('Y-m-d H:i:s');
      
      $valor_gravado = $this->verifica_rota($this->referencia_id,$this->referencia_modulo);
      if(empty($valor_gravado)){
          $this->db->insert('cms_paginas',$data);
          $id_inserido = $this->db->insert_id();
      }else{
          $this->db->where('referencia_id',$this->referencia_id);
          $this->db->where('referencia_modulo',$this->referencia_modulo);
          $this->db->update('cms_paginas',$data);
          $id_inserido = $valor_gravado;
      }
        
      if(empty($this->controle)){
          $update = array();
          $update['controle'] = 'paginas/index/'.$id_inserido;
          $this->db->where('id',$id_inserido);
          $this->db->update('cms_paginas',$update);
      }
  }
  
  public function apagarReferencia(){
      $this->db->where('referencia_modulo', $this->referencia_modulo);
      $this->db->where('referencia_id', $this->referencia_id);
      $this->db->delete('cms_paginas');
  }
  
  //Verifica se existe rota para referencia ID, Tabela
  function verifica_rota($id,$modulo){
        if(!empty($id) && !empty($modulo)){
            $this->db->from('cms_paginas');
            $this->db->where('referencia_id', $id);
            $this->db->where('referencia_modulo',$modulo);
            $retorno = $this->db->get()->row();
            if(count($retorno)>0){
                return $retorno->id;
            }
        }
        return false;
  }
  
}