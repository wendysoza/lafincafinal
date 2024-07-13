var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	$.post("../ajax/productos.php?op=selectcat", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_cat").html(r);
        $('#id_cat').selectpicker('refresh');
    });

	document.getElementById("libra").style.display = "none";
    document.getElementById("vol").style.display = "none";
}


//Función limpiar
function limpiar()
{
	$("#id_prod").val("");
	$("#id_cat").val("");
	$('#id_cat').selectpicker('refresh');
	$("#descripcion").val("");
	$("#codbarras").val("");
	$("#stock").val("");
	$("#preciocompra").val("");
	$("#precioventa").val("");
	$("#preciolibra").val("");
	$("#preciovol").val("");
	$("#fecha_venc").val("");
	$("#nombreproductor").val("");
	document.getElementById("libra").style.display = "none";
    document.getElementById("vol").style.display = "none";
}

function vercat(){
	var id_cat = $("#id_cat").val();

	if(id_cat == 2){
		document.getElementById("libra").style.display = "block";
    	document.getElementById("vol").style.display = "block";
	}else{
		document.getElementById("libra").style.display = "none";
		document.getElementById("vol").style.display = "none";
	}
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
					url: '../ajax/productos.php?op=listar',
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
		url: "../ajax/productos.php?op=guardaryeditar",
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

function mostrar(id_prod)
{
	$.post("../ajax/productos.php?op=mostrar",{id_prod : id_prod}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#id_prod").val(data.id_prod);
        $("#id_cat").val(data.id_cat);
        $('#id_cat').selectpicker('refresh');
        $("#descripcion").val(data.descripcion);
        $("#codbarras").val(data.codbarras);
        $("#stock").val(data.stock);
        $("#preciocompra").val(data.preciocompra);
        $("#precioventa").val(data.precioventa);
		$("#preciolibra").val(data.preciolibra);
		$("#preciovol").val(data.preciovol);
		$("#fecha_venc").val(data.fecha_venc);
		$("#nombreproductor").val(data.nombreproductor);

		if(data.id_cat == 2){
			document.getElementById("libra").style.display = "block";
    		document.getElementById("vol").style.display = "block";
		}else{
			document.getElementById("libra").style.display = "none";
    		document.getElementById("vol").style.display = "none";
		}
 	});
}

//Función para desactivar registros
function desactivar(id_prod)
{
	bootbox.confirm("¿Está seguro de desactivar el producto?", function(result){
		if(result)
        {
        	$.post("../ajax/productos.php?op=desactivar", {id_prod : id_prod}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_prod)
{
	bootbox.confirm("¿Está seguro de activar el producto?", function(result){
		if(result)
        {
        	$.post("../ajax/productos.php?op=activar", {id_prod : id_prod}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();