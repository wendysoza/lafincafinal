<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Docenviados.php";
$empleados= new Docenviados();

$id_doc_e = isset($_POST["id_doc_e"])? limpiarCadena($_POST["id_doc_e"]):"";
$num_oficio = isset($_POST["num_oficio"])? limpiarCadena($_POST["num_oficio"]):"";
$cargo = isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$para = isset($_POST["para"])? limpiarCadena($_POST["para"]):"";
$fecha = isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$observaciones = isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";
$documento_e = isset($_POST["documento_e"])? limpiarCadena($_POST["documento_e"]):"";

switch ($_GET["op"]){

    case 'guardaryeditar':
        if(!file_exists($_FILES['documento_e']['tmp_name']) || !is_uploaded_file($_FILES['documento_e']['tmp_name']))
        {
            $documento_e=$_POST["imagenactual"];
        }else{
            $ext = explode(".", $_FILES["documento_e"]["name"]);
            if($_FILES['documento_e']['type'] == "application/pdf")
            {
                $documento_e = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["documento_e"]["tmp_name"],"../files/documentosenviados/" . $documento_e);
            }
        }

        if(empty($id_doc_e)){
                $rspta= $empleados->insertar($num_oficio,$cargo,$para,$fecha,$observaciones,$documento_e);
                echo $rspta ? "Documento enviado registrado" : "No se pudo registrar el documento enviado";               
        }
        else{ 
                $rspta= $empleados->editar($id_doc_e,$num_oficio,$cargo,$para,$fecha,$observaciones,$documento_e);
                echo $rspta ? "Documento enviado actualizado" : "No se pudo actualizar el documento enviado";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_doc_e);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_doc_e)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_doc_e.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_doc_e.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_doc_e.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_doc_e.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->num_oficio,
                "2"=>$reg->cargo,
                "3"=>$reg->para,
                "4"=>$reg->fecha,
                "5"=>$reg->observaciones,
                "6"=>($reg->estado_doc_e)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_doc_e);
            echo $rspta ? "Documento enviado desactivado" : "Documento enviado no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_doc_e);
            echo $rspta ? "Documento enviado activado" : "Documento enviado no se puede activar";
        break;
}
ob_end_flush();
?>