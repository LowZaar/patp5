<?php
/**
 * Configuração geral
 */

// Caminho para a raiz
define('ABSPATH', dirname(__FILE__));

// Caminho para a pasta de uploads
define('UP_ABSPATH', ABSPATH . '/views/_uploads');

// URL da home
define('HOME_URI', 'http://localhost/patp');

// Nome do host da base de dados
define('HOSTNAME', '');

// Nome do DB
define('DB_NAME', '');

// Usuário do DB
define('DB_USER', '');

// Senha do DB
define('DB_PASSWORD', '');

// Charset da conexão PDO
define('DB_CHARSET', 'utf8mb4');

// Se você estiver desenvolvendo, modifique o valor para true
define('DEBUG', true);

// Define a timezone de São Paulo
define('TIMEZONE', 'America/Sao_Paulo');

/**
 * Não edite daqui em diante
 */

// Carrega o loader, que vai carregar a aplicação inteira
require_once ABSPATH . '/loader.php';
