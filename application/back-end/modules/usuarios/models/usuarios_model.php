<?php
class Usuarios_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function lista(){
        $this->db->select('u.id,u.nome,u.email,g.nome as grupo');
        $this->db->from('cms_usuarios u');
        $this->db->join('cms_grupos g','g.id = u.id_grupo','left');
        return $this->db->get()->result();
    }
    
    function salvarSenha($id,$campo){
        if(!empty($campo['senha']) && !empty($campo['senha_conf'])){
            if($campo['senha'] == $campo['senha_conf']){
                $data = array('senha'=>md5($campo['senha']));
                $this->db->where('id', $id);
                $this->db->update('cms_usuarios', $data);
            }
        }
    }

    function grupos(){
        $this->db->from('cms_grupos');
        return $this->db->get()->result();
    }

    function dados($id){
        $this->db->from('cms_usuarios');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    function grupo_dados($id){
        $this->db->from('cms_grupos');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    function grupo_salvar($campos,$id=''){
        if(!empty ($id)){
            //Muda Nome
             $data = array(
                   'nome' => $campos['nome'],
                   'updated_at' => date("Y-m-d H:i:s")
             );

            $this->db->where('id', $id);
            $this->db->update('cms_grupos', $data);
        }else{
            $data = array(
               'nome' => $campos['nome'],
               'created_at' => date("Y-m-d H:i:s")
            );

            $this->db->insert('cms_grupos', $data);
            $id = $this->db->insert_id();
        }


        //Limpa Acessos
        $this->db->where('id_grupo', $id);
        $this->db->where('permissao', 'acessar');
        $this->db->delete('cms_grupos_permissoes');
        //Inserir Acessos
        if(!empty ($campos['acessar'])){
            foreach($campos['acessar'] as $chave=>$classe){
                $data = array(
                    'id_grupo' => $id ,
                    'classe' => $classe,
                    'permissao' => 'acessar'
                );

                $this->db->insert('cms_grupos_permissoes', $data);
            }
        }

        //Limpa Modificar
        $this->db->where('id_grupo', $id);
        $this->db->where('permissao', 'modificar');
        $this->db->delete('cms_grupos_permissoes');
        //Inserir Acessos
        if(!empty ($campos['modificar'])){
            foreach($campos['modificar'] as $chave=>$classe){
                $data = array(
                    'id_grupo' => $id ,
                    'classe' => $classe,
                    'permissao' => 'modificar'
             );
             $this->db->insert('cms_grupos_permissoes', $data);
            }
        }
        return '';
    }

    function permissoes($id='',$permissao=''){
        //Buscando os modulos
        //Elimina módulos privados da lista
        $privado = array(".", "..",'fm','index.html');
        //Diretorio de módulos
        $dir = APPPATH."modules";
        $files = array();
        $dirhandle = opendir($dir);
        $i=0;
        while ($file = readdir($dirhandle)) {
            if(!in_array($file,$privado)){
                $files[$file] = '';
                $i++;
            }
        }
        closedir($dirhandle);

        if(!empty ($id) && !empty ($permissao)){
            $this->db->from('cms_grupos_permissoes');
            $this->db->where('id_grupo', $id);
            $this->db->where('permissao', $permissao);
            $banco = $this->db->get()->result();
            foreach($banco as $cada){
                $files[$cada->classe] = true;
            }
        }
        
        //print_r($files);

        return $files;
    }
    
    function verificaUsuario($usuario){
        $this->db->from('cms_usuarios');
        $this->db->where('usuario', $usuario);
        $this->db->limit(1);
        $retorno = $this->db->get()->row();
        if(count($retorno)>0)
            return true;
        return false;
    }
}