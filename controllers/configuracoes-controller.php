<?php

namespace patp\Controllers;

use patp\Classes\MainController;
use SolicitacaoModel;

/**
 * home - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */


 class ConfiguracoesController extends MainController
 {
    
     /**
      * @var SolicitacaoModel
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
         // dd($solicitacoes);
         require ABSPATH . '/views/_includes/header.php';
         require ABSPATH . '/views/_includes/menu.php';
         require ABSPATH . '/views/solicitacoes/configuracoes-view.php';
         require ABSPATH . '/views/_includes/footer.php';
     }
 }