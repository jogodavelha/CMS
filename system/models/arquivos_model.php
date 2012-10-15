<?php
class Arquivos_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function arquivo($id,$campo,$tabela,$config = array()){
        if(!empty($_FILES[$campo]['name'])){
            //Apaga o arquivo antigo se existir
            $arquivo_antigo = $this->buscaArquivo($id,$campo,$tabela);
            if(!empty ($arquivo_antigo)){
                $this->apagaArquivo($arquivo_antigo);
            }
            
            //Verifica se existe o diretorio na pasta uploads
            $diretorio_tabela = realpath(getcwd().'/../uploads/'.$tabela.'/');
            if($this->verificaDiretorio($diretorio_tabela)){
                $diretorio = $diretorio_tabela.$id;
                $this->verificaDiretorio($diretorio);
            }
            
            //Configuração Inicial
            $config['upload_path'] = getcwd().'/../uploads/'.$tabela.'/'.$id;
            $config['encrypt_name'] = true;
            $config['allowed_types'] = 'pdf|doc';
            $config['max_size']	= (!empty($config['max_size']))?$config['max_size']:'1000';
            
            $this->upload->initialize($config);
            
            //Faz UPLOAD
            $this->upload->do_upload($campo);
            $retorno = $this->upload->data();
            print_r($this->upload->display_errors());
            if($retorno){
                $this->inserirCampo($retorno['full_path'],$id,$campo,$tabela);
                //print_r($this->upload->display_errors());
                $this->session->set_flashdata('erro', $this->upload->display_errors());
            }
        }
    }

    function imagem($id,$campo,$tabela){            
        if(!empty($_FILES[$campo]['name'])){
            $arquivo_antigo = $this->buscaArquivo($id,$campo,$tabela);
            if(!empty ($arquivo_antigo)){
                $this->apagaArquivo($arquivo_antigo);
            }

            $diretorio_tabela = getcwd().'/../uploads/'.$tabela.'/';
            if($this->verificaDiretorio($diretorio_tabela)){
                echo $diretorio = $diretorio_tabela.$id;
                $this->verificaDiretorio($diretorio);
            }

            $config['upload_path'] = getcwd().'/../uploads/'.$tabela.'/'.$id;
            $config['encrypt_name'] = true;
            $config['allowed_types'] = 'gif|jpg|png';
            //$config['max_size']	= '100';
            //$config['max_width'] = '1024';
            //$config['max_height'] = '768';

            $this->upload->initialize($config);

            $this->upload->do_upload($campo);
            $retorno = $this->upload->data();
            if($retorno){
                $this->inserirCampo($retorno['full_path'],$id,$campo,$tabela);
                //print_r($this->upload->display_errors());
            }
        }
    }

    function verificaDiretorio($diretorio){
        if(! @is_dir($diretorio)){
            mkdir($diretorio, 0777);
        }
        return true;
    }

    function inserirCampo($valor,$id,$campo,$tabela){
        $valor = explode('uploads',$valor);
        $valor = 'uploads'.$valor[1];
        //cho $campo = str_replace('[]', '', $campo);
        $data[$campo] = $valor;
        
        $this->db->where('id', $id);
        $this->db->update($tabela, $data);
        return true;
    }

    function buscaArquivo($id,$campo,$tabela){
        if($this->db_model->checaCampo($campo,$tabela)){
            $this->db->select($campo);
            $this->db->from($tabela);
            $this->db->where('id', $id);
            $dados = $this->db->get()->row();
            return $dados->$campo;
        }
    }

    function apagaArquivo($arquivo){
        if(@is_file('../'.$arquivo)){
            unlink('../'.$arquivo);
        }
    }
}