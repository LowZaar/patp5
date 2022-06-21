<?php

use patp\Classes\MainModel;

/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class ConfiguracoesModel
{

	/**
	 * $form_data
	 *
	 * Os dados do formulário de envio.
	 *
	 * @access public
	 */	
	public $form_data;

	/**
	 * $form_msg
	 *
	 * As mensagens de feedback para o usuário.
	 *
	 * @access public
	 */	
	public $form_msg;

	/**
	 * $db
	 *
	 * O objeto da nossa conexão PDO
	 *
	 * @access public
	 */
	public $db;

	/**
	 * Construtor
	 * 
	 * Carrega  o DB.
	 *
	 * @since 0.1
	 * @access public
	 */
	public function __construct( $db = false ) {
		$this->db = $db;
	}
    
    public function retornaConfiguracoes()
    {
        
        return $this->db->query(
            'SELECT
                titulo,
                cor,
                horario,
                fimDeSemana
            FROM
                 Usuarios
            WHERE
                  id = ?',
            [$_SESSION['user']['id']]
        )->fetch(PDO::FETCH_ASSOC);
	}
    
    public function editarConfiguracoes($dados)
    {
        try {
            $this->db->update('Usuarios', 'id', $_SESSION['user']['id'], $dados);
        } catch (Throwable $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao editar configurações, tente novamente!',
                'label' => ''
            ];
        }
        
        $_SESSION['user']['cor'] = $dados['cor'];
        $_SESSION['user']['titulo'] = $dados['titulo'];
        $_SESSION['user']['fimDeSemana'] = $dados['fimDeSemana'];
        $_SESSION['user']['horario'] = $dados['horario'];
    
        return [
            'status' => 'success',
            'message' => 'Configurações atualizadas com sucesso!',
            'label' => ''
        ];
    }
}