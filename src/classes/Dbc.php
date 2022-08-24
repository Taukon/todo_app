<?php
namespace Taukon\TodoApp\Classes;

require_once(__DIR__ . '/../config/env.php');

class Dbc{
    /**
     * データベースに接続
     * @param void
     * @return PDO
     */
    protected static function dbConnect(){
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $dsn = 'mysql:host='.$host.';dbname='.$dbname.';charset=utf8';

        try{
            $dbh = new \PDO($dsn, $user, $pass,[
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_EMULATE_PREPARES => false,    //prevent sql injection
            ]);

        } catch(PDOException $e){
            echo "接続失敗".$e->getMessage();
            exit();
        };
        return $dbh;
    }

}

?>