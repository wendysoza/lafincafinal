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
$pdf->Cell(100,6,utf8_decode('LISTA DE VACUNACIONES'),2,0,'C');
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(2,66,104); 
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(30,6,utf8_decode('Vacuna'),1,0,'C',1); 
$pdf->Cell(40,6,utf8_decode('Animal - Dueño'),1,0,'C',1); 
$pdf->Cell(25,6,utf8_decode('Fecha Vac.'),1,0,'C',1);
$pdf->Cell(25,6,utf8_decode('Fecha Revac.'),1,0,'C',1);
$pdf->Cell(25,6,utf8_decode('Lote'),1,0,'C',1);
$pdf->Cell(25,6,utf8_decode('Num registro'),1,0,'C',1);
$pdf->Cell(20,6,utf8_decode('Laboratorio'),1,0,'C',1);
 
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Vacunacion.php";
$usuarios = new Vacunacion();

$rspta = $usuarios->listar();

//Table with rows and columns
$pdf->SetWidths(array(30,40,25,25,25,25,20));

while($reg= $rspta->fetch_object())
{  
    $descripcion = $reg->descripcion;
    $nombres_cli = $reg->nombres_cli;
    $especie = $reg->especie;
    $fecha_vac = $reg->fecha_vac;
    $fecha_revac = $reg->fecha_revac;
    $lote = $reg->lote;
    $num_reg = $reg->num_reg;
    $laboratorio = $reg->laboratorio;

 	
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($descripcion),utf8_decode($especie).utf8_decode(" - Dueño: ").utf8_decode($nombres_cli),utf8_decode($fecha_vac),utf8_decode($fecha_revac),utf8_decode($lote),utf8_decode($num_reg),utf8_decode($laboratorio)));
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