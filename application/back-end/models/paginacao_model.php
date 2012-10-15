<?php
class Paginacao_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function paginacao(){
        $config['base_url'] = 'http://example.com/index.php/test/page/';
        $config['total_rows'] = 200;
        $config['per_page'] = 20;
        
        //Visual da páginação
        $config['full_tag_open'] = '<div class="box-footer"><div class="action_bar nomargin"><div class="dataTables_paginate paging_full_numbers">';
        $config['full_tag_close'] = '</div></div></div>';
            //Firsts
            $config['first_link'] = 'Primeiro';
            $config['first_tag_open'] = '<span class="first paginate_button">';
            $config['first_tag_close'] = '</span>';
            //Last
            $config['last_link'] = 'Último';
            $config['last_tag_open'] = '<span class="last paginate_button">';
            $config['last_tag_close'] = '</span>';
            //Next
            $config['next_link'] = 'Próximo';
            $config['next_tag_open'] = '<span class="next paginate_button">';
            $config['next_tag_close'] = '</span>';
            //previous
            $config['prev_link'] = 'Anterior';
            $config['prev_tag_open'] = '<span class="previous paginate_button">';
            $config['prev_tag_close'] = '</span>';
            //Current
            $config['cur_tag_open'] = '<span class="paginate_active">';
            $config['cur_tag_close'] = '</span>';
            //Digit
            $config['num_tag_open'] = '<span class="paginate_button">';
            $config['num_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }
}