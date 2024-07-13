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
      <img src="../files/Fondo2.png" class="img-fluid" alt="">
     <!-- <section class="content-section" id="portfolio">
            <div class="container px-4 px-lg-5">
              <br><br>-->
              <!-- BEGINS: AUTO-GENERATED MUSES RADIO PLAYER CODE -->
<!-- ENDS: AUTO-GENERATED MUSES RADIO PLAYER CODE -->
</div>
               
<?php
  
}else{
  require 'noacceso.php';
}

require 'footer.php';
?>

<script type="text/javascript" src="scripts/escritorio.js"></script>

<?php 
}
ob_end_flush();
?>

