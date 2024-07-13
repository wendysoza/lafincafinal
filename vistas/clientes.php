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
                    <center><h1 class="box-title">CLIENTES </h1></center>
                            <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> 
                            <a href="../reportes/rptclientes.php" target="_blank"><button class="btn btn-info" id="btnreporte"><i class="fa fa-clipboard"></i> Reporte</button></a>
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
                            <th>Cédula</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Email</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombres</th>
                            <th>Cédula</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Email</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                       
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

<script type="text/javascript" src="scripts/clientes.js"></script>
<?php 
}
ob_end_flush();
?>