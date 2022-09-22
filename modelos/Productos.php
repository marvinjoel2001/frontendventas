<?php
//Incluimos la concexion a la base de datos.
require "../config/Conexion.php";

class Productos
{
    public function __contruct()
    {
    }

    //Implementamos un metodo para insertar multas.
    public function insertar($nombre, $descripcion, $precio)
    {
        $sql="INSERT INTO productos (nombre,descripcion,precio) 
              VALUES('$nombre','$descripcion','$precio')";
        return ejecutarConsulta($sql);
    }

    //Implementamos un metodo para Actualizar multas.
    public function editar($idproducto, $nombre, $descripcion, $precio)
    {
        $sql="UPDATE productos SET nombre='$nombre',
                               descripcion='$descripcion',
                               precio='$precio'
                         WHERE idproducto='$idproducto'";
        return ejecutarConsulta($sql);
    }

    //Implementamos el metodo para eliminar multas
    public function eliminar($idproducto)
    {
        $sql="DELETE FROM productos WHERE idproducto='$idproducto'";
        return ejecutarConsulta($sql);
    }

    //Implementamos el metodo para cancelar el pago
    public function mostrar($idproducto)
    {
        $sql="SELECT * FROM productos WHERE idproducto='$idproducto'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementamos el metodo para cancelar el pago
    public function listar()
    {
        $sql="SELECT p.idproducto,
                    p.nombre as nombre,
                    p.descripcion, 
                    p.precio
                    FROM productos p ";
        return ejecutarConsulta($sql);
    }

    public function select()
    {
        $sql="SELECT nombre, idproducto FROM productos  ORDER BY nombre ASC;";
        return ejecutarConsulta($sql);
    }
}
    
?>