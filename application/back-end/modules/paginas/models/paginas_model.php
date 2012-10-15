<?php
class Paginas_model extends CI_Model {

    public $numero_categorias = 0;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function lista(){
        $this->db->from('cms_paginas');
        return $this->db->get()->result();
    }
    
    
    public function pegaElementos($parent_id = 0,$menu='sim') {
		 $corpo = '';
                 $this->db->from('cms_paginas');
                 $this->db->where('menu', $menu);
                 $this->db->where('id_pai', $parent_id);
                 $this->db->order_by('ordem');
                 $resultado = $this->db->get()->result();
                 
                 if(!empty($resultado)){
                     $corpo .= ($parent_id==0)?'<ol class="sortable">':'<ol>';
                        foreach ($resultado as $dado) {
                            $nome = $dado->titulo.' | '.$dado->uri.' | '.$dado->controle;
                            if($menu=='sim'){
                                $nome = $dado->titulo;
                            }
                            $corpo .= '<li id="list_'.$dado->id.'"><div><a class="editar" rel="'.$dado->id.'" href="'.site_url('paginas/editar/'.$dado->id).'">'.$nome.'</a>'.(($dado->apagar=='sim')?'<a style="color:red" title="Apagar" class="apaga" href="'.site_url('paginas/apagar/'.$dado->id).'">X</a>':'').'</div>';
                            $corpo .= $this->pegaElementos($dado->id,$menu);
                        }
                     $corpo .= '</ol>';
                 }


		return $corpo;
   }

   public function pegaNome($category_id) {
                $this->db->select('nome,id_pai');
                $this->db->from('cms_categorias');
                $this->db->where('id', $category_id);
                $this->db->order_by('nome');
                $dados = $this->db->get()->row();
		//$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");

		if ($dados->id_pai) {
			return $this->pegaNome($dados->id_pai) . ' &gt; ' . ucfirst($dados->nome);
		} else {
			return ucfirst($dados->nome);
		}
  }
  
  function listaLayouts(){
        //Buscando os Layouts Existentes no Front-End
        //Elimina dados inúteis
        $privado = array(".", "..",'fm','index.html');
        //Diretorio de módulos
        $dir = APPPATHDB."front-end/views/layouts";
        $dirhandle = opendir($dir);
        $layouts = array();
        while ($file = readdir($dirhandle)) {
            if(!in_array($file,$privado)){
                $path_parts = pathinfo($dir.'/'.$file);
                $layouts[] = $path_parts['filename'];
            }
        }
        closedir($dirhandle);
        
        return $layouts;
    }
}