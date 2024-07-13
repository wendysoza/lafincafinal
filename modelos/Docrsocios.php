<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Docrsocios
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($num_oficio,$id_socio,$fecha,$observaciones,$documento_r2)
	{
		$sql="INSERT INTO doc_r_socios (num_oficio,id_socio,fecha,observaciones,documento_r2,estado_d_r2)
		VALUES ('$num_oficio','$id_socio','$fecha','$observaciones','$documento_r2','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_d_r2,$num_oficio,$id_socio,$fecha,$observaciones,$documento_r2)
	{
		$sql="UPDATE doc_r_socios SET num_oficio = '$num_oficio', id_socio='$id_socio',fecha='$fecha',
		observaciones='$observaciones',documento_r2='$documento_r2' WHERE id_d_r2='$id_d_r2'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para desactivar categorías
	public function desactivar($id_d_r2)
	{
		$sql="UPDATE doc_r_socios SET estado_d_r2='0' WHERE id_d_r2='$id_d_r2'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_d_r2)
	{
		$sql="UPDATE doc_r_socios SET estado_d_r2='1' WHERE id_d_r2='$id_d_r2'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_d_r2)
	{
		$sql="SELECT * FROM doc_r_socios WHERE id_d_r2 ='$id_d_r2'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM doc_r_socios";
		return ejecutarConsulta($sql);		
	}

    public function selectsocios(){
        $sql="SELECT * FROM socios where estado_s = '1'";
        return ejecutarConsulta($sql);
    }
}

?>