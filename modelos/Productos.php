<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Productos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_cat,$descripcion,$codbarras,$stock,$preciocompra,$precioventa,$preciolibra,$preciovol,$fecha_venc,$nombreproductor)
	{
		$sql="INSERT INTO productos (id_cat,descripcion,codbarras,stock,preciocompra,precioventa,preciolibra,preciovol,fecha_venc,nombreproductor,estado_prod)
		VALUES ('$id_cat','$descripcion','$codbarras','$stock','$preciocompra','$precioventa','$preciolibra','$preciovol','$fecha_venc','$nombreproductor','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_prod,$id_cat,$descripcion,$codbarras,$stock,$preciocompra,$precioventa,$preciolibra,$preciovol,$fecha_venc,$nombreproductor)
	{
		$sql="UPDATE productos SET id_cat = '$id_cat', descripcion='$descripcion',codbarras='$codbarras',stock='$stock', nombreproductor = '$nombreproductor',
		preciocompra='$preciocompra',precioventa='$precioventa', fecha_venc = '$fecha_venc', preciolibra = '$preciolibra', preciovol = '$preciovol' 
		WHERE id_prod='$id_prod'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_prod)
	{
		$sql="UPDATE productos SET estado_prod='0' WHERE id_prod='$id_prod'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_prod)
	{
		$sql="UPDATE productos SET estado_prod='1' WHERE id_prod='$id_prod'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_prod)
	{
		$sql="SELECT * FROM productos WHERE id_prod ='$id_prod'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM productos p, categorias c where c.id_cat = p.id_cat";
		return ejecutarConsulta($sql);		
	}

	public function selectcat(){
		$sql="SELECT * from categorias where estado_cat = '1'";
		return ejecutarConsulta($sql);
	}
}

?>