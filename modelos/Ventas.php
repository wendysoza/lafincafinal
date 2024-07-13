<?php
require "../config/Conexion.php";

Class Ventas {
    public function __construct()
    {
        
    }

    //insertar 
    public function insertar($fecha,$id_cliente,$id_empleado,$total_venta,$iva,$dcto,$total_venta_final,$id_prod,$cantidad,$valor_venta)
    {
        $hora_actual = date("h:i:s");

        $sql= "INSERT INTO cabecera_factura (fecha,id_cli,id_empleado,total_venta,iva,dcto,total_venta_final,estado) 
        VALUES ('$fecha','$id_cliente','$id_empleado','$total_venta','$iva','$dcto','$total_venta_final','Aceptado')" ;
        //return ejecutarConsulta($sql);

        $idcabeceranew = ejecutarConsulta_retornarID($sql);

        $num_elementos=0;
        $sw=true;

        while($num_elementos < count($id_prod))
        {   
            $sql_detalle = "INSERT INTO detalle_factura(id_cabecera, id_prod, cantidad, valor_venta) VALUES('$idcabeceranew', '$id_prod[$num_elementos]','$cantidad[$num_elementos]','$valor_venta[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos = $num_elementos + 1;
        }
        return $sw;
    }
    
    //muestra los datos de un registro a modificar
    
    public function mostrar($id_cabecera)
    {
        $sql="SELECT * FROM cabecera_factura WHERE id_cabecera='$id_cabecera'";
		return ejecutarConsultaSimpleFila($sql);
    }

    public function listarDetalle($id_cabecera){
        $sql="SELECT *
        FROM detalle_factura df, productos p, cabecera_factura c, categorias cat
        WHERE df.id_prod = p.id_prod and df.id_cabecera = '$id_cabecera' and c.id_cabecera = df.id_cabecera and p.id_cat = cat.id_cat";
        return ejecutarConsulta($sql);
    }

    //Implementamos un métodos para anular 
    public function anular($id_cabecera)
    {
        $sql="UPDATE cabecera_factura SET estado='Anulado' WHERE id_cabecera='$id_cabecera'";
        return ejecutarConsulta($sql);
    }

    public function listar($fecha_inicio,$fecha_fin){
            $sql="SELECT c.id_cabecera, c.fecha, cli.nombres_cli, e.nombre_usuario, e.apellido_usuario, c.total_venta_final, c.estado, c.total_venta, c.iva 
            FROM cabecera_factura c, clientes cli, usuarios e WHERE c.id_empleado = e.id_usuario and c.id_cli = cli.id_cli and c.fecha>='$fecha_inicio' and c.fecha<='$fecha_fin'";
             return ejecutarConsulta($sql);     
    }

    public function listar2(){
        $sql="SELECT c.*, cli.*
        FROM cabecera_factura c, clientes cli
        WHERE c.id_cli = cli.id_cli";
         return ejecutarConsulta($sql);
     }

     public function verserie()
	{
		$sql="SELECT MAX(id_cabecera+1) as 'idcab' from cabecera_factura";
		return ejecutarConsultaSimpleFila($sql);
	}

     public function listarProductos(){
        $sql="SELECT * FROM productos p, categorias c
        where p.id_cat = c.id_cat";
        return ejecutarConsulta($sql);
    }


    public function ventacabecera($id_cabecera){
        $sql="SELECT *
        FROM cabecera_factura c, clientes cli, usuarios e 
        WHERE c.id_cli = cli.id_cli and c.id_cabecera ='$id_cabecera' and e.id_usuario = c.id_empleado";
         return ejecutarConsulta($sql);
	}


	public function ventadetalle($id_cabecera){
        $sql="SELECT df.valor_venta, df.cantidad, p.*,c.*, cat.*, ROUND((df.valor_venta)+(df.valor_venta)*((df.cantidad*df.valor_venta)),2) as subtotal
        FROM detalle_factura df, productos p, cabecera_factura c, categorias cat
        WHERE df.id_prod = p.id_prod and df.id_cabecera = '$id_cabecera' and c.id_cabecera = df.id_cabecera and p.id_cat = cat.id_cat";
        return ejecutarConsulta($sql);
	}

    public function totalventa(){
        $sql="SELECT SUM(total_venta_final) as 'totalfinal' from cabecera_factura where estado = 'Aceptado'";
        return ejecutarConsulta($sql);
    }

    
    public function reportecab($id_cabecera){
        $sql="SELECT *
        FROM cabecera_factura c, clientes cli, usuarios e 
        WHERE c.id_cli = cli.id_cli and c.id_cabecera ='$id_cabecera' and e.id_usuario = cli.id_usuario";
         return ejecutarConsulta($sql);
	}

    public function reportevendedor($id_cabecera){
        $sql="SELECT *
        FROM cabecera_factura c, usuarios e 
        WHERE c.id_cabecera ='$id_cabecera' and e.id_usuario = c.id_empleado";
         return ejecutarConsulta($sql);
	}
	
    public function selectcat(){
		$sql="SELECT * FROM categorias";
		return ejecutarConsulta($sql);
    }
}


?>