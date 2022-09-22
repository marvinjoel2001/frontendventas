<?php
require_once "../modelos/Garantia.php";

$garantia=new Garantia();

$idgarantia=isset($_POST["idgarantia"])? limpiarCadena($_POST["idgarantia"]):"";
$nombreobjeto=isset($_POST["nombreobjeto"])? limpiarCadena($_POST["nombreobjeto"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$idprestamo=isset($_POST["idprestamo"])? limpiarCadena($_POST["idprestamo"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$estadodev=isset($_POST["estadodev"])? limpiarCadena($_POST["estadodev"]):"";


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
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
            }
        }
		if (empty($idgarantia)){
			$rspta=$garantia->insertar($nombreobjeto,$descripcion,$imagen,$idprestamo,$estado,$estadodev);
			echo $rspta ? "Garantia registrada" : "Garantia no se pudo registrar";
		}
		else {
			$rspta=$garantia->editar($idgarantia,$nombreobjeto,$descripcion,$imagen,$idprestamo,$estado,$estadodev);
			echo $rspta ? "Garantia actualizada" : "Garantia no se pudo actualizar";
		}
	break;
        
   case 'eliminar':
		$rspta=$garantia->eliminar($idgarantia);
 		echo $rspta ? "Garantia Eliminada" : "Garantia no se puede eliminar";
	break;
        
    case 'mostrar':
        $rspta=$garantia->mostrar($idgarantia);
        //Codificar el resultado con json
        echo json_encode($rspta);
    break;
        
    case 'listar':
        $rspta=$garantia->listar();
        //vamos a declarar un array
        $data= Array();
        
        
        while ($reg=$rspta->fetch_object()){
            $estado="";
            $estadodev='';
            switch ($reg->estado ) {
                    case '1':
                        $estado = "Usado";
                        break;
                    case '2':
                        $estado = "Medio Uso";
                        break;    
                    case '3':
                        $estado = "Nuevo";
                        break;
                    
                    default:
                        $estado = "Nose registro estado";
                        break;
            }
            switch($reg->estadodev){
                case '1':
                    $estadodev='<span class="label bg-success">Devuelto</span>';
                    break;
                case '2':
                    $estadodev='<span class="label bg-danger">No devuelto</span>';
                    break;
                default:
                $estado = "Nose tiene registro de la devolucion";
                break;   
            }
 			$data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idgarantia.')"> <i class="fa fa-pencil"> </i></button>'.
 					 ' <button class="btn btn-danger" onclick="eliminar('.$reg->idgarantia.')"> <i class="fa fa-trash"> </i></button>',
                "1"=>$reg->nombreobjeto,
                "2"=>$reg->descripcion,
                "3"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' >",
                "4"=>$reg->nombre,
                "5"=>$estado,
                "6"=>$estadodev
            );
        }
        
        $results = array(
        "sEcho"=>1, //Informacion para el datatables
            "iTotalRecords"=>count($data), //Enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
        
    case "selectPrestamo":
        require_once "../modelos/Prestamos.php";
        $prestamo = new Prestamo();
        
        $rspta = $prestamo->select();
        
        while($reg = $rspta->fetch_object())
        {
            echo '<option value='.$reg->idprestamo.'>'.$reg->nombre .'</option>';
        }
    break;
}

?>