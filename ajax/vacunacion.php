<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Vacunacion.php";
$empleados= new Vacunacion();

$id_vac = isset($_POST["id_vac"])? limpiarCadena($_POST["id_vac"]):"";
$id_prod = isset($_POST["id_prod"])? limpiarCadena($_POST["id_prod"]):"";
$id_animal = isset($_POST["id_animal"])? limpiarCadena($_POST["id_animal"]):"";
$edad = isset($_POST["edad"])? limpiarCadena($_POST["edad"]):"";
$peso = isset($_POST["peso"])? limpiarCadena($_POST["peso"]):"";
$fecha_vac = isset($_POST["fecha_vac"])? limpiarCadena($_POST["fecha_vac"]):"";
$fecha_revac = isset($_POST["fecha_revac"])? limpiarCadena($_POST["fecha_revac"]):"";
$lote = isset($_POST["lote"])? limpiarCadena($_POST["lote"]):"";
$num_reg = isset($_POST["num_reg"])? limpiarCadena($_POST["num_reg"]):"";
$laboratorio = isset($_POST["laboratorio"])? limpiarCadena($_POST["laboratorio"]):"";


switch ($_GET["op"]){
    case 'guardaryeditar':
        if(empty($id_vac)){
                $rspta= $empleados->insertar($id_prod,$id_animal,$edad,$peso,$fecha_vac,$fecha_revac,$lote,$num_reg,$laboratorio);
                echo $rspta ? "Vacunación registrada" : "No se pudo registrar la vacunación";                
        }
        else{ 
                $rspta= $empleados->editar($id_vac,$id_prod,$id_animal,$edad,$peso,$fecha_vac,$fecha_revac,$lote,$num_reg,$laboratorio);
                echo $rspta ? "Vacunación actualizada" : "No se pudo actualizar la vacunación";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_vac);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_vac)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_vac.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_vac.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_vac.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_vac.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->descripcion,
                "2"=>$reg->especie." - Dueño: ".$reg->nombres_cli,
                "3"=>$reg->fecha_vac,
                "4"=>$reg->fecha_revac,
                "5"=>$reg->lote,
                "6"=>$reg->num_reg,
                "7"=>$reg->laboratorio,
                "8"=>($reg->estado_vac)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_vac);
            echo $rspta ? "Vacunación desactivada" : "Vacunación no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_vac);
            echo $rspta ? "Vacunación activada" : "Vacunación no se puede activar";
        break;

        case 'selectproductos':
            //Obtenemos todos los permisos de la tabla permisos
                $rspta = $empleados -> selectproductos();
                while($reg = $rspta->fetch_object())
                {
                    echo '<option  selected value=' . $reg->id_prod . '>' . $reg->descripcion .'</option>';
                }
            break;
    
        case 'selectanimales':
                $rspta = $empleados -> selectanimales();
                while($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->id_animal . '>' . $reg->especie. " - Dueño: ".$reg->nombres_cli.' </option>';
                }
            break;
}
ob_end_flush();
?>