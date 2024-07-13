var tabla;

function init(){ //hace referencia a otras funciones
    actualizarporcentrecargo();
    actualizarinterespormora();
}

function actualizarporcentrecargo(){
    $.get("../ajax/anios.php?op=actualizarporcentrecargo");
}

function actualizarinterespormora(){
    $.get("../ajax/anios.php?op=actualizarinterespormora");
}


//Función para desactivar registros
function desactivar(id_imp_an){
    bootbox.confirm("¿Está seguro de eliminar los impuestos?", function(result){
            if(result){
                $.post("../ajax/impuesto_anio.php?op=desactivar", {id_imp_an : id_imp_an}, function(e){
                    bootbox.alert(e);
                    tabla.ajax.reload();
                });
            }
    })
}



init();