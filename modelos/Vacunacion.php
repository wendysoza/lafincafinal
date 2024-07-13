<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Vacunacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_prod,$id_animal,$edad,$peso,$fecha_vac,$fecha_revac,$lote,$num_reg,$laboratorio)
	{
		$sql="INSERT INTO vacunacion (id_prod,id_animal,edad,peso,fecha_vac,fecha_revac,lote,num_reg,laboratorio,estado_vac)
		VALUES ('$id_prod','$id_animal','$edad','$peso','$fecha_vac','$fecha_revac','$lote','$num_reg','$laboratorio','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_vac,$id_prod,$id_animal,$edad,$peso,$fecha_vac,$fecha_revac,$lote,$num_reg,$laboratorio)
	{
		$sql="UPDATE vacunacion SET id_prod = '$id_prod', id_animal = '$id_animal', edad = '$edad', peso = '$peso', fecha_vac = '$fecha_vac',
        fecha_revac = '$fecha_revac', lote = '$lote', num_reg = '$num_reg', laboratorio = '$laboratorio' WHERE id_vac='$id_vac'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_vac)
	{
		$sql="UPDATE vacunacion SET estado_vac='0' WHERE id_vac='$id_vac'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_vac)
	{
		$sql="UPDATE vacunacion SET estado_vac='1' WHERE id_vac='$id_vac'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_vac)
	{
		$sql="SELECT * FROM vacunacion WHERE id_vac ='$id_vac'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM animales a, clientes c, especie e, tipo_a t, 
        vacunacion v, productos p 
        where a.id_especie = e.id_especie and t.id_tipo = e.id_tipo
        and a.id_cli = c.id_cli and v.id_prod = p.id_prod 
        and v.id_animal = a.id_animal";
		return ejecutarConsulta($sql);		
	}

	public function selectproductos()
	{
		$sql="SELECT * FROM productos where estado_prod = '1' and id_cat = '1'";
		return ejecutarConsulta($sql);		
	}

    public function selectanimales()
	{
		$sql="SELECT * FROM animales a, clientes c, especie e, tipo_a t 
        where a.id_especie = e.id_especie and t.id_tipo = e.id_tipo
        and a.id_cli = c.id_cli and a.estado_animal = '1'";
		return ejecutarConsulta($sql);		
	}
}

?>