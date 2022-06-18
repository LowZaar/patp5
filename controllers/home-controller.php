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
    
    /**
     * @var mixed|void
     */
    private $model;
    
    public function __construct($parametros = array())
    {
        parent::__construct($parametros);
        $this->model = $this->loadModel('home/home-model');
    
    }
    
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
        
        if (!empty($_GET)) {
           $_SESSION['calendar'] = encrypt_decrypt('decrypt', $_GET['calendar']);
            
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/home/home-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        } else {
            unset($_SESSION['calendar']);
            
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/home/home-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        }
    }
    
    public function retornaCalendario()
    {
        if (isset($_SESSION['calendar'])) {
            $return = $this->model->retornaDataCalendario($_SESSION['calendar']);
        } else {
            $return = $this->model->retornaDataCalendario($_SESSION['user']['id']);
        }
        
        echo json_encode($return);
    }
}
