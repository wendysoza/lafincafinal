<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Categorias
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cat)
	{
		$sql="INSERT INTO categorias (cat,estado_cat)
		VALUES ('$cat','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_cat,$cat)
	{
		$sql="UPDATE categorias SET cat = '$cat' WHERE id_cat='$id_cat'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_cat)
	{
		$sql="UPDATE categorias SET estado_cat='0' WHERE id_cat='$id_cat'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_cat)
	{
		$sql="UPDATE categorias SET estado_cat='1' WHERE id_cat='$id_cat'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_cat)
	{
		$sql="SELECT * FROM categorias WHERE id_cat ='$id_cat'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM categorias";
		return ejecutarConsulta($sql);		
	}
}

?>