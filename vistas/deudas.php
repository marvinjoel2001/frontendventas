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

if ($_SESSION['Deudas']==1)
{
?>
    <!-- Inicio Contenido PHP-->
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix">
                <header class="main-box-header clearfix">
                     <h2 class="box-title">Deudas<button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h2>
                </header>
                <div class="main-box-body clearfix" id="listadoregistros">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="tbllistado">
                            <thead>
                                <tr>
                                   <th>Opciones</th>
                                    <th>Clientes</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Saldo</th>
                                    <th>Descripcion</th>
                                    <th>Plazo</th>  
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                </div>
                </div>
                
                   <div class="main-box-body clearfix" id="formularioregistros">
                    <form name="formulario" id="formulario" method="POST">
                        <input type="hidden" name="iddeuda" id="iddeuda">
                        <div class="row">
                           <div class="form-group col-md-6 col-sm-9 col-xs-12">
                            <label>Cliente</label>
                            
                            <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true" required></select>                           
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                           <label>Usuarios</label>
                            <select name="usuario" id="usuario" class="form-control selectpicker" data-live-search="true" required></select> 
                            <input type="hidden" class="form-control" name="fdeuda" id="fdeuda" required>
                        </div>
                                                  
                        </div>
                        <div class="row">
                        <div class="form-group col-sm-3 col-xs-12">
                            <label>Monto</label>
                            <input type="number" name="monto" id="monto" class="form-control" placeholder="Monto" required>
                            <input type="hidden"  id="valor" >
                        </div>
                         <div class="form-group col-sm-3 col-xs-12">
                            <label>Saldo</label>
                            <input type="number" name="saldo" id="saldo" class="form-control" placeholder="Saldo" required >
                        </div>
                        </div>
                        <div class="row">
                             <div class="form-group col-sm-3 col-xs-12">
                            <label>Plazo</label>
                            <input  type="date" name="fplazo" id="fplazo" class="form-control" placeholder="Plazo" required >
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Descripcion</label>
                            <input  type="text" rows="3" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion" required >
                        </div>
                        </div>
                        <div class="form-group col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Contenido PHP-->
    <?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script>
$(document).ready(function($){
var mont;
	$('#monto').keyup(function (e) {
		mont = $(this).val();
	 //console.log(mont)	  
	})
})
</script>
<script type="text/javascript" src="scripts/deudas.js"></script>
<!--<script type="text/javascript" src="scripts/prestamos.js?v=<?php echo str_replace('.', '', microtime(true)); ?>"></script>-->

<?php 
}
ob_end_flush();
?>

