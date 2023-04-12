var tabla;

//Funcion que se ejecuta al inicio
function init(){
	
    mostrarform(false);
    listar();
    $("#formulario").on("submit",function(e)
	{
		if($('#id').val() != '') {
			convertirAJson2(e);
		  } else {
			convertirAJson(e);
		  }	
	});
    
	$.get("https://localhost:7060/api/Products", function(data) {
    var options = "";
    $.each(data, function(key, value) {
        options += "<option value='" + value.id + "'>" + value.name + " - $" + value.price + "</option>";
    });
    $("#idproducto1").html(options);
    $('#idproducto1').selectpicker('refresh');
	});
    
   
}

function convertirAJson2(e) {
	e.preventDefault(); // evita el comportamiento por defecto del formulario
    
    // obtiene los valores de los campos
    var id = $("#id").val();
    var productId = $("#idproducto1").val();
    var quantity = $("#cantidad1").val();


    // crea un objeto con los datos del formulario
    var data = {
        id:id,
        productId:productId, 
        quantity:quantity
    };


    // llama a la función para enviar el formulario
    update('PUT', data);
}
//Función para guardar o editar
function convertirAJson(e) {
	e.preventDefault(); // evita el comportamiento por defecto del formulario
    
    // obtiene los valores de los campos
    
    var productId = $("#idproducto1").val();
    var quantity = $("#cantidad1").val();

    // crea un objeto con los datos del formulario
    var data = {
        productId:productId, 
        quantity:quantity
    };

    // llama a la función para enviar el formulario
    create('POST', data);
}
function create(type, data){
	var token = document.cookie.replace(/(?:(?:^|.*;\s*)token\s*\=\s*([^;]*).*$)|^.*$/, "$1");
	$.ajax({
		url: "https://localhost:7060/api/Inventories",
		type: type,
		data: JSON.stringify(data),
		contentType: "application/json; charset=utf-8",
		headers: {
			'Authorization': 'Bearer ' + token
		},
		success: function(response)
		{                    
			bootbox.alert("creado exitosamente");	          
			mostrarform(false);
			tabla.ajax.reload();
		},
		error: function(error)
		{
			console.log("Ah ocurrido un error");
		}
	});
}
function update(type, data){
	var token = document.cookie.replace(/(?:(?:^|.*;\s*)token\s*\=\s*([^;]*).*$)|^.*$/, "$1");
	$.ajax({
		url: "https://localhost:7060/api/Inventories/" + data.id,
		type: type,
		data: JSON.stringify(data),
		contentType: "application/json; charset=utf-8",
		headers: {
			'Authorization': 'Bearer ' + token
		},
		success: function(response)
		{                    
			bootbox.alert("aptualizado exitosamente");	          
			mostrarform(false);
			tabla.ajax.reload();
		},
		error: function(error)
		{
			console.log("Ah ocurrido un error");
		}
	});
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
    $.get("https://localhost:7060/api/Products", function(response) {
    $.each(response, function(i, item) {
        var option = $('<option></option>').attr("value", item.id).text(item.name + ' - $' + item.price);
        $("#idproducto" + idproductogenerar).append(option);
    });
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


function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'pdf'
        ],
        "ajax": {
            url: 'https://localhost:7060/api/Inventories',
            type: "GET",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            },
            dataSrc: function (data) {
                return data;
            }
        },
        "columns": [
            {
                "data": null,
                "render": function (data, type, row) {
                    return '<button class="btn btn-warning" onclick="mostrar('+row.id+')"> <i class="fa fa-pencil"> </i></button> <button class="btn btn-danger" onclick="eliminar(' + row.id + ')"> <i class="fa fa-trash"> </i></button>';
                }
            },
            { "data": "productId" },
            { "data": "quantity"}
        ],
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación
        "order": [
            [0, "desc"]
        ] //Ordenar (columna,orden)
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

function mostrar(idinventory)
{
    $.ajax({
        url: "https://localhost:7060/api/Inventories/" + idinventory,
        type: "GET",
        headers: {
            "Content-Type": "application/json"
        },
        success: function(data) {
            mostrarform(true);
			
			$("#id").val(data.id);
            $("#idproducto1").val(data.productId);
            $("#cantidad1").val(data.quantity);
        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}

//Función para eliminar registros
function eliminar(idinventory)
{
    bootbox.confirm("¿Está Seguro de eliminar este inventario?", function(result){
        if(result)
        {
            // leer el token de la cookie
            var token = document.cookie.replace(/(?:(?:^|.*;\s*)token\s*\=\s*([^;]*).*$)|^.*$/, "$1");           
            $.ajax({
                url: 'https://localhost:7060/api/Inventories/' + idinventory,
                type: "DELETE",
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token // agregar el token como cabecera
                },
                success: function(e) {
                    bootbox.alert("Eliminado correctamente");
                    location.reload();
                },
                error: function(e) {
                    console.log("Ocurrio un error al eliminar intentalo mas tarde");
                }
            });
        }
    })
}
init();