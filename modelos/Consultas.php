<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function comprasfecha()
	{
				
	}
	public function totalventas10dias()
	{
		$fecha = date('Y-m-d');
		$nuevaFecha = date("Y-m-d",strtotime ( '-10 day' , strtotime ( $fecha ) ) );
		$sql="SELECT fecha , total FROM ventas WHERE fecha BETWEEN '$nuevaFecha' AND '$fecha'  GROUP BY fecha;";
		return ejecutarConsulta($sql);
	}
	public function totalpago10dias(){
		$fecha = date('Y-m-d');
		$nuevaFecha = date('Y-m-d',strtotime( '-10 day' , strtotime ( $fecha ) ) );
		$sql="SELECT fecha, cuota FROM pagos WHERE fecha BETWEEN '$nuevaFecha' AND '$fecha' GROUP BY fecha";
		return ejecutarConsulta($sql);
	}
	public function totalgastos(){
		$sql="SELECT gasto FROM gastos";
		return ejecutarConsulta($sql);
	}


	public function totalmontohoy()
	{
		$sql="SELECT IFNULL(SUM(monto),0) as total_montos FROM prestamos WHERE DATE(fprestamo)=curdate()";
		return ejecutarConsulta($sql);
	}
    public function totalpagoshoy()
	{
		$sql="SELECT IFNULL(SUM(cuota),0) as total_pagos FROM pagos WHERE DATE(fecha)=curdate()";
		return ejecutarConsulta($sql);
	}
    
	public function totalgastohoy()
	{
		$sql="SELECT IFNULL(SUM(gasto),0) as total_gasto FROM gastos WHERE DATE(fecha)=curdate()";
		return ejecutarConsulta($sql);
	}
	public function totalpago(){
		$sql="SELECT cuota FROM pagos";
		return ejecutarConsulta($sql);
	}
	public function totaldeuda(){
		$sql="SELECT monto FROM deudas";
		return ejecutarConsulta($sql);
	}
	
	public function totalclientes(){
			$sql="SELECT idcliente FROM clientes";
			return ejecutarConsulta($sql);
	}

}

?>