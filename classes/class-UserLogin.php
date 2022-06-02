<?php

namespace patp\Classes;

/**
 * UserLogin - Manipula os dados de usuários
 *
 * Manipula os dados de usuários, faz login e logout, verifica permissões e
 * redireciona página para usuários logados.
 *
 * @package patpMVC
 * @since 0.1
 */

class UserLogin
{
    /**
     * Usuário logado ou não
     *
     * Verdadeiro se ele estiver logado.
     *
     * @public
     * @access public
     * @var bol
     */
    public $logged_in;

    /**
     * Dados do usuário
     *
     * @public
     * @access public
     * @var array
     */
    public $userdata;

    /**
     * Mensagem de erro para o formulário de login
     *
     * @public
     * @access public
     * @var string
     */
    public $login_error;


    /**
     * Verifica o login
     *
     * Configura as propriedades $logged_in e $login_error. Também
     * configura o array do usuário em $userdata
     */
    public function checkUserLogin()
    {
        // Verifica se existe uma sessão com a chave userdata
        // Tem que ser um array e não pode ser HTTP POST
        if (isset($_SESSION['userdata'])
             && ! empty($_SESSION['userdata'])
             && is_array($_SESSION['userdata'])
             && ! isset($_POST['userdata'])
            ) {
            // Configura os dados do usuário
            $userdata = $_SESSION['userdata'];

            // Garante que não é HTTP POST
            $userdata['post'] = false;
        }

        // Verifica se existe um $_POST com a chave userdata
        // Tem que ser um array
        if (isset($_POST['userdata'])
             && ! empty($_POST['userdata'])
             && is_array($_POST['userdata'])
            ) {
            // Configura os dados do usuário
            $userdata = $_POST['userdata'];

            // Garante que é HTTP POST
            $userdata['post'] = true;
        }

        // Verifica se existe algum dado de usuário para conferir
        if (! isset($userdata) || ! is_array($userdata)) {
            // Desconfigura qualquer sessão que possa existir sobre o usuário

            $this->logout();

            return;
        }

        // Passa os dados do post para uma variável
        if ($userdata['post'] === true) {
            $post = true;
        } else {
            $post = false;
        }

        // Remove a chave post do array userdata
        unset($userdata['post']);

        // Verifica se existe algo a conferir
        if (empty($userdata)) {
            $this->logged_in = false;
            $this->login_error = null;

            // Desconfigura qualquer sessão que possa existir sobre o usuário
            $this->logout();

            return;
        }

        // Extrai variáveis dos dados do usuário
        extract($userdata);

        // Verifica se existe um usuário e senha
        if (! isset($email) || ! isset($password)) {
            $this->logged_in = false;
            $this->login_error = null;

            // Desconfigura qualquer sessão que possa existir sobre o usuário
            $this->logout();

            return;
        }

        // Verifica se o usuário existe na base de dados
        $query = $this->db->query('SELECT * FROM ut_usuarios WHERE email = ? LIMIT 1', array($email));

        // Verifica a consulta
        if (! $query) {
            $this->logged_in = false;
            $this->login_error = 'Internal error.';

            // Desconfigura qualquer sessão que possa existir sobre o usuário
            $this->logout();

            return;
        }

        // Obtém os dados da base de usuário
        $fetch = $query->fetch(\PDO::FETCH_ASSOC);

        // Obtém o ID do usuário
        $user_id = $fetch['id'];

        // Verifica se o ID existe
        if (empty($user_id)) {
            $this->logged_in = false;
            $this->login_error = '<b style="color:red">Usuário ou senha inválidos.</b>';

            // Desconfigura qualquer sessão que possa existir sobre o usuário
            $this->logout();

            return;
        }

        /*
        print_r($this->phpass->hashPassword($password));
        die();
        */
        // Confere se a senha enviada pelo usuário bate com o hash do BD
        if ($this->phpass->checkPassword($password, $fetch['senha'])) {
            //  Se for uma sessão, verifica se a sessão bate com a sessão do BD
            //  if (session_id() != $fetch['user_session_id'] && ! $post) {
            //  $this->logged_in = false;
            //  $this->login_error = 'Sessão inválida.';

            //  // Desconfigura qualquer sessão que possa existir sobre o usuário
            //  $this->logout();

            //  return;
            //  }

            // Se for um post
            if ($post) {
                // Recria o ID da sessão
                session_regenerate_id();
                $session_id = session_id();

                // Envia os dados de usuário para a sessão
                $_SESSION['userdata'] = $fetch;

                // Atualiza a senha
                $_SESSION['userdata']['password'] = $password;

                // Atualiza o ID da sessão
                $_SESSION['userdata']['user_session_id'] = $session_id;

                // Atualiza o ID da sessão na base de dados

                $query = $this->db->query(
                    'UPDATE ut_usuarios SET user_session_id = ? WHERE id = ?',
                    array($session_id, $user_id)
                );
            }

            //Se a conta do usuário for Empresa e status 0
            if ($fetch['tipo_usuario'] != 1 && $fetch['status'] == 2) {
                require_once ABSPATH . '/includes/402.php';
                die();
            }

            // Permissões para as empresas
            $query = $this->db->query('SELECT * FROM ut_tipos_usuarios ORDER BY nome ASC');
            $tipos_usuarios = $query->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($tipos_usuarios as $key => $tipo_usuario) {
                if ($fetch['tipo_usuario'] == $tipo_usuario['id']) {
                    $_SESSION['userdata']['user_permissions'] = json_decode($tipo_usuario['permissoes'], true);
                    break;
                }
            }

            // Obtém um array com as permissões de usuário
            // $var_temp = base64_encode(serialize($fetch['privilegios']));
            // $_SESSION['userdata']['user_permissions'] = unserialize(base64_decode($var_temp));

            // Configura a propriedade dizendo que o usuário está logado
            $this->logged_in = true;

            // Configura os dados do usuário para $this->userdata
            $this->userdata = $_SESSION['userdata'];

            // Verifica se existe uma URL para redirecionar o usuário
            if (isset($_SESSION['goto_url'])) {
                // Passa a URL para uma variável
                $goto_url = urldecode($_SESSION['goto_url']);
                // Remove a sessão com a URL
                unset($_SESSION['goto_url']);

                // Redireciona para a página
                echo '<meta http-equiv="Refresh" content="0; url=' . $goto_url . '">';
                echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
                //header('location: ' . $goto_url);
            }

            return;
        } else {
            // O usuário não está logado
            $this->logged_in = false;

            // A senha não bateu
            $this->login_error = '<b style="color:red">Usuário ou senha inválidos.</b>';

            // Remove tudo
            $this->logout();

            return;
        }
    }

    /**
     * Logout
     *
     * Desconfigura tudo do usuário.
     *
     * @param bool $redirect Se verdadeiro, redireciona para a página de login
     * @final
     */
    protected function logout($redirect = false)
    {
        // Remove all data from $_SESSION['userdata']
        $_SESSION['userdata'] = array();

        // Only to make sure (it isn't really needed)
        unset($_SESSION['userdata']);

        // Regenerates the session ID
        session_regenerate_id();

        if ($redirect === true) {
            // Send the user to the login page
            $this->gotoLogin();
        }
    }


    /**
     * Vai para a página de login
     */
    protected function gotoLogin()
    {
        // Verifica se a URL da HOME está configurada
        if (defined('HOME_URI')) {
            // Configura a URL de login
            $login_uri  = HOME_URI . '/login/';

            // Separa a URL em partes
            $url_redir = explode('/', $_SERVER['REQUEST_URI']);

            if (empty($url_redir)) {
                // Caso a variável estiver vazia, redireciona para a home
                $_SESSION['goto_url'] = urlencode(HOME_URI . '/home/');
            } else {
                if (array_search('sair', $url_redir)) {
                    // Caso o usuário veio do /sair, redireciona para a home
                    $_SESSION['goto_url'] = urlencode(HOME_URI . '/home/');
                } else {
                    if (isset($_SERVER['REQUEST_URI'])) {
                        // Caso a request_uri esteja setada, redireciona para ela
                        $_SESSION['goto_url'] = urlencode($_SERVER['REQUEST_URI']);
                    }
                }
            }

            // Redireciona
            echo '<meta http-equiv="Refresh" content="0; url=' . $login_uri . '">';
            echo '<script type="text/javascript">window.location.href = "' . $login_uri . '";</script>';
        }
        return;
    }


    /**
     * Envia para uma página qualquer
     *
     * @final
     */
    final protected function gotoPage($page_uri = null)
    {
        if (isset($_GET['url']) && ! empty($_GET['url']) && ! $page_uri) {
            // Configura a URL
            $page_uri  = urldecode($_GET['url']);
        }

        if ($page_uri) {
            // Redireciona
            echo '<meta http-equiv="Refresh" content="0; url=' . $page_uri . '">';
            echo '<script type="text/javascript">window.location.href = "' . $page_uri . '";</script>';
            //header('location: ' . $page_uri);
            return;
        }
    }


    /**
     * Verifica permissões
     *
     * @param string $menu O menu requerido
     * @param string $required A permissão requerida
     * @param array $user_permissions As permissões do usuário
     * @final
     */
    final public function possuiPermissao($menu = 'any', $required = 'any', $tipo_usuario = '0')
    {
        // Se for Admin
        if ($tipo_usuario == '1') {
            return true;
        }

        // Persmissões funcionários
        $funcionarios = [
            'home' => ['visualizar'],
            'caixa' => ['visualizar', 'inserir', 'editar', 'excluir', 'imprimir'],
            'turnos' => ['visualizar', 'inserir', 'editar', 'excluir'],
            'usuario' => ['editar']
        ];

        // Usuário comum
        // Checa se existe um indice com o nome da permissão a ser checada dentro das permissões do usuário
        if (array_key_exists($menu, $funcionarios)) {
            if (in_array($required, $funcionarios[$menu])) {
                return true;
            }
        }

        // Caso a permissão não tenha sido encontrada
        return false;
    }


    /**
     * Recupera a senha do usuário
     *
     *
     * @param bool $message Se verdadeiro, envia email para o usuário
     * @final
     */
    protected function recoverPassword()
    {
        $email = $_POST['email'];

        // Verifica se o usuário existe na base de dados
        $query_user = $this->db->query('SELECT * FROM ut_usuarios WHERE email = ? LIMIT 1', array($email));
        $fetut_user = $query_user->fetch();

        return 'false';
    }


    /**
     * Altera a senha do usuário
     *
     *
     * @param bool $message Se verdadeiro, envia email para o usuário
     * @final
     */
    protected function changePass()
    {
        $query = $this->db->query(
            "SELECT
                *
            FROM
                ut_usuarios
            WHERE
                email = '".$_GET['email']."'
                AND senha = '".$_GET['token']."'
            LIMIT
                1"
        );
        if ($query) {
            $usuario = $query->fetch();
            $update_query = $this->db->update('ut_usuarios', 'id', $usuario['id'], array(
                'senha' => $this->phpass->hashPassword($_POST['password'])
            ));
            if ($update_query) {
                return 'true';
            }
        }
        return 'false';
    }
}
