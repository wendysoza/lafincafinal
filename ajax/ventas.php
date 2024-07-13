<?php
require_once "../modelos/Ventas.php";
if(strlen(session_id()) < 1)
	session_start();

$ventas= new Ventas();

$id_cabecera = isset($_POST["id_cabecera"])? limpiarCadena($_POST["id_cabecera"]):"";
$fecha = isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$id_cliente = isset($_POST["id_cliente"])? limpiarCadena($_POST["id_cliente"]):"";
$id_empleado = $_SESSION["id_usuario"];
$total_venta = isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";
$iva = isset($_POST["iva"])? limpiarCadena($_POST["iva"]):"";
$dcto = isset($_POST["dcto"])? limpiarCadena($_POST["dcto"]):"";
$total_venta_final = isset($_POST["total_venta_final"])? limpiarCadena($_POST["total_venta_final"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        //si el id esta vacio --empty
         if(empty($id_cabecera)){
                $rspta= $ventas->insertar($fecha,$id_cliente,$id_empleado,$total_venta,$iva,$dcto,$total_venta_final,$_POST["id_prod"],$_POST["cantidad"],$_POST["valor_venta"]);
                echo $rspta ? "Venta Registrada": "No se pudo registrar la venta";
        }
        else{
        }   
        break;

    case 'mostrar':
        $rspta=$ventas->mostrar($id_cabecera);
        echo json_encode($rspta);
        break;
       

    case 'listarDetalle':
        //Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $ventas->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Valor Venta</th>
                                    <th>Dcto</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
				 	echo '<tr class="filas"><td></td><td>'.$reg->descripcion.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->valor_venta.'</td><td>'.ROUND(((($reg->valor_venta-($reg->valor_venta))*$reg->cantidad)),2).'</td></tr>';
					$total_s=ROUND($total_s+(($reg->valor_venta*$reg->cantidad)),2);
                    $iva_r = ROUND($total_s * ($reg->iva),2);
                    $dcto = $reg->dcto;
                    $total2=($total_s+$iva_r) - $dcto;
				}     
                echo '<tfoot>
                <th>TOTAL FINAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th><h4 id="total">$ '.$total2.'</h4>
            </tfoot>';

            echo '<tfoot>
            <th>TOTAL</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><h4 id="total">$ '.$total_s.'</h4>
        </tfoot>';

        echo '<tfoot>
        <th>I.V.A.</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><h4 id="total">$ '.$iva_r.'</h4>
    </tfoot>';

    echo '<tfoot>
        <th>DESCUENTO</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><h4 id="total">$ '.$dcto.'</h4>
    </tfoot>';
                  
        break;

    case 'listar':
        $fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];

        $rspta=$ventas->listar($fecha_inicio,$fecha_fin);
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla

            $url2='../reportes/Ticketventa.php?id=';

            $data[]=array(
                "0"=>$reg->id_cabecera,
                "1"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_cabecera.')"><i class="fa fa-eye"></i></button>'.
                '<a target="_blank" href="'.$url2.$reg->id_cabecera.'"> <button class="btn btn-success"><i class="fa fa-file"></i></button></a>'.
                ' <button class="btn btn-danger" onclick="anular('.$reg->id_cabecera.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_cabecera.')"><i class="fa fa-eye"></i></button>'),
                "2"=>$reg->fecha,
                "3"=>$reg->nombres_cli,
                "4"=>$reg->nombre_usuario.' '.$reg->apellido_usuario,
                "5"=>$reg->total_venta_final,
                "6"=>($reg->estado=='Aceptado' || $reg->estado=='Pendiente')?'<span class="label bg-green">'.$reg->estado.'</span>':'<span class="label bg-red">Anulado</span>'
            );
        }

        $results = array(
            "sEcho"=>1, 
            "iTotalRecords"=>count($data), //enviar total de registros al datatable
            "iTotalDisplayRecords"=>count($data), //envio total de registros a visualizar
            "aaData"=>$data
        );
        echo json_encode($results);

        break;

    case 'anular':
            $rspta=$ventas->anular($id_cabecera);
            echo $rspta ? "Venta anulada" : "Venta no se puede anular";
        break;

    case 'selectClientes':
        
        require_once "../modelos/Clientes.php";
                $clientes = new Clientes();
                $rspta = $clientes -> select();
                while($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->id_cli . '>'  . $reg->cedula_cli." - ". $reg->nombres_cli.' </option>';
                }
            break;

    case 'listarProductos':
       
        $rspta=$ventas->listarProductos();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->id_prod.',\''.$reg->id_cat.'\',\''.$reg->codbarras.'\',\''.$reg->descripcion.'\',\''.$reg->precioventa.'\',\''.$reg->stock.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->codbarras,
                "2"=>$reg->descripcion,
                "3"=>$reg->stock,
                "4"=>$reg->cat,
                "5"=>$reg->precioventa
            );
        }

        $results = array(
            "sEcho"=>1, 
            "iTotalRecords"=>count($data), //enviar total de registros al datatable
            "iTotalDisplayRecords"=>count($data), //envio total de registros a visualizar
            "aaData"=>$data
        );
        echo json_encode($results);
        break;

        case 'verserie':
            $rspta=$ventas->verserie();
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
            break;
}

?>