<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comum extends CI_Controller {

        function __construct()
        {
            parent::__construct();
            $this->autenticacao->acessar = array();
            $this->autenticacao->modificar = array();
            $this->autenticacao->checar_logado($this->router->class , $this->router->method);
        }
        
        //Ajax URL
        function uri(){
            $str = $this->input->post('titulo');
            $delimiter='-';
            $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
            $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
            $clean = strtolower(trim($clean, '-'));
            $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

            echo  $clean;

        }
}