<?php

namespace App\Bd;

use \PDOException;
use \PDOStatement;
use \PDO;

class Usuario extends Conexion
{
    private int $id;
    private string $email;
    private int $perfil;
    private string $password;

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

    public static function esLoginValido(string $email, string $password): int
    {
        $q = "select password, perfil from usuarios where email=:e";
        $stmt = self::executeQuery($q, [':e' => $email], true);
        $datos = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (count($datos) > 0) {
            return password_verify($password, $datos[0]->password) ? $datos[0]->perfil : -1;
        }
        return -1;
    }

    public static function getUserIdByEmail(string $email) :int {
        $q="select id from usuarios where email=:e";
        $stmt=self::executeQuery($q, [':e'=>$email], true);
        return $stmt->fetchAll(PDO::FETCH_OBJ)[0]->id;
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
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of perfil
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * Set the value of perfil
     *
     * @return  self
     */
    public function setPerfil(string $perfil): self
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
