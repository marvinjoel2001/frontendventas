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

if ($_SESSION['Multas']==1)
{
?>
    <!-- Inicio Contenido PHP-->
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix">
                <header class="main-box-header clearfix">
                    <h2 class="box-title">Multas <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h2>
                </header>
                <div class="main-box-body clearfix" id="listadoregistros">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="tbllistado">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Monto</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Razon de multa</th>
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
                        <div class="form-group col-sm-5 col-xs-12">
                            <label>Cliente</label>
                            <input type="hidden" name="idmulta" id="idmulta">
                        <select id="idprestamo" name="idprestamo" class="form-control selectpicker" data-live-search="true" required >
                        
                        </select>
                        </div>
                        </div>
                        
                        <div class="row">
                              <div class="form-group col-sm-5 col-xs-12">
                            <label>Fecha</label>
                            <input type="date" name="fmulta" id="fmulta">
                        </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-2 col-xs-12">
                            <label>Monto</label>
                            <input type="number" name="monto" id="monto" class="form-control" placeholder="Monto de la multa" required>
                        </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-2 col-xs-12">
                            <label>Razon de la multa</label>
                            <input type="text" name="razon" id="razon" class="form-control" placeholder="Describa la razon de la multa" required>
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
        <script type="text/javascript" src="scripts/multas.js"></script>
<?php 
}
ob_end_flush();
?>