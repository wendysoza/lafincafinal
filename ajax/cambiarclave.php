<?php 
require_once('../config/Conexion.php');
$id = $_POST['id'];
$pass = $_POST['new_password'];

$clave1 = hash("MD5",$pass);
$clavehash=hash("SHA256",$clave1); 

$query = "UPDATE usuarios set clave_us= '$clavehash' WHERE id_usuario= '$id'";
$conexion->query($query);

header("Location: ../index.php?message=success_password");

?>