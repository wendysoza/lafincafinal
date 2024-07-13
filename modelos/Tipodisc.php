<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Tipodisc
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($tipo_d)
	{
		$sql="INSERT INTO tipo_discapacidad (tipo_d,estado_tipo_d)
		VALUES ('$tipo_d','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_tipo_d,$tipo_d)
	{
		$sql="UPDATE tipo_discapacidad SET tipo_d = '$tipo_d' WHERE id_tipo_d='$id_tipo_d'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_tipo_d)
	{
		$sql="UPDATE tipo_discapacidad SET estado_tipo_d='0' WHERE id_tipo_d='$id_tipo_d'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_tipo_d)
	{
		$sql="UPDATE tipo_discapacidad SET estado_tipo_d='1' WHERE id_tipo_d='$id_tipo_d'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_tipo_d)
	{
		$sql="SELECT * FROM tipo_discapacidad WHERE id_tipo_d ='$id_tipo_d'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tipo_discapacidad";
		return ejecutarConsulta($sql);		
	}
}

?>