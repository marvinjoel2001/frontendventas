<?php 
//Incluimos inicialmente la conexion a la base de datos
require "../config/Conexion.php";
    
Class Garantia
{
    //implementamos nuestro constructor
    public function __construct()
    {   
    }
    
    //implementamos un metodo para insertar registros
    public function insertar($nombreobjeto,$descripcion,$imagen,$idprestamo,$estado,$estadodev)
    {
        $sql="INSERT INTO garantia (nombreobjeto,descripcion,imagen,idprestamo,estado,estadodev)
		                  VALUES ('$nombreobjeto','$descripcion','$imagen','$idprestamo','$estado','$estadodev')";
		return ejecutarConsulta($sql);
    }
    
    //Implementamos el metodo para Editar Registros
    public function editar($idgarantia,$nombreobjeto,$descripcion,$imagen,$idprestamo,$estado,$estadodev)
	{
		$sql="UPDATE garantia SET idgarantia='$idgarantia',
                                nombreobjeto='$nombreobjeto',
                                descripcion='$descripcion',
                                imagen='$imagen',
                                idprestamo='$idprestamo',
                                estado='$estado',
                                estadodev='$estadodev'
                                WHERE idgarantia='$idgarantia'";
		return ejecutarConsulta($sql);
	}
    
    //implementamos el metodo eliminar
    public function eliminar($idgarantia)
	{
		$sql="DELETE FROM garantia WHERE idgarantia='$idgarantia'";
		return ejecutarConsulta($sql);
	}
    
    //Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idgarantia)
	{
		$sql="SELECT * FROM garantia WHERE idgarantia='$idgarantia'";
		return ejecutarConsultaSimpleFila($sql);
	}
    
//mostrar lista de la tabla garantia    
    public function listar()
	{
		$sql="SELECT g.idgarantia,
        g.nombreobjeto,
        c.nombre,
        g.descripcion,
        g.imagen,
        g.estado,
        g.estadodev
        FROM garantia g INNER JOIN prestamos p 
        ON g.idprestamo=p.idprestamo
                            INNER JOIN clientes c ON
                            p.idcliente= c.idcliente WHERE p.idprestamo=g.idprestamo
                            ";
		return ejecutarConsulta($sql);		
	}
    public function selectid($id){
        $sql="SELECT c.nombre FROM prestamos p INNER JOIN clientes c ON p.idcliente=c.idcliente WHERE p.estado=1  AND p.idprestamo='$id' ORDER BY c.nombre ASC";
		return ejecutarConsulta($sql);
    }

}

?>