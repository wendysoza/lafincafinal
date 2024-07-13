<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Docenviados
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($num_oficio,$cargo,$para,$fecha,$observaciones,$documento_e)
	{
		$sql="INSERT INTO doc_env (num_oficio,cargo,para,fecha,observaciones,documento_e,estado_doc_e)
		VALUES ('$num_oficio','$cargo','$para','$fecha','$observaciones','$documento_e','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_doc_e,$num_oficio,$cargo,$para,$fecha,$observaciones,$documento_e)
	{
		$sql="UPDATE doc_env SET num_oficio = '$num_oficio', cargo='$cargo',para='$para',fecha='$fecha',
		observaciones='$observaciones',documento_e='$documento_e' WHERE id_doc_e='$id_doc_e'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_doc_e)
	{
		$sql="UPDATE doc_env SET estado_doc_e='0' WHERE id_doc_e='$id_doc_e'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_doc_e)
	{
		$sql="UPDATE doc_env SET estado_doc_e='1' WHERE id_doc_e='$id_doc_e'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_doc_e)
	{
		$sql="SELECT * FROM doc_env WHERE id_doc_e ='$id_doc_e'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM doc_env";
		return ejecutarConsulta($sql);		
	}
}

?>