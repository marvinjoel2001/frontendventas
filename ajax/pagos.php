<?php
require_once "../modelos/Pagos.php";

$pago=new Pago();

//Variables
$idpago=isset($_POST["idpago"])? limpiarCadena($_POST["idpago"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$usuario=isset($_POST["usuario"])? limpiarCadena($_POST["usuario"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$cuota=isset($_POST["cuota"])? limpiarCadena($_POST["cuota"]):"";

switch($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idpago)) {
            $rspta=$pago->insertar($idcliente, $usuario, $fecha, $cuota);
            echo $rspta ? "Pago Registrado" : "Pago No se Pudo Registrar";
        } else {
            $rspta=$pago->editar($idpago, $idcliente, $usuario, $fecha, $cuota);
            echo $rspta ? "Pago Actualizado" : "Pago no se pudo actualizar";
        }
        break;

    case 'eliminar':
        $rspta=$pago->eliminar($idpago);
        echo $rspta ? "Pago Eliminado" : "Pago no se puede eliminar";
        break;

    case 'mostrar':
        $rspta=$pago->mostrar($idpago);
        //Codificar resultado con json
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta=$pago->listar();
        //declaracion de array
        $data=array();

        while ($reg=$rspta->fetch_object()) {
            $data[]=array(
            "0"=>' <button class="btn btn-danger" onclick="eliminar('.$reg->idpago.')"> <i class="fa fa-trash"> </i></button>',
            "1"=>$reg->idcliente,
            "2"=>$reg->usuario,
            "3"=>$reg->fecha,
            "4"=>$reg->cuota);
        }
        $results = array(
        "sEcho"=>1, //Informacion para el datatables
            "iTotalRecords"=>count($data), //Enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
        break;

    case 'selectCliente':
        require_once "../modelos/Clientes.php";
        $cliente = new Clientes();
        $rspta = $cliente->select();
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idcliente . '>' . $reg->nombre . '</option>';
        }
        break;
}
?>