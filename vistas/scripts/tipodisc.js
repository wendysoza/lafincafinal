var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	$("#imagenmuestra").hide();
	//Mostramos los permiso
}


//Función limpiar
function limpiar()
{
	$("#id_tipo_d").val("");
	$("#tipo_d").val("");
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
					url: '../ajax/tipodisc.php?op=listar',
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
		url: "../ajax/tipodisc.php?op=guardaryeditar",
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

function mostrar(id_tipo_d)
{
	$.post("../ajax/tipodisc.php?op=mostrar",{id_tipo_d : id_tipo_d}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#id_tipo_d").val(data.id_tipo_d);
        $("#tipo_d").val(data.tipo_d);
 	});
}

//Función para desactivar registros
function desactivar(id_tipo_d)
{
	bootbox.confirm("¿Está seguro de desactivar el tipo de discapacidad?", function(result){
		if(result)
        {
        	$.post("../ajax/tipodisc.php?op=desactivar", {id_tipo_d : id_tipo_d}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_tipo_d)
{
	bootbox.confirm("¿Está seguro de activar el tipo de discapacidad?", function(result){
		if(result)
        {
        	$.post("../ajax/tipodisc.php?op=activar", {id_tipo_d : id_tipo_d}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();