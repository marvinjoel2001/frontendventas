var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		if($('#id').val() != '') {
			convertirAJson2(e);
			// si el valor del input no es vacío
		  } else {
			convertirAJson(e);
			// si el valor del input es vacío
		  }	
	})

}

//Función limpiar
function limpiar()
{
	$("#nombre").val("");
    $("#descripcion").val("");
    $("#precio").val("");
    $('#idproducto').val("");
}

//Función mostrar formulario
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

//Función cancelarform
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
            url: 'https://localhost:7060/api/Products',
            type: "GET",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            },
			dataSrc: function (data) {
                return data;
            }
        },
        "columns": [
			{
				"render": function (data, type, row) {
					return '<button class="btn btn-warning" onclick="mostrar('+row.id+')"> <i class="fa fa-pencil"> </i></button> <button class="btn btn-danger" onclick="eliminar(' + row.id + ')"> <i class="fa fa-trash"> </i></button>';
				}
			},
			{ "data": "name" },
			{ "data": "description" },
			{ "data": "price" },
			{"data": "cost"}
		],
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación
        "order": [
            [0, "asc"]
        ] //Ordenar (columna,orden)
    }).DataTable();
}
function convertirAJson2(e) {
	e.preventDefault(); // evita el comportamiento por defecto del formulario
    
    // obtiene los valores de los campos
    var name = $("#name").val();
    var id = $("#id").val();
    var description = $("#description").val();
    var price = $("#price").val();
    var cost = $("#cost").val();

    // crea un objeto con los datos del formulario
    var data = {
		id:id,
        name: name,
        description: description,
        price: price,
        cost: cost
    };

    // llama a la función para enviar el formulario
    update('PUT', data);
}
//Función para guardar o editar
function convertirAJson(e) {
	e.preventDefault(); // evita el comportamiento por defecto del formulario
    
    // obtiene los valores de los campos
    var name = $("#name").val();
    var id = $("#id").val();
    var description = $("#description").val();
    var price = $("#price").val();
    var cost = $("#cost").val();

    // crea un objeto con los datos del formulario
    var data = {
        name: name,
        description: description,
        price: price,
        cost: cost
    };

    // llama a la función para enviar el formulario
    create('POST', data);
}
function create(type, data){
	var token = document.cookie.replace(/(?:(?:^|.*;\s*)token\s*\=\s*([^;]*).*$)|^.*$/, "$1");
	$.ajax({
		url: "https://localhost:7060/api/Products",
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
		url: "https://localhost:7060/api/Products/" + data.id,
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
function mostrar(idproducto)
{
    $.ajax({
        url: "https://localhost:7060/api/Products/" + idproducto,
        type: "GET",
        headers: {
            "Content-Type": "application/json"
        },
        success: function(data) {
            mostrarform(true);
			
			$("#id").val(data.id);
            $("#name").val(data.name);
            $("#description").val(data.description);
            $("#price").val(data.price);
			$("#cost").val(data.cost);

            $("#idproducto").val(data.idproducto);
        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}
function eliminar(idproducto)
{
    bootbox.confirm("¿Está seguro de eliminar este producto?", function(result){
        if(result)
        {
            var token = document.cookie.replace(/(?:(?:^|.*;\s*)token\s*\=\s*([^;]*).*$)|^.*$/, "$1");
            $.ajax({
                url: 'https://localhost:7060/api/Products/' + idproducto,
                type: "DELETE",
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(e) {
                    bootbox.alert("eliminado correctamente");
                    location.reload();
                },
                error: function(e) {
                    console.log(e.responseText);
                }
            });
        }
    })
}
init();