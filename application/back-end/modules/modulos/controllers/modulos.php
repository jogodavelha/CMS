<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulos extends MX_Controller {

        function __construct(){
            parent::__construct();
            $this->autenticacao->acessar = array('index');
            $this->autenticacao->modificar = array('novo');
            $this->autenticacao->livre = array('instalar');
            $this->autenticacao->checar_logado($this->router->class , $this->router->method);
            $this->load->model('modulos_model', 'modulos');
        }

        //Notícias
	public function index(){
            $data['modulos'] = $this->modulos->listaModulos();
            $this->load->view('lista_view',$data);
	}
        
        public function desinstalar($id){
            $dados = $this->db_model->dados($id,'cms_menu_modules');
            $this->modulos->desistala($id);
            $this->db_model->apagar(array('classe'=>$dados->modulo),'cms_grupos_permissoes');
            redirect('modulos');
        }
}