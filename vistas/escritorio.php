<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
require 'header.php';
?>
<script>
  // Comprobar si existe un token en las cookies
  if (!getCookie('token')) {
    // Si no existe, redirigir al index
    window.location.href = "../index.php";
  }

  // Función para obtener el valor de una cookie
  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
  }
</script>
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


{
  require 'noacceso.php';
}

require 'footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
<script 
<?php 

ob_end_flush();
?>


