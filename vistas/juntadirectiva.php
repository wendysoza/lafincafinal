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
                    <center><h1 class="box-title">JUNTA DIRECTIVA </h1></center>
                           <!--  <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>  -->
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Presidente</th>
                            <th>Vicepresidente</th>
                            <th>Secretaria/o</th>
                            <th>Tesorera/o</th>
                            <th>Primer vocal</th>
                            <th>Segundo vocal</th>
                            <th>Tercer vocal</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Presidente</th>
                            <th>Vicepresidente</th>
                            <th>Secretaria/o</th>
                            <th>Tesorera/o</th>
                            <th>Primer vocal</th>
                            <th>Segundo vocal</th>
                            <th>Tercer vocal</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                       
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Presidente(*):</label> 
                            <input type="hidden" name="id_junta" id="id_junta">
                            <input type="text" class="form-control" name="presidente" id="presidente" maxlength="100" placeholder="Presidente" required>
                          </div>
                         
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Vicepresidente(*):</label>
                            <input type="text" class="form-control" name="vicepres" id="vicepres" maxlength="100" placeholder="Vicepresidente" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Secretaria/o(*):</label>
                            <input type="text" class="form-control" name="secretaria" id="secretaria" maxlength="100" placeholder="Secretaria/o" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tesorera/o(*):</label>
                            <input type="text" class="form-control" name="tesorero" id="tesorero" placeholder="Tesorera/o" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Primer vocal(*):</label>
                            <input type="text" class="form-control" name="primer_v" id="primer_v" placeholder="Primer vocal" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Segundo vocal(*):</label>
                            <input type="text" class="form-control" name="segundo_v" id="segundo_v" placeholder="Segundo vocal" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tercer vocal(*):</label>
                            <input type="text" class="form-control" name="tercer_v" id="tercer_v" placeholder="Tercer vocal" required>
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

<script type="text/javascript" src="scripts/juntadirectiva.js"></script>
<?php 
}
ob_end_flush();
?>