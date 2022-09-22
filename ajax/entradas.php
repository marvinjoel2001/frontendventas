<?php
require_once "../modelos/Entradas.php";

$entrada=new Entradas();

$identrada=isset($_POST["identrada"])? limpiarCadena($_POST["identrada"]):"";
$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";



switch($_GET["op"]){
        
   case 'guardaryeditar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
        {
            $imagen=$_POST["imagenactual"];
        }
        else 
        {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
            {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/entradas" . $imagen);
            }
        }
		if (empty($identrada)){
			$rspta=$entrada->insertar($idproducto,$cantidad,$imagen,$fecha);
			echo $rspta ? "Entrada registrada" : "Entrada no se pudo registrar";
		}
		else {
			$rspta=$entrada->editar($identrada,$idproducto,$cantidad,$imagen,$fecha);
			echo $rspta ? "Entrada actualizada" : "Entrada no se pudo actualizar";
		}
	break;
        
    case 'eliminar':
		$rspta=$entrada->eliminar($identrada);
 		echo $rspta ? "Entrada Eliminada" : "Entrada no se puede eliminar";
	break;
        
    case 'mostrar':
        $rspta=$entrada->mostrar($identrada);
        //Codificar el resultado con json
        echo json_encode($rspta);
    break;
        
    case 'listar':
        $rspta=$entrada->listar();
        //vamos a declarar un array
        $data= Array();
        
        
        while ($reg=$rspta->fetch_object()){
 			$data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->identrada.')"> <i class="fa fa-pencil"> </i></button>'.
 					 ' <button class="btn btn-danger" onclick="eliminar('.$reg->identrada.')"> <i class="fa fa-trash"> </i></button>',
                "1"=>$reg->idproducto,
                "2"=>$reg->cantidad,
                "3"=>"<img src='../files/usuarios/entradas".$reg->imagen."' height='50px' width='50px' >",
                "4"=>$reg->fecha
            );
        }
        
        $results = array(
        "sEcho"=>1, //Informacion para el datatables
            "iTotalRecords"=>count($data), //Enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
        
    case "selectProducto":
        require_once "../modelos/Productos.php";
        $producto = new Productos();
        
        $rspta = $producto->select();
        
        while($reg = $rspta->fetch_object())
        {
            echo '<option value='.$reg->idproducto.'>'.$reg->nombre .'</option>';
        }
    break;
}

?>