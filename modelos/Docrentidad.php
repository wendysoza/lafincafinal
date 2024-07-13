<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Docrentidad
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($num_oficio,$entidad,$de,$fecha,$observaciones,$documento_r1)
	{
		$sql="INSERT INTO doc_r_entidad (num_oficio,entidad,de,fecha,observaciones,documento_r1,estado_d_r1)
		VALUES ('$num_oficio','$entidad','$de','$fecha','$observaciones','$documento_r1','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_d_r1,$num_oficio,$entidad,$de,$fecha,$observaciones,$documento_r1)
	{
		$sql="UPDATE doc_r_entidad SET num_oficio = '$num_oficio', entidad='$entidad',de='$de',fecha='$fecha',
		observaciones='$observaciones',documento_r1='$documento_r1' WHERE id_d_r1='$id_d_r1'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_d_r1)
	{
		$sql="UPDATE doc_r_entidad SET estado_d_r1='0' WHERE id_d_r1='$id_d_r1'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_d_r1)
	{
		$sql="UPDATE doc_r_entidad SET estado_d_r1='1' WHERE id_d_r1='$id_d_r1'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_d_r1)
	{
		$sql="SELECT * FROM doc_r_entidad WHERE id_d_r1 ='$id_d_r1'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM doc_r_entidad";
		return ejecutarConsulta($sql);		
	}
}

?>