<?php
//session_start(); 
require_once "../modelos/Deudas.php";

$deuda=new Deuda();

$iddeuda=isset($_POST["iddeuda"])? limpiarCadena($_POST["iddeuda"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$usuario=isset($_POST["usuario"])? limpiarCadena($_POST["usuario"]):"";
$fdeuda=isset($_POST["fdeuda"])? limpiarCadena($_POST["fdeuda"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$saldo=isset($_POST["saldo"])? limpiarCadena($_POST["saldo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$fplazo=isset($_POST["fplazo"])? limpiarCadena($_POST["fplazo"]):"";
//$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($iddeuda)){
			$rspta=$deuda->insertar($idcliente,$usuario,$fdeuda,$monto,$saldo,$descripcion,$fplazo);
			echo $rspta ? "Deuda registrada" : "Deuda no se pudo registrar";
		}
		else {
			$rspta=$deuda->editar($iddeuda,$idcliente,$usuario,$fdeuda,$monto,$saldo,$descripcion,$fplazo);
			echo $rspta ? "Deuda actualizada" : "Deuda no se pudo actualizar";
		}
	break;
        
    case 'eliminar':
		$rspta=$deuda->eliminar($iddeuda);
 		echo $rspta ? "Deuda eliminada" : "Deuda no se puede eliminar";
	break;
    
	case 'mostrar':
		$rspta=$deuda->mostrar($iddeuda);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
	$rspta=$deuda->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
               "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->iddeuda.')"> <i class="fa fa-pencil"> </i></button>'.
 			        ' <button class="btn btn-danger" onclick="eliminar('.$reg->iddeuda.')"> <i class="fa fa-trash"> </i></button>',
 				"1"=>$reg->idcliente,
 				"2"=>$reg->usuario,
 				"3"=>$reg->fdeuda,
 				"4"=>$reg->monto,
 				"5"=>$reg->saldo,
 				"6"=>$reg->descripcion,
 				"7"=>$reg->fplazo
            );
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
        
    case 'selectCliente':
        require_once "../modelos/Clientes.php";
		$cliente = new Clientes();
		$rspta = $cliente->select();
		while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->idcliente . '>' . $reg->nombre . '</option>';
        }
	break;
        
    case "selectUsuario":
        require_once "../modelos/Usuarios.php";
        $usuario = new Usuarios();
        
        $rspta = $usuario->select();
        
        while($reg = $rspta->fetch_object())
        {
            echo '<option value='.$reg->idusuario .'>'.$reg->nombre .'</option>';
        }
    break;
}
?>