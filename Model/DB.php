<?php

namespace Model;

use App\Config;
use PDO;
use PDOException;

class DB {

    private string $host = Config::HOST;
    private string $db = Config::DB_NAME;
    private string $user = Config::USER;
    private string $password = Config::PASSWORD;

    private static ?PDO $dbInstance = null;

    public function __construct() {
        try{
            self::$dbInstance = new PDO("mysql:host=$this->host;dbname=$this->db;charset=utf8", $this->user, $this->password);
            self::$dbInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //to avoid getting 2 times the same result
            self::$dbInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch(PDOException $exception){
            echo $exception->getMessage();
        }

    }

    public static function getInstance(): ?PDO {
        if(is_null(self::$dbInstance)){
            new self();
        }
        return self::$dbInstance;
    }


    /**
     * We prevent people from cloning the object
     * to make sure that there is only one instance of the connection to the db
     */
    public function __clone() {}
}