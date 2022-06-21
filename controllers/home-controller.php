<?php

namespace patp\Controllers;

use HomeModel;
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
     * @var HomeModel
     */
    private $model;
    
    public function __construct($parametros = array())
    {
        // Título da página
        $this->title = 'Home';
        parent::__construct($parametros);
        $this->model = $this->loadModel('home/home-model');
        
        $this->verifyLogin();
    }
    
    public function index()
    {
        if (!empty($_GET)) {
           $_SESSION['calendar'] = encrypt_decrypt('decrypt', $_GET['calendar']);
            
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/home/home-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        } else {
            unset($_SESSION['calendar']);
            
            $link = HOME_URI . '?calendar=' . encrypt_decrypt('encrypt', $_SESSION['user']['id']);
            
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/home/home-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        }
    }
    
    public function retornaCalendario()
    {
        if (isset($_SESSION['calendar'])) {
            $return = $this->model->retornaDataCalendario($_SESSION['calendar'], true);
        } else {
            $return = $this->model->retornaDataCalendario($_SESSION['user']['id']);
        }
        
        echo json_encode($return);
    }
}
