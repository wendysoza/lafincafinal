<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LA FINCA | www.lafinca.com</title>
   <!-- Tell the browser to be responsive to screen width -->
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Bootstrap 3.3.5 -->
   <link rel="stylesheet" href="../public/css/bootstrap.min.css">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="../public/css/font-awesome.css">
   <link rel="stylesheet" href="../css black/login.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
   <!-- iCheck -->
   <link rel="stylesheet" href="../public/css/blue.css">

   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
       <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
       <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->
 </head> 
 <body >
   
   <!-- <div class="row">
     <div class="col-xs-4 col-xs-offset-4  ">
      <img src="../files/logo.png" class="logo center-block">
      </div> 
  
   </div>-->


   <div >
     <div >
      
      <!-- <a href="../../index2.html" class="a1" target="_blank"><b>MADERERA GALLARDO</b></a>-->
       
             
             
               
               
       
               <form class="login" method="post" id="frmAcceso">
                <img src="../files/logo1.png" class="img1" width=60%; alt="">
                  <input type="email" placeholder="Email" id="logina" name="logina">
                  <input type="password" placeholder="Contraseña" id="clavea" name="clavea">
                  <button type="submit">Ingresar</button>



                  <div class="my-2">
                    <a href="recuperacion.php">¿Olvidaste tu contraseña?</a><br>
                    
                  </div>
                  <?php 
                  if(isset($_GET['message'])){
                   
                  ?>
                    <div class="alert alert-primary" role="alert">
                      <?php 
                      switch ($_GET['message']) {
                        case 'ok':
                          echo 'Por favor, revisa tu correo';
                          break;
                        case 'success_password':
                          echo 'Inicia sesión con tu nueva contraseña';
                          break;
                          
                        default:
                          echo 'Algo salió mal, intenta de nuevo';
                          break;
                      }
                      ?>
                    </div>
                  <?php
                  }
                  ?>



                  
                </form>
               
            
       
             
           </div><!-- /.login-box -->
       
           <!-- jQuery 2.1.4 -->
           <script src="../public/js/jquery-3.1.1.min.js"></script>
           <!-- Bootstrap 3.3.5 -->
           <script src="../public/js/bootstrap.min.js"></script>
           <!-- Bootbox -->
           <script src="../public/js/bootbox.min.js"></script>
           <script type="text/javascript" src="scripts/login.js"></script>
       
         </body>
       </html>