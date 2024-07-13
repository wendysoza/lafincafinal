<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function mostrar_login($email_usuario)
	{
		$sql="SELECT * FROM usuarios WHERE email_usuario = '$email_usuario'";
		return ejecutarConsultaContar($sql);
	}

	public function mostrar_login2($email_usuario, $id_usuario)
	{
		$sql="SELECT * FROM usuarios WHERE email_usuario = '$email_usuario' and id_usuario = '$id_usuario'";
		return ejecutarConsultaContar($sql);
	}

	public function mostrar_cedula($cedula_usuario)
	{
		$sql="SELECT * FROM usuarios WHERE cedula_usuario = '$cedula_usuario'";
		return ejecutarConsultaContar($sql);
	}

	public function mostrar_cedula2($cedula_usuario, $id_usuario)
	{
		$sql="SELECT * FROM usuarios WHERE cedula_usuario = '$cedula_usuario' and id_usuario = '$id_usuario'";
		return ejecutarConsultaContar($sql);
	}

	//Implementamos un método para insertar registros
	public function insertar($cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$email_usuario,$clave_us,$imagen_usuario,$id_permiso)
	{
		$sql="INSERT INTO usuarios (cedula_usuario,nombre_usuario,apellido_usuario,telefono_usuario,direccion_usuario,email_usuario,clave_us,imagen_usuario,estado_usuario)
		VALUES ('$cedula_usuario','$nombre_usuario','$apellido_usuario','$telefono_usuario','$direccion_usuario','$email_usuario','$clave_us','$imagen_usuario','1')";
		//return ejecutarConsulta($sql);
		$idusuarionew=ejecutarConsulta_retornarID($sql);

		$sql_detalle = "INSERT INTO usuario_permisos(id_usuario, id_permiso) VALUES('$idusuarionew', '$id_permiso')";
		return ejecutarConsulta($sql_detalle);
	}

	//Implementamos un método para editar registros
	public function editar($id_usuario,$cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$email_usuario,$clave_us,$imagen_usuario,$id_permiso)
	{
		$sql="UPDATE usuarios SET cedula_usuario = '$cedula_usuario', nombre_usuario='$nombre_usuario',apellido_usuario='$apellido_usuario',telefono_usuario='$telefono_usuario',
		direccion_usuario='$direccion_usuario',email_usuario='$email_usuario',
		clave_us='$clave_us',imagen_usuario='$imagen_usuario' WHERE id_usuario='$id_usuario'";
		ejecutarConsulta($sql);

		$sql2="UPDATE usuario_permisos SET id_permiso = '$id_permiso' where id_usuario = '$id_usuario'";
		return ejecutarConsulta($sql2);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_usuario)
	{
		$sql="UPDATE usuarios SET estado_usuario='0' WHERE id_usuario='$id_usuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_usuario)
	{
		$sql="UPDATE usuarios SET estado_usuario='1' WHERE id_usuario='$id_usuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_usuario)
	{
		$sql="SELECT * FROM usuarios u, usuario_permisos up, permisos p WHERE u.id_usuario = up.id_usuario and up.id_permiso = p.id_permiso and u.id_usuario='$id_usuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM usuarios u, permisos p, usuario_permisos up where u.id_usuario = up.id_usuario and p.id_permiso = up.id_permiso";
		return ejecutarConsulta($sql);		
	}

	public function listarreporte()
	{
		$sql="SELECT * FROM usuarios u, usuario_permisos up, permisos p where u.id_usuario = up.id_usuario and p.id_permiso = up.id_permiso";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los permisos marcados
	public function listarmarcados($id_usuario)
	{
		$sql="SELECT * FROM usuario_permisos WHERE id_usuario='$id_usuario'";
		return ejecutarConsulta($sql);
	}

	public function selecttipo(){
		$sql="SELECT * from permisos";
		return ejecutarConsulta($sql);
	}

	//Función para verificar el acceso al sistema
	public function verificar($login_us,$clave_us)
    {
    	$sql="SELECT * FROM usuarios WHERE email_usuario='$login_us' AND clave_us='$clave_us' and estado_usuario = '1'"; 
    	return ejecutarConsulta($sql);  
    }

	public function verificar2($cedula_usuario){
        $sql= "SELECT * FROM usuarios where cedula_usuario = '$cedula_usuario'";
        return ejecutarConsulta($sql);
    }
}

?>