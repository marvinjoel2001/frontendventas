<?php
//Incluimos la concexion a la base de datos.
require "../config/Conexion.php";

Class Multa
{
    public function __contruct()
    {   
    }
    
    //Implementamos un metodo para insertar multas.
    public function insertar($monto,$idcliente,$fmulta,$razon)
    {
        $sql="INSERT INTO multas (monto,idcliente,fmulta,razon) 
              VALUES('$monto','$idcliente','$fmulta','$razon')";
        return ejecutarConsulta($sql);
    }
    
    //Implementamos un metodo para Actualizar multas.
    public function editar($idmulta,$monto,$idcliente,$fmulta,$razon)
    {
        $sql="UPDATE multas SET monto='$monto',
                               idcliente='$idcliente',
                               fmulta='$fmulta',
                               razon='$razon' 
                         WHERE idmulta='$idmulta'";
        return ejecutarConsulta($sql);
    }
    
    //Implementamos el metodo para eliminar multas
    public function eliminar($idmulta)
    {
        $sql="DELETE FROM multas WHERE idmulta='$idmulta'";
        return ejecutarConsulta($sql);
    }
    
    //Implementamos el metodo para cancelar el pago
    public function mostrar($idmulta)
    {
        $sql="SELECT * FROM multas WHERE idmulta='$idmulta'";
		return ejecutarConsultaSimpleFila($sql);
    }
    
    //Implementamos el metodo para cancelar el pago
    public function listar()
	{
		$sql="SELECT m.idmulta,
                    m.monto,
                    c.nombre as nombre,
                    c.idcliente as idcliente, 
                    m.fmulta,
                    m.razon 
                    FROM multas m INNER JOIN clientes c 
                    ON m.idcliente=c.idcliente";
		return ejecutarConsulta($sql);		
	}
}
?>