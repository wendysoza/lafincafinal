<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre_usuario"]))
{
  header("Location: login.html");
} 
 else
{ 
require 'header.php';
 if ($_SESSION['administrador']==1 || $_SESSION['secretaria']==1)
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
                    <center><h1 class="box-title">PRODUCTOS </h1></center>
                            <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> 
                            <a href="../reportes/rptproductos.php" target="_blank"><button class="btn btn-info" id="btnreporte"><i class="fa fa-clipboard"></i> Reporte</button></a>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Código de barras</th>
                            <th>Stock</th>
                            <th>Precio de compra</th>
                            <th>Precio de venta</th>
                            <th>Fecha vencimiento</th>
                            <th>Nombre del productor</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Código de barras</th>
                            <th>Stock</th>
                            <th>Precio de compra</th>
                            <th>Precio de venta</th>
                            <th>Fecha vencimiento</th>
                            <th>Nombre del productor</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                       
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Descripción(*):</label> 
                            <input type="hidden" name="id_prod" id="id_prod">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="200" placeholder="Descripción" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-4 col-sm-4 col-xs-4">
                            <label>Categoría(*):</label> 
                            <select onchange="vercat()" id="id_cat" name="id_cat" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Código de barras(*):</label>
                            <input type="number" class="form-control" name="codbarras" id="codbarras" maxlength="100" placeholder="Código de barras" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Stock(*):</label>
                            <input type="number" class="form-control" name="stock" id="stock" placeholder="Stock" required>
                          </div>
                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Precio de compra(*):</label>
                            <input type="number" step=".01" class="form-control" name="preciocompra" id="preciocompra" placeholder="Precio de compra" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Precio de venta(*):</label>
                            <input type="number" step=".01" class="form-control" name="precioventa" id="precioventa" placeholder="Precio de venta" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" id="libra">
                            <label>Precio por libra:</label>
                            <input type="number" step=".01" class="form-control" name="preciolibra" id="preciolibra" placeholder="Precio por libra">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" id="vol">
                            <label>Precio por volumen (quintal):</label>
                            <input type="number" step=".01" class="form-control" name="preciovol" id="preciovol" placeholder="Precio por volumen (quintal)">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de vencimiento:</label>
                            <input type="date" class="form-control" name="fecha_venc" id="fecha_venc">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre del productor(*):</label>
                            <input type="text" class="form-control" name="nombreproductor" id="nombreproductor" required>
                          </div>

                          <center>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                          </center>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
require 'noacceso.php';
} 
require 'footer.php';
?>

<script type="text/javascript" src="scripts/productos.js"></script>
<?php 
}
ob_end_flush();
?>