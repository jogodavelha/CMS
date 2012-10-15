<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

        function __construct()
        {
            parent::__construct();
            $this->autenticacao->acessar = array('index','lista');
            $this->autenticacao->modificar = array('grupos','usuario_editar','usuario_novo');
            $this->autenticacao->livre = array('instalar');
            $this->autenticacao->checar_logado($this->router->class , $this->router->method);
            $this->load->model('usuarios_model', 'usuarios');
        }

	public function index()
	{
		$this->lista();
	}

       
        public function lista()
	{
            $data['usuarios'] = $this->usuarios->lista();
            $this->load->view('usuarios/usuarios_lista_view',$data);
	}

        public function editar($id_usuario)
	{
            $data['usuario'] = $this->usuarios->dados($id_usuario);
            $data['grupos'] = $this->usuarios->grupos();
            $this->load->view('usuarios/usuario_form_view',$data);
	}
        
        public function edita($id){
            $conteudo= $this->input->post('campo');
            $senha = $this->input->post('senha');
            
            $this->usuarios->salvarSenha($id,$senha);
            
            $this->db_model->editar($id,$conteudo,'cms_usuarios');
            redirect('usuarios','refresh');
        }
        
        public function novo(){
            $data['grupos'] = $this->usuarios->grupos();
            $this->load->view('usuarios/usuario_form_view',$data);
	}
        
        public function inserir(){
            $conteudo= $this->input->post('campo');
            if(!$this->usuarios->verificaUsuario($conteudo['usuario'])){
                $conteudo= $this->input->post('campo');
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