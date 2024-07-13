<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre_usuario"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['administrador']==1)
{

//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table.php');
 
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table();
 
//Agregamos la primera página al documento pdf
$pdf->AddPage();
 
//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
 
//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->Image("../files/PLANTILLA.png",-3,1, 214, 45);
$pdf->cell(80);
$pdf->Ln(50);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('LISTA DE USUARIOS'),2,0,'C');
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(2,66,104); 
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(23,6,utf8_decode('Cédula'),1,0,'C',1); 
$pdf->Cell(21,6,utf8_decode('Nombres'),1,0,'C',1); 
$pdf->Cell(22,6,utf8_decode('Apellidos'),1,0,'C',1);
$pdf->Cell(21,6,utf8_decode('Teléfono'),1,0,'C',1);
$pdf->Cell(21,6,utf8_decode('Dirección'),1,0,'C',1);
$pdf->Cell(21,6,utf8_decode('Email'),1,0,'C',1);
$pdf->Cell(16,6,utf8_decode('Usuario'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Rol'),1,0,'C',1);
 
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Usuario.php";
$usuarios = new Usuario();

$rspta = $usuarios->listarreporte();

//Table with rows and columns
$pdf->SetWidths(array(23,21,22,21,21,21,16,45));

while($reg= $rspta->fetch_object())
{  
    $cedula_usuario = $reg->cedula_usuario;
    $nombre_usuario = $reg->nombre_usuario;
    $apellido_usuario = $reg->apellido_usuario;
    $telefono_usuario = $reg->telefono_usuario;
    $direccion_usuario = $reg->direccion_usuario;
    $email_usuario = $reg->email_usuario;
    $login = $reg->login_us;
    $permiso =$reg->nombre;
 	
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($cedula_usuario),utf8_decode($nombre_usuario),utf8_decode($apellido_usuario),utf8_decode($telefono_usuario),utf8_decode($direccion_usuario),utf8_decode($email_usuario),utf8_decode($login),utf8_decode($permiso)));
}
 
//Mostramos el documento pdf
$pdf->Output();

?>
<?php
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>