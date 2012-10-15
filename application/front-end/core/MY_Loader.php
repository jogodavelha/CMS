<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {
    public function model_modules($model, $name = '', $db_conn = FALSE)
	{
                $pasta = $model;
                $model = $model.'_fe';
		if (is_array($model))
		{
			foreach ($model as $babe)
			{
				$this->model($babe);
			}
			return;
		}

		if ($model == '')
		{
			return;
		}

		$path = '';

		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($model, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$path = substr($model, 0, $last_slash + 1);

			// And the model name behind it
			$model = substr($model, $last_slash + 1);
		}

		if ($name == '')
		{
			$name = $model;
		}

		if (in_array($name, $this->_ci_models, TRUE))
		{
			return;
		}

		$CI =& get_instance();
		if (isset($CI->$name))
		{
			show_error('O nome do Modelo que você está carregando é o nome de um recurso que está sendo usado: '.$name);
		}

		$model = strtolower($model);
                
                $arquivo = realpath(APPPATH.'../back-end/modules/'.$pasta.'/models/'.$model.'.php');
                
		foreach ($this->_ci_model_paths as $mod_path)
		{
			if (!file_exists($arquivo))
			{
				continue;
			}

			if ($db_conn !== FALSE AND ! class_exists('CI_DB'))
			{
				if ($db_conn === TRUE)
				{
					$db_conn = '';
				}

				$CI->load->database($db_conn, FALSE, TRUE);
			}

			if ( ! class_exists('CI_Model'))
			{
				load_class('Model', 'core');
			}

			require_once($arquivo);

			$model = ucfirst($model);

			$CI->$name = new $model();

			$this->_ci_models[] = $name;
			return;
		}

		// couldn't find the model
		show_error('Não foi possível localiar: '.$model);
	}
}