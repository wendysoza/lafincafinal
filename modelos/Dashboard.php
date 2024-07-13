<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Dashboard
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function totalclientes()
	{
		$sql="SELECT count(id_cli) as total FROM clientes where estado_cli = '1'";
		return ejecutarConsulta($sql);
	}

    public function totalvacunacion()
	{
		$sql="SELECT count(id_vac) as totalvacunacion FROM vacunacion where estado_vac = '1'";
		return ejecutarConsulta($sql);
	}

	public function totalventashoy()
	{
		$sql="SELECT IFNULL(ROUND(SUM(total_venta_final), 2),0) as total_venta_final FROM cabecera_factura WHERE fecha=curdate() and estado = 'Aceptado'";
		return ejecutarConsulta($sql);
	}

	public function totalventas()
	{
		$sql="SELECT IFNULL(ROUND(SUM(total_venta_final), 2),0) as total_venta_final FROM cabecera_factura WHERE estado = 'Aceptado'";
		return ejecutarConsulta($sql);
	}

	/* public function ventassultimos_10dias()
	{
		$sql="SELECT DATE_FORMAT(fecha_actual, '%d/%m') as fecha,ROUND(SUM(abono), 2)as total FROM citas_medicas GROUP by DAY(fecha_actual) ORDER BY fecha_actual ASC limit 0,10";
		return ejecutarConsulta($sql);
	} */

	/* public function ventasultimos_12meses()
	{
		$sql="SELECT DATE_FORMAT(fecha, '%m/%Y') as fecha, ROUND(SUM(total_venta_final), 2) as total FROM cabecera_factura GROUP by MONTH(fecha) ORDER BY fecha ASC limit 0,10";
		return ejecutarConsulta($sql);
	}
 */
	public function ventasultimos_12meses()
	{
		$sql="SELECT DATE_FORMAT(fecha, '%m/%Y') as fecha, ROUND(SUM(total_venta_final), 2) as total FROM cabecera_factura where  estado = 'Aceptado' and fecha<=date_add(CURDATE(),INTERVAL 12 month) GROUP by YEAR(fecha), MONTH(fecha)";
		return ejecutarConsulta($sql);
	}

    public function reporte_mensual($mes){
		$sql2="SELECT case month(c.fecha) WHEN 1 THEN 'Enero' WHEN 2 THEN 'Febrero' WHEN 3 THEN 'Marzo' WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' 
        WHEN 6 THEN 'Junio' WHEN 7 THEN 'Julio' WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre' WHEN 10 THEN 'Octubre' WHEN 11 THEN 'Noviembre' WHEN 12 THEN 'Diciembre' 
        END as fecha, p.descripcion, SUM(d.cantidad) AS total FROM productos p, cabecera_factura c, 
        detalle_factura d where p.id_prod = d.id_prod and c.id_cabecera = d.id_cabecera and month(c.fecha) = '$mes' GROUP BY month(c.fecha), p.id_prod LIMIT 0 , 10";
		return ejecutarConsulta($sql2);
	}
    
}

?>