<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grupos extends CI_Controller {

        function __construct()
        {
            parent::__construct();
            $this->autenticacao->acessar = array('index','lista');
            $this->autenticacao->modificar = array('novo','inserir','editar','edita','salvar');
            $this->autenticacao->livre = array('instalar');
            $this->autenticacao->checar_logado($this->router->class , $this->router->method);
            $this->load->model('grupos_model', 'grupos');
        }

	public function index()
	{
		$data['grupos'] = $this->grupos->grupos();
                $this->load->view('grupos/grupos_lista_view',$data);
	}
        
        public function novo(){
            $data['acessar'] = $this->grupos->permissoes('','acessar');
            $data['modificar'] = $this->grupos->permissoes('','modificar');
            $this->load->view('grupos/grupo_form_view',$data);
	}
        
        public function editar($id)
	{
            $data['grupo'] = $this->grupos->grupo_dados($id);
            $data['acessar'] = $this->grupos->permissoes($id,'acessar');
            $data['modificar'] = $this->grupos->permissoes($id,'modificar');
            $this->load->view('grupos/grupo_form_view',$data);
	}
        
        public function salvar($id=''){
            $campos['acessar'] = $this->input->post('acesso');
                $campos['modificar'] = $this->input->post('modificar');
                $campos['nome'] = $this->input->post('nome');
            if(!empty($id) && is_numeric($id)){
                $this->grupos->grupo_salvar($campos,$id);
                redirect('grupos');
            }else{
                $this->grupos->grupo_salvar($campos);
                redirect('grupos');
            }
        }

        public function grupos($acao='',$id='')
	{
            if(empty ($acao)){
                
            }elseif($acao=='novo'){
                
            }elseif($acao=='editar' && is_numeric($id)){
                
            }elseif($acao=='salvar'){
                
                //$data['metodos'] = $this->usuarios->permissoes();
                //$this->load->view('usuarios/grupo_form_view',$data);
            }
            
	}
        public function lista()
	{
            $data['usuarios'] = $this->usuarios->lista();
            $this->load->view('usuarios/usuarios_lista_view',$data);
	}

        
        
        public function edita($id){
            $conteudo= $this->input->post('campo');
            $senha = $this->input->post('senha');
            
            $this->usuarios->salvarSenha($id,$senha);
            
            $this->db_model->editar($id,$conteudo,'cms_usuarios');
            redirect('usuarios','refresh');
        }
        
        
        
        public function inserir(){
            $conteudo= $this->input->post('campo');
            if(!$this->usuarios->verificaUsuario($conteudo['usuario'])){
                //$conteudo= $this->input->post('campo');
                $retorno = $this->db_model->inserir($conteudo,'cms_usuarios');
                if(!empty($retorno)){
                    $senha = $this->input->post('senha');
                    $this->usuarios->salvarSenha($retorno,$senha);
                }

                redirect('usuarios','refresh');
            }else{
                redirect('usuarios/novo','refresh');
            }
        }

        
}