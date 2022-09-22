var tabla;

//Funcion que se ejecuta al inicio

function init() {

    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })
    
    //Cargamos los items al select Usuario
	$.post("../ajax/multas.php?op=selectCliente", function(r){
                
	            $("#idprestamo").html(r);
	            $('#idprestamo').selectpicker('refresh');

	});
}

//Funcion Limpiar
function limpiar() {
    $("#idmulta").val("");
    $("#monto").val("");
    $("#fmulta").val("");
    $("#idprestamo").val("");
    $("#razon").val("");
    
    //Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fmulta').val(today);
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
            url: '../ajax/multas.php?op=listar',
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
        url: "../ajax/multas.php?op=guardaryeditar",
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

function mostrar(idmulta) {
    $.post("../ajax/multas.php?op=mostrar", {
        idmulta: idmulta
    }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#idprestamo").val(data.idcliente);
        $('#idprestamo').selectpicker('refresh');
        $("#fmulta").val(data.fmulta);
        $("#razon").val(data.razon);
        $("#monto").val(data.monto);
        $("#idmulta").val(data.idmulta);
    })
}
//Función para eliminar registros
function eliminar(idmulta)
{
	bootbox.confirm("¿Está Seguro de eliminar la multa?", function(result){
		if(result)
        {
        	$.post("../ajax/multas.php?op=eliminar", {idmulta : idmulta}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();