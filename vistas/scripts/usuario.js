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

	$.post("../ajax/usuario.php?op=selecttipo", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_permiso").html(r);
        $('#id_permiso').selectpicker('refresh');
    });
}

function validar(){
    cedula=$("#cedula_usuario").val();

    if(cedula.length == 10){
        
        //Obtenemos el digito de la region que sonlos dos primeros digitos
        var digito_region = cedula.substring(0,2);
        
        //Pregunto si la region existe ecuador se divide en 24 regiones
        if( digito_region >= 1 && digito_region <=24 ){
        
        // Extraigo el ultimo digito
        var ultimo_digito   = cedula.substring(9,10);

        //Agrupo todos los pares y los sumo
        var pares = parseInt(cedula.substring(1,2)) + parseInt(cedula.substring(3,4)) + parseInt(cedula.substring(5,6)) + parseInt(cedula.substring(7,8));

        //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
        var numero1 = cedula.substring(0,1);
        var numero1 = (numero1 * 2);
        if( numero1 > 9 ){ var numero1 = (numero1 - 9); }

        var numero3 = cedula.substring(2,3);
        var numero3 = (numero3 * 2);
        if( numero3 > 9 ){ var numero3 = (numero3 - 9); }

        var numero5 = cedula.substring(4,5);
        var numero5 = (numero5 * 2);
        if( numero5 > 9 ){ var numero5 = (numero5 - 9); }

        var numero7 = cedula.substring(6,7);
        var numero7 = (numero7 * 2);
        if( numero7 > 9 ){ var numero7 = (numero7 - 9); }

        var numero9 = cedula.substring(8,9);
        var numero9 = (numero9 * 2);
        if( numero9 > 9 ){ var numero9 = (numero9 - 9); }

        var impares = numero1 + numero3 + numero5 + numero7 + numero9;

        //Suma total
        var suma_total = (pares + impares);

        //extraemos el primero digito
        var primer_digito_suma = String(suma_total).substring(0,1);

        //Obtenemos la decena inmediata
        var decena = (parseInt(primer_digito_suma) + 1)  * 10;

        //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
        var digito_validador = decena - suma_total;

        //Si el digito validador es = a 10 toma el valor de 0
        if(digito_validador == 10)
            var digito_validador = 0;

        //Validamos que el digito validador sea igual al de la cedula
        if(digito_validador == ultimo_digito){
            cedula=$("#cedula_usuario").val();
   
        }else{
            $("#cedula_usuario").val("");
            document.getElementById("prueba").innerHTML = "Cédula incorrecta, ingrese otra";
        }
		document.getElementById("prueba").innerHTML = "Cédula correcta";
        }else{
        // imprimimos en consola si la region no pertenece
        $("#cedula_usuario").val("");
        document.getElementById("prueba").innerHTML = "Cédula incorrecta, ingrese otra";
        }
    }else{
        //imprimimos en consola si la cedula tiene mas o menos de 10 digitos
        $("#cedula_usuario").val("");
        document.getElementById("prueba").innerHTML = "Cédula incorrecta, ingrese otra";
    }  
}

//Función limpiar
function limpiar()
{
	$("#cedula_usuario").val("");
	$("#id_permiso").val("");
	$('#id_permiso').selectpicker('refresh');
	$("#nombre_usuario").val("");
	$("#apellido_usuario").val("");
	$("#telefono_usuario").val("");
	$("#direccion_usuario").val("");
	$("#email_usuario").val("");
	$("#clave_us").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#id_usuario").val("");
	$("#imagenmuestra").hide();
}

//Función mostrar formulario
function mostrarform(flag)
{
	$("#id_usuario").val("");
	//limpiar();
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
					url: '../ajax/usuario.php?op=listar',
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
		url: "../ajax/usuario.php?op=guardaryeditar",
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

function mostrar(id_usuario)
{
	$.post("../ajax/usuario.php?op=mostrar",{id_usuario : id_usuario}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		
		$("#id_usuario").val(data.id_usuario);
		$("#id_permiso").val(data.id_permiso);
		$('#id_permiso').selectpicker('refresh');
		$("#cedula_usuario").val(data.cedula_usuario);
		$("#nombre_usuario").val(data.nombre_usuario);
		$("#apellido_usuario").val(data.apellido_usuario);
		$("#telefono_usuario").val(data.telefono_usuario);
		$("#direccion_usuario").val(data.direccion_usuario);
		$("#email_usuario").val(data.email_usuario);
		$("#clave_us").val(data.clave_us);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen_usuario);
		$("#imagenactual").val(data.imagen_usuario);

 	});
}

//Función para desactivar registros
function desactivar(id_usuario)
{
	bootbox.confirm("¿Está seguro de desactivar el usuario?", function(result){
		if(result)
        {
        	$.post("../ajax/usuario.php?op=desactivar", {id_usuario : id_usuario}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_usuario)
{
	bootbox.confirm("¿Está seguro de activar el usuario?", function(result){
		if(result)
        {
        	$.post("../ajax/usuario.php?op=activar", {id_usuario : id_usuario}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();