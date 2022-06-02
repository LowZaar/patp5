<?php

namespace patp\Controllers;

use patp\Classes\MainController;
use patp\Classes\MainModel;

class ContasController extends MainController
{
    public function index()
    {
        // Título da página
        $this->title = 'Conta';

        // Verifica se o usuário está logado
        if (! $this->logged_in) {
            $this->logout(true);
            return;
        }

        // Verifica se o usuário tem permissão
        if (!$this->possuiPermissao('contas', 'visualizar', $this->userdata['tipo_usuario'])) {
            require_once ABSPATH . '/includes/403.php';
            return;
        }

        $modelo = $this->loadModel('contas/contas-model');

        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();
        $this->tipos = $modelo->retornaTiposImplantacao();

        // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //     $result = $modelo->atualizaImplantacao($_POST);
        //     unset($_POST);
        //     if ($result !== true) {
        //         $_SESSION['notification'] = ['title' => 'Erro', 'msg' => $result, 'type' => 'error'];
        //     } else {
        //         $_SESSION['notification'] = ['title' => 'Sucesso', 'msg' => 'Passo cadastrado com sucesso', 'type' => 'success'];
        //     }
        // }

        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/contas/index.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function retornaContas() 
    {
        $modelo = $this->loadModel('contas/contas-model');
        
        $contas = $modelo->retornaContas($_POST);

        if ($contas === false) {
            http_response_code(500);
            echo 'Nenhuma conta atende aos filtros selecionados';
            return;
        }

        echo json_encode($contas);
    }

    public function retornaHistorico()
    {
        $modelo = $this->loadModel('contas/contas-model');
        
        $historico = $modelo->retornaHistorico($_POST['id']);

        echo json_encode($historico);
    }

    public function salvaHistorico()
    {
        $modelo = $this->loadModel('contas/contas-model');
        
        $historico = $modelo->salvaHistorico($_POST);

        echo json_encode($historico);
    }

    public function editarConta()
    {
        $modelo = $this->loadModel('contas/contas-model');
        
        $retorno = $modelo->editaConta($_POST);

        if ($retorno === false) {
            http_response_code(500);
            return;
        }

        echo json_encode($retorno);
    }

    public function retornaConta()
    {
        $modelo = $this->loadModel('contas/contas-model');
        
        $retorno = $modelo->retornaConta($_POST['id']);

        if ($retorno === false) {
            http_response_code(500);
            return;
        }

        echo json_encode($retorno);
    }

    public function atualizaPassos()
    {
        $modelo = $this->loadModel('contas/contas-model');
        
        $retorno = $modelo->atualizaImplantacao($_POST);

        if ($retorno !== true) {
           http_response_code(500);
        } else {
            $retorno = 'Passo cadastrado com sucesso';
        }

        echo $retorno;
    }

    public function retornaPassosImplantacao() {
        $modelo = $this->loadModel('contas/contas-model');
        
        $retorno = $modelo->retornaPassosImplantacao($_POST);

        if ($retorno === false) {
            http_response_code(500);
            return;
        }

        echo json_encode($retorno);
    }

    public function inserir()
    {
        $this->title = 'Formulário de cadastro de contas';

        // Verifica se o usuário está logado
        if (!$this->logged_in) {
            $this->logout(true);
            return;
        }

        // Verifica se o usuário tem permissão
        if (!$this->possuiPermissao('contas', 'inserir', $this->userdata['tipo_usuario'])) {
            require_once ABSPATH . '/includes/403.php';
            return;
        }

        $modelo = $this->loadModel('contas/contas-model');
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Retorna os tipos de contas
        $this->tipos = $modelo->retornaTiposContas();

        // Carrega o método para inserir um usuario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $result = $modelo->insereConta($_POST);
            unset($_POST);
            if ($result !== true) {
                $_SESSION['notification'] = ['title' => 'Erro', 'msg' => $result, 'type' => 'error'];
            } else {
                $_SESSION['notification'] = ['title' => 'Sucesso', 'msg' => 'Conta cadastrada com sucesso', 'type' => 'success'];
            }
        }

        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/contas/inserir.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
}
