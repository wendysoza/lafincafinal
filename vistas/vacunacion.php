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
                    <center><h1 class="box-title">VACUNACIÓN </h1></center>
                            <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> 
                            <a href="../reportes/rptvacunacion.php" target="_blank"><button class="btn btn-info" id="btnreporte"><i class="fa fa-clipboard"></i> Reporte</button></a>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Vacuna</th>
                            <th>Animal - Dueño</th>
                            <th>Fecha vacunación</th>
                            <th>Fecha revacunación</th>
                            <th>Lote</th>
                            <th>Num registro</th>
                            <th>Laboratorio</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Vacuna</th>
                            <th>Animal - Dueño</th>
                            <th>Fecha vacunación</th>
                            <th>Fecha revacunación</th>
                            <th>Lote</th>
                            <th>Num registro</th>
                            <th>Laboratorio</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                       
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Vacuna(*):</label> 
                            <input type="hidden" name="id_vac" id="id_vac">
                            <select id="id_prod" name="id_prod" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-4 col-sm-4 col-xs-4">
                            <label>Animal - Dueño(*):</label> 
                            <select id="id_animal" name="id_animal" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Edad(*):</label>
                            <input type="text" class="form-control" name="edad" id="edad" maxlength="100" placeholder="Edad" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Peso(*):</label>
                            <input type="text" class="form-control" name="peso" id="peso" maxlength="100" placeholder="Peso" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de vacunación(*):</label>
                            <input type="date" class="form-control" name="fecha_vac" id="fecha_vac" placeholder="Fecha de vacunación" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de revacunación(*):</label>
                            <input type="date" class="form-control" name="fecha_revac" id="fecha_revac" placeholder="Fecha de revacunación" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Lote(*):</label>
                            <input type="text" class="form-control" name="lote" id="lote" placeholder="Lote" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Num registro(*):</label>
                            <input type="number" class="form-control" name="num_reg" id="num_reg" placeholder="Num registro" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Laboratorio(*):</label>
                            <input type="text" class="form-control" name="laboratorio" id="laboratorio" placeholder="Laboratorio" required>
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

<script type="text/javascript" src="scripts/vacunacion.js"></script>
<?php 
}
ob_end_flush();
?>