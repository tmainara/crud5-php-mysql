<?php

namespace App\Bd;

use PDO;
use PDOException;
use PDOStatement;

class Libro extends Conexion
{
    private int $id;
    private string $titulo;
    private string $sinopsis;
    private string $disponible;
    private int $genero_id;
    private int $usuario_id;
    private ?string $portada = null;

    private static function executeQuery(string $q, array $opciones, bool $devolverAlgo): bool|PDOStatement
    {
        $stmt = parent::getConexion()->prepare($q);
        try {
            $stmt->execute($opciones);
            return $devolverAlgo ? $stmt : false;
        } catch (PDOException $ex) {
            throw new PDOException("Error al ejecutar consulta: " . $ex->getMessage());
        }
    }

    public static function getLibrosDisponibles():array{
         $q = "select libros.*, generos.nombre AS genero
          from libros, generos
          where libros.genero_id = generos.id
          AND libros.disponible = 'Si'";
        $stmt= self::executeQuery($q, [], true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getLibrosUsuario(int $usuario_id): array
    {
        $q = "select libros.*, generos.nombre AS genero
        from libros, generos
        where libros.genero_id = generos.id
        AND libros.usuario_id = :u";
        $stmt = self::executeQuery($q, [':u' => $usuario_id], true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function libroPerteneceUsuario(int $id_u, int $id_l)
    {
        $q = "select * from libros where usuario_id=:u AND id=:i";
        $stmt = self::executeQuery($q, [':u' => $id_u, ':i' => $id_l], true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }



    public function crear()
    {
        $q = "insert into libros (titulo, sinopsis, disponible, portada, genero_id, usuario_id)
        values (:t, :s, :d, :p, :g, :u)";
        $stmt = self::executeQuery($q, [':t' => $this->titulo, ':s' => $this->sinopsis, ':d' => $this->disponible, ':p' => $this->portada, ':g' => $this->genero_id, ':u' => $this->usuario_id], false);
    }

    public function editar(int $id)
    {
        $q = "update articulos set titulo=:t, sinopsis=:s, disponible=:d, portada=:img, genero_id=:gi where id=:i";
        self::executeQuery(
            $q,
            [
                ':t' => $this->titulo,
                ':s' => $this->sinopsis,
                ':d' => $this->disponible,
                ':img' => $this->portada,
                ':gi' => $this->genero_id,
                ':i' => $id
            ], false
        );
    }

    public static function borrar(int $id){
        $q="delete from libros where id=:i";
        $stmt=self::executeQuery($q, [':i'=>$id],false);
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
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of psinopsis
     */
    public function getSinopsis()
    {
        return $this->sinopsis;
    }

    /**
     * Set the value of psinopsis
     *
     * @return  self
     */
    public function setSinopsis(string $sinopsis): self
    {
        $this->sinopsis = $sinopsis;

        return $this;
    }

    /**
     * Get the value of titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */
    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of disponible
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * Set the value of disponible
     *
     * @return  self
     */
    public function setDisponible(string $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get the value of genero_id
     */
    public function getGenero_id()
    {
        return $this->genero_id;
    }

    /**
     * Set the value of genero_id
     *
     * @return  self
     */
    public function setGenero_id(int $genero_id): self
    {
        $this->genero_id = $genero_id;

        return $this;
    }

    /**
     * Get the value of usuario_id
     */
    public function getUsuario_id()
    {
        return $this->usuario_id;
    }

    /**
     * Set the value of usuario_id
     *
     * @return  self
     */
    public function setUsuario_id(int $usuario_id): self
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    /**
     * Get the value of portada
     */
    public function getPortada()
    {
        return $this->portada;
    }

    /**
     * Set the value of portada
     *
     * @return  self
     */
    public function setPortada(?string $portada): self
    {
        $this->portada = $portada;

        return $this;
    }
}
