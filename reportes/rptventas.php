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
if ($_SESSION['administrador']==1 || $_SESSION['secretaria']==1)
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
$pdf->Cell(100,6,utf8_decode('LISTA DE VENTAS'),2,0,'C');
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(2,66,104); 
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(37,6,utf8_decode('Fecha'),1,0,'C',1); 
$pdf->Cell(46,6,utf8_decode('Cliente'),1,0,'C',1); 
$pdf->Cell(50,6,utf8_decode('Empleado'),1,0,'C',1);
$pdf->Cell(25,6,utf8_decode('Total'),1,0,'C',1);
$pdf->Cell(32,6,utf8_decode('Estado'),1,0,'C',1);
 
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Ventas.php";
$usuarios = new Ventas();

$fecha_inicio=$_REQUEST["fecha_inicio"];
$fecha_fin=$_REQUEST["fecha_fin"];

$rspta = $usuarios->listar($fecha_inicio,$fecha_fin);

//Table with rows and columns
$pdf->SetWidths(array(37,46,50,25,32));

while($reg= $rspta->fetch_object())
{  
    $fecha = $reg->fecha;
    $nombres_cli = $reg->nombres_cli;
    $nombre_usuario = $reg->nombre_usuario;
    $apellido_usuario = $reg->apellido_usuario;
    $total_venta_final = $reg->total_venta_final;
    $estado = $reg->estado;
 	
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($fecha),utf8_decode($nombres_cli),utf8_decode($nombre_usuario)." ".utf8_decode($apellido_usuario),utf8_decode($total_venta_final),utf8_decode($estado)));
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