<?php

namespace patp\Controllers;

use patp\Classes\MainController;
use patp\Classes\MainModel;

class UsuariosController extends MainController
{
    public function index()
    {
        // Título da página
        $this->title = 'Usuários';

        // Verifica se o usuário está logado
        if (! $this->logged_in) {
            $this->logout(true);
            return;
        }

        // Verifica se o usuário tem permissão
        if (!$this->possuiPermissao('usuarios', 'visualizar', $this->userdata['tipo_usuario'])) {
            require_once ABSPATH . '/includes/403.php';
            return;
        }

        $modelo = $this->loadModel('usuarios/usuarios-model');

        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();
        $this->lista = $modelo->retornaUsuarios();
        $this->tipos_usuarios = $modelo->retornaTiposUsuario();

        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/usuarios/index.php';
        require ABSPATH . '/views/_includes/footer.php';
    }


    public function inserir()
    {
        $this->title = 'Inserir novo usuário';

        // Verifica se o usuário está logado
        if (!$this->logged_in) {
            $this->logout(true);
            return;
        }

        // Verifica se o usuário tem permissão
        if (!$this->possuiPermissao('usuarios', 'inserir', $this->userdata['tipo_usuario'])) {
            require_once ABSPATH . '/includes/403.php';
            return;
        }

        $modelo = $this->loadModel('usuarios/usuarios-model');
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o método para inserir um usuario
        $retorno = $modelo->insereUsuario();
        $this->tipos_usuarios = $modelo->retornaTiposUsuario();

        if ($retorno == 'success') {
            $this->modal_notification = array(
                'Usuário cadastrado com sucesso.',
                'success'
            );
        } elseif (!empty($retorno)) {
            $this->modal_notification = array(
                $retorno,
                'danger'
            );
        }

        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/usuarios/inserir.php';
        require ABSPATH . '/views/_includes/footer.php';
    }


    public function editar($id)
    {
        $this->title = 'Editar Dados Usuário';

        // Verifica se o usuário está logado
        if (!$this->logged_in) {
            $this->logout(true);
            return;
        }

        // Verifica se o usuário tem permissão
        if (!$this->possuiPermissao('usuarios', 'editar', $this->userdata['tipo_usuario'])) {
            require_once ABSPATH . '/includes/403.php';
            return;
        }

        $modelo = $this->loadModel('usuarios/usuarios-model');
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o método para editar um usuario
        $retorno = $modelo->atualizaUsuario($id);
        $this->usuario = $modelo->retornaUsuario($id);
        $this->tipos_usuarios = $modelo->retornaTiposUsuario();

        if ($retorno == 'success') {
            $this->modal_notification = array(
                'Usuário atualizado com sucesso.',
                'success'
            );
        } elseif (!empty($retorno)) {
            $this->modal_notification = array(
                $retorno,
                'error'
            );
        }

        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/usuarios/editar.php';
        require ABSPATH . '/views/_includes/footer.php';
    }


    public function delete($id)
    {
        $this->title = 'Gerenciar Usuário';

        // Verifica se o usuário está logado
        if (!$this->logged_in) {
            $this->logout(true);
            return;
        }

        // Verifica se o usuário tem permissão
        if (!$this->possuiPermissao('usuarios', 'excluir', $this->userdata['tipo_usuario'])) {
            require_once ABSPATH . '/includes/403.php';
            return;
        }

        $this->modal_message = MainModel::modalMessage(
            'Excluir Usuário',
            'Tem certeza que deseja apagar este usuário?',
            '<button type="submit" onclick="window.location=\''.$_SERVER['REQUEST_URI']. 'confirma/'.'\'"
            class="btn btn-success">Excluir</button>'
        );

        $modelo = $this->loadModel('usuarios/usuarios-model');
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        $this->lista = $modelo->retornaUsuarios();
        $modelo->form_confirma = $modelo->excluiUsuario();

        require ABSPATH . '/views/_includes/header.php';
        //require ABSPATH . '/views/usuarios/usuarios-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
}
