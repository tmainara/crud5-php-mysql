<?php
namespace App\Bd;

use \PDOException;
use \PDOStatement;
use \PDO;
class Genero extends Conexion{
    private int $id;
    private string $nombre;
    private string $color;

    private static function executeQuery(string $q, array $opciones, bool $devolverAlgo): bool|PDOStatement{
        $stmt= parent::getConexion()->prepare($q);
        try{
            $stmt->execute($opciones);
            return $devolverAlgo ? $stmt : false;
        }catch(PDOException $ex){
            throw new PDOException("Error al ejecutar consulta: ".$ex->getMessage());
        }
    }

    public function crear(){
        $q="insert into generos (nombre, color) values (:n, :c)";
        $stmt=self::executeQuery($q, [':n'=>$this->nombre, ':c'=>$this->color ], false);
    }

    public static function borrar(int $id){
        $q="delete from generos where id=:i";
        $stmt=self::executeQuery($q, [':i'=>$id],false);
    }
    
    public function update(int $id){
        $q="update generos set nombre=:n, color=:c where id=:i";
        $stmt=self::executeQuery($q, [':n'=>$this->nombre, ':c'=>$this->color, ':i'=>$id],false);
    }

    public static function getGeneros():array{
        $q="select * from generos";
        $stmt=self::executeQuery($q, [], true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getIdGeneros():array{
        $q="select id from generos";
        $stmt=self::executeQuery($q, [], true);
        $datos=$stmt->fetchAll(PDO::FETCH_OBJ);
        $ids=[];
        foreach($datos as $dato){
            $ids[]=$dato->id;
        }
        return $ids;
    }

    public static function existeGenero(string $nombre, int $id=-1):bool{
        $q="select 1 from generos where nombre=:n AND id!=:i";
        $stmt=self::executeQuery($q, [':n'=>$nombre, ':i'=>$id],true);
        $datos=$stmt->fetchAll(PDO::FETCH_OBJ);
        return count($datos)!=0;
    }

    public static function getGeneroById(int $id):array{
        $q="select * from generos where id=:i";
        $stmt=self::executeQuery($q, [':i'=>$id],true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id):self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre(string $nombre):self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of color
     */ 
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return  self
     */ 
    public function setColor(string $color):self
    {
        $this->color = $color;

        return $this;
    }
}