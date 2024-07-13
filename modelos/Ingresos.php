<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Ingresos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($fecha_i,$descripcion,$cantidad)
	{
		$sql="INSERT INTO ingresos (fecha_i,descripcion,cantidad,estado_ingreso)
		VALUES ('$fecha_i','$descripcion','$cantidad','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_ingreso,$fecha_i,$descripcion,$cantidad)
	{
		$sql="UPDATE ingresos SET fecha_i = '$fecha_i', descripcion='$descripcion',cantidad='$cantidad' WHERE id_ingreso='$id_ingreso'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_ingreso)
	{
		$sql="UPDATE ingresos SET estado_ingreso='0' WHERE id_ingreso='$id_ingreso'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_ingreso)
	{
		$sql="UPDATE ingresos SET estado_ingreso='1' WHERE id_ingreso='$id_ingreso'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_ingreso)
	{
		$sql="SELECT * FROM ingresos WHERE id_ingreso ='$id_ingreso'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM ingresos";
		return ejecutarConsulta($sql);		
	}
}

?>