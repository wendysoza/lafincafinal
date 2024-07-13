var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

    $.post("../ajax/vacunacion.php?op=selectproductos", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_prod").html(r);
        $('#id_prod').selectpicker('refresh');
    });

    $.post("../ajax/vacunacion.php?op=selectanimales", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_animal").html(r);
        $('#id_animal').selectpicker('refresh');
    });
}


//Función limpiar
function limpiar()
{
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

	$("#id_vac").val("");
    $("#id_prod").val("");
    $('#id_prod').selectpicker('refresh');
	$("#id_animal").val("");
    $('#id_animal').selectpicker('refresh');
    $("#edad").val("");
    $("#peso").val("");
    $("#fecha_vac").val(today);
    $("#fecha_revac").val("");
    $("#lote").val("");
    $("#num_reg").val("");
    $("#laboratorio").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#btnreporte").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#btnreporte").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
	//location.reload();
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
	    buttons: [		          
		            /* 'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf' */
		        ],
		"ajax":
				{
					url: '../ajax/vacunacion.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
            "copyTitle": "Tabla Copiada",
            "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/vacunacion.php?op=guardaryeditar",
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

function mostrar(id_vac)
{
	$.post("../ajax/vacunacion.php?op=mostrar",{id_vac : id_vac}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#id_vac").val(data.id_vac);
        $('#id_prod').selectpicker('refresh');
        $('#id_prod').selectpicker('refresh');
        $("#id_animal").val(data.id_animal);
        $('#id_animal').selectpicker('refresh');
        $("#edad").val(data.edad);
        $("#peso").val(data.peso);
        $("#fecha_vac").val(data.fecha_vac);
        $("#fecha_revac").val(data.fecha_revac);
        $("#lote").val(data.lote);
        $("#num_reg").val(data.num_reg);
        $("#laboratorio").val(data.laboratorio);
 	});
}

//Función para desactivar registros
function desactivar(id_vac)
{
	bootbox.confirm("¿Está seguro de desactivar la vacunación?", function(result){
		if(result)
        {
        	$.post("../ajax/vacunacion.php?op=desactivar", {id_vac : id_vac}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_vac)
{
	bootbox.confirm("¿Está seguro de activar la vacunación?", function(result){
		if(result)
        {
        	$.post("../ajax/vacunacion.php?op=activar", {id_vac : id_vac}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();