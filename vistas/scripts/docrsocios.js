var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

    $.post("../ajax/docrsocios.php?op=selectsocios", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_socio").html(r);
        $('#id_socio').selectpicker('refresh');
    });
}


//Función limpiar
function limpiar()
{
	$("#id_d_r2").val("");
	$("#num_oficio").val("");
	$("#id_socio").val("");
    $('#id_socio').selectpicker('refresh');
	$("#fecha").val("");
	$("#observaciones").val("");
	$("#documento_r2").val("");
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
					url: '../ajax/docrsocios.php?op=listar',
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
		url: "../ajax/docrsocios.php?op=guardaryeditar",
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

function mostrar(id_d_r2)
{
	$.post("../ajax/docrsocios.php?op=mostrar",{id_d_r2 : id_d_r2}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#id_d_r2").val(data.id_d_r2);
        $("#num_oficio").val(data.num_oficio);
        $("#id_socio").val(data.id_socio);
        $('#id_socio').selectpicker('refresh');
        $("#fecha").val(data.fecha);
        $("#observaciones").val(data.observaciones);
        if(data.documento_r2 != ""){ 
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src","../files/documentosrecibidos/"+data.documento_r2);
        } 
    
            $("#imagenactual").val(data.documento_r2);
    })
}

//Función para desactivar registros
function desactivar(id_d_r2)
{
	bootbox.confirm("¿Está seguro de desactivar el documento recibido?", function(result){
		if(result)
        {
        	$.post("../ajax/docrsocios.php?op=desactivar", {id_d_r2 : id_d_r2}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_d_r2)
{
	bootbox.confirm("¿Está seguro de activar el documento recibido?", function(result){
		if(result)
        {
        	$.post("../ajax/docrsocios.php?op=activar", {id_d_r2 : id_d_r2}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();