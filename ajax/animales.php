<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Animales.php";
$empleados= new Animales();

$id_animal = isset($_POST["id_animal"])? limpiarCadena($_POST["id_animal"]):"";
$id_cli = isset($_POST["id_cli"])? limpiarCadena($_POST["id_cli"]):"";
$id_especie = isset($_POST["id_especie"])? limpiarCadena($_POST["id_especie"]):"";
$raza = isset($_POST["raza"])? limpiarCadena($_POST["raza"]):"";
$observacion = isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if(empty($id_animal)){
                $rspta= $empleados->insertar($id_cli,$id_especie,$raza,$observacion);
                echo $rspta ? "Animal registrado" : "No se pudo registrar el animal";                
        }
        else{ 
                $rspta= $empleados->editar($id_animal,$id_cli,$id_especie,$raza,$observacion);
                echo $rspta ? "Animal actualizado" : "No se pudo actualizar el animal";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_animal);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_animal)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_animal.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_animal.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_animal.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_animal.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombres_cli,
                "2"=>$reg->especie,
                "3"=>$reg->tipo,
                "4"=>$reg->raza,
                "5"=>$reg->observacion,
                "6"=>($reg->estado_animal)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_animal);
            echo $rspta ? "Animal desactivado" : "Animal no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_animal);
            echo $rspta ? "Animal activado" : "Animal no se puede activar";
        break;

        case 'selectespecie':
            //Obtenemos todos los permisos de la tabla permisos
                $rspta = $empleados -> selectespecie();
                while($reg = $rspta->fetch_object())
                {
                    echo '<option  selected value=' . $reg->id_especie . '>' . $reg->especie ." - ".$reg->tipo .'</option>';
                }
            break;
    
        case 'selectClientes':
        
        require_once "../modelos/Clientes.php";
                $clientes = new Clientes();
                $rspta = $clientes -> select();
                while($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->id_cli . '>' . $reg->nombres_cli.' </option>';
                }
            break;
}
ob_end_flush();
?>