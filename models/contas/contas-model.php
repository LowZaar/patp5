<?php

use patp\Classes\MainModel;
use patp\Classes\Implantacao;
use patp\Classes\SendMessage;
use patp\Classes\SendMessageMarketing;
use Solarium\Component\Facet\Interval;

class ContasModel extends MainModel
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

    public function insereConta($values) {
        if ($values['nome_loja'] == '') {
            return 'Nome da loja não inserido';
        }

        if ($values['responsavel_loja'] == '') {
            return 'Responsável não inserido';
        }

        if ($values['previsao_lancamento'] == '') {
            return 'Previsão de lançamento não inserida';
        } 

        if ($values['tipo'] == '') {
            return 'Tipo de conta não inserida';
        } 

        $query = $this->db->insert('ut_projetos_implantacao', array(
            'nome_loja' => $values['nome_loja'],
            'responsavel_loja' => $values['responsavel_loja'],
            'previsao_lancamento' => $values['previsao_lancamento'],
            'tipo' => $values['tipo'],
            'implantado' => 2,
            'data' => date('Y-m-d H:i:s', strtotime('now'))
        ));

        $id_usuario = $_SESSION['userdata']['id'];

        $id_projeto = $this->db->last_id;

        $texto_historico = 'O projeto ' . $values['nome_loja'] . ' foi criado no dia ';
        $texto_historico .= date('d/m/Y', strtotime('now'));

        $query = $this->db->insert('ut_historico_implantacao', array(
            'id_usuario' => $id_usuario,
            'id_projeto' => $id_projeto,
            'texto' => $texto_historico,
            'anexo' => 3,
            'data' => date('Y-m-d H:i:s', strtotime('now'))
        ));

        $data_prazo = new DateTime('now');

        foreach ($values['passos'] as $key => $passo) {
            $query = $this->db->query("SELECT * FROM ut_passos_implantacao WHERE id = ?", [$passo]);
            $passo_bd = $query->fetch(PDO::FETCH_ASSOC);

            $data_incio = new DateTime($data_prazo->format('Y-m-d'));

            $prazo = (int)$passo_bd['previsao_de_dias'];

            $interval = new DateInterval("P" . $prazo . "D");

            $data_prazo->add($interval);

            $query = $this->db->insert('ut_implantacao', array(
                'id_projeto' => $id_projeto,
                'id_tipo' => $passo_bd['id'],
                'data_inicio' => $data_prazo->format('Y-m-d H:i:s'),
                'status' => 2
            ));

            $texto_historico = 'O passo de integração: '.$passo_bd['nome']. ' foi cadastrado à conta com inicio';
            $texto_historico .= ' no dia ' . $data_incio->format('d/m/Y') . ' e prazo de ' . $passo_bd['previsao_de_dias'];
            $texto_historico .= ' dias com previsão de expiração do prazo no dia ' . $data_prazo->format('d/m/Y');

            $query = $this->db->insert('ut_historico_implantacao', array(
                'id_usuario' => $id_usuario,
                'id_projeto' => $id_projeto,
                'texto' => $texto_historico,
                'anexo' => '3',
                'data' => date('Y-m-d H:i:s', strtotime('now'))
            ));
        }

        if ($query) {
            return true;
        }

        return 'Erro ao cadastrar projeto';
    }

    public function editaConta($values) {
        var_dump($values);
        $id_conta = $values['id'];
        unset($values['id']);

        $id_usuario = $_SESSION['userdata']['id'];

        $query = $this->db->query(
            "SELECT
                utim.*,
                utpi.nome
            FROM
                ut_implantacao AS utim
            LEFT JOIN ut_passos_implantacao AS utpi ON utpi.id = utim.id_tipo
            WHERE
                id_projeto = 1", 
            [$id_conta]
        );

        $passos_conta = $query->fetchAll(PDO::FETCH_ASSOC);

        $passos_add = array();

        foreach ($values['passos'] as $key => $passo) {
            array_push($passos_add, ['id' => $passo]);
        }

        foreach ($passos_add as $key => $passo) {
            $adicionar = 1;
            foreach ($passos_conta as $chave => $pc) {
                if ($passo['id'] == $pc['id_tipo']) {
                    $adicionar = 2;
                }
            }
            $passos_add[$key]['adicionar'] = $adicionar;
        }

        foreach ($passos_conta as $chave => $pc) {
            if ($pc['status'] == 1) {
                $passos_conta[$chave]['remover'] = 2;
                continue;
            }
            $remover = 1;
            foreach ($values['passos'] as $key => $passo) {
                if ($passo == $pc['id_tipo']) {
                    $remover = 2;
                }
            }
            $passos_conta[$chave]['remover'] = $remover;
        }

        foreach ($passos_add as $key => $passo) {
            if ($passo['adicionar'] == 1) {
                $query = $this->db->query("SELECT * FROM ut_passos_implantacao WHERE id = ?", [$passo['id']]);

                $passo_bd = $query->fetch(PDO::FETCH_ASSOC);

                $query = $this->db->insert('ut_implantacao', [
                    'id_projeto' => $id_conta,
                    'id_tipo' => $passo['id'],
                    'status' => 2
                ]);

                if ($query) {
                    $texto_historico = 'O passo de integração: ' . $passo_bd['nome'] . ' foi adicionado à conta.';
                    $texto_historico .= '<br/>Lembre-se de cadastrar a data inicial do período na edição de passos.';

                    $query = $this->db->insert('ut_historico_implantacao', array(
                        'id_usuario' => $id_usuario,
                        'id_projeto' => $id_conta,
                        'texto' => $texto_historico,
                        'anexo' => 3,
                        'data' => date('Y-m-d H:i:s', strtotime('now'))
                    ));
                } else {
                    return $query;
                }
            }
        }

        foreach ($passos_conta as $chave => $pc) {
            if ($pc['remover'] == 1) {
                $query = $this->db->delete('ut_implantacao', 'id', $pc['id']);

                if ($query) {
                    $texto_historico = 'O passo de integração: ' . $pc['nome'] . ' foi removido da conta.';

                    $query = $this->db->insert('ut_historico_implantacao', array(
                        'id_usuario' => $id_usuario,
                        'id_projeto' => $id_conta,
                        'texto' => $texto_historico,
                        'anexo' => 3,
                        'data' => date('Y-m-d H:i:s', strtotime('now'))
                    ));
                } else {
                    return $query;
                }
            }
        }
        
        $nome = true;
        $responsavel = true;
        $previsao = true;
        $implantacao = true;

        $query = $this->db->query('SELECT * FROM ut_projetos_implantacao WHERE id = ?', [$id_conta]);
        $conta = $query->fetch(PDO::FETCH_ASSOC);

        if (
            $values['nome_loja'] == ''
            || $values['nome_loja'] == $conta['nome_loja']
        ) {
            unset($values['nome_loja']);
            $nome = false;
        }

        if (
            $values['responsavel_loja'] == ''
            || $values['responsavel_loja'] == $conta['responsavel_loja']
        ) {
            unset($values['responsavel_loja']);
            $responsavel = false;
        }

        if (
            $values['previsao_lancamento'] == ''
            || $values['previsao_lancamento'] == $conta['previsao_lancamento']
        ) {
            unset($values['previsao_lancamento']);
            $previsao = false;
        } 

        if (
            $values['implantado'] == ''
            || $values['implantado'] == $conta['implantado']
        ) {
            unset($values['implantado']);
            $implantacao = false;
        } 

        if (
            $nome == false
            && $responsavel == false
            && $previsao == false
            && $implantacao == false
        ) {
            return true;
        }

        $texto_historico = '';
        if ($nome) {
            $texto_historico = 'O nome da conta foi alterado de "'
            . $conta['nome_loja'] . '" para "' . $values['nome_loja'] . '".<br/>';
        }

        if ($responsavel) {
            $texto_historico .= 'O responsavel da loja foi alterado de "'
            . $conta['responsavel_loja'] . '" para "' . $values['responsavel_loja'] . '".<br/>';
        }

        if ($previsao) {
            $texto_historico .= 'A previsão de lançamento foi alterado de '
            . date('d/m/Y', strtotime($conta['previsao_lancamento'])) . ' para ' 
            . date('d/m/Y', strtotime($values['previsao_lancamento'])) . '.<br/>';
        }

        if ($implantacao) {
            $statusAntes = '';
            $statusDepois = '';

            switch ($conta['implantado']) {
                case 1:
                    $statusAntes = 'implantado';
                    break;
                case 2:
                    $statusAntes = 'não implantado';
                    break;
                case 3:
                    $statusAntes = 'em implantação';
                    break;
            }

            switch ($values['implantado']) {
                case 1:
                    $statusDepois = 'implantado';
                    break;
                case 2:
                    $statusDepois = 'não implantado';
                    break;
                case 3:
                    $statusDepois = 'em implantação';
                    break;
            }

            $texto_historico .= 'O status da implantação foi alterado de "'
            . $statusAntes . '" para "' . $statusDepois . '".<br/>';
        }

        $query = $this->db->update('ut_projetos_implantacao', 'id', $id_conta, $values);

        $query = $this->db->insert('ut_historico_implantacao', array(
            'id_usuario' => $id_usuario,
            'id_projeto' => $id_conta,
            'texto' => $texto_historico,
            'anexo' => 3,
            'data' => date('Y-m-d H:i:s', strtotime('now'))
        ));

        if ($query) {
            return true;
        }
    }

    public function retornaContas($values)
    {
        $where = '';
        if ($values['implantacao'] != 4) {
            $where = "WHERE implantado = " . $values['implantacao'];
        }

        if (
            $values['implantacao'] != 4
            && $values['tipo'] != 4
        ) {
            $where .= " AND tipo = " . $values['tipo'];
        } else if ($values['implantacao'] == 4 && $values['tipo'] != 4) {
            $where = "WHERE tipo = " . $values['tipo'];
        }

        $sql = "SELECT utpi.*, uttc.nome as nome_tipo FROM ut_projetos_implantacao AS utpi LEFT JOIN ut_tipos_contas AS uttc ON uttc.id = utpi.tipo $where ORDER BY id DESC";

        $query = $this->db->query($sql);
        $projetos = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($projetos)) {
            return false;
        }

        foreach ($projetos as $key => $projeto) {
            $query = $this->db->query(
                "SELECT
                    utimp.*,
                    DATE_FORMAT(utimp.data_inicio, '%d/%m/%Y') AS inicio,
                    DATE_FORMAT(utimp.data_final, '%d/%m/%Y') AS fim,
                    uttimp.nome,
                    uttimp.previsao_de_dias AS tempo
                FROM
                    ut_implantacao AS utimp
                LEFT JOIN
                    ut_passos_implantacao AS uttimp ON utimp.id_tipo = uttimp.id
                WHERE
                    utimp.id_projeto = ?
                ORDER BY
                    id_tipo ASC",
                [$projeto['id']]
            );

            $query = $this->db->query('SELECT * FROM ut_passos_implantacao ORDER BY id ASC');
            $tipos = $query->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($projetos as $key => $projeto) {
                $implantacao = array();
                $query = $this->db->query(
                    "SELECT
                        utimp.*,
                        DATE_FORMAT(utimp.data_inicio, '%d/%m/%Y') AS inicio,
                        DATE_FORMAT(utimp.data_final, '%d/%m/%Y') AS fim,
                        uttimp.nome,
                        uttimp.previsao_de_dias AS tempo
                    FROM
                        ut_implantacao AS utimp
                    LEFT JOIN
                        ut_passos_implantacao AS uttimp ON utimp.id_tipo = uttimp.id
                    WHERE
                        utimp.id_projeto = ?
                    ORDER BY
                        id_tipo ASC",
                    [$projeto['id']]
                );
                $passos = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach($passos as $key2 => $imp) {
                    if ($imp['inicio'] == null) {
                        $imp['inicio'] = 'Não definido!';
                        $imp['status'] = '2';
                    } else {
                        $data_at = new DateTime(date('Y-m-d', strtotime('now')));

                        $data_fim = new DateTime(date('Y-m-d', strtotime($imp['data_inicio'])));
                        $intervalo = new DateInterval('P'.$imp['tempo'].'D');
                        $data_fim->add($intervalo);

                        $interval = $data_at->diff($data_fim);
                        if ($interval->format('%R') == '-' && $imp['status'] == '2') {
                            $imp['status'] = '3';
                        }
                    }
                    array_push($implantacao, $imp);
                }
                $projetos[$key]['ut_implantacao'] = $implantacao;
            }
        }
        return $projetos;
    }


    public function retornaConta($id)
    {
        $query = $this->db->query("SELECT * FROM ut_projetos_implantacao WHERE id = ?", [$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizaImplantacao($values)
    {
        $id_conta = $values['id'];
        $id_tipo = $values['id_tipo'];
        $id_usuario = $_SESSION['userdata']['id'];
        var_dump($values);

        $query = $this->db->query(
            "SELECT
                *
            FROM
                ut_implantacao
            WHERE
                id_tipo = ? 
                AND id_projeto = ?",
            [$id_tipo, $id_conta]
        );

        $imp = $query->fetch(PDO::FETCH_ASSOC);

        $query = $this->db->query('SELECT * FROM ut_passos_implantacao WHERE id = ?', [$id_tipo]);
        $tipo = $query->fetch(PDO::FETCH_ASSOC);

        if (!empty($imp)) {
            if ($values['inicio'] == '') {
                $values['inicio'] =  $imp['data_inicio'];
            } else {
                $values['inicio'] = date('Y-m-d H:i:s', strtotime($values['inicio']));
            }

            $data_incio = '';
            $data_fim = '';

            if ($values['fim'] == '' && $values['status'] == 1) {
                $values['fim'] = $imp['data_final'];
            } elseif ($values['fim'] !== '' && $values['status'] == 1) {
                $values['fim'] = date('Y-m-d H:i:s', strtotime($values['fim']));

                $data_incio = new DateTime($values['inicio']);
                $data_fim = new DateTime($values['fim']);

                if ($data_fim < $data_incio) {
                    return 'A data de termino deve ser maior ou igual a data de inicio';
                }  
            } else {
                $values['fim'] == null;
            }

            $query = $this->db->update('ut_implantacao', 'id', $imp['id'], array(
                'data_inicio' => $values['inicio'],
                'data_final' => $values['fim'],
                'status' => $values['status'],
            ));

            if ($imp['status'] == '2' && $values['status'] == '1') {
                $data_fim= new DateTime($values['fim']);

                $texto_historico = 'O passo de integração: '.$tipo['nome']. ' foi definido como concluíudo.';
                $texto_historico .= '<br/>A data de conclusão foi definida como '. $data_fim->format('d/m/Y');

                $query = $this->db->insert('ut_historico_implantacao', array(
                    'id_usuario' => $id_usuario,
                    'id_projeto' => $id_conta,
                    'texto' => $texto_historico,
                    'anexo' => '3',
                    'data' => date('Y-m-d H:i:s', strtotime('now'))
                ));
            } else if ($imp['status'] == '1' && $values['status'] == '2') {
                $data_prazo = new DateTime($values['inicio']);
                $interval = new DateInterval('P'.$tipo['previsao_de_dias'].'D');
                $data_prazo->add($interval);

                $texto_historico = 'O passo de integração: '.$tipo['nome']. ' foi cadastrado à conta com inicio';
                $texto_historico .= ' no dia ' . $data_incio->format('d/m/Y') . ' e prazo de ' . $tipo['previsao_de_dias'];
                $texto_historico .= ' dias com previsão de expiração do prazo no dia ' . $data_prazo->format('d/m/Y');

                $data_at = new DateTime(date('Y-m-d', strtotime('now')));

                if ($data_prazo < $data_at) {
                    $texto_historico .= '<br/> O prazo de implantação desse passo já expirou!';
                }

                $query = $this->db->insert('ut_historico_implantacao', array(
                    'id_usuario' => $id_usuario,
                    'id_projeto' => $id_conta,
                    'texto' => $texto_historico,
                    'anexo' => '3',
                    'data' => date('Y-m-d H:i:s', strtotime('now'))
                ));
            }

            if ($query) {
                return true;
            } else {
                return 'Erro ao atualizar o registro';
            }
        } else {
            if ($values['inicio'] == '') {
                return 'A data incial não deve ser vazia';
            }

            if ($values['fim'] == '') {
                $values['fim'] = null;
            } else {
                if ($values['status'] == 1) {
                    $values['fim'] = date('Y-m-d H:i:s', strtotime($values['fim']));
                } else {
                    $values['fim'] = null;
                }
            }

            // var_dump($values);

            $query = $this->db->insert('ut_implantacao', array(
                'id_projeto' => $id_conta,
                'id_tipo' => $id_tipo,
                'data_inicio' => date('Y-m-d H:i:s', strtotime($values['inicio'])),
                'data_final' => $values['fim'],
                'status' => $values['status'],
            ));

            if (!$query) {
                return 'Erro ao salvar o passo';
            }

            $data_incio = new DateTime($values['inicio']);
            $data_prazo = new DateTime($values['inicio']);
            $interval = new DateInterval('P'.$tipo['previsao_de_dias'].'D');
            $data_prazo->add($interval);

            $texto_historico = 'O passo de integração: '.$tipo['nome']. ' foi cadastrado à conta com inicio';
            $texto_historico .= ' no dia ' . $data_incio->format('d/m/Y') . ' e prazo de ' . $tipo['previsao_de_dias'];
            $texto_historico .= ' com previsão de expiração do prazo no dia ' . $data_prazo->format('d/m/Y');

            $query = $this->db->insert('ut_historico_implantacao', array(
                'id_usuario' => $id_usuario,
                'id_projeto' => $id_conta,
                'texto' => $texto_historico,
                'anexo' => '3',
                'data' => date('Y-m-d H:i:s', strtotime('now'))
            ));

            if ($query) {
                return true;
            } else {
                return 'Erro ao cadastrar os dados do passo de implantação';
            }
        }
    }

    public function retornaHistorico($id_conta)
    {
        $path = HOME_URI.'/views/_uploads/historico/';
        $query = $this->db->query(
            "SELECT
                uthi.*,
                utus.nome,
                (CASE 
                    WHEN uthi.anexo <> 3 THEN CONCAT('${path}', utahi.nome_arquivo)
                    ELSE NULL
                END) AS arquivo,
                (CASE 
                    WHEN uthi.anexo = 2 THEN CONCAT('audio/', utahi.extensao)
                    ELSE NULL
                END) AS extensao,
                DATE_FORMAT(STR_TO_DATE(uthi.data, '%Y-%m-%d'), '%d/%m/%Y') AS data_formatada
            FROM
                ut_historico_implantacao AS uthi
            LEFT JOIN ut_usuarios AS utus ON uthi.id_usuario = utus.id
            LEFT JOIN ut_arquivos_historico_implantacao AS utahi ON utahi.id_historico_implantacao = uthi.id
            WHERE
                id_projeto = ?
            ORDER BY
                id DESC",
            [$id_conta]
        );

        $historico = $query->fetchAll(PDO::FETCH_ASSOC);

        return $historico;
    }

    public function salvaHistorico($values)
    {
        $id_usuario = $_SESSION['userdata']['id'];

        if ($values['arquivo'] != 'false') {
            $tipo = explode(';', $values['arquivo']);
            $tipo = explode('/', $tipo[0]);

            $anexo = 3;

            if ($tipo[0] == 'data:image') {
                $anexo = 1;
            } elseif ($tipo[0] == 'data:audio') {
                $anexo = 2;
                if ($tipo[1] == 'mpeg') {
                    $tipo[1] = 'mp3';
                }
            }

            $nome_arquivo = md5(time()). '.' . $tipo[1];

            $caminho_arquivo = UP_ABSPATH . '/historico/' .$nome_arquivo;

            $file = fopen($caminho_arquivo, "wb");

            $foto = explode(',', $values['arquivo']);

            $content = base64_decode($foto[1]);

            fwrite($file, $content);
            fclose($file);

            $query = $this->db->insert('ut_historico_implantacao', array(
                'id_usuario' => $id_usuario,
                'id_projeto' => $values['id_conta'],
                'texto' => $values['conteudo'],
                'anexo' => $anexo,
                'data' => date('Y-m-d H:i:s', strtotime('now'))
            ));

            $id_historico = $this->db->last_id;

            $query = $this->db->insert('ut_arquivos_historico_implantacao', array(
                'id_historico_implantacao' => $id_historico,
                'nome_arquivo' => $nome_arquivo,
                'extensao' => $tipo[1],
                'data' => date('Y-m-d H:i:s', strtotime('now'))
            ));
        } else {
            $query = $this->db->insert('ut_historico_implantacao', array(
                'id_usuario' => $id_usuario,
                'id_projeto' => $values['id_conta'],
                'texto' => $values['conteudo'],
                'anexo' => '3',
                'data' => date('Y-m-d H:i:s', strtotime('now'))
            ));
        }
    }

    public function retornaTiposImplantacao()
    {
        $query = $this->db->query("SELECT * FROM ut_passos_implantacao ORDER BY id ASC");

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function retornaTiposContas()
    {
        $query = $this->db->query("SELECT * FROM ut_tipos_contas WHERE status = 1");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function retornaPassosImplantacao($values)
    {
        $query = $this->db->query(
            "SELECT
                *
            FROM
                ut_passos_implantacao
            WHERE 
                (tipo_conta IS NULL OR tipo_conta = ?)",
            [$values['tipo_conta']]
        );

        $passos = $query->fetchAll(PDO::FETCH_ASSOC);

        if (isset($values['id_conta'])) {
            $query = $this->db->query(
                "SELECT
                    *
                FROM
                    ut_implantacao
                WHERE
                    id_projeto = ?",
                [$values['id_conta']]
            );

            $passos_conta = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($passos as $key => $passo) {
                $selected = 2; 
                foreach ($passos_conta as $chave => $passo_conta) {
                    if ($passo['id'] == $passo_conta['id_tipo']) {
                        $selected = 1;
                    }
                }
                if ($values['apenas_conta'] == 'false') {
                    $passos[$key]['selected'] = $selected;
                } else {
                    if ($selected == 2) {
                        unset($passos[$key]);
                    }
                }
            }
        }

        if ($values['apenas_conta'] == 'true') {
            $pcs = array();

            foreach ($passos as $key => $passo) {
                array_push($pcs, $passo);
            }

            $passos = $pcs;
        }

        return $passos;
    }
}
