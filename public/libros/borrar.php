<?php

use App\Bd\Libro;
use App\Bd\Usuario;

session_start();
if(!isset($_SESSION['email'])){
    header("Location:admin.php");
    exit();
}
$id= filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if(!$id){
    header("Location:admin.php");
    exit();
}

$user_id= Usuario::getUserIdByEmail($_SESSION['email']);
$arrayLibros= Libro::libroPerteneceUsuario($user_id, $id);
if(count($arrayLibros)== 0){
    header("Location:prohibido.php");
    exit();
}

Libro::borrar($id);

$portada= $arrayLibros[0]->portada;
if(basename($portada) != 'default.jpg'){
    unlink("./..".$portada);
}

$_SESSION['mensaje']="Libro eliminado";
header("Location:admin.php");
exit();