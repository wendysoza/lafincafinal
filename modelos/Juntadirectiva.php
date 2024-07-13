<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Junta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($presidente,$vicepres,$secretaria,$tesorero,$primer_v,$segundo_v,$tercer_v)
	{
		$sql="INSERT INTO juntadirectiva (presidente,vicepres,secretaria,tesorero,primer_v,segundo_v,tercer_v)
		VALUES ('$presidente','$vicepres','$secretaria','$tesorero','$primer_v','$segundo_v','$tercer_v')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_junta,$presidente,$vicepres,$secretaria,$tesorero,$primer_v,$segundo_v,$tercer_v)
	{
		$sql="UPDATE juntadirectiva SET presidente = '$presidente', vicepres='$vicepres',secretaria='$secretaria',tesorero='$tesorero',
		primer_v='$primer_v',segundo_v='$segundo_v',
		tercer_v='$tercer_v' WHERE id_junta='$id_junta'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_junta)
	{
		$sql="SELECT * FROM juntadirectiva where id_junta = '$id_junta'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM juntadirectiva";
		return ejecutarConsulta($sql);		
	}
}

?>