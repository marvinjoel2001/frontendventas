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

if ($_SESSION['Ventas']==1)
{
?>
    <!-- Inicio Contenido PHP-->
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix">
                <header class="main-box-header clearfix">
                     <h2 class="box-title">Ventas  <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h2>
                </header>
                <div class="main-box-body clearfix" id="listadoregistros">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="tbllistado">
                            <thead>
                                <tr>
                                   <th>Opciones</th>
                                   <th>Venta</th>
                                    <th>Producto</th>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                </div>
                </div>
                
                   <div class="main-box-body clearfix" id="formularioregistros">
                    <form name="formulario" id="formulario" method="POST">
                        <input type="hidden" name="idventa" id="idventa">
                        <input type="hidden" name="idproductogenerar" id="idproductogenerar">
                        <div class="row" id="listproductos">
                        <h2 class="box-title"><button class="btn btn-success" onclick="agregar()"><i class="fa fa-plus-circle"></i> Agregar producto</button></h2>
                        <h1 class="box-title">Venta numero <span id="numventa"></span></h1>
                           <div class="form-group col-md-7 col-sm-9 col-xs-12">
                            
                            <label>Producto</label>
                            
                            <select name="idproducto1" id="idproducto1" class="form-control selectpicker" data-live-search="true" required></select>
                                    
                        </div>
                        <div class="form-group col-md-3 col-sm-9 col-xs-12">
                            <label>Cantidad</label>
                            <input type="number" name="cantidad1" id="cantidad1" class="form-control" placeholder="Cantidad" required>
                        </div>
                        <div class="form-group col-md-2 col-sm-9 col-xs-12">
                            <label>Precio</label>
                            <input type="number" name="precio1" id="precio1" class="form-control" placeholder="Precio" required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo ''.$_SESSION["nombre"].''?>">  
                            <input type="hidden" class="form-control" name="fventa" id="fventa" >
                            <input type="hidden" class="form-control" name="ventaultimo" id="ventaultimo" >
                        </div>
                        
                                                  
                        </div>
                        <div class="row">
                             <div class="form-group col-sm-3 col-xs-12">
                            <label>Total $</label>
                            <input  type="number" name="total" id="total" class="form-control" placeholder="Total" required >
                        </div>
                        </div>
                        <div class="form-group col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            <button class="btn btn-info" onclick="calcular()" type="button"><i class="fa fa-refresh"></i> Calcular Total</button>
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
<script type="text/javascript" src="scripts/ventas.js"></script>
<script type="text/javascript">
</script>


<!--<script type="text/javascript" src="scripts/prestamos.js?v=<?php echo str_replace('.', '', microtime(true)); ?>"></script>-->

<?php 
}
ob_end_flush();
?>

