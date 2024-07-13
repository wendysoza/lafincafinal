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
}


//Función limpiar
function limpiar()
{
	$("#id_ayuda").val("");
	$("#descripcion").val("");
	$("#cantidad").val("");
	$("#existencia").val("");
	$("#tamaño").val("");
	$("#observaciones").val("");
	$("#foto_ayuda").val("");
    $("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#imagenmuestra").hide();
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
					url: '../ajax/ayudas.php?op=listar',
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
		url: "../ajax/ayudas.php?op=guardaryeditar",
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

function mostrar(id_ayuda)
{
	$.post("../ajax/ayudas.php?op=mostrar",{id_ayuda : id_ayuda}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#id_ayuda").val(data.id_ayuda);
        $("#descripcion").val(data.descripcion);
        $("#cantidad").val(data.cantidad);
        $("#existencia").val(data.existencia);
        $("#tamaño").val(data.tamaño);
        $("#observaciones").val(data.observaciones);
        $("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/ayudastec/"+data.foto_ayuda);
		$("#imagenactual").val(data.foto_ayuda);
 	});
}

//Función para desactivar registros
function desactivar(id_ayuda)
{
	bootbox.confirm("¿Está seguro de desactivar la ayuda técnica?", function(result){
		if(result)
        {
        	$.post("../ajax/ayudas.php?op=desactivar", {id_ayuda : id_ayuda}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_ayuda)
{
	bootbox.confirm("¿Está seguro de activar la ayuda técnica?", function(result){
		if(result)
        {
        	$.post("../ajax/ayudas.php?op=activar", {id_ayuda : id_ayuda}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();