<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Ingresos.php";
$empleados= new Ingresos();

$id_ingreso = isset($_POST["id_ingreso"])? limpiarCadena($_POST["id_ingreso"]):"";
$fecha_i = isset($_POST["fecha_i"])? limpiarCadena($_POST["fecha_i"]):"";
$descripcion = isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$cantidad = isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";

switch ($_GET["op"]){

    case 'guardaryeditar':

        if(empty($id_ingreso)){
                $rspta= $empleados->insertar($fecha_i,$descripcion,$cantidad);
                echo $rspta ? "Ingreso registrado" : "No se pudo registrar el ingreso";               
        }
        else{ 
                $rspta= $empleados->editar($id_ingreso,$fecha_i,$descripcion,$cantidad);
                echo $rspta ? "Ingreso actualizado" : "No se pudo actualizar el ingreso";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_ingreso);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_ingreso)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_ingreso.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_ingreso.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_ingreso.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_ingreso.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->fecha_i,
                "2"=>$reg->descripcion,
                "3"=>$reg->cantidad,
                "4"=>($reg->estado_ingreso)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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

        case 'desactivar':
            $rspta=$empleados->desactivar($id_ingreso);
            echo $rspta ? "Ingreso desactivado" : "Ingreso no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_ingreso);
            echo $rspta ? "Ingreso activado" : "Ingreso no se puede activar";
        break;
}
ob_end_flush();
?>