<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

require_once('../config/Conexion.php'); 
$email = $_POST['cedula1'];
  
$query = "SELECT * FROM usuarios where cedula_usuario = '$email'";
$result = $conexion->query($query);
$row = $result->fetch_assoc();

if($result->num_rows > 0){
  $mail = new PHPMailer(true);
  
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp-mail.outlook.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'aqui va tu correo de hotmail';
    $mail->Password   = 'aqui va tu clave de hotmail';
    $mail->Port       = 587;
    
    $mail->setFrom('aqui va tu correo de hotmail', 'La Finca');
    $mail->addAddress($row['email_usuario']);
    $mail->isHTML(true);
    $mail->Subject = 'Recuperacion de contrasena';
    $mail->Body    = 'Hola, '.$row['nombre_usuario'].' has solicitado el cambio de tu contrasena, por favor, da click en el siguiente link  <a href="http://localhost/lafincafinal/vistas/cambiarclave.php?id='.$row['id_usuario'].'">Recuperacion de contrasena</a> para realizar el cambio correspondiente';

    $mail->send();
    header("Location: ../vistas/login.php?message=ok");
} catch (Exception $e) {
  header("Location: ../vistas/login.php?message=error");
}

}else{
  header("Location: ../vistas/login.php?message=not_found");
}

?>
