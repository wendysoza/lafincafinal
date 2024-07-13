<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if(!isset($_SESSION["nombre_usuario"]))
{
    header("Location: login.php");
}

else
{

  
require 'header.php';
if($_SESSION['administrador']==1 || $_SESSION['secretaria']==1)
{

?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <center><h1 class="box-title">VENTAS </h1></center>
                         
                          <a target="_blank"><button onclick="reporteventas()" class="btn btn-info" id="btnreporte" ><i class="fa fa-clipboard"></i>  Reporte de ventas</button></a>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    
                    <!-- centro -->
                    <div class="panel-body table-responsive"  id="listadoregistros">
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          <label>Fecha inicio: </label>
                          <input onchange="listar()" type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          <label>Fecha fin: </label>
                          <input onchange="listar()" type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                    
                      <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                         <th>Num</th>
                          <th>Opciones</th>
                          <th>Fecha</th>
                          <th>Cliente</th>
                          <th>Empleado</th>
                          <th>Total</th>
                          <th>Estado</th>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                          <th>Num</th>
                          <th>Opciones</th>
                          <th>Fecha</th>
                          <th>Cliente</th>
                          <th>Empleado</th>
                          <th>Total</th>
                          <th>Estado</th>
                        </tfoot>
                      </table>    
                    </div>
                    <div class="panel-body" style="height: 100%;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Fecha(*):</label>&nbsp; <B><FONT COLOR="red" id="fechaid" name="fechaid"> </FONT>
                            <input type="hidden" name="id_cabecera" id="id_cabecera">
                            <input onchange="fechas()" type="date" class="form-control" name="fecha" id="fecha" required="">
                          </div>
                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <label>Cliente(*):</label>
                          <select id="id_cliente" name="id_cliente" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          
                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Productos</button>
                            </a>  
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3" id="seriediv">
                              <input type="number" id="serie" name="serie" readonly>
                          </div>

                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Valor Venta</th>
                                    <th>Dcto</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                <th>
                                      TOTAL
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                  
                     
                                    <th>
                                    <th><h4 id="total">S/. 0.00</h4><input type="hidden" name="total_venta" id="total_venta">
                                    <select name="iva" id="iva" style="width:150px" onchange="modificarSubtotales()">
                                        <option value="0">0</option>
                                        <option value="0.12" selected>0.12</option>
                                    </select></h4>
                                    <h4 id="totalfinal">$. 0.00</h4><input type="hidden" name="total_venta_final" id="total_venta_final" step=".01">
                                </th> 
                                </tfoot>
                                <tbody>
                                  
                                </tbody>
                            </table>
                            
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  <link rel="stylesheet" href="../public/bootstrap/css/modal.css">
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">Seleccione un producto</h4>  
                         
    </div>
      <div class="modal-body">
        <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
          <thead>
            <th>Opciones</th>
            <th>Descripción</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Precio</th>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
          <th>Opciones</th>
            <th>Descripción</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Precio</th>
          </tfoot>

        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          Cerrar
        </button>
      </div>
    </div>
    </div>
  </div>

  <?php
  }
  else{
    require 'noacceso.php';
  }
    require 'footer.php';
  ?>

  <script type="text/javascript" src="scripts/ventas.js"></script>

 <?php
  }
  ob_end_flush();
  ?>
  