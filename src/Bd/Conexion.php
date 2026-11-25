<?php
namespace App\Bd;

use PDO;
use PDOException;

abstract class Conexion{
    private static ?PDO $conexion=null;

    protected static function getConexion(): PDO {
        if(self::$conexion == null){
            self::setConexion();
        }
        return self::$conexion;
    }

    protected static function setConexion(): void{
        $dotenv= \Dotenv\Dotenv::createImmutable(self::getRootPath());
        $dotenv->load();

        $usuario= $_ENV['USUARIO'];
        $password= $_ENV['PASSWORD'];
        $puerto= $_ENV['PORT'];
        $host=$_ENV['HOST'];
        $db=$_ENV['DBNAME'];

        $dsn= "mysql:host=$host; dbname=$db; port=$puerto charset=utf8mb4";
        $opciones=[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try{
            self::$conexion = new PDO($dsn, $usuario, $password, $opciones);
        }catch (PDOException $ex){
            throw new PDOException("Error en la conexión ". $ex->getMessage());
        }
    }

    private static function getRootPath(): string
    {
        return dirname(__DIR__, 2);
    }
    
}