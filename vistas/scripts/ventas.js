var tabla;

function init(){ //hace referencia a otras funciones
    mostrarform(false);
    listar();
   
    //se reciben peticiones del formulario para guardar y editar
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    });

    
    //Cargamos los items al select clientes
    $.post("../ajax/ventas.php?op=selectClientes", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_cliente").html(r);
     $('#id_cliente').selectpicker('refresh');
    });

    listarProductos();
    verserie();
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
		document.getElementById("seriediv").style.display = "block";
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
    mostrarform(false);
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

function reporteventas(){
    var fecha_inicio = $("#fecha_inicio").val(); 
	var fecha_fin = $("#fecha_fin").val();
	
		$url = '../reportes/rptventas.php?fecha_inicio='+fecha_inicio+'&fecha_fin='+fecha_fin;
		target = "_blank";
		window.open($url, '_blank');
}

function listar(){
    var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();

    tabla=$('#tbllistado').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            /* 'excelHtml5' */
        ],
        
        "ajax":
        {
            url: "../ajax/ventas.php?op=listar",
            data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin},
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 8, //paginacion
        "order": [[0, "desc"]] //orden
    }).DataTable();
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
            mostrarform(false);
            tabla.ajax.reload();
            listar();
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
		document.getElementById("seriediv").style.display = "none";
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
var dcto = 0;
$("#btnGuardar").hide();


function agregarDetalle(id_prod, id_cat, descripcion, precioventa, stock)
{
    var cantidad=1;

    if(id_prod!="" && id_cat == '1')
    {
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td> <button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
        '<td> <input type="hidden" name="id_prod[]" value="'+id_prod+'">'+descripcion+'</td>'+
        '<td><input  onchange="modificarSubtotales()" type="number" min="1" max="'+stock+'" step=".01" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td><input type="number" min= 1 name="valor_venta[]" step=".01" id="valor_venta[]" value="'+precioventa+'"></td>'+
        '<td><select onchange = "modificarSubtotales()" name="dcto[]" id="dcto[]" style="width:150px"><option value="0.05">0.05</option><option  value="0.08" selected>0.08</option><option  value="0.10" selected>0.10</option></select></td>'+
        '<td> <span name="subtotal" id="subtotal'+cont+'">'+(((cantidad*valor_venta))-(cantidad*valor_venta)*dcto)+'</span> </td>'+
        '<td><input type="hidden" name="stock[]" id="stock[]" value="'+stock+'"></td>'+
        '</tr>';
        cont++;
        detalles=detalles+1;
        $('#detalles').append(fila);
        modificarSubtotales();
    }else if(id_prod != "" && id_cat == '2'){
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td> <button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
        '<td> <input type="hidden" name="id_prod[]" value="'+id_prod+'">'+descripcion+'</td>'+
        '<td><input  onchange="modificarSubtotales()" type="number" step=".01" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td><input type="number" min= 1 name="valor_venta[]" step=".01" id="valor_venta[]" value="'+precioventa+'"></td>'+
        '<td><input readonly type="number" min= 0 name="dcto[]" step=".01" id="dcto[]" value="0"></td>'+
        '<td> <span name="subtotal" id="subtotal'+cont+'">'+(((cantidad*valor_venta))-(cantidad*valor_venta)*dcto)+'</span> </td>'+
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
    var d = document.getElementsByName("dcto[]");
    var sub = document.getElementsByName("subtotal");
    var stock_var = document.getElementsByName("stock[]");

    for(var i=0; i<cant.length; i++){

        var inpC = cant[i];
        var inpP = pre[i];
        var inpD = d[i];
        var inpS = sub[i];
        var inpSt = stock_var[i];

        var inpC = cant[i];
        var inpP = pre[i];
        var inpS = sub[i];
        var inpSt = stock_var[i];

            
            inpS.value = (((inpC.value * inpP.value)) - (inpC.value * inpP.value)*inpD.value);
            document.getElementsByName("subtotal")[i].innerHTML = (inpS.value).toFixed(2);
    }

    calcularTotales();
     
}

function calcularTotales(){
   var sub = document.getElementsByName("subtotal");
    var total = 0.0;
    var totalfinal = 0.0;
    var iva2 = document.getElementsByName("iva").innerHTML = iva.value;
    

    for (var i=0; i<sub.length; i++){
        total += document.getElementsByName("subtotal")[i].value;
        totalfinal = (total * iva2)+total;
        ivac = (total*iva2)
    }

    $("#total").html("S/. "+(total).toFixed(2));
    $("#total_venta").val(total);

   // $("#iva2").html("S/. "+iva2);
    $("#iva").val(iva2);

    $("#totalfinal").html("S/. "+[totalfinal.toFixed(2)]);
    $("#ivacalculo").html("S/. "+(ivac).toFixed(2));
    $("#total_venta_final").val((totalfinal));
    
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