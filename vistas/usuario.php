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
                    <center><h1 class="box-title">USUARIOS </h1></center>
                            <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> 
                            <a href="../reportes/rptusuarios.php" target="_blank"><button class="btn btn-info" id="btnreporte"><i class="fa fa-clipboard"></i> Reporte</button></a>
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
                            <th>Celular</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombres</th>
                            <th>Cédula</th>
                            <th>Celular</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                       
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Cédula(*):</label>  &nbsp; <B><FONT COLOR="red" id="prueba" name="prueba"> </FONT>
                            <input type="hidden" name="id_usuario" id="id_usuario">
                            <input onchange="validar()" type="number" class="form-control" name="cedula_usuario" id="cedula_usuario" placeholder="Cédula" required
                            maxlength = "10" 
                            oninput="javascript: if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            
                          </div>
                          <div class="form-group col-lg-6 col-md-4 col-sm-4 col-xs-4">
                            <label>Tipo usuario(*):</label> 
                            <select id="id_permiso" name="id_permiso" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Nombre(*):</label>
                            <input type="text" onkeydown="return /[a-z, ]/i.test(event.key)" class="form-control" name="nombre_usuario" id="nombre_usuario" maxlength="100" placeholder="Nombres" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellido(*):</label>
                            <input type="text" onkeydown="return /[a-z, ]/i.test(event.key)" class="form-control" name="apellido_usuario" id="apellido_usuario" maxlength="20" placeholder="Apellidos" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Teléfono:</label>
                            <input type="number" class="form-control" name="telefono_usuario" id="telefono_usuario" placeholder="Teléfono"
                            maxlength = "10" 
                            oninput="javascript: if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" name="direccion_usuario" id="direccion_usuario" placeholder="Dirección" maxlength="70">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Email(*):</label>
                            <input type="email" class="form-control" name="email_usuario" id="email_usuario" maxlength="50" placeholder="Email" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Clave (*):</label>
                            <input type="password" class="form-control" name="clave_us" id="clave_us" maxlength="64" placeholder="Clave" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" class="form-control" name="imagen_usuario" id="imagen_usuario" style="width: 26%" accept="image/x-png,image/gif,image/jpeg">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
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

<script type="text/javascript" src="scripts/usuario.js"></script>
<?php 
}
ob_end_flush();
?>