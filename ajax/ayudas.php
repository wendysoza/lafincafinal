<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Ayudas.php";
$empleados= new Ayudas();

$id_ayuda = isset($_POST["id_ayuda"])? limpiarCadena($_POST["id_ayuda"]):"";
$descripcion = isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$cantidad = isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$existencia = isset($_POST["existencia"])? limpiarCadena($_POST["existencia"]):"";
$tamaño = isset($_POST["tamaño"])? limpiarCadena($_POST["tamaño"]):"";
$observaciones = isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";
$foto_ayuda = isset($_POST["foto_ayuda"])? limpiarCadena($_POST["foto_ayuda"]):"";

switch ($_GET["op"]){

    case 'guardaryeditar':
        if(!file_exists($_FILES['foto_ayuda']['tmp_name']) || !is_uploaded_file($_FILES['foto_ayuda']['tmp_name']))
        {
            $foto_ayuda=$_POST["imagenactual"];
        }else{
            $ext = explode(".", $_FILES["foto_ayuda"]["name"]);
            if($_FILES['foto_ayuda']['type'] == "image/jpg" || $_FILES['foto_ayuda']['type'] == "image/jpeg" || $_FILES['foto_ayuda']['type'] == "image/png")
            {
                $foto_ayuda = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["foto_ayuda"]["tmp_name"],"../files/ayudastec/" . $foto_ayuda);
            }
        }

        if(empty($id_ayuda)){
                $rspta= $empleados->insertar($descripcion,$cantidad,$existencia,$tamaño,$observaciones,$foto_ayuda);
                echo $rspta ? "Ayuda técnica registrada" : "No se pudo registrar la ayuda técnica";               
        }
        else{ 
                $rspta= $empleados->editar($id_ayuda,$descripcion,$cantidad,$existencia,$tamaño,$observaciones,$foto_ayuda);
                echo $rspta ? "Ayuda técnica actualizada" : "No se pudo actualizar la ayuda técnica";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_ayuda);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_ayuda)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_ayuda.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_ayuda.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_ayuda.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_ayuda.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->descripcion,
                "2"=>$reg->cantidad,
                "3"=>$reg->existencia,
                "4"=>$reg->tamaño,
                "5"=>$reg->observaciones,
                "6"=>"<img src ='../files/ayudastec/".$reg->foto_ayuda."' height='50px', width='50px'>",
                "7"=>($reg->estado_ayuda)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_ayuda);
            echo $rspta ? "Ayuda técnica desactivada" : "Ayuda técnica no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_ayuda);
            echo $rspta ? "Ayuda técnica activada" : "Ayuda técnica no se puede activar";
        break;
}
ob_end_flush();
?>