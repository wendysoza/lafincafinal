<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Gastos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($fecha_g,$cantidad,$descripcion,$v_u,$v_t)
	{
		$sql="INSERT INTO gastos (fecha_g,cantidad,descripcion,v_u,v_t,estado_gasto)
		VALUES ('$fecha_g','$cantidad','$descripcion','$v_u','$v_t','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_gasto,$fecha_g,$cantidad,$descripcion,$v_u,$v_t)
	{
		$sql="UPDATE gastos SET fecha_g = '$fecha_g', descripcion='$descripcion',cantidad='$cantidad',
        v_u = '$v_u', v_t = '$v_t' WHERE id_gasto='$id_gasto'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_gasto)
	{
		$sql="UPDATE gastos SET estado_gasto='0' WHERE id_gasto='$id_gasto'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_gasto)
	{
		$sql="UPDATE gastos SET estado_gasto='1' WHERE id_gasto='$id_gasto'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_gasto)
	{
		$sql="SELECT * FROM gastos WHERE id_gasto ='$id_gasto'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM gastos";
		return ejecutarConsulta($sql);		
	}
}

?>