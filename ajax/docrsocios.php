<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Docrsocios.php";
$empleados= new Docrsocios();

$id_d_r2 = isset($_POST["id_d_r2"])? limpiarCadena($_POST["id_d_r2"]):"";
$num_oficio = isset($_POST["num_oficio"])? limpiarCadena($_POST["num_oficio"]):"";
$id_socio = isset($_POST["id_socio"])? limpiarCadena($_POST["id_socio"]):"";
$fecha = isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$observaciones = isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";
$documento_r2 = isset($_POST["documento_r2"])? limpiarCadena($_POST["documento_r2"]):"";

switch ($_GET["op"]){

    case 'guardaryeditar':
        if(!file_exists($_FILES['documento_r2']['tmp_name']) || !is_uploaded_file($_FILES['documento_r2']['tmp_name']))
        {
            $documento_r2=$_POST["imagenactual"];
        }else{
            $ext = explode(".", $_FILES["documento_r2"]["name"]);
            if($_FILES['documento_r2']['type'] == "application/pdf")
            {
                $documento_r2 = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["documento_r2"]["tmp_name"],"../files/documentosrecibidos/" . $documento_r2);
            }
        }

        if(empty($id_d_r2)){
                $rspta= $empleados->insertar($num_oficio,$id_socio,$fecha,$observaciones,$documento_r2);
                echo $rspta ? "Documento recibido registrado" : "No se pudo registrar el documento recibido";               
        }
        else{ 
                $rspta= $empleados->editar($id_d_r2,$num_oficio,$id_socio,$fecha,$observaciones,$documento_r2);
                echo $rspta ? "Documento recibido actualizado" : "No se pudo actualizar el documento recibido";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_d_r2);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_d_r2)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_d_r2.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_d_r2.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_d_r2.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_d_r2.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->num_oficio,
                "2"=>$reg->id_socio,
                "3"=>$reg->fecha,
                "4"=>$reg->observaciones,
                "5"=>($reg->estado_d_r2)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_d_r2);
            echo $rspta ? "Documento recibido desactivado" : "Documento recibido no se puede desactivar";
        break;

        case 'selectsocios':
            //Obtenemos todos los permisos de la tabla permisos
                $rspta = $empleados -> selectsocios();
                while($reg = $rspta->fetch_object())
                {
                    echo '<option  selected value=' . $reg->id_socio . '>' . $reg->nombres_s." ".$reg->apellidos_s .'</option>';
                }
            break;


    case 'activar':
            $rspta=$empleados->activar($id_d_r2);
            echo $rspta ? "Documento recibido activado" : "Documento recibido no se puede activar";
        break;
}
ob_end_flush();
?>