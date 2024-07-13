<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Socios
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function mostrar_cedula($cedula_s)
	{
		$sql="SELECT * FROM socios WHERE cedula_s = '$cedula_s'";
		return ejecutarConsultaContar($sql);
	}

	public function mostrar_cedula2($cedula_s, $id_socio)
	{
		$sql="SELECT * FROM socios WHERE cedula_s = '$cedula_s' and id_socio = '$id_socio'";
		return ejecutarConsultaContar($sql);
	}

	//Implementamos un método para insertar registros
	public function insertar($nombres_s,$apellidos_s,$cedula_s,$id_tipo_d,$porc_d,$telefono_s,$lugar_s,$direccion_s,$necesidad)
	{
		$sql="INSERT INTO socios (nombres_s,apellidos_s,cedula_s,id_tipo_d,porc_d,telefono_s,lugar_s,direccion_s,necesidad,estado_s)
		VALUES ('$nombres_s','$apellidos_s','$cedula_s','$id_tipo_d','$porc_d','$telefono_s','$lugar_s','$direccion_s','$necesidad','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_socio,$nombres_s,$apellidos_s,$cedula_s,$id_tipo_d,$porc_d,$telefono_s,$lugar_s,$direccion_s,$necesidad)
	{
		$sql="UPDATE socios SET nombres_s = '$nombres_s', apellidos_s='$apellidos_s',cedula_s='$cedula_s',id_tipo_d='$id_tipo_d',
		porc_d='$porc_d',telefono_s='$telefono_s',
		lugar_s='$lugar_s',direccion_s='$direccion_s',necesidad='$necesidad' WHERE id_socio='$id_socio'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_socio)
	{
		$sql="UPDATE socios SET estado_s='0' WHERE id_socio='$id_socio'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_socio)
	{
		$sql="UPDATE socios SET estado_s='1' WHERE id_socio='$id_socio'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_socio)
	{
		$sql="SELECT * FROM socios WHERE id_socio ='$id_socio'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM socios s, tipo_discapacidad td where s.id_tipo_d = td.id_tipo_d";
		return ejecutarConsulta($sql);		
	}

	public function selecttipo(){
		$sql="SELECT * from tipo_discapacidad where estado_tipo_d = '1'";
		return ejecutarConsulta($sql);
	}
}

?>