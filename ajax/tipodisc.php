<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Tipodisc.php";
$empleados= new Tipodisc();

$id_tipo_d = isset($_POST["id_tipo_d"])? limpiarCadena($_POST["id_tipo_d"]):"";
$tipo_d = isset($_POST["tipo_d"])? limpiarCadena($_POST["tipo_d"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if(empty($id_tipo_d)){
            
                $rspta= $empleados->insertar($tipo_d);
                echo $rspta ? "Tipo de discapacidad registrado" : "No se pudo registrar el tipo de discapacidad";
                        
        }
        else{ 
                $rspta= $empleados->editar($id_tipo_d,$tipo_d);
                echo $rspta ? "Tipo de discapacidad actualizado" : "No se pudo actualizar el tipo de discapacidad";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_tipo_d);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_tipo_d)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_tipo_d.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_tipo_d.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_tipo_d.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_tipo_d.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->tipo_d,
                "2"=>($reg->estado_tipo_d)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_tipo_d);
            echo $rspta ? "Tipo de discapacidad desactivado" : "Tipo de discapacidad no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_tipo_d);
            echo $rspta ? "Tipo de discapacidad activado" : "Tipo de discapacidad no se puede activar";
        break;
}
ob_end_flush();
?>