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
                    <center><h1 class="box-title">DOCUMENTOS RECIBIDOS - ENTIDADES </h1></center>
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
                            <th>Num oficio</th>
                            <th>Cargo</th>
                            <th>Para</th>
                            <th>Fecha</th>
                            <th>Observaciones</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Num oficio</th>
                            <th>Cargo</th>
                            <th>Para</th>
                            <th>Fecha</th>
                            <th>Observaciones</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                       
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Número de oficio(*):</label> 
                            <input type="hidden" name="id_doc_e" id="id_doc_e">
                            <input type="text" class="form-control" name="num_oficio" id="num_oficio" placeholder="Número de oficio" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Cargo(*):</label>
                            <input type="text" class="form-control" name="cargo" id="cargo" placeholder="Cargo" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Para(*):</label>
                            <input type="text" class="form-control" name="para" id="para" placeholder="Para" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-4 col-sm-4 col-xs-4">
                            <label>Fecha(*):</label> 
                            <input type="date" class="form-control" name="fecha" id="fecha" placeholder="Fecha" required>
                        </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Observaciones(*):</label>
                            <input type="text" class="form-control" name="observaciones" id="observaciones" placeholder="Observaciones" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Documento(*):</label>
                            <input type="file" class="form-control" name="documento_e" id="documento_e" style="width: 26%" accept="application/pdf,application/vnd.ms-excel">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <embed src="" width="100%" height="600px" id="imagenmuestra">
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

<script type="text/javascript" src="scripts/docenviados.js"></script>
<?php 
}
ob_end_flush();
?>