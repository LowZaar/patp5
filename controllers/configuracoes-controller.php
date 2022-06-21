<?php

namespace patp\Controllers;

use ConfiguracoesModel;
use patp\Classes\MainController;

/**
 * home - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */


 class ConfiguracoesController extends MainController
 {
    
     /**
      * @var ConfiguracoesModel
      */
     private $model;
    
     public function __construct($parametros = array())
     {
         parent::__construct($parametros);
         $this->model = $this->loadModel('configuracoes/configuracoes-model');
         $this->verifyLogin();
         $this->title = 'Configurações';
     }
    
     public function index()
     {
         $configuracoes = $this->model->retornaConfiguracoes();
         
         require ABSPATH . '/views/_includes/header.php';
         require ABSPATH . '/views/_includes/menu.php';
         require ABSPATH . '/views/configuracoes/configuracoes-view.php';
         require ABSPATH . '/views/_includes/footer.php';
     }
    
     public function editar()
     {
         echo json_encode($this->model->editarConfiguracoes($_POST));
     }
 }