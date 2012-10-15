<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paginas extends MX_Controller {

        function __construct()
        {
            $this->autenticacao->acessar = array('index','ajax_dados');
            $this->autenticacao->modificar = array('apagar','ajax_ordem');
            $this->autenticacao->livre = array('instalar');
            $this->autenticacao->checar_logado($this->router->class , $this->router->method);
            $this->load->model('paginas_model', 'menu');
        }
        
	public function index(){
            $data = array();
            $data['lista_menu'] = $this->menu->pegaElementos();
            $data['lista_rotas'] = $this->menu->pegaElementos(0,'nao');
            $this->load->view('menu_elementos_view',$data);
        }
        
        public function novo(){
            $data = array();
            $data['layouts'] = $this->menu->listaLayouts(); 
            $this->load->view('form_view',$data);
        }
        
        public function criar_pagina(){
            $conteudo = $this->input->post('campo');
            //print_r($conteudo);
            $conteudo['id_pai'] = 0;
            $conteudo['menu'] = (!empty($conteudo['menu']))?$conteudo['menu']:'nao';
            $conteudo['padrao'] = (!empty($conteudo['padrao']))?$conteudo['padrao']:'nao';
            $conteudo['apagar'] = (!empty($conteudo['apagar']))?$conteudo['menu']:'nao';
            $retorno = $this->db_model->inserir($conteudo,'cms_paginas');
            if($conteudo['controle_padrao']=='sim'){
                $conteudo['controle'] = 'paginas/index/'.$retorno;
                $this->db->where('id', $retorno);
                $this->db->update('cms_paginas',$conteudo);
            }
            redirect('paginas');
        }
        
        function editar($id){
            $data = array();
            $data['layouts'] = $this->menu->listaLayouts(); 
            $data['dados'] = $this->db_model->dados($id,'cms_paginas');
            $this->load->view('form_view',$data);
        }
        
        
        public function edita($id){
            $conteudo = $this->input->post('campo');
            $conteudo['menu']   = (!empty($conteudo['menu']))?$conteudo['menu']:'nao';
            $conteudo['padrao'] = (!empty($conteudo['padrao']))?$conteudo['padrao']:'nao';
            $conteudo['apagar'] = (!empty($conteudo['apagar']))?$conteudo['apagar']:'nao';
            if(!empty($conteudo['titulo'])){
                $this->db_model->editar($id,$conteudo,'cms_paginas');
            }
            redirect('paginas');
        }
        
        public function apagar($id){
            $this->db_model->apagar($id,'cms_paginas');
            redirect('paginas');
        }
        

        
        
        ///AJAX
        public function ajax_ordem(){
             
            $ordens = $this->input->post('ordem');
            foreach($ordens as $ordem=>$linha){
                if($linha['item_id']!='root'){
                    $id =  $linha['item_id'];
                    $id_pai =  $linha['parent_id'];
                    $data = array(
                        'ordem' => $ordem,
                        'id_pai' => $id_pai,
                        'updated_at' => date('Y-m-d')
                    );

                    $this->db->where('id', $id);
                    $this->db->update('cms_paginas', $data); 
                }
                
            }
        }
        
        public function ajax_dados($id){
            $dados = '';
            $this->db->from('cms_paginas');
            $this->db->where('id',$id);
            //$this->db->where('menu','sim');
            $data = $this->db->get()->row();
            $dados .= '<form action="'.site_url('paginas/editar/'.$data->id).'" method="POST">';
            $dados .= '<p><input type="text" name="campo[titulo]" value="'.$data->titulo.'" class="{validate:{required:true}}"/></p>';
            $dados .= '<p>Controle: '.$data->controle.'</p>';
            $dados .= '<p>URI: <input type="text" name="campo[uri]" value="'.$data->uri.'" class="{validate:{required:true}}"/></p>';
            $dados .= '<p><input type="submit" id="submit" value="Salvar" class="button blue" /></p>';
            $dados .= '</form>';
            echo $dados;
        }
        


}