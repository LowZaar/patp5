<?php

use patp\Classes\MainModel;

class LoginModel extends MainModel
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
     * @param object $db Objeto da nossa conexão PDO
     * @param object $controller Objeto do controlador
     * @since 0.1
     * @access public
     */
    public function __construct($db = false, $controller = null)
    {
        // Configura o DB (PDO)
        $this->db = $db;
        
        // Configura o controlador
        $this->controller = $controller;
        
        // // Configura os parâmetros
        // $this->parametros = $this->controller->parametros;
        //
        // // Configura os dados do usuário
        // $this->userdata = $this->controller->userdata;
    }
    
    public function logar($dados)
    {
        if (empty($dados['email']) || empty($dados['senha'])) {
            return [
                'status' => 'error',
                'message' => 'Preencha todos os campos para realizar o login!'
            ];
        }
    
        $dados['senha'] = md5($dados['senha']);
        
        $query = $this->db->query('SELECT * FROM Usuarios WHERE email = ? AND senha = ?', [$dados['email'], $dados['senha']])->fetch(PDO::FETCH_ASSOC);
        
        if (!$query) {
            return [
                'status' => 'error',
                'message' => 'E-mail ou senha incorretos!'
            ];
        }
    
        $_SESSION = $query;
        
        return [
            'status' => 'success',
        ];
    }
    
}
