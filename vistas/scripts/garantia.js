var tabla;

//Funcion que se ejecuta al inicio

function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })
    
    //Cargamos los items al select Usuario
	$.post("../ajax/garantia.php?op=selectPrestamo", function(r){
	            $("#idprestamo").html(r);
	            $('#idprestamo').selectpicker('refresh');

	});
}

//Funcion Limpiar
function limpiar() {
    $("#idgarantia").val("");
    $("#nombreobjeto").val("");
    $("#descripcion").val("");
    $("#imagen").val("");
    $("#idprestamo").val("");
    $("estado").val("");
    $("estadodev").val("");
    
}

//Mostrar Formulario

function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

function cancelarform() {
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
            url: '../ajax/garantia.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación
        "order": [
            [2, "desc"]
        ] //Ordenar (columna,orden)
    }).DataTable();
}

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/garantia.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(idgarantia) {
    $.post("../ajax/garantia.php?op=mostrar", {
        idgarantia: idgarantia
    }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#idgarantia").val(data.idgarantia);
        $('#idprestamo').selectpicker('refresh');
        $("#nombreobjeto").val(data.nombreobjeto);
        $("#descripcion").val(data.descripcion);
        $("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
		$("#imagenactual").val(data.imagen);
        $("#estado").val(data.estado);
        $("#estadodev").val(data.estadodev);
    })
}
//Función para eliminar registros
function eliminar(idgarantia)
{
	bootbox.confirm("¿Está Seguro de eliminar la Garantia?", function(result){
		if(result)
        {
        	$.post("../ajax/garantia.php?op=eliminar", {idgarantia : idgarantia}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();