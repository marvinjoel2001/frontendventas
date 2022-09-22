<?php
//session_start(); 
require_once "../modelos/Ventas.php";

$venta=new Venta();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$usuario=isset($_POST["usuario"])? limpiarCadena($_POST["usuario"]):"";
$fventa=isset($_POST["fventa"])? limpiarCadena($_POST["fventa"]):"";
$total=isset($_POST["total"])? limpiarCadena($_POST["total"]):"";
$ultimavent=isset($_POST["ventaultimo"])? limpiarCadena($_POST["ventaultimo"]):"";
$idproductogenerar=isset($_POST["idproductogenerar"])? limpiarCadena($_POST["idproductogenerar"]):"";
$idproductogenerar=(int)$idproductogenerar;

//$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idventa)){
			$rspta=$venta->insertar($fventa,$usuario,$total);
			
			for($i=1;$i<=$idproductogenerar;$i++){
				$idproductod=isset($_POST["idproducto$i"])? limpiarCadena($_POST["idproducto$i"]):"";
				$cantidadd=isset($_POST["cantidad$i"])? limpiarCadena($_POST["cantidad$i"]):"";
				$preciod=isset($_POST["precio$i"])? limpiarCadena($_POST["precio$i"]):"";
				$rsptadeta=$venta->insertardetalle($ultimavent,$idproductod,$cantidadd,$preciod);
			}
			
			echo $rspta ? "Venta registrada" : "Venta no se pudo registrar";
		}
		else {
			$rspta=$venta->editar($idventa,$idproducto,$usuario,$fventa,$cantidad,$total);
			echo $rspta ? "Venta actualizada" : "Venta no se pudo actualizar";
		}
	break;
        
    case 'eliminar':
		$rspta=$venta->eliminar($idventa);
		;
 		echo $rspta ? "Venta eliminada" : "Venta no se puede eliminar";
	break;
    
	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
	$rspta=$venta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
               "0"=>'<button class="btn btn-danger" onclick="eliminar('.$reg->venta.')"> <i class="fa fa-trash"> </i></button>',
 				"1"=>$reg->venta,
 				"2"=>$reg->idproducto,
 				"3"=>$reg->fecha,
 				"4"=>$reg->cantidad,
 				"5"=>$reg->precio
            );
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
        
    case 'selectProducto':
        require_once "../modelos/Productos.php";
		$producto = new Productos();
		$rspta = $producto->select();
		while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->idproducto . '>' . $reg->nombre . '</option>';
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
	case "mostrarVenta":
        require_once "../modelos/Ventas.php";
        $venta = new Venta();        
        $rspta = $venta->ultimoid();
		echo json_encode($rspta);
    break;
}
?>