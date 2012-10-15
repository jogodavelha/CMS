<?php
class Padrao_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    /*
     * Busca uma linha em qualquer tabela.
     * 
     */
    function dados($condicao,$tabela,$limite=''){
        if(is_array($condicao)){
            foreach ($condicao as $coluna=>$valor){
                $this->db->where($coluna, $valor);
            }
        }elseif(is_numeric($condicao)){
            $this->db->where('id', $condicao);
        }
        $this->db->from($tabela);
        
        if($limite==''){
            $this->db->limit(1);
            return $this->db->get()->row();
        }elseif($limite==0){
            return $this->db->get()->result();
        }elseif($limite>0){
            $this->db->limit($limite);
            return $this->db->get()->result();
        }
    }
    
    function dadosPaginado($tabela,$segmento=1,$qtd=5,$condicao=array()){ //$qtd = array(total_registros,por_pagina)
        $data = array();
	//paginacao
        if(is_array($condicao)){
            foreach($condicao as $chave=>$valor){
                $this->db->where($chave,$valor);
            }
        }
        
        $this->load->library('pagination');
        $page = $this->uri->segment($segmento);
        $page = (empty($page))?1:$page+1;
        $offset = ($page-1)*$qtd;
        $data['resultado'] = $this->db->get($tabela,$qtd,$offset)->result();
        
        
        if(is_array($condicao)){
            foreach($condicao as $chave=>$valor){
                $this->db->where($chave,$valor);
            }
        }

        $data['total'] = $this->db->get($tabela)->num_rows();

        
        $config['base_url'] = $this->config->site_url($this->uri->uri_string());
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $qtd;
        $config['uri_segment'] = $segmento;
        //$config['num_links'] = 5;
        
        $config['full_tag_open'] = '<ul class="left">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'Primeira';
        $config['first_tag_open'] = '<div>';
        $config['first_tag_close'] = '</div>';

        $config['last_link'] = 'Ultima';
        $config['last_tag_open'] = '<div>';
        $config['last_tag_close'] = '</div>';

        $config['next_link'] = 'Próxima';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = 'Anterior';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li><a class="backcolrhover backcolr" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $data['num_de_paginas'] = round($data['total'] / $qtd);
        //$data['produtos'] = $query;
        
        $data['paginacao'] = $this->pagination->create_links();
	return $data;
    }
    
    function lista_menu($parent_id = 0,$config=array()) {
                $filhos = (!empty($config['filhos']))?$config['filhos']:'sim';
        
                $a_ativo = (!empty($config['a-ativo']))?$config['a-ativo']:'';
                $a_class = (!empty($config['a-class']))?$config['a-class']:'';
                
                $li_class = (!empty($config['li-class']))?$config['li-class'].' ':'';
                $li_ativo = (!empty($config['li-ativo']))?$config['li-ativo']:'';
                $li_expande = (!empty($config['li-expande']))?$config['li-expande']:'';
                
                $p_ul_class = (!empty($config['primeira-ul-class']))?$config['primeira-ul-class']:'';
                $ul_class = (!empty($config['ul-class']))?$config['ul-class']:'';
        
                
                
		$corpo = '';
                 
                $this->db->from('cms_paginas');
                $this->db->where('id_pai', $parent_id);
                $this->db->where('menu', 'sim');
                $this->db->order_by('ordem');
                $resultado = $this->db->get()->result();
		 //$query = $this->db->query("SELECT * FROM cms_categorias WHERE id_pai = '" . (int)$parent_id . "' ORDER BY nome ASC");
                 if(!empty($resultado)){
                     
                     $corpo .= ($parent_id==0)?'<ul class="'.$p_ul_class.'">':'<ul class="'.$ul_class.'">';
                        foreach ($resultado as $dado) {
                            //Adiciona Class Ativo
                            $classe_a_ativo = '';
                            if($dado->uri==$this->uri->uri_string && !empty($a_ativo)){
                                $classe_a_ativo = $a_ativo;
                                if(!empty($a_class)){
                                    $classe_a_ativo .= ' ';
                                }
                            }
                            
                            $classe_li_ativo = '';
                            if($dado->uri==$this->uri->uri_string && !empty($li_ativo)){
                                $classe_li_ativo = $li_ativo.' ';
                            }
                            
                            $classe_li_expande = '';
                            if($this->temFilho($dado->id) && !empty($li_expande)){
                                $classe_li_expande = $li_expande;
                            }
                            
                            $corpo .= '<li class="'.$li_class.$classe_li_ativo.$classe_li_expande.'"><a class="'.$classe_a_ativo.$a_class.'" href="'.(($dado->uri!='#')?site_url($dado->uri):$dado->uri).'">'.$dado->titulo.'</a>';
                            if($filhos=='sim'){
                                $corpo .= $this->lista_menu($dado->id,$config);
                            }
                        }
                     $corpo .= '</ul>';
                 }


		return $corpo;
   }
   
   function temFilho($id){
       $this->db->from('cms_paginas');
       $this->db->where('id_pai', $id);
       $this->db->where('menu', 'sim');
       $resultado = $this->db->get()->row();
       if(count($resultado)>0){
           return true;
       }
       return false;
   }
    
    /*
     * Imagem edita.
     */
    function imagem($arqOriginal,$width=0,$height=0){
                //Carrega Lib Imagem
                $this->load->library('image_lib');
                //Pega informação imagem original
                $info = pathinfo($arqOriginal);
                //Medidas do arquivo
                list($o_width, $o_height, $o_type, $o_attr)= getimagesize($arqOriginal);
                
                if(empty($width)&&empty($heigth)){
                    return $arqOriginal;
                }elseif(empty($width)&&!empty($height)){
                    $width = ($o_width*$height)/$o_height;
                }elseif(!empty($width)&&empty($height)){
                    $height = ($width*$o_height)/$o_width;
                }

                //Caminho e nome do arquivo com as medidas
                $arqTempo = 'temp/' . $info['filename'] . '-' . $width . 'x' . $height . '.' . $info['extension'];
                $arqNovo = 'cache/'. $info['dirname'].'/'. $info['filename'] . '-' . $width . 'x' . $height . '.' . $info['extension'];

                //Verifica se o arquivo existe.
		if(file_exists($arqNovo))
                    return $arqNovo;

                
                $master_dim = (($o_width-$width) < $o_height-$height?'width':'height');

                $perc = max((100*$width)/$o_width ,(100*$height)/$o_height);

                $perc = round($perc,0);

                $w_d = round(($perc*$o_width)/100, 0);
                $h_d = round(($perc*$o_height)/100, 0);

                //Criar Pastas
                $dir = explode('/', 'cache/'.$info['dirname']);
                $pasta = '';
                for($i=0;$i<(count($dir));$i++){
                    $pasta .= ($i>0)?'/':'';
                    $pasta .= $dir[$i];
                    if(!@is_dir($pasta)){
                        mkdir($pasta);
                    }
                }

                /*
                *    Redimensiona Imagem
                */
                
                $config['source_image'] = $arqOriginal;
                $config['new_image'] = $arqTempo;
                $config['maintain_ratio'] = TRUE;
                $config['master_dim'] = $master_dim;
                $config['width'] = $w_d + 5;
                $config['height'] = $h_d + 5;
                $config['quality'] = 100;

                $this->image_lib->initialize($config);

                $this->image_lib->resize();

                //$size = _get_size($arqTempo);
                list($t_width, $t_height, $t_type, $t_attr)= getimagesize($arqTempo);

                unset($config); // clear $config
                    
                    
                /*
                *    Recortar a imagem em. weight, height
                */

                $config['source_image'] = $arqTempo;
                $config['new_image'] = $arqNovo;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = $width;
                $config['height'] = $height;
                $config['y_axis'] = round(($t_height-$height)/2);
                $config['x_axis'] = round(($t_width-$width)/2);

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if ( ! $this->image_lib->crop())
                {
                    echo $this->image_lib->display_errors();
                }

                unlink($arqTempo);
                $info = pathinfo($arqNovo);
                //out($info);

                return $arqNovo;
               
    }
    
    function pegarConfiguracao($chave){
        $this->db->select('valor');
        $this->db->from('cms_config');
        $this->db->where('chave', $chave);
        $dado = $this->db->get()->row();
        return (!empty ($dado->valor))?$dado->valor:'';
    }
    
    function pegarTexto($uri=''){
       if(!empty($uri)){
           $this->db->select('titulo,uri,conteudo');
           $this->db->from('textos');
           $this->db->where('uri', $uri);
           return $this->db->get()->row(); 
       }
       return '';
    }
   
    function pegarBanners($local,$limite=0){
        $this->db->select('bi.*');
        $this->db->from('banners b');
        $this->db->join('banners_imagens bi','bi.id_banner = b.id');
        $this->db->where('b.local', $local);
        if($limite>0){
            $this->db->limit($limite);
        }
        return $this->db->get()->result();
    }
   
   function pegarGaleria($id,$limite=0){
                $this->db->select('gi.*,g.local as galeria');
                $this->db->from('galerias g');
                $this->db->join('galerias_imagens gi','gi.id_galeria = g.id');
                $this->db->where('g.id', $id);
                if($limite>0){
                    $this->db->limit($limite);
                }elseif($limite==1){
                    return $this->db->get()->row();
                }
                return $this->db->get()->result();
    }
   
   function pegarGalerias(){
       $this->db->from('galerias');
       $this->db->where('publicar', 'sim');
       $this->db->order_by('created_at','desc');
       $resultado = $this->db->get()->result();
       $i=0;
       foreach($resultado as $linha){
           $objeto = $this->pegarGaleria($linha->id,1);
           $resultado[$i]->destaque = $objeto[0]->imagem;
           $i++;
       }
       return $resultado;
   }
   
   function galeriaInfo($id){
       $this->db->from('galerias');
       $this->db->where('publicar', 'sim');
       $this->db->where('id', $id);
       return $this->db->get()->row();
   }
    
}