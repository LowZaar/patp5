<?php

use patp\Classes\MainModel;
use patp\Classes\Implantacao;
use patp\Classes\SendMessage;
use patp\Classes\SendMessageMarketing;
use Solarium\Component\Facet\Interval;

class CadastroModel extends MainModel
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
    
    public function cadastrar($dados)
    {
        if (empty($dados['email']) || empty($dados['senha']) || empty($dados['nome']) || empty($dados['cpfcnpj']) || empty($dados['telefone'])) {
            return [
                'status' => 'error',
                'message' => 'Preencha todos os campos para realizar o cadastro!'
            ];
        }
    
        $dados['senha'] = md5($dados['senha']);
        $dados['titulo'] = 'true';
        $dados['cor'] = '#D0021B';
        $dados['fimDeSemana'] = 'true';
        $dados['horario'] = 'false';
        
        try {
            $this->db->insert('Usuarios', $dados);
        } catch (Throwable $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao realizar cadastro, tente novamente!'
            ];
        }
        
        return [
            'status' => 'success',
            'message' => 'Cadastro realizado com sucesso!'
        ];
    }
    
}
