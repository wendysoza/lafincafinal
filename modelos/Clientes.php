<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Clientes
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombres_cli,$cedula_cli,$telefono_cli,$direccion_cli,$email_cli)
	{
		$sql="INSERT INTO clientes (nombres_cli,cedula_cli,telefono_cli,direccion_cli,email_cli,estado_cli)
		VALUES ('$nombres_cli','$cedula_cli','$telefono_cli','$direccion_cli','$email_cli','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_cli,$nombres_cli,$cedula_cli,$telefono_cli,$direccion_cli,$email_cli)
	{
		$sql="UPDATE clientes SET nombres_cli = '$nombres_cli', cedula_cli = '$cedula_cli', telefono_cli = '$telefono_cli',
        direccion_cli = '$direccion_cli', email_cli = '$email_cli' WHERE id_cli='$id_cli'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_cli)
	{
		$sql="UPDATE clientes SET estado_cli='0' WHERE id_cli='$id_cli'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_cli)
	{
		$sql="UPDATE clientes SET estado_cli='1' WHERE id_cli='$id_cli'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_cli)
	{
		$sql="SELECT * FROM clientes WHERE id_cli ='$id_cli'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM clientes";
		return ejecutarConsulta($sql);		
	}

	public function select()
	{
		$sql="SELECT * FROM clientes where estado_cli = '1'";
		return ejecutarConsulta($sql);		
	}
}

?>