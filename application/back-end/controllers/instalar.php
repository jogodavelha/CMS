<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instalar extends CI_Controller {

        function __construct()
        {
            parent::__construct();
        }
        
        //Função para instalar o CMS.
	public function index(){
            $data_criado = date('Y-m-d H:i:s');
            
            //Montando CMS_CONFIG
            $this->db->query("CREATE TABLE IF NOT EXISTS cms_config (
                                id int(11) NOT NULL AUTO_INCREMENT,
                                chave varchar(255) DEFAULT NULL,
                                valor text,
                                created_at datetime DEFAULT NULL,
                                updated_at datetime DEFAULT NULL,
                                PRIMARY KEY (id)
                              ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
            
            //Montando GRUPOS
            $this->db->query("CREATE TABLE IF NOT EXISTS cms_grupos (
                                id int(11) NOT NULL AUTO_INCREMENT,
                                nome varchar(255) DEFAULT NULL,
                                created_at datetime DEFAULT NULL,
                                updated_at datetime DEFAULT NULL,
                                PRIMARY KEY (id)
                              ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
            
            
            $this->db->query("CREATE TABLE IF NOT EXISTS cms_grupos_permissoes(
                                id int(11) NOT NULL AUTO_INCREMENT,
                                id_grupo int(11) DEFAULT NULL,
                                nome varchar(255) DEFAULT NULL,
                                classe varchar(100) DEFAULT NULL,
                                permissao enum('modificar','acessar') DEFAULT NULL,
                                PRIMARY KEY (id)
                                ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
            
            //Cria tabela MODULOS
            $this->db->query("CREATE TABLE IF NOT EXISTS cms_menu (
                                id int(11) NOT NULL AUTO_INCREMENT,
                                ativo enum('nao','sim') DEFAULT NULL,
                                titulo varchar(100) DEFAULT NULL,
                                icone varchar(100) DEFAULT NULL,
                                link varchar(100) DEFAULT NULL,
                                ordem int(11) DEFAULT NULL,
                                PRIMARY KEY (id)
                              ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
            
            $this->db->query("CREATE TABLE IF NOT EXISTS cms_menu_modules (
                                id int(11) NOT NULL AUTO_INCREMENT,
                                id_menu int(11) DEFAULT NULL,
                                titulo varchar(100) DEFAULT NULL,
                                modulo varchar(111) DEFAULT NULL,
                                ativo enum('sim','nao') DEFAULT NULL,
                                ordem int(11) DEFAULT NULL,
                                PRIMARY KEY (id)
                              ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
            
            //Cria a Tabela MENU
            $this->db->query("CREATE TABLE IF NOT EXISTS cms_paginas (
                                id int(11) NOT NULL AUTO_INCREMENT,
                                padrao enum('nao','sim') DEFAULT 'nao' COMMENT '//Se é a página principal',
                                id_pai int(11) DEFAULT '0',
                                referencia_modulo varchar(255) DEFAULT NULL,
                                referencia_id int(11) DEFAULT NULL,
                                titulo varchar(255) DEFAULT 'sem titulo',
                                uri varchar(255) DEFAULT NULL,
                                controle varchar(255) DEFAULT NULL,
                                menu enum('nao','sim') DEFAULT 'nao',
                                ordem int(11) DEFAULT '0',
                                apagar enum('nao','sim') DEFAULT NULL,
                                layout varchar(255) DEFAULT 'padrao',
                                view varchar(255) DEFAULT 'default_view',
                                created_at datetime DEFAULT NULL,
                                updated_at datetime DEFAULT NULL,
                                PRIMARY KEY (id)
                              ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
            
            //Cria a tabela USUARIOS
            $this->db->query("CREATE TABLE IF NOT EXISTS cms_usuarios (
                                id int(11) NOT NULL AUTO_INCREMENT,
                                id_grupo int(11) DEFAULT NULL,
                                usuario varchar(255) DEFAULT NULL,
                                senha varchar(255) DEFAULT NULL,
                                nome varchar(255) DEFAULT NULL,
                                email varchar(255) DEFAULT NULL,
                                created_at datetime DEFAULT NULL,
                                updated_at datetime DEFAULT NULL,
                                PRIMARY KEY (id)
                            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
            
            //Inserir Configuração inicial
            $this->db->query("INSERT IGNORE INTO cms_config VALUES ('1', 'site_titulo', 'DAPHOST CMS', '$data_criado', null);");
            //Inserir um GRUPO PRINCIPAL
            $this->db->query("INSERT IGNORE INTO cms_grupos VALUES ('1', 'Administrador TOP', '$data_criado', null);");
            //Inserir PERMISSÕES
            $this->db->query("INSERT IGNORE INTO cms_grupos_permissoes VALUES ('1', '1', null, 'usuarios', 'modificar');");
            $this->db->query("INSERT IGNORE INTO cms_grupos_permissoes VALUES ('2', '1', null, 'usuarios', 'acessar');");
            
            $this->db->query("INSERT IGNORE INTO cms_grupos_permissoes VALUES ('3', '1', null, 'modulos', 'modificar');");
            $this->db->query("INSERT IGNORE INTO cms_grupos_permissoes VALUES ('4', '1', null, 'modulos', 'acessar');");
            
            $this->db->query("INSERT IGNORE INTO cms_grupos_permissoes VALUES ('5', '1', null, 'grupos', 'modificar');");
            $this->db->query("INSERT IGNORE INTO cms_grupos_permissoes VALUES ('6', '1', null, 'grupos', 'acessar');");
            
            $this->db->query("INSERT IGNORE INTO cms_grupos_permissoes VALUES ('7', '1', null, 'menus', 'modificar');");
            $this->db->query("INSERT IGNORE INTO cms_grupos_permissoes VALUES ('8', '1', null, 'menus', 'acessar');");
            
            //Insere MENU
            $this->db->query("INSERT IGNORE INTO cms_menu VALUES ('1', 'sim', 'Painel', 'dashboard', null, '1');");
            $this->db->query("INSERT IGNORE INTO cms_menu VALUES ('2', 'sim', 'Usuários', 'user', null, '2');");
            $this->db->query("INSERT IGNORE INTO cms_menu VALUES ('3', 'sim', 'Config', 'cog', null, '3');");
            
            //Insere Página Principal
            $this->db->query("INSERT INTO cms_paginas VALUES ('1', 'sim', '0', null, null, 'Home', 'principal', 'paginas/index/1', 'nao', '0', 'nao', 'padrao', 'principal_view', '{$data_criado}', null);");
            
            //Insere Primeiro Usuario
            //Login: admin
            //Senha: 123456
            $this->db->query("INSERT IGNORE INTO cms_usuarios VALUES ('1', '1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Primeiro Usuário', 'diegooass@gmail.com', '{$data_criado}', '');");
            
            //Instala os MODULOS
            $this->menu_model->instalarModulo(2,'grupos');
            $this->menu_model->instalarModulo(3,'modulos');
            $this->menu_model->instalarModulo(3,'paginas','Páginas');
            $this->menu_model->instalarModulo(2,'usuarios','Usuários');
            
            //echo 'Instalado com sucesso!';
            
            redirect('');
            
        }
}