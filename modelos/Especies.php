<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Especies
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_tipo,$especie)
	{
		$sql="INSERT INTO especie (id_tipo,especie,estado_especie)
		VALUES ('$id_tipo','$especie','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_especie,$id_tipo,$especie)
	{
		$sql="UPDATE especie SET id_tipo = '$id_tipo', especie = '$especie'
        WHERE id_especie='$id_especie'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_especie)
	{
		$sql="UPDATE especie SET estado_especie='0' WHERE id_especie='$id_especie'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_especie)
	{
		$sql="UPDATE especie SET estado_especie='1' WHERE id_especie='$id_especie'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_especie)
	{
		$sql="SELECT * FROM especie WHERE id_especie ='$id_especie'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM especie e, tipo_a t where e.id_tipo = t.id_tipo";
		return ejecutarConsulta($sql);		
	}

	public function selecttipo()
	{
		$sql="SELECT * FROM tipo_a where estado_tipo = '1'";
		return ejecutarConsulta($sql);		
	}
}

?>