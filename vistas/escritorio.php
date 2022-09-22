<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

//if ($_SESSION['Escritorio']==1)
{
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();
  //$rsptac = $consulta->totalprestamos10dias();
  //$regc=$rsptac->fetch_object();
  //$totalc=$regc->total_compra;

  /*$rsptav = $consulta->totalventahoy();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->total_venta;
  */

  
  $ventas10 = $consulta->totalventas10dias();
  $fechasp='';
  $totalesp='';
  while ($regfechav= $ventas10->fetch_object()) {
      $fechasp=$fechasp.'"'.$regfechav->fecha .'",';
      $totalesp=$totalesp.$regfechav->total .','; 
  }


  $totalclientes=$consulta->totalclientes();
  $totalonlyclientes=0.0;
  while ($totalclient=$totalclientes->fetch_object()){
    $totalonlyclientes=$totalonlyclientes + 1.0;
  };
  var_dump($totalonlyclientes);

  $pagos10= $consulta->totalpago10dias();
  $fechaspa='';
  $totalespa='';
  while ($regfechapa= $pagos10->fetch_object()){
    $fechaspa=$fechasp.'"'.$regfechapa->fecha .'",';
    $totalespa=$totalespa.$regfechapa->cuota .','; 
  }
  //Linea para traer el json y sumar todos los gastos
  $totalgasto=$consulta->totalgastos();
  $totalonlygasto=0.0;
  while ($totalgast=$totalgasto->fetch_object()){
    $totalonlygasto=$totalonlygasto + $totalgast->gasto;
  };


  //Linea para traer el json y sumar todos los pagos hechos
  $totalpago=$consulta->totalpago();
  $totalonlypago=0.0;
  while ($totalpag=$totalpago->fetch_object()){
    $totalonlypago=$totalonlypago + $totalpag->cuota;
  };
  //Linea para traer json y sumar todo el monto prestado
  $totalprestado=$consulta->totaldeuda();
  $totalonlyprestado=0.0;
  while ($totalprest=$totalprestado->fetch_object()){
    $totalonlyprestado=$totalonlyprestado + $totalprest->monto;
  };


  

  
/*
   //Datos para mostrar el gráfico de barras de las ventas
  $ventas12 = $consulta->ventasultimos_12meses();
  $fechasv='';
  $totalesv='';
  

  //Quitamos la última coma
  $fechasv=substr($fechasv, 0, -1);
  $totalesv=substr($totalesv, 0, -1);
  */


?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
           
        <!-- Main content -->
        <div class="container">
        <h1 class="box-title">Escritorio </h1>
      <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Dinero deuda</h6>
                    <h2 class="text-right"><i class="fa fa-money f-left"></i><span id="prestamomonto">1000</span>bs</h2>
                    <p class="m-b-0">TOTAL DEUDAS<span class="f-right">total</span></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Pagos recibidos</h6>
                    <h2 class="text-right"><i class="fa fa-dollar f-left"></i><span id="pagomonto">486</span>bs</h2>
                    <p class="m-b-0">TOTAL PAGOS<span class="f-right">total</span></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Gastos hechos</h6>
                    <h2 class="text-right"><i class="fa fa-shirtsinbulk f-left"></i><span id="gastomonto">700</span>bs</h2>
                    <p class="m-b-0">TOTAL GASTOS<span class="f-right">total</span></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Clientes registrados</h6>
                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span id="totalclientes">14</span></h2>
                    <p class="m-b-0">CLIENTES<span class="f-right">registrados</span></p>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Escritorio </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                     
                       
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                Prestamos ultimos 10 dias
                              </div>
                              <div class="box-body">
                                <canvas id="prestamos" width="400" height="300"></canvas>
                              </div>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                Pagos ultimos 10 dias
                              </div>
                              <div class="box-body">
                                <canvas id="pagos" width="400" height="300"></canvas>
                              </div>
                          </div>
                        </div>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
</div>

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}

{
  require 'noacceso.php';
}

require 'footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
<script type="text/javascript">
var totalcliente=document.getElementById("totalclientes");
totalcliente.innerText=[<?php echo $totalonlyclientes; ?>];

var ctx = document.getElementById("prestamos").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasp; ?>],
        datasets: [{
            label: 'Ventas',
            data: [<?php echo $totalesp; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
//Linea para traer el gasto total
var totalgasto=document.getElementById("gastomonto");
totalgasto.innerText=[<?php echo $totalonlygasto; ?>];

//Linea para traer el pago total
var totalpago=document.getElementById("pagomonto");
totalpago.innerText=[<?php echo $totalonlypago; ?>];

var totalprestamo=document.getElementById("prestamomonto");
totalprestamo.innerText=[<?php echo $totalonlyprestado; ?>];


var ctxpago = document.getElementById("pagos").getContext('2d');
var pago = new Chart(ctxpago, {
    type: 'line',
    data: {
        labels: [<?php echo $fechaspa; ?>],
        datasets: [{
            label: 'Pagos',
            data: [<?php echo $totalespa; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
<?php 
}
ob_end_flush();
?>


