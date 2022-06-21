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
class CadastroController extends MainController
{
    
    public function __construct($parametros = array())
    {
        parent::__construct($parametros);
        $this->verifyLogin();
    }
    
    public function index()
	{
		// Título da página
		$this->title = 'Cadastro';

		// Verifica se o usuário está logado
		if ($this->logged_in) {
			header("Location: ".HOME_URI); 
			exit();
        }
		
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
	
        require ABSPATH . '/views/cadastro/cadastro-view.php';
	}
    
    public function cadastrar()
    {
        $modelo = $this->loadModel('cadastro/cadastro-model');
        $retorno = $modelo->cadastrar($_POST);
        
        echo json_encode($retorno);
    }
	
	public function sair()
	{
		$this->logout(true);
	}
}
