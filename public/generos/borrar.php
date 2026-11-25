<?php

use App\Bd\Genero;

session_start();
require __DIR__ . "/../../vendor/autoload.php";

if(!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1){
    header("Location:./..");
    exit();
}

$id=filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if(!$id){
    header("Location:admin.php");
    exit();
}

Genero::borrar($id);
$_SESSION['mensaje']="Genero borrado";
header("Location:admin.php");
exit();