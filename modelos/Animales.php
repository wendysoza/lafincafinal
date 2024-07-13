<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Animales
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_cli,$id_especie,$raza,$observacion)
	{
		$sql="INSERT INTO animales (id_cli,id_especie,raza,observacion,estado_animal)
		VALUES ('$id_cli','$id_especie','$raza','$observacion','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_animal,$id_cli,$id_especie,$raza,$observacion)
	{
		$sql="UPDATE animales SET id_cli = '$id_cli', id_especie = '$id_especie', raza = '$raza',
        observacion = '$observacion' WHERE id_animal='$id_animal'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_animal)
	{
		$sql="UPDATE animales SET estado_animal='0' WHERE id_animal='$id_animal'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_animal)
	{
		$sql="UPDATE animales SET estado_animal='1' WHERE id_animal='$id_animal'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_animal)
	{
		$sql="SELECT * FROM animales WHERE id_animal ='$id_animal'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM animales a, clientes c, especie e, tipo_a t 
        where a.id_especie = e.id_especie and t.id_tipo = e.id_tipo
        and a.id_cli = c.id_cli";
		return ejecutarConsulta($sql);		
	}

	public function selectespecie()
	{
		$sql="SELECT * FROM especie e, tipo_a t where e.id_tipo = t.id_tipo and e.estado_especie = '1'";
		return ejecutarConsulta($sql);		
	}
}

?>