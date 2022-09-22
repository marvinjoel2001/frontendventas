<?php
//Incluimos la concexion a la base de datos.
require "../config/Conexion.php";

Class Pago
{
    public function __contruct()
    {   
    }
    
    //Implementamos un metodo para insertar pagos.
    public function insertar($idcliente,$usuario,$fecha,$cuota)
    {
        $sql="INSERT INTO pagos (idcliente,usuario,fecha,cuota) 
              VALUES('$idcliente','$usuario','$fecha','$cuota')";
        return ejecutarConsulta($sql);
    }
    
    //Implementamos un metodo para Actualizar pagos.
    public function editar($idpago,$idcliente,$usuario,$fecha,$cuota)
    {
        $sql="UPDATE pagos SET idprestamo='$idcliente',
                               usuario='$usuario',
                               fecha='$fecha',
                               cuota='$cuota' 
                         WHERE idpago='$idpago'";
        return ejecutarConsulta($sql);
    }
    
    //Implementamos el metodo para eliminar pagos
    public function eliminar($idpago)
    {
        $sql="DELETE FROM pagos WHERE idpago='$idpago'";
        return ejecutarConsulta($sql);
    }
    
    //Implementamos el metodo para cancelar el pago
    public function mostrar($idpago)
    {
        $sql="SELECT * FROM pagos WHERE idpago='.$idpago.'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    //Implementamos el metodo para cancelar el pago
    public function listar()
	{
		$sql="SELECT p.idpago as idpago,
                    c.nombre as idcliente,
                    p.usuario as usuario, 
                    p.fecha as fecha,
                    p.cuota as cuota 
                    FROM pagos p INNER JOIN clientes c 
                    ON p.idcliente=c.idcliente";
        return ejecutarConsulta($sql);		
	}
}
?>