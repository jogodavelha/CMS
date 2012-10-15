<?php
class Db_model extends CI_Model {
    public $paginacao = false;
    public $porpagina = 10;
    public $paginas = '';
    public $pagsegmento = 3;
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function inseriConfig($conteudo){
        foreach ($conteudo as $chave=>$valor){
            $this->db->from('cms_config');
            $this->db->where('chave', $chave);
            $retorno = $this->db->get()->row();
            $data['chave'] = $chave;
            $data['valor'] = $valor;
            if(count($retorno)>0){
                $this->editar($retorno->id,$data,'cms_config');
            }else{
                $this->inserir($data,'cms_config');
            }
        }
    }


    /*
     * Inserir campo Normal.
     * Retorna ID do dado Inserido
     */

    function inserir($campos,$tabela){
        foreach($campos as $campo=>$valor){
            if($this->checaCampo($campo,$tabela))
                $data[$campo] = $valor;
        }
        $data['created_at'] = date("Y-m-d H:i:s");
        
        $this->db->insert($tabela, $data);
        $this->session->set_flashdata('sucesso', 'Inserido com sucesso!');
        return $this->db->insert_id();
    }

    /*
     * Editar campo Normal
     */
    function editar($id,$campos,$tabela){

        foreach($campos as $campo=>$valor){
            if($this->checaCampo($campo,$tabela))
                $data[$campo] = $valor;
        }
        $data['updated_at'] = date("Y-m-d H:i:s");

        $this->db->where('id', $id);
        $this->db->update($tabela, $data);
        $this->session->set_flashdata('sucesso', 'Editado com sucesso!');
    }

    /*
     * Pega Dados de Uma Tabela
     */
     function dados($id,$tabela){
        $this->db->from($tabela);
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    /*
     * Pega lista de dados de uma tabela
     */
    function lista($tabela,$condicoes=array()){
        if($this->paginacao){
            
            $numreg = $this->porpagina;
            $pg = $this->uri->segment($this->pagsegmento);
            if (!isset($pg)) {
                $pg = 0;
            }
            $inicial = $pg * $numreg;

            //Pegando registros
            $this->db->limit($numreg,$inicial);
            $this->db->start_cache();
            foreach ($condicoes as $campo=>$valor){
                if($this->checaCampo($campo,$tabela)){
                    $this->db->where($campo, $valor);
                }
                
            }
            $this->db->stop_cache();
            
            $this->db->from($tabela);
            $resultado = $this->db->get()->result();
            
            //Conta os resultados
            $this->db->from($tabela);
            $totalregistros = $this->db->count_all_results();
            
            $this->geraPaginas($totalregistros,$pg);
            $config['base_url'] = site_url($this->router->class.'/'.$this->router->method);
            $config['total_rows'] = 50;
            $config['per_page'] = $this->porpagina;
            $this->db->flush_cache();
            return $resultado;
        }else{
        //Se não precisar de paginação
        if($this->checaTabela($tabela)){
            foreach ($condicoes as $campo=>$valor){
                if($this->checaCampo(trim(str_replace('!=', '', $campo)),$tabela)){
                    $this->db->where($campo, $valor);
                }
                
            }

            $this->db->from($tabela);
            return $this->db->get()->result();
        }
        }
    }
    
    /*
     * Gera armazena paginas
     */
    function geraPaginas($quantreg,$pg){
        $quant_pg = ceil($quantreg/$this->porpagina);
        $quant_pg++;
        $PHP_SELF = site_url($this->router->class.'/'.$this->router->method);
        
        //Veriavel de Páginas
        $paginas = '';
        // Verifica se esta na primeira página, se nao estiver ele libera o link para anterior
        $paginas .= '<div class="action_bar nomargin">';
        $paginas .= '<div class="dataTables_info"></div>';
        $paginas .= '<div class="dataTables_paginate paging_full_numbers">';
        //<span class="first paginate_button paginate_button_disabled">Primeira</span>
        //<span>
        //<span class="paginate_active">1</span>
        //<span class="paginate_button"><a href="#">2</a></span>
        //</span>
        //<span class="next paginate_button">Próxima</span>
        //<span class="last paginate_button">Última</span>
        if ( $pg > 0) { 
                $paginas.= '<span class="previous paginate_button paginate_button"><a href="'.$PHP_SELF.'/'.($pg-1) .'"><b>&laquo; anterior</b></a></span>';
        } else { 
                $paginas.= '<span class="previous paginate_button paginate_button_disabled">&laquo; anterior</span>';
        }
        $paginas .= '<span>';
        // Faz aparecer os numeros das página entre o ANTERIOR e PROXIMO
        for($i_pg=1;$i_pg<$quant_pg;$i_pg++) { 
                // Verifica se a página que o navegante esta e retira o link do número para identificar visualmente
                if ($pg == ($i_pg-1)) { 
                        $paginas.= '<span class="paginate_active">'.$i_pg.'</span>';
                } else {
                        $i_pg2 = $i_pg-1;
                        $paginas.= '<span class="paginate_button"><a href="'.$PHP_SELF.'/'.$i_pg2.'">'.$i_pg.'</a></span>';
                }
        }
        $paginas .= '</span>';
        // Verifica se esta na ultima página, se nao estiver ele libera o link para próxima
        if (($pg+2) < $quant_pg) { 
                $paginas.= '<span class="next paginate_button"><a href="'.$PHP_SELF."/".($pg+1).'"><b>próximo &raquo;</b></a></span>';
        } else { 
                $paginas.= '<span class="next paginate_button paginate_button_disabled">Próxima</span>';
        }
        
        $paginas .= '</div></div>';
        $this->paginas = $paginas;
    }

    /*
     * Apaga dado do Campo
     */
    function apagar($id,$tabela){
        if(is_array($id)){
            foreach ($id as $chave=>$valor){
                $this->db->where($chave, $valor);
            }
        }else{
            $this->db->where('id', $id);
        }
        $this->db->delete($tabela);
        $this->session->set_flashdata('sucesso', 'Apagado com sucesso!');
        return true;
    }

    /*
     * Checar se campo existe na tabela
     */

    function checaCampo($campo,$tabela,$tipo=''){
        $retorno = $this->checaTabela($tabela,$criar=true);
        if($retorno){
            if (!$this->db->field_exists($campo,$tabela)){
                switch ($tipo) {
                    case '':
                        $tipo = 'VARCHAR(255)';
                        break;
                    case 'text':
                        $tipo = 'TEXT';
                        break;
                    default:
                        $tipo = 'VARCHAR(255)';
                }
                $query = ("ALTER TABLE $tabela ADD COLUMN $campo $tipo AFTER id;");
                $this->db->query($query);
            }
        }
        return true;
    }
    /*
     * Checar se tabela existe no campo de dados
     */

    function checaTabela($tabela,$criar=true){
        //$tabelas = $this->db->list_tables();
        if (!$this->db->table_exists($tabela)){
            if($criar){
                $this->db->query("CREATE TABLE IF NOT EXISTS $tabela (
                                      id int(11) NOT NULL AUTO_INCREMENT,
                                      created_at datetime DEFAULT NULL,
                                      updated_at datetime DEFAULT NULL,
                                      PRIMARY KEY (id)
                                  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
            }
        }
        return true;
    }

}