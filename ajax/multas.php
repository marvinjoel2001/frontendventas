<?php
require_once "../modelos/Multas.php";

$multas=new Multa();

$idmulta=isset($_POST["idmulta"])? limpiarCadena($_POST["idmulta"]):"";
$idcliente=isset($_POST["idprestamo"])? limpiarCadena($_POST["idprestamo"]):"";
$fmulta=isset($_POST["fmulta"])? limpiarCadena($_POST["fmulta"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$razon=isset($_POST["razon"])? limpiarCadena($_POST["razon"]):"";


switch($_GET["op"]){
        
   case 'guardaryeditar':
		if (empty($idmulta)){
			$rspta=$multas->insertar($monto,$idcliente,$fmulta,$razon);
			echo $rspta ? "Multa registrado" : "Multa no se pudo registrar";
		}
		else {
			$rspta=$multas->editar($idmulta,$monto,$idcliente,$fmulta,$razon);
			echo $rspta ? "Multa actualizada" : "Multa no se pudo actualizar";
		}
	break;
        
   case 'eliminar':
		$rspta=$multas->eliminar($idmulta);
 		echo $rspta ? "Multa Eliminada" : "Multa no se puede eliminar";
	break;
        
    case 'mostrar':
        $rspta=$multas->mostrar($idmulta);
        //Codificar el resultado con json
        echo json_encode($rspta);
    break;
        
    case 'listar':
        $rspta=$multas->listar();
        //vamos a declarar un array
        $data= Array();
        
        while ($reg=$rspta->fetch_object()){
 			$data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idmulta.')"> <i class="fa fa-pencil"> </i></button>'.
 					 ' <button class="btn btn-danger" onclick="eliminar('.$reg->idmulta.')"> <i class="fa fa-trash"> </i></button>',
                "1"=>$reg->monto,
                "2"=>$reg->nombre,
                "3"=>$reg->fmulta,
                "4"=>$reg->razon 
            );
        }
        
        $results = array(
        "sEcho"=>1, //Informacion para el datatables
            "iTotalRecords"=>count($data), //Enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
        
    case "selectCliente":
        require_once "../modelos/Clientes.php";
        $cliente = new Clientes();
        
        $rspta = $cliente->select();
        
        while($reg = $rspta->fetch_object())
        {
            echo '<option value='.$reg->idcliente.'>'.$reg->nombre.'////'.$reg->idcliente.'</option>';
        }
    break;
}

?>