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
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">
<?php

//Incluímos la clase Venta
require_once "../modelos/Ventas.php";
//Instanaciamos a la clase con el objeto venta
$ventas = new Ventas();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $ventas->ventacabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetch_object();

//Establecemos los datos de la empresa
$empresa = "LA FINCA";
$direccion = "Cantón Paján";
$telefono = "0000000000";
$email = "lafinca@hotmail.es";

?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="300px" class="operaciones">
    <tr>
        <td align="center" class="operaciones">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        .::<strong> <?php echo $empresa; ?></strong>::.<br>
        <?php echo $direccion .' - '.$telefono; ?><br>
        </td>
    </tr>
    <tr>
        <td align="center"><?php echo $reg->fecha; ?></td>
    </tr>
    <tr>
      <td align="center"></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <td>Cliente: <?php echo $reg->nombre_usuario." ".$reg->apellido_usuario; ?></td>
    </tr>
    <tr>
        <td><?php echo "Cédula: ".$reg->cedula_usuario ?></td>
    </tr>
    <tr>
        <td>Nº de venta: <?php echo $reg->id_cabecera ; ?></td>
    </tr>    
</table>
<br>
<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="300px">
    <tr>
        <td>CANT.</td>
        <td>DESCRIPCIÓN</td>
        <td align="right">SUBTOTAL</td>
    </tr>
    <tr>
      <td colspan="3">==========================================</td>
    </tr>
    <?php
    $rsptad = $ventas->ventadetalle($_GET["id"]);
    $cantidad=0;
    while ($regd = $rsptad->fetch_object()) {
        echo "<tr>";
        echo "<td>".$regd->cantidad."</td>";
        echo "<td>".$regd->descripcion;
        echo "<td align='right'>S/ ".$regd->subtotal."</td>";
        echo "</tr>";
        $cantidad+=$regd->cantidad;
    }
    ?>
    <!-- Mostramos los totales de la venta en el documento HTML -->
    <tr>
    <td>&nbsp;</td>
    <td align="right"><b>TOTAL:</b></td>
    <td align="right"><b>S/  <?php echo $reg->total_venta_final;  ?></b></td>
    </tr>
    <tr>
      <td colspan="3">Nº de artículos: <?php echo $cantidad; ?></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>      
    <tr>
      <td colspan="3" align="center">¡Gracias por su compra!</td>
    </tr>
    <tr>
      <td colspan="3" align="center">LA FINCA</td>
    </tr>
    <tr>
      <td colspan="3" align="center">Paján - Ecuador</td>
    </tr>
    
</table>
<br>
</div>
<p>&nbsp;</p>

</body>
</html>
<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>