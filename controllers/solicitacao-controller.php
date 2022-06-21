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


 class SolicitacaoController extends MainController
 {
    
     /**
      * @var SolicitacaoModel
      */
     private $model;
    
     public function __construct($parametros = array())
     {
         parent::__construct($parametros);
         $this->model = $this->loadModel('solicitacao/solicitacao-model');
    
     }
    
     public function index()
     {
         $solicitacoes = $this->model->retornaSolicitacoes();
         // dd($solicitacoes);
         require ABSPATH . '/views/_includes/header.php';
         require ABSPATH . '/views/_includes/menu.php';
         require ABSPATH . '/views/solicitacoes/solicitacoes-view.php';
         require ABSPATH . '/views/_includes/footer.php';
     }
    
     public function criar()
     {
        echo json_encode($this->model->criar($_POST));
     }


     public function setStatus()
     {
       echo $this->model->setStatus($_POST['idSoc'], $_POST['acao']);
     }
 }