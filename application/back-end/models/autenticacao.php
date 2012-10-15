<?php
class Autenticacao extends CI_Model {

    var $acessar;
    var $modificar;
    var $livre = array();

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function entrar($usuario,$senha)
    {
        if(empty ($usuario) || empty ($senha)){
            return false;
        }
        
        $sql = "SELECT id,id_grupo,usuario,nome,email FROM cms_usuarios WHERE usuario ='" . $usuario . "' AND senha ='" . $senha . "'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)<1){
            return false;
        }else{
            $login = array(
                'id_usuario' => $result[0]->id,
                'id_grupo' => $result[0]->id_grupo,
                'usuario' => $result[0]->usuario,
                'nome' => $result[0]->nome,
                'email' => $result[0]->email,
                'logged_in_b-e' => TRUE,
                'data' => date("d/m/Y h:i:s")
            );
            //$data['ip'] = getenv("REMOTE_ADDR");
            //$data['usuario'] = $result[0]->id;
            //$this->db->insert('tb_acessos',$data);
            $this->session->set_userdata($login);
            return true;
        }
    }

    function checar_logado($classe,$metodo){
        
        if(in_array($metodo, $this->livre))
                return '';
        $session_id = $this->session->userdata('logged_in_b-e');
        if(!$session_id){
            redirect('login');
        }else{
            $this->chegar_permissao($classe,$metodo);
        }
    }
    
    //Retorna Booleando
    function bChecaLogado(){
        $session_id = $this->session->userdata('logged_in_b-e');
        if($session_id){
            return true;
        }
        return false;
    }

    function chegar_permissao($classe,$metodo){
        if(empty($this->acessar))
                $this->acessar = array();
        if(empty($this->modificar))
                $this->modificar = array();
        if(!in_array($metodo, $this->acessar) && !in_array($metodo, $this->modificar))
                return '';
        //Verifica o Tipo
        $tipo_a = false;
        $tipo_m = false;
        if(in_array($metodo, $this->acessar)){
            $tipo_a = true;
        }
        if(in_array($metodo, $this->modificar)){
            $tipo_m = true;
        }

        if($tipo_a){
            if(!$this->verifica_grupo($classe,'acessar'))
                    redirect('principal/sempermissao');
        }

        if($tipo_m){
            if(!$this->verifica_grupo($classe,'modificar'))
                    redirect('principal/sempermissao');
        }

    }

    function verifica_grupo($classe,$permissao){
        $id_grupo = $this->session->userdata('id_grupo');
        $this->db->from('cms_grupos_permissoes');
        $this->db->where('id_grupo', $id_grupo);
        $this->db->where('classe', $classe);
        $this->db->where('permissao', $permissao);
        $resultado = $this->db->get()->row();
        if(count($resultado)>0)
            return true;
        return false;
    }
    
    function pegarDadosUsuarios(){
        $entrou = $this->bChecaLogado();
        if(!$entrou)
            return '';
        $id_usuario = $this->session->userdata('id_usuario');
        $this->db->select('id,id_grupo,usuario,nome,email');
        $this->db->from('cms_usuarios');
        $this->db->where('id',$id_usuario);
        return $this->db->get()->row();
    }

}