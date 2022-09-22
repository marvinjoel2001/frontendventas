<?php 
//Incluimos inicialmente la conexion a la base de datos
require "../config/Conexion.php";
    
Class Deuda
{
    //implementamos nuestro constructor
    public function __construct()
    {   
    }
    
    //implementamos un metodo para insertar registros
    public function insertar($idcliente,$usuario,$fdeuda,$monto,$saldo,$descripcion,$fplazo)
    {
        $sql="INSERT INTO deudas (idcliente,usuario,fdeuda,monto,saldo,descripcion,fplazo) 
        VALUES ('$idcliente','$usuario','$fdeuda','$monto','$saldo','$descripcion','$fplazo')";
        return ejecutarConsulta($sql);
    }
    
    //Implementamos el metodo para Editar Registros
    public function editar($iddeuda,$idcliente,$usuario,$fdeuda,$monto,$saldo,$descripcion,$fplazo)
	{
		$sql="UPDATE deudas SET 
                     idcliente='$idcliente',
                     usuario='$usuario',
                     fdeuda='$fdeuda',
                     monto='$monto',  
                     saldo='$saldo',
                     descripcion='$descripcion',
                     fplazo='$fplazo' 
                    WHERE iddeuda='$iddeuda'";
		return ejecutarConsulta($sql);
	}
    
    //Implementamos un método para eliminar categorías
	public function eliminar($iddeuda)
	{
		$sql="DELETE FROM deudas WHERE iddeuda='$iddeuda'";
		return ejecutarConsulta($sql);
	}
    
    //Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($iddeuda)
	{
		$sql="SELECT * FROM deudas WHERE iddeuda = '$iddeuda'";
		return ejecutarConsultaSimpleFila($sql);
	}
    
//mostrar lista de la tabla gastos    
    public function listar()
	{
		$sql="SELECT d.iddeuda,c.nombre as idcliente,u.nombre as usuario,DATE(d.fdeuda) as fdeuda,d.monto,d.saldo,DATE(d.fplazo) as fplazo 
        ,d.descripcion as descripcion FROM deudas d INNER JOIN clientes c ON 
        d.idcliente=c.idcliente INNER JOIN usuarios u ON 
        d.usuario=u.idusuario" ;
		return ejecutarConsulta($sql);		
	}
    
    public function select()
	{
		$sql="SELECT d.idprestamo,c.nombre FROM deudas d INNER JOIN clientes c ON d.idcliente=c.idcliente ORDER BY c.nombre ASC";
		return ejecutarConsulta($sql);		
	}
    public function selectid($id){
        $sql="SELECT c.nombre FROM deudas d INNER JOIN clientes c ON d.idcliente=c.idcliente WHERE d.idprestamo='$id' ORDER BY c.nombre ASC";
		return ejecutarConsulta($sql);
    }
}
?>