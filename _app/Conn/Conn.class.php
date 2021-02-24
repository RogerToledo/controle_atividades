<?php

/**
 * Conn.class [ CONEXÃO ]
 * Classe abstrata de conexão. Padrão SingleTon.
 * Retorna um objeto PDO pelo método estático getConn();
 * 
 * @copyright (c) 2013, Robson V. Leite UPINSIDE TECNOLOGIA
 */
class Conn {

    private static $Host = SIS_DB_HOST;
    private static $User = SIS_DB_USER;
    private static $Pass = SIS_DB_PASS;
    private static $Dbsa = SIS_DB_DBSA;

    /** @var PDO */
    private static $Connect = null;
    private static $Banco = 1; // 1-MYSQL | 2-MSSQL |
    /**
     * Conecta com o banco de dados com o pattern singleton.
     * Retorna um objeto PDO!
     */
    private static function Conectar() {
        try {
            if(self::$Banco == 1):
                if (self::$Connect == null):
                    $dsn = 'mysql:host=' . self::$Host . ';dbname=' . self::$Dbsa;
                    $options = [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                    self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
                    self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                endif; 
            elseif(self::$Banco == 2):
                if (self::$Connect == null):
                    $user = "roger.toledo"; $pass = ""; $name = ""; $host = "";
                    self::$Connect = new PDO('odbc:Driver={SQL Server Native Client 10.0}; Server='.$host.'; Database='.$name.';', $user, $pass); 
                    self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    print_r(self::$Connect);
                                        
                endif;
            endif;
            
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            var_dump($e);
            die;
        }

        return self::$Connect;
    }

    /** Retorna um objeto PDO Singleton Pattern. */
    public static function getConn() {
        return self::Conectar();
    }

    /**
     * Construtor do tipo protegido previne que uma nova instância da
     * Classe seja criada através do operador `new` de fora dessa classe.
     */
    private function __construct() {
        
    }

    /**
     * Método clone do tipo privado previne a clonagem dessa instância
     * da classe
     *
     * @return void
     */
    private function __clone() {
        
    }

    /**
     * Método unserialize do tipo privado para previnir que desserialização
     * da instância dessa classe.
     *
     * @return void
     */
    private function __wakeup() {
        
    }

}
