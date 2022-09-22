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

if ($_SESSION['Garantia']==1)
{
?>
    <!-- Inicio Contenido PHP-->
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix">
                <header class="main-box-header clearfix">
                    <h2 class="box-title">Garantia <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h2>
                </header>
                <div class="main-box-body clearfix" id="listadoregistros">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="tbllistado">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Objeto</th>
                                    <th>Descripcion</th>
                                    <th>Imagen</th>
                                    <th>Prestamo de</th>
                                    <th>Estado</th>
                                    <th>Devolucion</th>  
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
                            <label>Prestamo</label>
                            <input type="hidden" name="idgarantia" id="idgarantia">
                          <select id="idprestamo" name="idprestamo" class="form-control selectpicker" data-live-search="true" required></select>
                          
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5 col-xs-12">
                                <label>Nombre Objeto</label>
                                <input type="text" class="form-control" placeholder="Descripcion"  name="nombreobjeto" id="nombreobjeto">
                            </div>
                        </div>
                          <div class="row">
                              <div class="form-group col-sm-5 col-xs-12">
                            <label>Descripcion</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion" maxlength="70" required>
                        </div>
                          </div>
                        <div class="row">
                            <div class="form-group col-sm-5 col-xs-12">
                            <label>Imagen</label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="../public/images/imagenvacia.jpg" width="150px" height="120px" id="imagenmuestra">
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4 col-xs-12">
                            <label>Estado</label>
                            
                            <select id="estado" name="estado" class="form-control selectpicker" data-live-search="true" required>
                                <option value="1">Usado</option>
                                <option value="2">Medio Uso</option>
                                <option value="3">Nuevo</option>
                            </select>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4 col-xs-12">
                            <label>Estado Devolucion</label>
                            
                            <select id="estadodev" name="estadodev" class="form-control selectpicker" data-live-search="true" required>
                                <option value="1">Devuelto</option>
                                <option value="2">No devuelto</option>
                            </select>
                            
                        </div>
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
        <script type="text/javascript" src="scripts/garantia.js"></script>
<?php 
}
ob_end_flush();
?>