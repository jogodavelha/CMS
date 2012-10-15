<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

        function __construct()
        {
            parent::__construct();
        }

	public function index()
	{
		$this->load->view('login_view');
	}

        public function entrar()
	{
            $usuario = $this->input->post('usuario');
            $senha = md5($this->input->post('senha'));
            if(!empty ($usuario) || !empty ($senha)){
                $retorno = $this->autenticacao->entrar($usuario,$senha);
                if($retorno){
                    redirect(base_url());
                }else{
                    redirect(base_url().'login');
                }
            }
	}

        public function sair()
	{
            $this->session->sess_destroy();
            $this->index();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */