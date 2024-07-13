<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Ayudas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$cantidad,$existencia,$tamaño,$observaciones,$foto_ayuda)
	{
		$sql="INSERT INTO ayudas_tec (descripcion,cantidad,existencia,tamaño,observaciones,foto_ayuda,estado_ayuda)
		VALUES ('$descripcion','$cantidad','$existencia','$tamaño','$observaciones','$foto_ayuda','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_ayuda,$descripcion,$cantidad,$existencia,$tamaño,$observaciones,$foto_ayuda)
	{
		$sql="UPDATE ayudas_tec SET descripcion = '$descripcion', cantidad='$cantidad',existencia='$existencia',tamaño='$tamaño',
		observaciones='$observaciones',foto_ayuda='$foto_ayuda' WHERE id_ayuda='$id_ayuda'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_ayuda)
	{
		$sql="UPDATE ayudas_tec SET estado_ayuda='0' WHERE id_ayuda='$id_ayuda'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_ayuda)
	{
		$sql="UPDATE ayudas_tec SET estado_ayuda='1' WHERE id_ayuda='$id_ayuda'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_ayuda)
	{
		$sql="SELECT * FROM ayudas_tec WHERE id_ayuda ='$id_ayuda'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM ayudas_tec";
		return ejecutarConsulta($sql);		
	}
}

?>