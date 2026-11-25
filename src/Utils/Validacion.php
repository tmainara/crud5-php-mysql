<?php

namespace App\Utils;

use App\Bd\Genero;
use App\Bd\Usuario;

abstract class Validacion
{
    public static function sanearCadena(string $cadena)
    {
        return htmlspecialchars(trim($cadena));
    }

    public static function longitudCadenaValida(string $cadena, string $valor, int $max, int $min):bool{
        if(strlen($valor) > $max || strlen($valor) < $min){
            $_SESSION["err_$cadena"]="ERROR, se esperaba una longitud entre $min y $max caracteres.";
            return false;
        }
        return true;
    }

    public static function loginValido(string $email, string $password)
    {
        $perfil = Usuario::esLoginValido($email, $password);

        if ($perfil == -1) {
            $_SESSION['err_login'] = "ERROR, email o password incorrectos";
        }
        return $perfil;
    }

    public static function generoValido(int $genero): bool
    {
        $ids = Genero::getIdGeneros();
        if (!in_array($genero, $ids)) {
            $_SESSION['err_genero'] = "*** Error, género inválido o no seleccionado";
            return false;
        }
        return true;
    }

    public static function colorValido(string $color):bool{
        if(!preg_match('/^#[0-9A-Fa-f]{6}$/', $color)){
        $_SESSION['err_color']="ERROR, color inválido o no seleccionado";
        return false;
        }
        return true;
    }

    public static function existeGenero(string $nombre, int $id=-1):bool{
        if(!Genero::existeGenero($nombre, $id)){
            $_SESSION['err_genero']="ERROR, el género ya existe";
            return false;
        }
        return true;
    }

    public static function disponibleValido(string $disponible): bool
    {
        if (!in_array($disponible, ['Si', 'No'])) {
            $_SESSION['err_disponible'] = "*** Error, disponibilidad inválida o no seleccionada";
            return false;
        }
        return true;
    }

    public static function imagenValida(string $tipo, int $size):bool{
        $tiposValidos=['image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/bmp',
            'image/svg+xml'];
        if(!in_array($tipo, $tiposValidos)){
            $_SESSION['err_img']="ERROR, se esperaba un archivo de imagen";
            return false;
        }
        if($size > 2000000){
            $_SESSION['err_img']="ERROR, la imagen excede los 2MB permitidos";
            return false;
        }
        return true;
    }

    public static function pintarError(string $nombre)
    {
        if (isset($_SESSION[$nombre])) {
            echo "<p class='text-red-600 italic text-sm'>" . $_SESSION[$nombre] . "</p>";
            unset($_SESSION[$nombre]);
        }
    }
}
