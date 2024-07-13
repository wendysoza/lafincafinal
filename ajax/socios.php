<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Socios.php";
$empleados= new Socios();

$id_socio = isset($_POST["id_socio"])? limpiarCadena($_POST["id_socio"]):"";
$nombres_s = isset($_POST["nombres_s"])? limpiarCadena($_POST["nombres_s"]):"";
$apellidos_s = isset($_POST["apellidos_s"])? limpiarCadena($_POST["apellidos_s"]):"";
$cedula_s = isset($_POST["cedula_s"])? limpiarCadena($_POST["cedula_s"]):"";
$id_tipo_d = isset($_POST["id_tipo_d"])? limpiarCadena($_POST["id_tipo_d"]):"";
$porc_d = isset($_POST["porc_d"])? limpiarCadena($_POST["porc_d"]):"";
$telefono_s = isset($_POST["telefono_s"])? limpiarCadena($_POST["telefono_s"]):"";
$lugar_s = isset($_POST["lugar_s"])? limpiarCadena($_POST["lugar_s"]):"";
$direccion_s = isset($_POST["direccion_s"])? limpiarCadena($_POST["direccion_s"]):"";
$necesidad = isset($_POST["necesidad"])? limpiarCadena($_POST["necesidad"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if(empty($id_socio)){

            $rsptaced = $empleados->mostrar_cedula($cedula_s);
            $cantidadced = count($rsptaced);
           
            if($cantidadced == 0){
                $rspta= $empleados->insertar($nombres_s,$apellidos_s,$cedula_s,$id_tipo_d,$porc_d,$telefono_s,$lugar_s,$direccion_s,$necesidad);
                echo $rspta ? "Socio registrado" : "No se pudo registrar el socio";
            }else{
                echo "Cédula ya está registrada";
            }                 
        }
        else{ 
            $rsptaced2 = $empleados->mostrar_cedula2($cedula_s,$id_socio);
            $cantidadced2 = count($rsptaced2);
            $rsptaced3 = $empleados->mostrar_cedula($cedula_s);
            $cantidadced3 = count($rsptaced3);

            if($cantidadced3 == 0){
                $rspta= $empleados->editar($id_socio,$nombres_s,$apellidos_s,$cedula_s,$id_tipo_d,$porc_d,$telefono_s,$lugar_s,$direccion_s,$necesidad);
                echo $rspta ? "Socio actualizado" : "No se pudo actualizar el socio";
            }else if($cantidadced2 == 1){
                $rspta= $empleados->editar($id_socio,$nombres_s,$apellidos_s,$cedula_s,$id_tipo_d,$porc_d,$telefono_s,$lugar_s,$direccion_s,$necesidad);
                echo $rspta ? "Socio actualizado" : "No se pudo actualizar el socio";
            }else{
                echo "Cédula ya está registrada";
            } 
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_socio);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_s)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_socio.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_socio.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_socio.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_socio.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombres_s,
                "2"=>$reg->apellidos_s,
                "3"=>$reg->cedula_s,
                "4"=>$reg->tipo_d,
                "5"=>$reg->porc_d,
                "6"=>$reg->telefono_s,
                "7"=>$reg->lugar_s,
                "8"=>$reg->direccion_s,
                "9"=>$reg->necesidad,
                "10"=>($reg->estado_s)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_socio);
            echo $rspta ? "Socio desactivado" : "Socio no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_socio);
            echo $rspta ? "Socio activado" : "Socio no se puede activar";
        break;

        case 'selecttipo':
            //Obtenemos todos los permisos de la tabla permisos
                $rspta = $empleados -> selecttipo();
                while($reg = $rspta->fetch_object())
                {
                    echo '<option  selected value=' . $reg->id_tipo_d . '>' . $reg->tipo_d .'</option>';
                }
            break;
}
ob_end_flush();
?>