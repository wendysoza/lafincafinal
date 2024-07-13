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
	//Mostramos los permisos

	$.post("../ajax/socios.php?op=selecttipo", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_tipo_d").html(r);
        $('#id_tipo_d').selectpicker('refresh');
    });
}


//Función limpiar
function limpiar()
{
	$("#id_socio").val("");
	$("#id_tipo_d").val("");
	$('#id_tipo_d').selectpicker('refresh');
	$("#nombres_s").val("");
	$("#apellidos_s").val("");
	$("#cedula_s").val("");
	$("#porc_d").val("");
	$("#telefono_s").val("");
	$("#lugar_s").val("");
	$("#direccion_s").val("");
	$("#necesidad").val("");
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
					url: '../ajax/socios.php?op=listar',
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
		url: "../ajax/socios.php?op=guardaryeditar",
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

function mostrar(id_socio)
{
	$.post("../ajax/socios.php?op=mostrar",{id_socio : id_socio}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#id_socio").val(data.id_socio);
        $("#id_tipo_d").val(data.id_tipo_d);
        $('#id_tipo_d').selectpicker('refresh');
        $("#nombres_s").val(data.nombres_s);
        $("#apellidos_s").val(data.apellidos_s);
        $("#cedula_s").val(data.cedula_s);
        $("#porc_d").val(data.porc_d);
        $("#telefono_s").val(data.telefono_s);
        $("#lugar_s").val(data.lugar_s);
        $("#direccion_s").val(data.direccion_s);
        $("#necesidad").val(data.necesidad);
 	});
}

//Función para desactivar registros
function desactivar(id_socio)
{
	bootbox.confirm("¿Está seguro de desactivar el socio?", function(result){
		if(result)
        {
        	$.post("../ajax/socios.php?op=desactivar", {id_socio : id_socio}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_socio)
{
	bootbox.confirm("¿Está seguro de activar el socio?", function(result){
		if(result)
        {
        	$.post("../ajax/socios.php?op=activar", {id_socio : id_socio}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();