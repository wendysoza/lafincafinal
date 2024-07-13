<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Gastos.php";
$empleados= new Gastos();

$id_gasto = isset($_POST["id_gasto"])? limpiarCadena($_POST["id_gasto"]):"";
$fecha_g = isset($_POST["fecha_g"])? limpiarCadena($_POST["fecha_g"]):"";
$descripcion = isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$cantidad = isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$v_u = isset($_POST["v_u"])? limpiarCadena($_POST["v_u"]):"";
$v_t = isset($_POST["v_t"])? limpiarCadena($_POST["v_t"]):"";

switch ($_GET["op"]){

    case 'guardaryeditar':

        if(empty($id_gasto)){
                $rspta= $empleados->insertar($fecha_g,$cantidad,$descripcion,$v_u,$v_t);
                echo $rspta ? "Gasto registrado" : "No se pudo registrar el gasto";               
        }
        else{ 
                $rspta= $empleados->editar($id_gasto,$fecha_g,$cantidad,$descripcion,$v_u,$v_t);
                echo $rspta ? "Gasto actualizado" : "No se pudo actualizar el gasto";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_gasto);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_gasto)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_gasto.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_gasto.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_gasto.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_gasto.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->fecha_g,
                "2"=>$reg->cantidad,
                "3"=>$reg->descripcion,
                "4"=>$reg->v_u,
                "5"=>$reg->v_t,
                "6"=>($reg->estado_gasto)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_gasto);
            echo $rspta ? "Gasto desactivado" : "Gasto no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_gasto);
            echo $rspta ? "Gasto activado" : "Gasto no se puede activar";
        break;
}
ob_end_flush();
?>