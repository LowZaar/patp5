<?php
/**
 * Verifica chaves de arrays
 *
 * Verifica se a chave existe no array e se ela tem algum valor.
 * Obs.: Essa função está no escopo global, pois, vamos precisar muito da mesma.
 *
 * @param array  $array O array
 * @param string $key   A chave do array
 * @return string|null  O valor da chave do array ou nulo
 */
function chk_array($array, $key)
{
    // Verifica se a chave existe no array
    if (isset($array[$key]) && !empty($array[ $key ])) {
        // Retorna o valor da chave
        return $array[ $key ];
    }
    
    // Retorna nulo por padrão
    return null;
} // chk_array

/**
 * Função para carregar automaticamente todas as classes padrão
 * Ver: http://php.net/manual/pt_BR/function.autoload.php.
 * Nossas classes estão na pasta classes/.
 * O nome do arquivo deverá ser class-NomeDaClasse.php.
 * Por exemplo: para a classe TutsupMVC, o arquivo vai chamar class-TutsupMVC.php
 */
spl_autoload_register(function ($className) {
    // Caminho para as classes com namespace
    $namespace = substr($className, strrpos($className, '\\') + 1);
    $path = ABSPATH . '/classes/class-' . $namespace . '.php';
    if (file_exists($path)) {
        require_once $path;
        return;
    }

    // Caminho para as classes sem namespace
    $path = ABSPATH . '/classes/class-' . $className . '.php';
    if (file_exists($path)) {
        require_once $path;
        return;
    }
    
    //throw new \Exception("Classe " . $className . " não encontrada!");
});

function format_BRL($valor)
{
    return "R$ ".number_format($valor, 2, ",", ".");
}

/**
 * Função para váliadar CPF
 * @param null $cpf
 * @return bool
 */
function validaCPF($cpf = null)
{
    // Verifica se um número foi informado
    if (empty($cpf)) {
        return false;
    }
    
    // Elimina possivel mascara
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
    
    // Verifica se são todos números
    if (!is_numeric($cpf)) {
        return false;
    }
    
    // Verifica se o numero de digitos informados é igual a 11
    if (strlen($cpf) != 11) {
        return false;
    } elseif ($cpf == '00000000000' ||
        $cpf == '11111111111' ||
        $cpf == '22222222222' ||
        $cpf == '33333333333' ||
        $cpf == '44444444444' ||
        $cpf == '55555555555' ||
        $cpf == '66666666666' ||
        $cpf == '77777777777' ||
        $cpf == '88888888888' ||
        $cpf == '99999999999') {
        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        return false;
    } else {
        // Calcula os digitos verificadores para verificar se o
        // CPF é válido
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}

/**
 * Função que verifica se o request é um POST
 * @return bool
 */
function requestIsPOST()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

/**
 * Função para aplicar máscaras.
 * @param $mask
 * @param $str
 * @return mixed
 */
function Mask($mask,$str)
{
    $str = str_replace(" ","",$str);
    
    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }
    
    return $mask;
    
}


if (!function_exists('encrypt_decrypt')) {
    /**
     * Used to encrypt and decrypt data
     * @param $action
     * @param $string
     * @return bool|false|string
     */
    function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        
        // hash
        $key = 'askoeo';
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', 'kopdk'), 0, 16);
        
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } elseif ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
}