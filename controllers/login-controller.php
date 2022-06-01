<?php

namespace patp\Controllers;

use patp\Classes\MainController;
use patp\Classes\MainModel;
/**
 * LoginController - Controller
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
		// if ($this->logged_in) {
		// 	header("Location: ".HOME_URI);
		// 	exit();
        // }
	
        require ABSPATH . '/views/login/login-view.php';
	}
	
	public function logar() {
	    $model = $this->loadModel('login/login-model');
	    $retorno = $model->logar($_POST);
	    echo json_encode($retorno);
    }
    
}
