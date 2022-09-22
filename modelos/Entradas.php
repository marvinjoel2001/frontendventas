<?php
//Incluimos la concexion a la base de datos.
require "../config/Conexion.php";

Class Entradas
{
    public function __contruct()
    {   
    }
    
    //Implementamos un metodo para insertar multas.
    public function insertar($idproducto,$cantidad,$imagen,$fecha)
    {
        $sql="INSERT INTO entradas (idproducto,cantidad,imagen,fecha) 
              VALUES('$idproducto','$cantidad','$imagen','$fecha')";
        return ejecutarConsulta($sql);
    }
    
    //Implementamos un metodo para Actualizar multas.
    public function editar($identrada,$idproducto,$cantidad,$imagen,$fecha)
    {
        $sql="UPDATE entradas SET idproducto='$idproducto',
                               cantidad='$cantidad',
                               imagen='$imagen',
                               fecha='$fecha' 
                         WHERE identrada='$identrada'";
        return ejecutarConsulta($sql);
    }
    //Implementamos el metodo para eliminar multas
    public function eliminar($identrada)
    {
        $sql="DELETE FROM entradas WHERE identrada='$identrada'";
        return ejecutarConsulta($sql);
    }
    
    //Implementamos el metodo para cancelar el pago
    public function mostrar($identrada)
    {
        $sql="SELECT * FROM entradas WHERE identrada='$identrada'";
		return ejecutarConsultaSimpleFila($sql);
    }
    
    //Implementamos el metodo para cancelar el pago
    public function listar()
	{
		$sql="SELECT e.identrada,
                    p.nombre as idproducto, 
                    e.cantidad,
                    e.imagen,
                    e.fecha 
                    FROM entradas e INNER JOIN productos p 
                    ON e.idproducto=p.idproducto";
		return ejecutarConsulta($sql);		
	}
}
?>