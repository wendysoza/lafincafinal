<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Categorias.php";
$empleados= new Categorias();

$id_cat = isset($_POST["id_cat"])? limpiarCadena($_POST["id_cat"]):"";
$cat = isset($_POST["cat"])? limpiarCadena($_POST["cat"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if(empty($id_cat)){
            
                $rspta= $empleados->insertar($cat);
                echo $rspta ? "Categoría registrada" : "No se pudo registrar la categoría";
                        
        }
        else{ 
                $rspta= $empleados->editar($id_cat,$cat);
                echo $rspta ? "Categoría actualizada" : "No se pudo actualizar la categoría";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_cat);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_cat)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_cat.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_cat.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_cat.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_cat.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->cat,
                "2"=>($reg->estado_cat)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_cat);
            echo $rspta ? "Categoría desactivada" : "Categoría no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_cat);
            echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
        break;
}
ob_end_flush();
?>