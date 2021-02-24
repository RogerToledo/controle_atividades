<?php
/**
 * VERSAO
 */
define('VERSION', '2.2.2');


/* 
 * SLA FIXO SUPORTE
 */
define('SLA_SUP', '08:00:00');

/*
 * BANCO DE DADOS
 */
 
//CONFIGURAÇÃO DO SITE ####################
//define('SIS_DB_HOST','mysql.hostinger.com.br');
//define('SIS_DB_USER','u902376232_dev');
//define('SIS_DB_PASS','9IQrlXfDKvbB');
//define('SIS_DB_DBSA','u902376232_dev');

//CONFIGURAÇÃO DO SITE ####################
define('SIS_DB_HOST','mysql.hostinger.com.br');
define('SIS_DB_USER','u902376232_motor');
define('SIS_DB_PASS','MR0t3yWEJe4j');
define('SIS_DB_DBSA','u902376232_motor');

//CONFIGURAÇÃO LOCALHOST ####################
//define('SIS_DB_HOST', 'localhost:3307'); //Link do banco de dados
//define('SIS_DB_USER', 'root'); //Usuário do banco de dados
//define('SIS_DB_PASS', ''); //Senha  do banco de dados
//define('SIS_DB_DBSA', 'soft'); //Nome  do banco de dados


/*
 * AUTO LOAD DE CLASSES
 */
function MyAutoLoad($Class) {
    $cDir = ['Conn', 'Helpers', 'Models'];
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php') && !is_dir(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php')):
            include_once (__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php');
            $iDir = true;
        endif;
    endforeach;
}

spl_autoload_register("MyAutoLoad");

/*
 * Exibe erros lançados
 */

function Erro($ErrMsg, $ErrNo = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? 'trigger_info' : ($ErrNo == E_USER_WARNING ? 'trigger_alert' : ($ErrNo == E_USER_ERROR ? 'trigger_error' : 'trigger_success')));
    echo "<div class='trigger {$CssClass}'>{$ErrMsg}<span class='ajax_close'></span></div>";
}

/*
 * Exibe erros lançados por ajax
 */

function AjaxErro($ErrMsg, $ErrNo = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? 'trigger_info' : ($ErrNo == E_USER_WARNING ? 'trigger_alert' : ($ErrNo == E_USER_ERROR ? 'trigger_error' : 'trigger_success')));
    return "<div class='trigger trigger_ajax {$CssClass}'>{$ErrMsg}<span class='ajax_close'></span></div>";
}

/*
 * personaliza o gatilho do PHP
 */

function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    echo "<div class='trigger trigger_error'>";
    echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class='ajax_close'></span></div>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

//set_error_handler('PHPErro');

?>
