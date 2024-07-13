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
 if ($_SESSION['administrador']==1)
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
                    <center><h1 class="box-title">SOCIOS </h1></center>
                            <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> 
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Cédula</th>
                            <th>Tipo de discapacidad</th>
                            <th>Porcentaje de discapacidad</th>
                            <th>Teléfono</th>
                            <th>Lugar</th>
                            <th>Dirección</th>
                            <th>Necesidad</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Cédula</th>
                            <th>Tipo de discapacidad</th>
                            <th>Porcentaje de discapacidad</th>
                            <th>Teléfono</th>
                            <th>Lugar</th>
                            <th>Dirección</th>
                            <th>Necesidad</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                       
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Nombres(*):</label> 
                            <input type="hidden" name="id_socio" id="id_socio">
                            <input type="text" class="form-control" name="nombres_s" id="nombres_s" maxlength="100" placeholder="Nombres" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Apellidos(*):</label>
                            <input type="text" class="form-control" name="apellidos_s" id="apellidos_s" maxlength="100" placeholder="Apellidos" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cédula(*):</label>
                            <input type="number" class="form-control" name="cedula_s" id="cedula_s" placeholder="Cédula" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-4 col-sm-4 col-xs-4">
                            <label>Tipo de discapacidad(*):</label> 
                            <select id="id_tipo_d" name="id_tipo_d" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Porcentaje de discapacidad(*):</label>
                            <input type="text" class="form-control" name="porc_d" id="porc_d" placeholder="Porcentaje de discapacidad" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Teléfono:</label>
                            <input type="number" class="form-control" name="telefono_s" id="telefono_s" placeholder="Teléfono">
                          </div>
                         
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Lugar(*):</label>
                            <input type="text" class="form-control" name="lugar_s" id="lugar_s" placeholder="Lugar" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Dirección(*):</label>
                            <input type="text" class="form-control" name="direccion_s" id="direccion_s" placeholder="Dirección" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Necesidad(*):</label>
                            <input type="text" class="form-control" name="necesidad" id="necesidad" placeholder="Necesidad" required>
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

<script type="text/javascript" src="scripts/socios.js"></script>
<?php 
}
ob_end_flush();
?>