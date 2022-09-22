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

if ($_SESSION['Productos']==1)
{
?>
    <!-- Inicio Contenido PHP-->
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix">
                <header class="main-box-header clearfix">
                    <h2 class="box-title">Productos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h2>
                </header>
                <div class="main-box-body clearfix" id="listadoregistros">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="tbllistado">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
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
                        <div class="row">
                              <<div class="form-group col-md-5 col-sm-8 col-xs-12">
                                <label>Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                              </div>
                            <div class="form-group col-sm-6 ">
                            <input type="hidden" name="idproducto" id="idproducto" >
                        </div>

                        <div class="row">
                            <div class="form-group col-md-8 col-sm-8 col-xs-12">
                                <label>Descripcion</label>
                                <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">  
                            <div class="form-group col-md-8 col-sm-8 col-xs-12">
                                <label>Precio</label>
                                <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
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
        <script type="text/javascript" src="scripts/productos.js"></script>
<?php 
}
ob_end_flush();
?>