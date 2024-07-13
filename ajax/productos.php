<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Productos.php";
$empleados= new Productos();

$id_prod = isset($_POST["id_prod"])? limpiarCadena($_POST["id_prod"]):"";
$id_cat = isset($_POST["id_cat"])? limpiarCadena($_POST["id_cat"]):"";
$descripcion = isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$codbarras = isset($_POST["codbarras"])? limpiarCadena($_POST["codbarras"]):"";
$stock = isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$preciocompra = isset($_POST["preciocompra"])? limpiarCadena($_POST["preciocompra"]):"";
$precioventa = isset($_POST["precioventa"])? limpiarCadena($_POST["precioventa"]):"";
$preciolibra = isset($_POST["preciolibra"])? limpiarCadena($_POST["preciolibra"]):"";
$preciovol = isset($_POST["preciovol"])? limpiarCadena($_POST["preciovol"]):"";
$fecha_venc = isset($_POST["fecha_venc"])? limpiarCadena($_POST["fecha_venc"]):"";
$nombreproductor = isset($_POST["nombreproductor"])? limpiarCadena($_POST["nombreproductor"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if(empty($id_prod)){
                $rspta= $empleados->insertar($id_cat,$descripcion,$codbarras,$stock,$preciocompra,$precioventa,$preciolibra,$preciovol,$fecha_venc,$nombreproductor);
                echo $rspta ? "Producto registrado" : "No se pudo registrar el producto";                
        }
        else{ 
                $rspta= $empleados->editar($id_prod,$id_cat,$descripcion,$codbarras,$stock,$preciocompra,$precioventa,$preciolibra,$preciovol,$fecha_venc,$nombreproductor);
                echo $rspta ? "Producto actualizado" : "No se pudo actualizar el producto";
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_prod);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_prod)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_prod.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_prod.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_prod.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_prod.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->descripcion,
                "2"=>$reg->cat,
                "3"=>$reg->codbarras,
                "4"=>$reg->stock,
                "5"=>$reg->preciocompra,
                "6"=>$reg->precioventa,
                "7"=>$reg->fecha_venc,
                "8"=>$reg->nombreproductor,
                "9"=>($reg->estado_prod)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_prod);
            echo $rspta ? "Producto desactivado" : "Producto no se puede desactivar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_prod);
            echo $rspta ? "Producto activado" : "Producto no se puede activar";
        break;

        case 'selectcat':
            //Obtenemos todos los permisos de la tabla permisos
                $rspta = $empleados -> selectcat();
                while($reg = $rspta->fetch_object())
                {
                    echo '<option  selected value=' . $reg->id_cat . '>' . $reg->cat .'</option>';
                }
            break;
}
ob_end_flush();
?>