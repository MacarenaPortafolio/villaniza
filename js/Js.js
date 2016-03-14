function Cambio(){
        var estado = $("#todos").is(':checked');        
        var cantidad = $("#cantidad").val();
        cantidad = cantidad-1;
       
        
        if(estado==true){            
            for(i=1;i<=cantidad;i++){
                 $("#checkbox-"+i).attr('checked',true);
            }
            
                    
        }else{
             location.reload();
        }
      }
      
      
function Archivo(){
//var file = $("#adjunto")[0].files[0];

//var direccion = file.tmp_name;
/*$.each( file, function( key, value ) {
  alert( key + ": " + value );
});*/
alert('1');
                    $.post("Ajax.php",{
                        'oper'     : 'Archivo'
                        
                    },function(data){
                        alert(data);
                    });

    
}      
      
function Enviar(){
    var DeEmail = $("#email").val();
    var DeNombre = $("#nombre").val();
    var asunto = $("#asunto").val();
    var telefono = $("#telefono").val();
    var mensaje = $("#mensaje").val();   
    var adjunto = $("#adjunto").val();
    if(asunto==""){
        alert("Debe ingresar el Asunto")
    }else if(mensaje==""){
        alert("Debe ingresar el Mensaje")
    }else{
        var cantidad = $("#cantidad").val();
        cantidad = cantidad-1;
        for(i=1;i<=cantidad;i++){         
            if(($("#checkbox-"+i).is(':checked'))==true)
            {
                var destinatario = $("#checkbox-"+i).val();
                //alert(adjunto);
                    
                    $.post("Email.php",{
                        'DeEmail'     : DeEmail,
                        'DeNombre'    : DeNombre,
                        'asunto'      : asunto,
                        'telefono'    : telefono,
                        'mensaje'     : mensaje,
                        'destinatario': destinatario,
                        'adjunto': adjunto                        
                       
                        
                    },function(data){
                        
                    });
                
            } 
        }
        $("#boton-enviar").hide();        
        alert("Correo Enviado");
        $(location).attr('href','sitio-administrador.php');
        }
        
}


     