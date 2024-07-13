var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

    $.post("../ajax/animales.php?op=selectespecie", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_especie").html(r);
        $('#id_especie').selectpicker('refresh');
    });

    $.post("../ajax/animales.php?op=selectClientes", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_cli").html(r);
        $('#id_cli').selectpicker('refresh');
    });
}


//Función limpiar
function limpiar()
{
	$("#id_cli").val("");
    $('#id_cli').selectpicker('refresh');
	$("#id_animal").val("");
    $("#id_especie").val("");
    $('#id_especie').selectpicker('refresh');
    $("#raza").val("");
    $("#observacion").val("");
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
					url: '../ajax/animales.php?op=listar',
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
		url: "../ajax/animales.php?op=guardaryeditar",
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

function mostrar(id_animal)
{
	$.post("../ajax/animales.php?op=mostrar",{id_animal : id_animal}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#id_cli").val(data.id_cli);
        $('#id_cli').selectpicker('refresh');
        $("#id_animal").val(data.id_animal);
        $("#id_especie").val(data.id_especie);
        $('#id_especie').selectpicker('refresh');
        $("#raza").val(data.raza);
        $("#observacion").val(data.observacion);
 	});
}

//Función para desactivar registros
function desactivar(id_animal)
{
	bootbox.confirm("¿Está seguro de desactivar el animal?", function(result){
		if(result)
        {
        	$.post("../ajax/animales.php?op=desactivar", {id_animal : id_animal}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_animal)
{
	bootbox.confirm("¿Está seguro de activar el animal?", function(result){
		if(result)
        {
        	$.post("../ajax/animales.php?op=activar", {id_animal : id_animal}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();