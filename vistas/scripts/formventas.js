var tabla;

function init(){ //hace referencia a otras funciones
    mostrarform(true);
   
    //se reciben peticiones del formulario para guardar y editar
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    });

    $("#formulario2").on("submit",function(e)
    {
        guardaryeditar2(e);
    });

    $("#formulario3").on("submit",function(e)
    {
        guardaryeditar3(e);
    });

    //Cargamos los items al select clientes
    $.post("../ajax/ventas.php?op=selectClientes", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_cliente").html(r);
     $('#id_cliente').selectpicker('refresh');
    });

    $.post("../ajax/productos.php?op=selectcat", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_cat").html(r);
        $('#id_cat').selectpicker('refresh');
    });

    listarProductos();
    $("#dcto").val(0);
    verserie();
}

function validar(){
    cedula=$("#cedula_cli").val();

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
            cedula=$("#cedula_cli").val();
   
        }else{
            $("#cedula_cli").val("");
            document.getElementById("prueba").innerHTML = "Cédula incorrecta, ingrese otra";
        }
		document.getElementById("prueba").innerHTML = "Cédula correcta";

        }else{
        // imprimimos en consola si la region no pertenece
        $("#cedula_cli").val("");
        document.getElementById("prueba").innerHTML = "Cédula incorrecta, ingrese otra";
        }
    }else{
        //imprimimos en consola si la cedula tiene mas o menos de 10 digitos
        $("#cedula_cli").val("");
        document.getElementById("prueba").innerHTML = "Cédula incorrecta, ingrese otra";
    }  
}

function verserie(){
    $.post("../ajax/ventas.php?op=verserie", function(r2){ 
        r2 = JSON.parse(r2);
        console.log(r2.idcab);

        $("#serie").val(r2.idcab);
    });
}

function limpiar(){
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    
    $("#id_cabecera").val("");
    $("#fecha").val(today);
    $("#id_cliente").val("");
    $("#id_empleado").val("");
    $("#total_venta").val("");
    $("#iva").val("");
    $("#total_venta_final").val("");
	$(".filas").remove();
	$("#total_venta").html("0");
    $("#iva").html("0");
    $("#total_venta_final").html("0");
    $("#total").html("S/. 0.00");
    $("#totalfinal").html("S/. 0.00");
    $("#cantidad").val("");
    $("#id_prod").val("");
    $("#dcto").val(0);
}

function limpiar2()
{
	$("#id_cli").val("");
	$("#nombres_cli").val("");
    $("#cedula_cli").val("");
    $("#telefono_cli").val("");
    $("#direccion_cli").val("");
    $("#email_cli").val("");
}

function limpiar3()
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

function fechas(){
    var fecha = $("#fecha").val();

	const diafecha = new Date(fecha).getDate();
	const mesfecha = new Date(fecha).getMonth() + 1;
	const aniofecha = new Date(fecha).getFullYear();

	const diafechaa = new Date().getDate();
	const mesfechaa = new Date().getMonth() + 1;
	const aniofechaa = new Date().getFullYear();

	console.log(mesfechaa);
	console.log(mesfecha);
	if(aniofechaa == aniofecha){
		if(mesfechaa == mesfecha){
			if(diafechaa > diafecha){
				$("#fecha").val("");
				document.getElementById("fechaid").innerHTML = "Fecha anterior a la actual";  
		}else{
			document.getElementById("fechaid").innerHTML = ""; 
		}
	}else if(mesfechaa > mesfecha){
		//Mes actual mayor a mes que está ingresando -- Fecha pasada
		$("#fecha").val("");
		document.getElementById("fechaid").innerHTML = "Fecha anterior a la actual";   
	}else{
		document.getElementById("fechaid").innerHTML = ""; 
	}

	}else if(aniofechaa > aniofecha){
		//Año actual es mayor a año que se está ingresando -- Fecha pasada
		$("#fecha").val("");
		document.getElementById("fechaid").innerHTML = "Fecha anterior a la actual";   
	}else{
		document.getElementById("fechaid").innerHTML = ""; 
	}
}

function guardaryeditar2(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarCli").prop("disabled",false);
	var formData = new FormData($("#formulario2")[0]);

	$.ajax({
		url: "../ajax/clientes.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	  
              $.post("../ajax/ventas.php?op=selectClientes", function(r){ //parametro r son las opciones que devuelve el id
                $("#id_cliente").html(r);
             $('#id_cliente').selectpicker('refresh');
            });      
	          //mostrarform(false);
	          //tabla.ajax.reload();
	    }

	});
	limpiar2();
}

function guardaryeditar3(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarProd").prop("disabled",false);
	var formData = new FormData($("#formulario3")[0]);

	$.ajax({
		url: "../ajax/productos.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	  
              listarProductos();     
	          //mostrarform(false);
	          //tabla.ajax.reload();
	    }

	});
	limpiar3();
}

function mostrarform(flag){
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $("#fecha").val(today);
    //limpiar();
    if(flag){ //si flag es true muestra el formulario
        $("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
        $("#btnreporte").hide();
		listarProductos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").show();
    }
    else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#btnreporte").show();
    }
}

function cancelarform(){
    limpiar();
    $("#dcto").val(0);
    mostrarform(true);
    //location.reload();
    $( "#detalles" ).load(window.location.href + " #detalles" );
    //$( "#total_venta" ).load(window.location.href + " #total_venta" );
    //$( "#id_cliente" ).load(window.location.href + " #id_cliente" );
    //location.href = 'ventas.php';
    detalles = 0;
    cantidad = 0;
    valor_art = 0;
    $("#total_venta").val("");
    $("#iva").val("");
    $("#total_venta_final").val("");
	$(".filas").remove();
	$("#total_venta").html("0");
    $("#iva").html("0");
    $("#total_venta_final").html("0");
    $("#total").html("S/. 0.00");
    $("#totalfinal").html("S/. 0.00");
    $("#cantidad").val("");
    $("#id_prod").val("");
}



function listarProductos(){
   
    tabla=$('#tblarticulos').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
          /*    'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'  */
        ],
        
        "ajax":
        {
            url: "../ajax/ventas.php?op=listarProductos",
            type: "get",
            dataType: "json",
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
        "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
        }).DataTable();
}


function guardaryeditar(e){
    e.preventDefault(); //no se activa la accion predeterminada del evento
  //  $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/ventas.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        { 
            //location.reload();
            bootbox.alert(datos)/* 
            window.setTimeout(, 10000); */
            mostrarform(true);
            tabla.ajax.reload();
            verserie();
            //location.reload();
        }
    });
    limpiar();
    $( "#detalles" ).load(window.location.href + " #detalles" );
    detalles = 0;
    cantidad = 0;
    
    //location.reload();
}

//muestra los datos que se quieren modificar
function mostrar(id_cabecera){
    
    $.post("../ajax/ventas.php?op=mostrar",{id_cabecera : id_cabecera}, function(data, status){
        data = JSON.parse(data);

        mostrarform(true);
        $("#id_cabecera").val(data.id_cabecera);
        $("#fecha").val(data.fecha);
        $("#id_cliente").val(data.id_cliente);
        $('#id_cliente').selectpicker('refresh');
        $("#total_venta").val(data.total_venta);
        $("#efectivo").val(data.efectivo);
        $("#cambio").val(data.cambio);
        $("#iva").val(data.iva);
        $("#total_venta_final").val(data.total_venta_final);

        //Ocultar y mostrar los botones
        $("#guardar").show();
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
    });

    $.post("../ajax/ventas.php?op=listarDetalle&id="+id_cabecera,function(r){
            $("#detalles").html(r);
    })

}

//Función para desactivar registros
function anular(id_cabecera){
    bootbox.confirm("¿Está seguro de anular la venta?", function(result){
            if(result){
                $.post("../ajax/ventas.php?op=anular", {id_cabecera : id_cabecera}, function(e){
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    tabla.ajax.reload();
                });
            }
    })
}


//Declaración de variables necesarias para trabajar con las compras y sus detalles
var impuesto=12;
var cont=0;
var detalles=0;
var valor_venta = 0;
$("#btnGuardar").hide();


function agregarDetalle(id_prod, id_cat, codbarras, descripcion, precioventa, stock)
{
    var cantidad=1;

    if(id_prod!="" && id_cat == '1')
    {
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td> <input type="hidden" name="id_prod[]" value="'+id_prod+'">'+descripcion+'</td>'+
        '<td> <input value="'+codbarras+'"></td>'+
        '<td><input type="number" min= 1 name="valor_venta[]" step=".01" id="valor_venta[]" value="'+precioventa+'"></td>'+
        '<td><input  onchange="modificarSubtotales()" type="number" min="1" max="'+stock+'" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td> <span name="subtotal" id="subtotal'+cont+'">'+(cantidad*valor_venta)+'</span> </td>'+
        '<td> <button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'+
        '<td><input type="hidden" name="stock[]" id="stock[]" value="'+stock+'"></td>'+
        '</tr>';
        cont++;
        detalles=detalles+1;
        $('#detalles').append(fila);
        modificarSubtotales();
    }else if(id_prod != "" && id_cat == '2'){
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td> <input type="hidden" name="id_prod[]" value="'+id_prod+'">'+descripcion+'</td>'+
        '<td> <input value="'+codbarras+'"></td>'+
        '<td><input type="number" min= 1 name="valor_venta[]" step=".01" id="valor_venta[]" value="'+precioventa+'"></td>'+
        '<td><input  onchange="modificarSubtotales()" type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td> <span name="subtotal" id="subtotal'+cont+'">'+(cantidad*valor_venta)+'</span> </td>'+
        '<td> <button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'+
        '<td><input type="hidden" name="stock[]" id="stock[]" value="'+stock+'"></td>'+
        '</tr>';
        cont++;
        detalles=detalles+1;
        $('#detalles').append(fila);
        modificarSubtotales();
    }
    else
    {
        alert("Error al ingresar el detalle, debe revisar los datos del producto");
    }
}

function modificarSubtotales()
{
    var cant = document.getElementsByName("cantidad[]");
    var pre = document.getElementsByName("valor_venta[]");
    var sub = document.getElementsByName("subtotal");
    var stock_var = document.getElementsByName("stock[]");

    for(var i=0; i<cant.length; i++){

        var inpC = cant[i];
        var inpP = pre[i];
        var inpS = sub[i];
        var inpSt = stock_var[i];

        var inpC = cant[i];
        var inpP = pre[i];
        var inpS = sub[i];
        var inpSt = stock_var[i];

            
            inpS.value = inpC.value * inpP.value;
            document.getElementsByName("subtotal")[i].innerHTML = (inpS.value).toFixed(2);
    }

    calcularTotales();
     
}

function calcularTotales(){
   var sub = document.getElementsByName("subtotal");
    var total = 0.0;
    var totalfinal = 0.0;
    var iva2 = document.getElementsByName("iva").innerHTML = iva.value;
    dcto=$("#dcto").val();
    
    console.log(dcto);

    for (var i=0; i<sub.length; i++){
        total += document.getElementsByName("subtotal")[i].value;
        totalfinal = (total * iva2)+total;
        ivac = (total*iva2)
    }

    $("#total").html("$ "+(total).toFixed(2));
    $("#total_venta").val(total);

   // $("#iva2").html("S/. "+iva2);
    $("#iva").val(iva2);

    $("#ivacalculo").html("$ "+(ivac).toFixed(2));
    cam = parseFloat(totalfinal).toFixed(2) - parseFloat(dcto).toFixed(2);
    $("#totalfinal").html("$ "+[cam.toFixed(2)]);

    console.log(cam);

    $("#total_venta_final").val((cam));
    
    evaluar();
}


function evaluar(){
    if(detalles>0)
    {
        $("#btnGuardar").show();
    }
    else{
        $("#btnGuardar").hide();
        cont=0;
    }
}

function eliminarDetalle(indice){
    $("#fila"+indice).remove();
    calcularTotales();
    detalles=detalles-1;
}

init();