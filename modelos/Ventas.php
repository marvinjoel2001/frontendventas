<?php 
//Incluimos inicialmente la conexion a la base de datos
require "../config/Conexion.php";
    
Class Venta
{
    //implementamos nuestro constructor
    public function __construct()
    {   
    }
    
    //implementamos un metodo para insertar registros
    public function insertar($fecha,$usuario,$total)
    {
        $sql="INSERT INTO ventas (fecha,usuario,total) 
        VALUES ('$fecha','$usuario','$total')";
        return ejecutarConsulta($sql);
    }
    public function insertardetalle($venta,$idproducto,$cantidad,$precio)
    {
        $sql="INSERT INTO detalleventa (venta,idproducto,cantidad,precio) 
        VALUES ('$venta','$idproducto','$cantidad','$precio')";
        return ejecutarConsulta($sql);
    }
    
    //Implementamos el metodo para Editar Registros
    public function editar($idventa,$idproducto,$usuario,$fventa,$cantidad,$total)
	{
		$sql="UPDATE ventas SET 
                     idproducto='$idproducto',
                     usuario='$usuario',
                     fventa='$fventa',
                     cantidad='$cantidad',  
                     total='$total' 
                    WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}
    
    //Implementamos un método para eliminar categorías
	public function eliminar($idventa)
	{
		$sql="DELETE FROM ventas WHERE venta='$idventa'";
		return ejecutarConsulta($sql);
	}
    public function eliminardetalle($idventa)
	{
		$sql="DELETE FROM detalleventa WHERE venta='$idventa'";
		return ejecutarConsulta($sql);
	}
    
    
    //Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT * FROM ventas WHERE idventa = '$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}
    
//mostrar lista de la tabla gastos    
    public function listar()
	{
		$sql="SELECT d.venta as venta ,p.nombre as idproducto,DATE(v.fecha) as fecha,d.cantidad as cantidad ,d.precio as precio
        FROM detalleventa d INNER JOIN productos p ON 
        d.idproducto=p.idproducto INNER JOIN ventas v ON d.venta=v.venta"  ;
		return ejecutarConsulta($sql);		
	}
    public function ultimoid(){
        $sql="SELECT MAX(venta) as id FROM detalleventa";
        return ejecutarConsultaSimpleFila($sql);
    }
    
}
?>