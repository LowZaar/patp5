<?php

namespace patp\Controllers;

use patp\Classes\MainController;
use patp\Classes\MainModel;
/**
 * LoginController - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class LoginController extends MainController
{

	public function index()
	{
		// Título da página
		$this->title = 'Login';

		// Verifica se o usuário está logado
		if ($this->logged_in) {
			header("Location: ".HOME_URI); 
			exit();
        }
		
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
	
        require ABSPATH . '/views/login/login-view.php';
	}
	
	public function sair()
	{
		$this->logout(true);
	}
}
