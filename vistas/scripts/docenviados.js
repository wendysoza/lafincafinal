var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	
}


//Función limpiar
function limpiar()
{
	$("#id_doc_e").val("");
	$("#num_oficio").val("");
	$("#cargo").val("");
	$("#para").val("");
	$("#fecha").val("");
	$("#observaciones").val("");
	$("#documento_e").val("");
    $("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");
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
					url: '../ajax/docenviados.php?op=listar',
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
		url: "../ajax/docenviados.php?op=guardaryeditar",
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

function mostrar(id_doc_e)
{
	$.post("../ajax/docenviados.php?op=mostrar",{id_doc_e : id_doc_e}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#id_doc_e").val(data.id_doc_e);
        $("#num_oficio").val(data.num_oficio);
        $("#cargo").val(data.cargo);
        $("#para").val(data.para);
        $("#fecha").val(data.fecha);
        $("#observaciones").val(data.observaciones);
        if(data.documento_e != ""){ 
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src","../files/documentosenviados/"+data.documento_e);
        } 
    
            $("#imagenactual").val(data.documento_e);
    })
}

//Función para desactivar registros
function desactivar(id_doc_e)
{
	bootbox.confirm("¿Está seguro de desactivar el documento enviado?", function(result){
		if(result)
        {
        	$.post("../ajax/docenviados.php?op=desactivar", {id_doc_e : id_doc_e}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_doc_e)
{
	bootbox.confirm("¿Está seguro de activar el documento enviado?", function(result){
		if(result)
        {
        	$.post("../ajax/docenviados.php?op=activar", {id_doc_e : id_doc_e}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();