var tabla;

//Funcion que se ejecuta al inicio
function init(){
	
    mostrarform(false);
    listar();
    $("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
    
    //Cargamos los items al select Cliente
	$.post("../ajax/ventas.php?op=selectProducto", function(r){
	            $("#idproducto1").append(r);
	            $('#idproducto1').selectpicker('refresh');
	});
    //Cargamos los items al select Usuarios
   
}
function mostrarventa()
{
	
    $.post("../ajax/ventas.php?op=mostrarVenta", function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
        $valor=parseInt(data.id) + 1;
		document.getElementById("numventa").textContent=$valor;
		$("#ventaultimo").val($valor);
 	});
}
var idproductogenerar=1;    
function agregar(){
    idproductogenerar= idproductogenerar + 1;
    var producto='<div class="form-group col-md-7 col-sm-9 col-xs-12"><label>Producto</label><select class="form-control selectpicker" id="idproducto' + idproductogenerar +'" name="idproducto' + idproductogenerar +'" data-live-search="true" >prueba</select></div><div class="form-group col-md-3 col-sm-9 col-xs-12"><label>Cantidad</label><input type="number" name="cantidad' + idproductogenerar +'" id="cantidad' + idproductogenerar +'" class="form-control" placeholder="Cantidad" required></div><div class="form-group col-md-2 col-sm-9 col-xs-12"><label>Precio</label><input type="number" name="precio' + idproductogenerar +'" id="precio' + idproductogenerar +'" class="form-control" placeholder="Precio" required></div>';
	$('#listproductos').append(producto);
    $.post("../ajax/ventas.php?op=selectProducto", function(r){
	            $("#idproducto" + idproductogenerar).append(r);
	            $('#idproducto' + idproductogenerar).selectpicker('refresh');
	});
	$("#idproductogenerar").val(idproductogenerar);
}
function calcular(){
    var total=0.0;
    var i=1;
    for (i=1;i<=idproductogenerar;i++){
        var cantidadp=parseFloat($("#cantidad"+i).val());
        var preciop=parseFloat($("#precio"+i).val()); 
        var mul=cantidadp * preciop;
        var total=total + mul;
    }
    if(isNaN(total)){
        alert("por favor llene todos los campos");
    }else{
     $("#total").val(total);   
    }
    
}
//Funcion Limpiar
function limpiar(){
    $("#idventa").val("");
    $("#idproducto1").val("");
    $("#fventa").val("");
    $("#cantidad1").val("");
	$("#precio1").val("");
    $("#total").val("");
	$("#idproductogenerar").val(idproductogenerar);
	$.post("../ajax/ventas.php?op=mostrarVenta", function(data, status)
	{
		data = JSON.parse(data);
		$varconverint=parseInt(data.id);
		if(isNaN($varconverint)){
			$valor= 1 ;
			document.getElementById("numventa").textContent=$valor;
			$("#ventaultimo").val($valor);
			
		}else{
			$valor=parseInt(data.id) + 1;
			document.getElementById("numventa").textContent=$valor;
			$("#ventaultimo").val($valor);
			
		}	
        
 	});

    //Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fventa').val(today);
	
	
    
}

//Mostrar Formulario
function mostrarform(flag)
{
	
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

function cancelarform()
{
    limpiar();
    mostrarform(false);
}


function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/ventas.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}




function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/ventas.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}





function mostrar(idventa)
{
	$.post("../ajax/ventas.php?op=mostrar",{idventa : idventa}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idproducto1").val(data.idproducto);
        $('#idproducto1').selectpicker('refresh');
        $("#usuario").val(data.idusuario);
        $('#usuario').selectpicker('refresh');
		$("#fventa").val(data.fecha);
		$("#total").val(data.total);

 	});
}

//Función para eliminar registros
function eliminar(idventa)
{
	bootbox.confirm("¿Está Seguro de eliminar esta Venta se eliminaran todos los de la venta?", function(result){
		if(result)
        {
        	$.post("../ajax/ventas.php?op=eliminar", {idventa : idventa}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


init();