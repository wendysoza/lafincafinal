<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Clientes.php";
$empleados= new Clientes();

$id_cli = isset($_POST["id_cli"])? limpiarCadena($_POST["id_cli"]):"";
$nombres_cli = isset($_POST["nombres_cli"])? limpiarCadena($_POST["nombres_cli"]):"";
$cedula_cli = isset($_POST["cedula_cli"])? limpiarCadena($_POST["cedula_cli"]):"";
$telefono_cli = isset($_POST["telefono_cli"])? limpiarCadena($_POST["telefono_cli"]):"";
$direccion_cli = isset($_POST["direccion_cli"])? limpiarCadena($_POST["direccion_cli"]):"";
$email_cli = isset($_POST["email_cli"])? limpiarCadena($_POST["email_cli"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if(empty($id_cli)){
                $rspta= $empleados->insertar($nombres_cli,$cedula_cli,$telefono_cli,$direccion_cli,$email_cli);
                echo $rspta ? "Cliente registrado" : "No se pudo registrar el cliente";                
        }
        else{ 
                $rspta= $empleados->editar($id_cli,$nombres_cli,$cedula_cli,$telefono_cli,$direccion_cli,$email_cli);
                echo $rspta ? "Cliente actualizado" : "No se pudo actualizar el cliente";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_cli);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_cli)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_cli.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_cli.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_cli.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_cli.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombres_cli,
                "2"=>$reg->cedula_cli,
                "3"=>$reg->telefono_cli,
                "4"=>$reg->direccion_cli,
                "5"=>$reg->email_cli,
                "6"=>($reg->estado_cli)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_cli);
            echo $rspta ? "Cliente desactivado" : "Cliente no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_cli);
            echo $rspta ? "Cliente activado" : "Cliente no se puede activar";
        break;
}
ob_end_flush();
?>