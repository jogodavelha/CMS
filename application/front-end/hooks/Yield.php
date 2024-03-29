<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Yield  ::  HOOKS
 *
 * Adds layout support :: Similar to RoR <%= yield =>
 * '{yield}' will be replaced with all output generated by the controller/view.
 */
class Yield
{
    function doYield()
    {
         
        global $OUT;

        $CI =& get_instance();
        $output = $CI->output->get_output();
        
        $default = realpath(APPPATH.'/views/layouts/padrao.php');
        $CI->layout = (!empty($CI->layout))?$CI->layout:'padrao';
        
        if ($CI->layout!=false){
            if (!preg_match('/(.+).php$/', $CI->layout)){
                $CI->layout .= '.php';
            }
            
            $requested = realpath(APPPATH.'/views/layouts/'.$CI->layout);
            
            if (file_exists($requested)){
                $layout = $CI->load->file($requested, true);
                $view = str_replace("{yield}", $output, $layout);
            }else{
                $view = $output;
            }
        }else if (file_exists($default) && $CI->layout!=false){
            $layout = $CI->load->file($default, true);
            $view = str_replace("{yield}", $output, $layout);
        }else{
            $view = $output;
        }
        $OUT->_display($view);
    }
}