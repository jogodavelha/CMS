<?php
class MY_Form_validation extends CI_Form_validation
{
    var $_display_fieldname = array();
    
    function MY_Form_validation()
    {
        parent::CI_Form_validation();
    }
    /**
    * numeric rules
    *
    */
    function greater_than($str,$min)
    {
        if(!is_numeric($str)){ return false; }
        return $str > $min;
    }
    
    function less_than($str,$max)
    {
        if(!is_numeric($str)){ return false; }
        return $str < $max;
    }
    /*
    *  checkbox rules
    *
    * use with required rule
    */
    function equal_to($str,$eq)
    {
        if(!is_numeric($str)){ return false; }
        return $str == $eq; 
    }
    
    function max_count($str,$max)
    {
        return (count($str) <= $max);
    }
    
    function min_count($str,$min)
    {
        return count($str) >= $min;
    }
    /**
    *  email rules
    *
    */
    function domain_email($str,$params)
    {
        $parts = explode("@", $str);
        $domain = $parts[1];
        $allowed_array = explode(',',$params);
        return in_array($domain, $allowed_array);
    }
    /**
    *   general rules
    *
    */
    function exact_count($str,$eq)
    {
       if(is_string($str))
       { 
           return (strlen($str) == $eq)?true:false;
       }
       else
       {
          return count($str) == $eq;
       }
    }
    /*
    * validate date from 3 selects
    *
    * example : $rule['year'] = 'valid_selectsdate[month,day]';
    *
    */
    function valid_selectsdate($str,$params)
    {
       $explode = explode(',',$params);
       $month = $this->CI->input->post($explode[0]);
       $day = $this->CI->input->post($explode[1]);
       if(!$day) // year and month don't need to be validated
       {
          return true;
       }
       if(checkdate($month,$day,$str))
       {
           return true;
       }
       return false;
    }
    /*
    * validate date from text input
    *
    *
    * example : $rule['date'] = 'valid_textdate[-,2,1,0]';
    */
    function valid_textdate($str,$params= '')
    {
       if($params == '')
       {
           // default setting
           $divider = '-';
           $yearpart = 0;
           $monthpart = 1;
           $daypart = 2;
       }
       else
       {
           $explode = explode(',',$params);
           $divider = $explode[0];
           $yearpart = $explode[1];
           $monthpart = $explode[2];
           $daypart = $explode[3];
       }
       $explode2 = explode($divider,$str);
       if(count($explode2) != 3)
       {
               return false;
       }
       $year = $explode2[$yearpart];
       $month = $explode2[$monthpart];
       $day = $explode2[$daypart];
       if(check_date($month,$day,$str))
       {
           return true;
       }
       return false;
    }
    
    /*
    *  set fields alternative
    *
    */
    function set_fields($data = '', $field = '', $separator = '_') {    
        if ($data == '') {
            if (count($this->_fields) == 0 && count($this->_rules) == 0) {
                return FALSE;
            }
        } else {
            if ( ! is_array($data)) {
                $data = array($data => $field);
            }
            
            if (count($data) > 0) {
                $this->_fields = $data;
            }
        }
        
        foreach($this->_rules as $key => $val) {                  
            $text = ucwords(str_replace($separator, ' ', $key));             
            $auto_fields[$key] = $text;     
        }
        
        $this->_fields = array_merge($auto_fields, $this->_fields);
        
        foreach($this->_fields as $key => $val) {        
            $this->$key = ( ! isset($_POST[$key]) OR is_array($_POST[$key])) ? '' : $this->prep_for_form($_POST[$key]);
            
            $error = $key.'_error';
            if ( ! isset($this->$error)) {
                $this->$error = '';
            }
        }        
    }
    
    /**
     * Single Space
     *
     * - converts multiple spaces to one space
     * 
     * eg. "a      b" -> "a b"
     *
     * @access    public
     * @param    string
     * @return    void
     */
    function single_space($str)
    {
        $_POST[$this->_current_field] = preg_replace('/  +/', ' ', $str);
    }

    /**
     * Alpha-numeric with underscores, dashes and spaces
     *
     * @access    public
     * @param    string
     * @return    bool
     */    
    function alpha_dash_space($str)
    {
        return ( ! preg_match("/^([-a-z0-9_- ])+$/i", $str)) ? FALSE : TRUE;
    }

} 