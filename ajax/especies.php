<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Especies.php";
$empleados= new Especies();

$id_especie = isset($_POST["id_especie"])? limpiarCadena($_POST["id_especie"]):"";
$id_tipo = isset($_POST["id_tipo"])? limpiarCadena($_POST["id_tipo"]):"";
$especie = isset($_POST["especie"])? limpiarCadena($_POST["especie"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if(empty($id_especie)){
            
                $rspta= $empleados->insertar($id_tipo,$especie);
                echo $rspta ? "Especie registrada" : "No se pudo registrar la especie";
                        
        }
        else{ 
                $rspta= $empleados->editar($id_especie,$id_tipo,$especie);
                echo $rspta ? "Especie actualizada" : "No se pudo actualizar la especie";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_especie);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_especie)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_especie.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_especie.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_especie.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_especie.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->especie,
                "2"=>$reg->tipo,
                "3"=>($reg->estado_especie)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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

        case 'selecttipo':
            //Obtenemos todos los permisos de la tabla permisos
                $rspta = $empleados -> selecttipo();
                while($reg = $rspta->fetch_object())
                {
                    echo '<option  selected value=' . $reg->id_tipo . '>' . $reg->tipo .'</option>';
                }
            break;

        case 'desactivar':
            $rspta=$empleados->desactivar($id_especie);
            echo $rspta ? "Especie desactivada" : "Especie no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_especie);
            echo $rspta ? "Especie activada" : "Especie no se puede activar";
        break;
}
ob_end_flush();
?>