var tabla;

//Funcion que se ejecuta al inicio

function init() {

    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })
    
    //Cargamos los items al select Usuario
	$.post("../ajax/entradas.php?op=selectProducto", function(r){
                
	            $("#idproducto").html(r);
	            $('#idproducto').selectpicker('refresh');

	});
}

//Funcion Limpiar
function limpiar() {    
    $("#idproducto").val("");
    $("#cantidad").val("");
    $("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
   
    
    //Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha').val(today);
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
            url: '../ajax/entradas.php?op=listar',
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
        url: "../ajax/entradas.php?op=guardaryeditar",
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

function mostrar(identrada) {
    $.post("../ajax/entradas.php?op=mostrar", {identrada : identrada}, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $('#identrada').val(data.identrada);
        $("#idproducto").val(data.idproducto);
        $('#idproducto').selectpicker('refresh');
        $("#cantidad").val(data.cantidad);
        $("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/entradas"+data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#fecha").val(data.fecha);
       
    })
}
//Función para eliminar registros
function eliminar(identrada)
{
	bootbox.confirm("¿Está Seguro de eliminar la entrada de producto ?", function(result){
		if(result)
        {
        	$.post("../ajax/entradas.php?op=eliminar", {identrada : identrada}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();