<?php

use patp\Classes\MainModel;

/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class SolicitacaoModel extends MainModel
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
    public function __construct($db = false)
    {
        $this->db = $db;
    }

    public function retornaSolicitacoes()
    {
        return $this->db->query(
            'SELECT
                s.*,
                u.nome as nome_solicitante
            FROM
                 Solicitacoes AS s
            LEFT JOIN Usuarios as u ON s.id_solicitante = u.id
            WHERE
                  s.id_usuario = ?
              AND
                  s.status = 0
              AND
                   s.datainicio >= NOW()',
            [$_SESSION['user']['id']]
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar($data)
    {
        $datainicio = str_replace('T', ' ', explode('-03:00', $data['horarioInicio'])[0]);
        $datafim = str_replace('T', ' ', explode('-03:00', $data['horarioFinal'])[0]);

        if (isset($_SESSION['calendar'])) {
            $post = [
                'id_usuario'     => $_SESSION['calendar'],
                'id_solicitante' => $_SESSION['user']['id'],
                'titulo'         => $data['titulo'],
                'datainicio'     => $datainicio,
                'datafim'        => $datafim,
                'status'         => 0
            ];

            $query = $this->db->insert('Solicitacoes', $post);

            if ($query) {
                return [
                    'type' => 'success',
                    'message' => 'Solicitação realizada com sucesso!',
                    'label' => 'Sucesso'
                ];
            } else {
                return [
                    'type' => 'error',
                    'message' => 'Falha ao realizar solicitação de agendamento!',
                    'label' => 'Erro'
                ];
            }
        } else {
            $post = [
                'id_usuario'     => $_SESSION['user']['id'],
                'id_solicitante' => $_SESSION['user']['id'],
                'titulo'         => $data['titulo'],
                'datainicio'     => $datainicio,
                'datafim'        => $datafim,
                'status'         => 1
            ];

            $query = $this->db->insert('Solicitacoes', $post);

            if ($query) {
                return [
                    'type' => 'success',
                    'message' => 'Horario adicionado com sucesso!',
                    'label' => 'Sucesso'
                ];
            } else {
                return [
                    'type' => 'error',
                    'message' => 'Falha ao adicionar horário à agenda!',
                    'label' => 'Erro'
                ];
            }
        }
    }

    public function setStatus($idSolicitacao, $acao)
    {
        if ($acao == 'aceitar') {
            $query = $this->db->update('Solicitacoes', 'id', $idSolicitacao, ['status' => '1']);
        } else if ($acao == 'recusar') {
            $query = $this->db->update('Solicitacoes', 'id', $idSolicitacao, ['status' => '2']);
        }
        if ($query) {
            return 'true';
        }
        return false;
    }
}
