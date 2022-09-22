<?php
require_once "../modelos/Productos.php";

$productos=new Productos();

$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$precio=isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";


switch($_GET["op"]){
        
    case 'guardaryeditar':
		if (empty($idproducto)){
			$rspta=$productos->insertar($nombre,$descripcion,$precio);
			echo $rspta ? "Producto registrado" : "Producto no se pudo registrar";
		}
		else {
			$rspta=$productos->editar($idproducto,$nombre,$descripcion,$precio);
			echo $rspta ? "Producto actualizado" : "Producto no se pudo actualizar";
		}
	break;
        
    case 'eliminar':
		$rspta=$productos->eliminar($idproducto);
 		echo $rspta ? "Producto Eliminado" : "Producto no se puede eliminar";
	break;
        
    case 'mostrar':
        $rspta=$productos->mostrar($idproducto);
        //Codificar el resultado con json
        echo json_encode($rspta);
    break;
        
    case 'listar':
        $rspta=$productos->listar();
        //vamos a declarar un array
        $data= Array();
        
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"> <i class="fa fa-pencil"> </i></button>'.
 					 ' <button class="btn btn-danger" onclick="eliminar('.$reg->idproducto.')"> <i class="fa fa-trash"> </i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->descripcion,
                "3"=>'<strong><h2>'.$reg->precio.' bs</h2></strong>'
            );
        }
        
        $results = array(
        "sEcho"=>1, //Informacion para el datatables
            "iTotalRecords"=>count($data), //Enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
}

?>