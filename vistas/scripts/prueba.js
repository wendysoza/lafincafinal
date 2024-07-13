var tabla;

function init(){ //hace referencia a otras funciones
    prueba();

    var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_inicio').val(today);

    //se reciben peticiones del formulario para guardar y editar
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    });

//Cargamos los items al select 
$.post("../ajax/medidas.php?op=selectPacientes", function(r){ //parametro r son las opciones que devuelve el id
    $("#id_paciente").html(r);
    $('#id_paciente').selectpicker('refresh');
});
}


function prueba(){
    document.getElementById("box-body3").style.display = "block";
    document.getElementById("box-body4").style.display = "none";
    document.getElementById("box-body5").style.display = "none";
    document.getElementById("box-body6").style.display = "none";
    document.getElementById("box-body7").style.display = "none";
    document.getElementById("box-body8").style.display = "none";
    document.getElementById("box-body9").style.display = "none";
    document.getElementById("box-body10").style.display = "none";
    document.getElementById("box-body11").style.display = "none";
    document.getElementById("box-body12").style.display = "none";
    document.getElementById("box-body13").style.display = "none";
    document.getElementById("box-body14").style.display = "none";
}


function myFunction() {
    var x = document.getElementById("mesid").value;
    document.getElementById("demo").innerHTML = x;


    if(x == 1){
        document.getElementById("box-body4").style.display = "none";
        document.getElementById("box-body3").style.display = "block";
        document.getElementById("box-body5").style.display = "none";
        document.getElementById("box-body6").style.display = "none";
        document.getElementById("box-body7").style.display = "none";
        document.getElementById("box-body8").style.display = "none";
        document.getElementById("box-body9").style.display = "none";
        document.getElementById("box-body10").style.display = "none";
        document.getElementById("box-body11").style.display = "none";
        document.getElementById("box-body12").style.display = "none";
        document.getElementById("box-body13").style.display = "none";
        document.getElementById("box-body14").style.display = "none";
    }else{
        if(x == 2){
            document.getElementById("box-body3").style.display = "none";
            document.getElementById("box-body4").style.display = "block";
            document.getElementById("box-body5").style.display = "none";
            document.getElementById("box-body6").style.display = "none";
            document.getElementById("box-body7").style.display = "none";
            document.getElementById("box-body8").style.display = "none";
            document.getElementById("box-body9").style.display = "none";
            document.getElementById("box-body10").style.display = "none";
            document.getElementById("box-body11").style.display = "none";
            document.getElementById("box-body12").style.display = "none";
            document.getElementById("box-body13").style.display = "none";
            document.getElementById("box-body14").style.display = "none";
        }else{
            if(x == 3){
                document.getElementById("box-body3").style.display = "none";
                document.getElementById("box-body4").style.display = "none";
                document.getElementById("box-body5").style.display = "block";
                document.getElementById("box-body6").style.display = "none";
                document.getElementById("box-body7").style.display = "none";
                document.getElementById("box-body8").style.display = "none";
                document.getElementById("box-body9").style.display = "none";
                document.getElementById("box-body10").style.display = "none";
                document.getElementById("box-body11").style.display = "none";
                document.getElementById("box-body12").style.display = "none";
                document.getElementById("box-body13").style.display = "none";
                document.getElementById("box-body14").style.display = "none";
        }else{
            if(x==4){
                document.getElementById("box-body3").style.display = "none";
                document.getElementById("box-body4").style.display = "none";
                document.getElementById("box-body5").style.display = "none";
                document.getElementById("box-body6").style.display = "block";
                document.getElementById("box-body7").style.display = "none";
                document.getElementById("box-body8").style.display = "none";
                document.getElementById("box-body9").style.display = "none";
                document.getElementById("box-body10").style.display = "none";
                document.getElementById("box-body11").style.display = "none";
                document.getElementById("box-body12").style.display = "none";
                document.getElementById("box-body13").style.display = "none";
                document.getElementById("box-body14").style.display = "none";
            }else{
                if(x==5){
                    document.getElementById("box-body3").style.display = "none";
                    document.getElementById("box-body4").style.display = "none";
                    document.getElementById("box-body5").style.display = "none";
                    document.getElementById("box-body6").style.display = "none";
                    document.getElementById("box-body7").style.display = "block";
                    document.getElementById("box-body8").style.display = "none";
                    document.getElementById("box-body9").style.display = "none";
                    document.getElementById("box-body10").style.display = "none";
                    document.getElementById("box-body11").style.display = "none";
                    document.getElementById("box-body12").style.display = "none";
                    document.getElementById("box-body13").style.display = "none";
                    document.getElementById("box-body14").style.display = "none";
                }else{
                    if(x==6){
                        document.getElementById("box-body3").style.display = "none";
                        document.getElementById("box-body4").style.display = "none";
                        document.getElementById("box-body5").style.display = "none";
                        document.getElementById("box-body6").style.display = "none";
                        document.getElementById("box-body7").style.display = "none";
                        document.getElementById("box-body8").style.display = "block";
                        document.getElementById("box-body9").style.display = "none";
                        document.getElementById("box-body10").style.display = "none";
                        document.getElementById("box-body11").style.display = "none";
                        document.getElementById("box-body12").style.display = "none";
                        document.getElementById("box-body13").style.display = "none";
                        document.getElementById("box-body14").style.display = "none";
                    }else{
                        if(x==7){
                            document.getElementById("box-body3").style.display = "none";
                            document.getElementById("box-body4").style.display = "none";
                            document.getElementById("box-body5").style.display = "none";
                            document.getElementById("box-body6").style.display = "none";
                            document.getElementById("box-body7").style.display = "none";
                            document.getElementById("box-body8").style.display = "none";
                            document.getElementById("box-body9").style.display = "block";
                            document.getElementById("box-body10").style.display = "none";
                            document.getElementById("box-body11").style.display = "none";
                            document.getElementById("box-body12").style.display = "none";
                            document.getElementById("box-body13").style.display = "none";
                            document.getElementById("box-body14").style.display = "none";
                        }else{
                            if(x==8){
                                document.getElementById("box-body3").style.display = "none";
                                document.getElementById("box-body4").style.display = "none";
                                document.getElementById("box-body5").style.display = "none";
                                document.getElementById("box-body6").style.display = "none";
                                document.getElementById("box-body7").style.display = "none";
                                document.getElementById("box-body8").style.display = "none";
                                document.getElementById("box-body9").style.display = "none";
                                document.getElementById("box-body10").style.display = "block";
                                document.getElementById("box-body11").style.display = "none";
                                document.getElementById("box-body12").style.display = "none";
                                document.getElementById("box-body13").style.display = "none";
                                document.getElementById("box-body14").style.display = "none";
                            }else{
                                if(x==9){
                                    document.getElementById("box-body3").style.display = "none";
                                    document.getElementById("box-body4").style.display = "none";
                                    document.getElementById("box-body5").style.display = "none";
                                    document.getElementById("box-body6").style.display = "none";
                                    document.getElementById("box-body7").style.display = "none";
                                    document.getElementById("box-body8").style.display = "none";
                                    document.getElementById("box-body9").style.display = "none";
                                    document.getElementById("box-body10").style.display = "none";
                                    document.getElementById("box-body11").style.display = "block";
                                    document.getElementById("box-body12").style.display = "none";
                                    document.getElementById("box-body13").style.display = "none";
                                    document.getElementById("box-body14").style.display = "none";
                                }else{
                                    if(x==10){
                                        document.getElementById("box-body3").style.display = "none";
                                        document.getElementById("box-body4").style.display = "none";
                                        document.getElementById("box-body5").style.display = "none";
                                        document.getElementById("box-body6").style.display = "none";
                                        document.getElementById("box-body7").style.display = "none";
                                        document.getElementById("box-body8").style.display = "none";
                                        document.getElementById("box-body9").style.display = "none";
                                        document.getElementById("box-body10").style.display = "none";
                                        document.getElementById("box-body11").style.display = "none";
                                        document.getElementById("box-body12").style.display = "block";
                                        document.getElementById("box-body13").style.display = "none";
                                        document.getElementById("box-body14").style.display = "none";
                                    }else{
                                        if(x==11){
                                            document.getElementById("box-body3").style.display = "none";
                                            document.getElementById("box-body4").style.display = "none";
                                            document.getElementById("box-body5").style.display = "none";
                                            document.getElementById("box-body6").style.display = "none";
                                            document.getElementById("box-body7").style.display = "none";
                                            document.getElementById("box-body8").style.display = "none";
                                            document.getElementById("box-body9").style.display = "none";
                                            document.getElementById("box-body10").style.display = "none";
                                            document.getElementById("box-body11").style.display = "none";
                                            document.getElementById("box-body12").style.display = "none";
                                            document.getElementById("box-body13").style.display = "block";
                                            document.getElementById("box-body14").style.display = "none";
                                        }else{
                                            if(x==12){
                                                document.getElementById("box-body3").style.display = "none";
                                                document.getElementById("box-body4").style.display = "none";
                                                document.getElementById("box-body5").style.display = "none";
                                                document.getElementById("box-body6").style.display = "none";
                                                document.getElementById("box-body7").style.display = "none";
                                                document.getElementById("box-body8").style.display = "none";
                                                document.getElementById("box-body9").style.display = "none";
                                                document.getElementById("box-body10").style.display = "none";
                                                document.getElementById("box-body11").style.display = "none";
                                                document.getElementById("box-body12").style.display = "none";
                                                document.getElementById("box-body13").style.display = "none";
                                                document.getElementById("box-body14").style.display = "block";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
    }  
}
}



init();