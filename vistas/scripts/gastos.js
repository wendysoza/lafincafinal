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

function vtotal(){
    cantidad=$("#cantidad").val();
	v_u=$("#v_u").val();


	calc1 = parseFloat(cantidad*v_u).toFixed(2);

	$("#v_t").val(calc1);
}


//Función limpiar
function limpiar()
{
	$("#id_gasto").val("");
	$("#descripcion").val("");
	$("#cantidad").val("");
    $("#v_u").val("");
    $("#v_t").val("");
	$("#fecha_g").val("");
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
					url: '../ajax/gastos.php?op=listar',
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
		url: "../ajax/gastos.php?op=guardaryeditar",
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

function mostrar(id_gasto)
{
	$.post("../ajax/gastos.php?op=mostrar",{id_gasto : id_gasto}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#id_gasto").val(data.id_gasto);
        $("#descripcion").val(data.descripcion);
        $("#cantidad").val(data.cantidad);
        $("#v_u").val(data.v_u);
        $("#v_t").val(data.v_t);
        $("#fecha_g").val(data.fecha_g);
 	});
}

//Función para desactivar registros
function desactivar(id_gasto)
{
	bootbox.confirm("¿Está seguro de desactivar el gasto?", function(result){
		if(result)
        {
        	$.post("../ajax/gastos.php?op=desactivar", {id_gasto : id_gasto}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_gasto)
{
	bootbox.confirm("¿Está seguro de activar el gasto?", function(result){
		if(result)
        {
        	$.post("../ajax/gastos.php?op=activar", {id_gasto : id_gasto}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();