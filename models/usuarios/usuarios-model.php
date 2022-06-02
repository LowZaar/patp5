<?php

use patp\Classes\MainModel;

class UsuariosModel extends MainModel
{
    /**
     * $posts_per_page
     *
     * Receberá o número de posts por página para configurar a listagem de
     * notícias. Também utilizada na paginação.
     *
     * @access public
     */
    public $modal_message = array();


    /**
     * Construtor para essa classe
     *
     * Configura o DB, o controlador, os parâmetros e dados do usuário.
     *
     * @since 0.1
     * @access public
     * @param object $db Objeto da nossa conexão PDO
     * @param object $controller Objeto do controlador
     */
    public function __construct($db = false, $controller = null)
    {
        // Configura o DB (PDO)
        $this->db = $db;

        // Configura o controlador
        $this->controller = $controller;

        // Configura os parâmetros
        $this->parametros = $this->controller->parametros;

        // Configura os dados do usuário
        $this->userdata = $this->controller->userdata;
    }

    public function insereUsuario()
    {
        /* Verifica se algo foi postado e se está vindo do form que tem o campo
        insere_noticia. */
        if (!$_SERVER['REQUEST_METHOD'] === 'POST' || empty($_POST['insere_usuario'])) {
            return;
        }

        /* Checa se o email existe no banco de dados */
        $query = $this->db->query('SELECT * FROM ut_usuarios WHERE email = ?', [$_POST['email']]);
        $result = $query->fetch();
        if (!empty($result)) {
            return 'E-mail já cadastrado';
        }

        /* Checa se o tipo_usuario é 1(admin) e libera apenas para admin */
        if ($_POST['tipo_usuario'] == 1 && $this->userdata['tipo_usuario'] != 1) {
            return 'Sem permissão para cadastrar usuário administrador';
        }

        /* Remove o campo insere_usuario para não gerar problema com o PDO */
        unset($_POST['insere_usuario']);

        /* Configura a senha */
        $_POST['senha'] = $this->controller->phpass->hashPassword($_POST['senha']);

        /* query */
        $query = $this->db->insert('ut_usuarios', $_POST);

        /* Verifica a consulta */
        if ($query) {
            return 'success';
        }
        return 'Erro ao inserir usuário no banco de dados';
    }


    public function atualizaUsuario($user_id)
    {
        // Verifica se algo foi postado e se está vindo do form que tem o campo
        // editarUsuario.
        if (!$_SERVER['REQUEST_METHOD'] === 'POST' || empty($_POST['editar_usuario'])) {
            return;
        }

        // Checa se o tipo_usuario é 1(admin) e libera apenas para admin
        if ($_POST['tipo_usuario'] == 1 && $this->userdata['tipo_usuario'] != 1) {
            return 'Sem permissão para editar usuário administrador';
        }

        // Checa se o email existe no banco de dados
        $query = $this->db->query('SELECT email FROM ut_usuarios WHERE email = ?', [$_POST['email']]);
        $checkEmail = $query->fetch(\PDO::FETCH_COLUMN, 0);

        // Busca como o usuário atual esta cadastrado no banco de dados
        $usuario = $this->retornaUsuario($user_id);

        // Caso tenha achado algum usuário já cadastrado com o email alvo
        if (!empty($checkEmail)) {
            // Se o email do usuário atual for diferente do email que foi encontrado no banco de dados,
            // isso significa que está tentando alterar o email para um email que já esta sendo utilizado
            if ($usuario['email'] != $checkEmail) {
                return 'E-mail já cadastrado';
            }
        }

        // Remove o campo insere_usuario para não gerar problema com o PDO
        unset($_POST['editar_usuario']);

        if (!empty($_POST['senha'])) {
            // Configura a senha para ser salva no banco de dados
            $_POST['senha'] = $this->controller->phpass->hashPassword($_POST['senha']);
        } else {
            unset($_POST['senha']);
        }

        // Atualiza os dados
        $query = $this->db->update('ut_usuarios', 'id', $user_id[0], $_POST);

        // Verifica a consulta
        if ($query) {
            return 'success';
        }
        return 'Falha ao atualizar o cadastro do usuário';
    }


    public function excluiUsuario()
    {
        // O segundo parâmetro deverá ser um ID numérico
        if (!is_numeric(chk_array($this->parametros, 0))) {
            return;
        }

        // Para excluir, o terceiro parâmetro deverá ser "confirma"
        if (chk_array($this->parametros, 1) != 'confirma') {
            return;
        }

        // Configura o ID do Usuário
        $idUsuario = (int) chk_array($this->parametros, 0);

        // Busca no BD o email do usuário
        $query = $this->db->query('SELECT email FROM ut_usuarios WHERE id = ?', [$idUsuario]);
        $email = $query->fetch(\PDO::FETCH_COLUMN, 0);

        // Executa a consulta
        $query = $this->db->delete('ut_usuarios', 'id', $idUsuario);

        // Redireciona para a página de administração de notícias
        echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/usuarios/">';
        echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/usuarios/";</script>';
    }


    public function retornaUsuarios($id = null)
    {
        $query = $this->db->query('SELECT * FROM ut_usuarios ORDER BY id DESC');
        return $query->fetchAll();
    }


    public function retornaUsuario($user_id)
    {
        // Faz a consulta para obter o valor
        $query = $this->db->query(
            'SELECT * FROM ut_usuarios WHERE id = ? LIMIT 1',
            $user_id
        );

        // Obtém os dados
        $fetut_data = $query->fetch();

        // Se os dados estiverem nulos, não faz nada
        if (empty($fetut_data)) {
            return;
        }

        return $fetut_data;
    }


    public function retornaTiposUsuario()
    {
        $query = $this->db->query('SELECT * FROM ut_tipos_usuarios ORDER BY id ASC');

        if ($query) {
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            if (!empty($result)) {
                return $result;
            } else {
                return 'Nenhum resultado encontrado';
            }
        } else {
            return 'Erro ao realizar consulta';
        }
    }
}
