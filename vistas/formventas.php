<?php
// Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
} else {
    require 'header.php';
    if ($_SESSION['administrador'] == 1 || $_SESSION['secretaria'] == 1) {
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
                        <center><h1 class="box-title">FORMULARIO DE VENTAS </h1></center>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
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
                            <tbody></tbody>
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
                        <div class="row">
                            <!-- Left column -->
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Fecha(*):</label>&nbsp; 
                                    <B><FONT COLOR="red" id="fechaid" name="fechaid"></FONT></B>
                                    <input type="hidden" name="id_cabecera" id="id_cabecera">
                                    <input onchange="fechas()" type="date" class="form-control" name="fecha" id="fecha" required="">
                                </div>
                                <h4><b>&nbsp;&nbsp;&nbsp;&nbsp;DATOS DEL CLIENTE</b></h4>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <label>Cliente(*):</label>
                                    <select id="id_cliente" name="id_cliente" class="form-control selectpicker" data-live-search="true" required></select>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <label>Registrar cliente:</label>
                                    <br>
                                    <a data-toggle="modal" href="#myModal2">
                                        <button id="btnAgregarArt2" type="button" class="btn btn-success" style="font-size: 12px; padding: 10px 10px;">
                                            <span class="fa fa-user-plus"></span> Agregar nuevo
                                        </button>
                                    </a>
                                </div>
                                <h4><b>&nbsp;&nbsp;&nbsp;&nbsp;DATOS DE PRODUCTOS</b></h4>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <a data-toggle="modal" href="#myModal">
                                        <button id="btnAgregarArt" type="button" class="btn btn-primary">
                                            <span class="fa fa-plus"></span> Agregar Productos
                                        </button>
                                    </a>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6" id="seriediv">
                                    <a data-toggle="modal" href="#myModal3">
                                        <button id="btnAgregarArt3" type="button" class="btn btn-warning" style="font-size: 12px; padding: 10px 10px;">
                                            <span class="fa fa-plus"></span> Nuevo producto
                                        </button>
                                    </a>
                                </div>
                               
                            </div>
                            <!-- Right column -->
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label style="display: inline-block; text-align: right; width: 425px;"> NRO. SERIE: </label>
                            <input type="number" id="serie" name="serie" readonly style="display: inline-block; text-align: left;">                              
                            <div class="table-responsive">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead style="background-color:#A9D0F5">
                                            <th>Producto</th>
                                            <th>Cod</th>
                                            <th>Precio</th>
                                            <th>Cant</th>
                                            <th>Total</th>
                                            <th></th>
                                        </thead>
                                        <tfoot>
                                            <th>SUBTOTAL<br>
                                                IVA<br>
                                              DCTO<br>
                                            TOTAL A PAGAR</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>
                                                <h4 id="total">$. 0.00</h4>
                                                <input type="hidden" name="total_venta" id="total_venta">
                                                <select name="iva" id="iva" style="width:150px" onchange="modificarSubtotales()">
                                                    <option value="0">0</option>
                                                    <option value="0.15" selected>0.15</option>
                                                </select>
                                                <br><br>
                                                <input onkeyup="calcularTotales()" type="number" step=".01" name="dcto" id="dcto" placeholder="Descuento" value="0">
                                                <h4 id="totalfinal">$. 0.00</h4>
                                                <input type="hidden" name="total_venta_final" id="total_venta_final" step=".01">
                                            </th>
                                        </tfoot>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                   <center>
                                   <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Generar venta</button>
                                   <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-ban"></i> Cancelar</button>
                                   </center>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
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
            <th>Cód barras</th>
            <th>Descripción</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Precio</th>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
          <th>Opciones</th>
          <th>Cód barras</th>
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

  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">Registrar nuevo cliente</h4>  
                      
    </div>
      <div class="modal-body">
      <div class="panel-body" id="formularioregistros2">
                        <form name="formulario2" id="formulario2" method="POST">
                        
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Nombres(*):</label>  
                            <input type="hidden" name="id_cli" id="id_cli">
                            <input type="text" onkeydown="return /[a-z, ]/i.test(event.key)" class="form-control" name="nombres_cli" id="nombres_cli" maxlength="200" placeholder="Nombres" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Cédula(*):</label>  &nbsp; <B><FONT COLOR="red" id="prueba" name="prueba"> </FONT>
                            <input type="number" onchange="validar()" class="form-control" name="cedula_cli" id="cedula_cli" placeholder="Cédula" required
                            maxlength = "10" 
                            oninput="javascript: if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                          </div>
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Teléfono(*):</label> 
                            <input type="number" class="form-control" name="telefono_cli" id="telefono_cli" placeholder="Teléfono" required
                            maxlength = "10" 
                            oninput="javascript: if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                          </div>
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Dirección(*):</label> 
                            <input type="text" class="form-control" name="direccion_cli" id="direccion_cli" maxlength="200" placeholder="Dirección" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Email(*):</label> 
                            <input type="email" class="form-control" name="email_cli" id="email_cli" maxlength="200" placeholder="Email" required>
                          </div>

                          <center>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardarCli"><i class="fa fa-save"></i> Guardar</button>
                          </div>
                          </center>
                        </form>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          Cerrar
        </button>
      </div>
    </div>
    </div>
  </div>

  <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">Registrar nuevo producto</h4>  
                      
    </div>
      <div class="modal-body">
      <div class="panel-body" id="formularioregistros3">
                        <form name="formulario3" id="formulario3" method="POST">
                     
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
                            <button class="btn btn-primary" type="submit" id="btnGuardarProd"><i class="fa fa-save"></i> Guardar</button>
                          </div>
                          </center>
                        </form>
                    </div>
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

  <script type="text/javascript" src="scripts/formventas.js"></script>

 <?php
  }
  ob_end_flush();
  ?>
  