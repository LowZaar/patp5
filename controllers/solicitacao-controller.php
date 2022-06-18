<?php

namespace patp\Controllers;

use patp\Classes\MainController;
/**
 * home - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */


 class SolicitacaoController extends MainController
 {

    public function criar(){
        

        
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
    
        $modelo = $this->loadModel('solicitacao/solicitacao-model');

        $modelo->criar($_POST);
    }

 }