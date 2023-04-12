<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
require 'header.php';
?>
    <!-- Inicio Contenido PHP-->
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix">
                <header class="main-box-header clearfix">
                     <h2 class="box-title">Inventario  <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h2>
                </header>
                <div class="main-box-body clearfix" id="listadoregistros">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="tbllistado">
                            <thead>
                                <tr>
                                   <th>Opciones</th>
                                   <th>Producto</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                </div>
                </div>
                
                    <div class="main-box-body clearfix" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="idproductogenerar" id="idproductogenerar">
                            <h1 class="box-title">Inventario</h1>
                            <div class="form-group col-md-7 col-sm-9 col-xs-12">
                                <label>Producto</label>
                                <select name="idproducto1" id="idproducto1" class="form-control selectpicker" data-live-search="true" required></select>
                            </div>
                            <div class="form-group col-md-3 col-sm-9 col-xs-12">
                                <label>Cantidad</label>
                                <input type="number" name="cantidad1" id="cantidad1" class="form-control" placeholder="Cantidad" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 col-xs-12">
                                    <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo ''.$_SESSION["nombre"].''?>">  
                                </div>
                                <div class="form-group col-xs-12">
                                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button> 
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    <!-- Fin Contenido PHP-->
    <?php


require 'footer.php';
?>
<script type="text/javascript" src="scripts/inventario.js"></script>

<!--<script type="text/javascript" src="scripts/prestamos.js?v=<?php echo str_replace('.', '', microtime(true)); ?>"></script>-->
<?php 
ob_end_flush();
?>

