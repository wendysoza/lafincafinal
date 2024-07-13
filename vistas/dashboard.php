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
  require_once "../modelos/Dashboard.php";
  $consulta = new Dashboard();
  $rsptac = $consulta->totalclientes();
  $regc=$rsptac->fetch_object();
  $totalc=$regc->total; 

  $rsptap = $consulta->totalventashoy();
  $regcp=$rsptap->fetch_object();
  $totalcp=$regcp->total_venta_final;

  $rsptap2 = $consulta->totalventas();
  $regcp2=$rsptap2->fetch_object();
  $totalcp2=$regcp2->total_venta_final;

  $rsptap3 = $consulta->totalvacunacion();
  $regcp3=$rsptap3->fetch_object();
  $totalcp3=$regcp3->totalvacunacion;

  //Datos para mostrar el gráfico de barras de las compras
/*   $ventas10 = $consulta->ventassultimos_10dias();
  $fechasc='';
  $totalesc='';
  while ($regfechac= $ventas10->fetch_object()) {
    $fechasc=$fechasc.'"'.$regfechac->fecha .'",';
    $totalesc=$totalesc.$regfechac->total .','; 
  } */

  //Quitamos la última coma
/*   $fechasc=substr($fechasc, 0, -1);
  $totalesc=substr($totalesc, 0, -1);  */

   //Datos para mostrar el gráfico de barras de las ventas
  $ventas12 = $consulta->ventasultimos_12meses();
  $fechasv='';
  $fechasv2='';
  $totalesv='';
  while ($regfechav= $ventas12->fetch_object()) {
    $fechasv=$fechasv.'"'.$regfechav->fecha .'",';
    $totalesv=$totalesv.$regfechav->total .','; 
  }

  //Quitamos la última coma
  $fechasv=substr($fechasv, 0, -1);
  $totalesv=substr($totalesv, 0, -1);

  //............................................................
  $mesid=1;
  $ventas1 = $consulta->reporte_mensual($mesid);
  $fechasc2='';
  $totalesc2='';
  while ($regfechac2= $ventas1->fetch_object()) {
    $fechasc2=$fechasc2.'"'.$regfechac2->descripcion .'",';
    $totalesc2=$totalesc2.$regfechac2->total .','; 
  }

  //Quitamos la última coma
  $fechasc2=substr($fechasc2, 0, -1);
  $totalesc2=substr($totalesc2, 0, -1);

  $mesid2=2;
  $ventas1a = $consulta->reporte_mensual($mesid2);
  $fechasc2a='';
  $totalesc2a='';
  while ($regfechac2a= $ventas1a->fetch_object()) {
    $fechasc2a=$fechasc2a.'"'.$regfechac2a->descripcion .'",';
    $totalesc2a=$totalesc2a.$regfechac2a->total .','; 
  }

  //Quitamos la última coma
  $fechasc2a=substr($fechasc2a, 0, -1);
  $totalesc2a=substr($totalesc2a, 0, -1);

  $mesid3=3;
  $ventas1b = $consulta->reporte_mensual($mesid3);
  $fechasc2b='';
  $totalesc2b='';
  while ($regfechac2b= $ventas1b->fetch_object()) {
    $fechasc2b=$fechasc2b.'"'.$regfechac2b->descripcion .'",';
    $totalesc2b=$totalesc2b.$regfechac2b->total .','; 
  }

  //Quitamos la última coma
  $fechasc2b=substr($fechasc2b, 0, -1);
  $totalesc2b=substr($totalesc2b, 0, -1);

  $mesid4=4;
  $ventas1c = $consulta->reporte_mensual($mesid4);
  $fechasc2c='';
  $totalesc2c='';
  while ($regfechac2c= $ventas1c->fetch_object()) {
    $fechasc2c=$fechasc2c.'"'.$regfechac2c->descripcion .'",';
    $totalesc2c=$totalesc2c.$regfechac2c->total .','; 
  }

  //Quitamos la última coma
  $fechasc2c=substr($fechasc2c, 0, -1);
  $totalesc2c=substr($totalesc2c, 0, -1);

  $mesid5=5;
  $ventas1d = $consulta->reporte_mensual($mesid5);
  $fechasc2d='';
  $totalesc2d='';
  while ($regfechac2d= $ventas1d->fetch_object()) {
    $fechasc2d=$fechasc2d.'"'.$regfechac2d->descripcion .'",';
    $totalesc2d=$totalesc2d.$regfechac2d->total .','; 
  }

  //Quitamos la última coma
  $fechasc2d=substr($fechasc2d, 0, -1);
  $totalesc2d=substr($totalesc2d, 0, -1);

  $mesid6=6;
  $ventas1e = $consulta->reporte_mensual($mesid6);
  $fechasc2e='';
  $totalesc2e='';
  while ($regfechac2e= $ventas1e->fetch_object()) {
    $fechasc2e=$fechasc2e.'"'.$regfechac2e->descripcion .'",';
    $totalesc2e=$totalesc2e.$regfechac2e->total .','; 
  }

  //Quitamos la última coma
  $fechasc2e=substr($fechasc2e, 0, -1);
  $totalesc2e=substr($totalesc2e, 0, -1);

  $mesid7=7;
  $ventas1f = $consulta->reporte_mensual($mesid7);
  $fechasc2f='';
  $totalesc2f='';
  while ($regfechac2f= $ventas1f->fetch_object()) {
    $fechasc2f=$fechasc2f.'"'.$regfechac2f->descripcion .'",';
    $totalesc2f=$totalesc2f.$regfechac2f->total .','; 
  }

  //Quitamos la última coma
  $fechasc2f=substr($fechasc2f, 0, -1);
  $totalesc2f=substr($totalesc2f, 0, -1);

  $mesid8=8;
  $ventas1g = $consulta->reporte_mensual($mesid8);
  $fechasc2g='';
  $totalesc2g='';
  while ($regfechac2g= $ventas1g->fetch_object()) {
    $fechasc2g=$fechasc2g.'"'.$regfechac2g->descripcion .'",';
    $totalesc2g=$totalesc2g.$regfechac2g->total .','; 
  }

  //Quitamos la última coma
  $fechasc2g=substr($fechasc2g, 0, -1);
  $totalesc2g=substr($totalesc2g, 0, -1);

  $mesid9=9;
  $ventas1h = $consulta->reporte_mensual($mesid9);
  $fechasc2h='';
  $totalesc2h='';
  while ($regfechac2h= $ventas1h->fetch_object()) {
    $fechasc2h=$fechasc2h.'"'.$regfechac2h->descripcion .'",';
    $totalesc2h=$totalesc2h.$regfechac2h->total .','; 
  }

  //Quitamos la última coma
  $fechasc2h=substr($fechasc2h, 0, -1);
  $totalesc2h=substr($totalesc2h, 0, -1);

  $mesid10=10;
  $ventas1i = $consulta->reporte_mensual($mesid10);
  $fechasc2i='';
  $totalesc2i='';
  while ($regfechac2i= $ventas1i->fetch_object()) {
    $fechasc2i=$fechasc2i.'"'.$regfechac2i->descripcion .'",';
    $totalesc2i=$totalesc2i.$regfechac2i->total .','; 
  }

  //Quitamos la última coma
  $fechasc2i=substr($fechasc2i, 0, -1);
  $totalesc2i=substr($totalesc2i, 0, -1);

  $mesid11=11;
  $ventas1j = $consulta->reporte_mensual($mesid11);
  $fechasc2j='';
  $totalesc2j='';
  while ($regfechac2j= $ventas1j->fetch_object()) {
    $fechasc2j=$fechasc2j.'"'.$regfechac2j->descripcion .'",';
    $totalesc2j=$totalesc2j.$regfechac2j->total .','; 
  }

  //Quitamos la última coma
  $fechasc2j=substr($fechasc2j, 0, -1);
  $totalesc2j=substr($totalesc2j, 0, -1);

  $mesid12=12;
  $ventas1k = $consulta->reporte_mensual($mesid12);
  $fechasc2k='';
  $totalesc2k='';
  while ($regfechac2k= $ventas1k->fetch_object()) {
    $fechasc2k=$fechasc2k.'"'.$regfechac2k->descripcion .'",';
    $totalesc2k=$totalesc2k.$regfechac2k->total .','; 
  }

  //Quitamos la última coma
  $fechasc2k=substr($fechasc2k, 0, -1);
  $totalesc2k=substr($totalesc2k, 0, -1);

?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                    <center><h1 class="box-title">DASHBOARD </h1></center>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->

                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                              <div class="small-box bg-light-blue-active">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong><?php echo $totalc; ?></strong>
                                </h4>
                                <p>Total de clientes</p>
                              </div>
                              <div class="icon">
                                <i class="ion-person"></i>
                              </div>
                              <a href="clientes.php" class="small-box-footer">Clientes <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                          </div>

                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                              <div class="small-box bg-olive">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong><?php echo $totalcp3; ?></strong>
                                </h4>
                                <p>Total de vacunación</p>
                              </div>
                              <div class="icon">
                                <i class="ion-person"></i>
                              </div>
                              <a href="vacunacion.php" class="small-box-footer">Vacunación <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                          </div>

                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-aqua">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong>$<?php echo $totalcp; ?></strong>
                                </h4>
                                <p>Total ventas (HOY)</p>
                              </div>
                              <div class="icon">
                                <i class="ion-cash"></i>
                              </div>
                              <a href="ventas.php" class="small-box-footer">Ventas Hoy<i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-blue">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong>$<?php echo $totalcp2; ?></strong>
                                </h4>
                                <p>Total ventas</p>
                              </div>
                              <div class="icon">
                                <i class="ion-cash"></i>
                              </div>
                              <a href="ventas.php" class="small-box-footer">Ventas <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                Ventas de los últimos 12 meses
                              </div>
                              <div class="box-body">
                                <canvas id="ventas12" width="400" height="300"></canvas>
                              </div>
                          </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="box box-primary">
                            <br>
                              <div class="box-header with-border">
                                Productos vendidos en el mes seleccionado
                              </div><br>
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <select name="mesid" id="mesid" onchange="myFunction()" style="width:150px">
                                        <option value="1" selected>Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>


                                   <p id="demo" hidden></p> 
                                    
                                    </div>
                                  
                                    <div id="box-body3">
                                <canvas id="ventas1" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body4">
                                <canvas id="ventas1a" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body5">
                                <canvas id="ventas1b" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body6">
                                <canvas id="ventas1c" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body7">
                                <canvas id="ventas1d" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body8">
                                <canvas id="ventas1e" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body9">
                                <canvas id="ventas1f" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body10">
                                <canvas id="ventas1g" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body11">
                                <canvas id="ventas1h" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body12">
                                <canvas id="ventas1i" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body13">
                                <canvas id="ventas1j" width="400" height="300"></canvas>
                              </div>
                              <div id="box-body14">
                                <canvas id="ventas1k" width="400" height="300"></canvas>
                              </div>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <script src="../public/js/chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script> 
<script type="text/javascript">


var ctx = document.getElementById("ventas12").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'line',
    fontcolor: "red",
    data: {
        labels: [<?php echo $fechasv?>],
        datasets: [{
            label: 'Ganancias en $ de los últimos 12 Meses',
            data: [<?php echo  $totalesv; ?>],
            fill: false,
            backgroundColor: [
                'rgb(0, 0, 255)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)'
            ],
            borderColor: [
              'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    steps: 10,
                    stepValue: 6,
                    max: 5000 //max value for the chart is 60
                }
            }],
        }
    }
});

var ctx = document.getElementById("ventas1").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2; ?>],
            fill: false,
            backgroundColor: [
                'rgb(0, 0, 255)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1a").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2a; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2a; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1b").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2b; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2b; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1c").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2c; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2c; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1d").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2d; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2d; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1e").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2e; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2e; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1f").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2f; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2f; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1g").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2g; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2g; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1h").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2h; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2h; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1i").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2i; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2i; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1j").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2j; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2j; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas1k").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2k; ?>],
        datasets: [{
            label: 'Productos vendidos en el último mes',
            data: [<?php echo $totalesc2k; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});
</script>


</script>

<?php
}
else
{
  require 'noacceso.php';
}




require 'footer.php';
?>

<script type="text/javascript" src="scripts/prueba.js"></script>
<?php 
}
ob_end_flush();
?>


