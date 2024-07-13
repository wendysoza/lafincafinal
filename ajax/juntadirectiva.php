<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Juntadirectiva.php";
$empleados= new Junta();

$id_junta = isset($_POST["id_junta"])? limpiarCadena($_POST["id_junta"]):"";
$presidente = isset($_POST["presidente"])? limpiarCadena($_POST["presidente"]):"";
$vicepres = isset($_POST["vicepres"])? limpiarCadena($_POST["vicepres"]):"";
$secretaria = isset($_POST["secretaria"])? limpiarCadena($_POST["secretaria"]):"";
$tesorero = isset($_POST["tesorero"])? limpiarCadena($_POST["tesorero"]):"";
$primer_v = isset($_POST["primer_v"])? limpiarCadena($_POST["primer_v"]):"";
$segundo_v = isset($_POST["segundo_v"])? limpiarCadena($_POST["segundo_v"]):"";
$tercer_v = isset($_POST["tercer_v"])? limpiarCadena($_POST["tercer_v"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if(empty($id_junta)){
           
                            $rspta= $empleados->insertar($presidente,$vicepres,$secretaria,$tesorero,$primer_v,$segundo_v,$tercer_v);
                            echo $rspta ? "Junta directiva registrada" : "No se pudo registrar la junta directiva";
        }
        else{ 
                $rspta= $empleados->editar($id_junta,$presidente,$vicepres,$secretaria,$tesorero,$primer_v,$segundo_v,$tercer_v);
                 echo $rspta ? "Junta directiva actualizada" : "No se pudo actualizar la junta directiva";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_junta);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->id_junta.')"><i class="fa fa-eye"></i></button>',
                "1"=>$reg->presidente,
                "2"=>$reg->vicepres,
                "3"=>$reg->secretaria,
                "4"=>$reg->tesorero,
                "5"=>$reg->primer_v,
                "6"=>$reg->segundo_v,
                "7"=>$reg->tercer_v
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
}
ob_end_flush();
?>