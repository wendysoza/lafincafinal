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
$pdf->Cell(100,6,utf8_decode('LISTA DE PRODUCTOS'),2,0,'C');
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(2,66,104); 
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(25,6,utf8_decode('Descripción'),1,0,'C',1); 
$pdf->Cell(21,6,utf8_decode('Categoría'),1,0,'C',1); 
$pdf->Cell(27,6,utf8_decode('Cód.barras'),1,0,'C',1);
$pdf->Cell(13,6,utf8_decode('Stock'),1,0,'C',1);
$pdf->Cell(18,6,utf8_decode('P. compra'),1,0,'C',1);
$pdf->Cell(15,6,utf8_decode('P. venta'),1,0,'C',1);
$pdf->Cell(15,6,utf8_decode('P. libra'),1,0,'C',1);
$pdf->Cell(20,6,utf8_decode('P. volumen'),1,0,'C',1);
$pdf->Cell(25,6,utf8_decode('F.V.'),1,0,'C',1);
$pdf->Cell(16,6,utf8_decode('Estado'),1,0,'C',1);
 
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Productos.php";
$usuarios = new Productos();

$rspta = $usuarios->listar();

//Table with rows and columns
$pdf->SetWidths(array(25,21,27,13,18,15,15,20,25,16));

while($reg= $rspta->fetch_object())
{  
    $descripcion = $reg->descripcion;
    $cat = $reg->cat;
    $codbarras = $reg->codbarras;
    $stock = $reg->stock;
    $preciocompra = $reg->preciocompra;
    $precioventa = $reg->precioventa;
    $preciolibra = $reg->preciolibra;
    $preciovol = $reg->preciovol;
    $fecha_venc = $reg->fecha_venc;
    
    if($reg->estado_prod == 1){
        $estado = 'Activo';
    }else{
        $estado = 'Inactivo';
    }
 	
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($descripcion),utf8_decode($cat),utf8_decode($codbarras),utf8_decode($stock),utf8_decode($preciocompra),utf8_decode($precioventa),utf8_decode($preciolibra),utf8_decode($preciovol),utf8_decode($fecha_venc),utf8_decode($estado)));
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