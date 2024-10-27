<?php
//Declarando valores de la conexion
$servidor="Localhost";
$User="root";
$password="";
$bd="musica";
$conecta=mysqli_connect($servidor,$User,$password,$bd);
if($conecta->connect_error){
    die ("Error al conectar a la base de datos".$conecta->connect_error);
}


?>
