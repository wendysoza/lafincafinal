<?php 
require_once "global.php";

$conexion=new mysqli(DB_HOST, DB_USERNAME,DB_PASSWORD,DB_NAME);

mysqli_query( $conexion, 'SET NAMES "'.DB_ENCODE.'"');

//Si tenemos un posible error en la conexión, lo mostramos
if (mysqli_connect_errno())
{
	printf("Falló conexión a la base de datos: %s\n", mysqli_conect_error());
	exit();
}

if(!function_exists('ejecutarConsulta')){
	function ejecutarConsulta($sql){
		global $conexion;
		$query = $conexion->query($sql);
		return $query;
	}

	function ejecutarConsultaSimpleFila($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$row = $query->fetch_assoc();
		return $row;	
	}

	function ejecutarConsulta_retornarID($sql){
		global $conexion;
		$query = $conexion->query($sql);
		return $conexion->insert_id;
	}

	function ejecutarConsulta_retornarID2($sql){
		global $conexion;
		$query = $conexion->query($sql);
		return $conexion->insert_id;
	}


	function limpiarCadena($str){
		global $conexion;
		$str = mysqli_real_escape_string($conexion,trim($str));
		return htmlspecialchars($str);
	}

	function ejecutarConsultaContar($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$empleados = $query->fetch_all(MYSQLI_ASSOC);
		return $empleados;
	}

	function ejecutarConsultaContarE($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$compras = $query->fetch_all(MYSQLI_ASSOC);
		return $compras;
	}

	function ejecutarConsultaContar2($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$empleados = $query->fetch_all(MYSQLI_ASSOC);
		return $stockP;
	}

	function ejecutarConsultaID1($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['id_admin_c'];
	}

	function ejecutarConsultaIDprof($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['id_prof'];
	}

	function ejecutarConsultaprom($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['promedio'];
	}

	function ejecutarConsultaprom2($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['promedio2'];
	}

	function ejecutarConsultaIDdato($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['id_dato'];
	}

	function ejecutarConsultaIDV($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['id_admi_v'];
	}

	function ejecutarConsultaID2($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['id_prof'];
	}

	function ejecutarConsultaID3($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['id_tema'];
	}

	function ejecutarConsultaID4($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['anio'];
	}

	function ejecutarConsultaID5($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['recargo'];
	}

	function ejecutarConsultaID6($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['prontopago'];
	}

	function ejecutarConsultaID7($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['interespormora'];
	}

	function ejecutarConsultaIDCantidad($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$campo = $query->fetch_array();
		return $campo['cant'];
	}
	
}
?>