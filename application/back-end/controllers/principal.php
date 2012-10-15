<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

        function __construct()
        {
            parent::__construct();
            $this->autenticacao->acessar = array();
            $this->autenticacao->modificar = array();
            $this->autenticacao->livre = array('instalar');
            $this->autenticacao->checar_logado($this->router->class , $this->router->method);
        }
        
	public function index(){

            $data = array();
            
            //Dados do servidor
            $diretorio = realpath('../');
            $ar = $this->pegarTamanhoDiretorio($diretorio);
            
            $data['total_site'] = $this->formatoTamanho($ar['size']);
            $data['total_diretorios'] = $ar['dircount'];
            $data['total_arquivos'] = $ar['count'];
            
            //Dados do diretório upload
            $diretorio = realpath('../uploads');
            $ar = $this->pegarTamanhoDiretorio($diretorio);
            $data['total_uploads'] = $this->formatoTamanho($ar['size']);

            //Google Analytics
            $report_id = '6387855';
            $start_date = date("Y-m-d",mktime(0, 0, 0, date("m"), date("d") - 10, date("Y")));;
            $end_date = date("Y-m-d");
            $params = array('email' => 'diegooass@gmail.com', 'senha' => '','token'=>null);
            //$this->load->library('gapi',$params);
            //$this->gapi->requestReportData($report_id, array('date'), array('pageviews', 'visits', 'newVisits','bounces'), 'date', '', $start_date, $end_date, 1, 366);
            //$data['ga'] = $this->gapi->getResults();
            
            $this->load->view('principal_view',$data);
	}

        public function sempermissao(){
                $this->load->view('sempermissao_view');
        }
        
        private function pegarTamanhoDiretorio($path){ 
            $totalsize = 0; 
            $totalcount = 0; 
            $dircount = 0; 
            if ($handle = opendir ($path)){ 
                while (false !== ($file = readdir($handle))){ 
                $nextpath = $path . '/' . $file; 
                if ($file != '.' && $file != '..' && !is_link ($nextpath)){ 
                    if (is_dir ($nextpath)){ 
                    $dircount++; 
                    $result = $this->pegarTamanhoDiretorio($nextpath); 
                    $totalsize += $result['size']; 
                    $totalcount += $result['count']; 
                    $dircount += $result['dircount']; 
                    }elseif (is_file ($nextpath)){ 
                    $totalsize += filesize ($nextpath); 
                    $totalcount++; 
                    } 
                } 
                } 
            } 
            closedir ($handle); 
            $total['size'] = $totalsize; 
            $total['count'] = $totalcount; 
            $total['dircount'] = $dircount; 
            return $total; 
        } 

        private function formatoTamanho($size){ 
            if($size<1024){ 
                return $size." bytes"; 
            } 
            else if($size<(1024*1024)){ 
                $size=round($size/1024,1); 
                return $size." KB"; 
            } 
            else if($size<(1024*1024*1024)){ 
                $size=round($size/(1024*1024),1); 
                return $size." MB"; 
            }else{ 
                $size=round($size/(1024*1024*1024),1); 
                return $size." GB"; 
            }
        }
}