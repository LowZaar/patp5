<?php

namespace patp\Controllers;

use patp\Classes\MainController;
/**
 * home - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class HomeController extends MainController
{

    public function index()
    {
        // Título da página
        $this->title = 'Home';

        // Verifica se o usuário está logado
      /*   if (!$this->logged_in) {
            $this->logout(true);
            return;
        }

        // Verifica se o usuário tem permissão
        if (!$this->possuiPermissao('home', 'visualizar', $this->userdata['tipo_usuario'])) {
            require_once ABSPATH . '/includes/403.php';
            return;
        } */
        
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
    
        // Essa página não precisa de modelo (model)
        $modelo = $this->loadModel('home/home-model');
        
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/home/home-view.php';
        require ABSPATH . '/views/_includes/footer.php';
        
    }
}
