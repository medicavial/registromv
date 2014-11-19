$(function(){
        
        $("#tipoItem").change(function(event){
            var id = $("#tipoItem").find(':selected').val();
            $("#itemOrtho").load('select-itemsDepen.php?id='+id);     
            
        });

        $('#btn-submit').on('click',function(){        
            var str = $('#agregaItem').serialize();
            $.ajax({
                type:"POST",
                url: 'http://www.medicavial.net/registro/agregaItem.php',
                data: str,
                success: function(data){
                    $('#resultado').html(data);
                    $('select').val('-1');
                },
                error: function(){
                    $("#resultado").html('There was an error updating the settings');
                }
            });  //End Ajax
            
            
        });//End click btn-submit


///////////fincion de envio de items agregados////////////////////
        $("#agregaItem").submit(function(event) {
        event.preventDefault();         
        var values = $(this).serialize();
        $.ajax({
            url: "guardaItem.php",
            type: "post",
            data: values,
            success: function(data){           
                $("#resultado").html(data);
            },
            error:function(){           
                $("#resultado").html('Error en el envío de datos');
            }
            });
    });
//////////////////// fin de aitems agregados /////////////////////



    });//Principal 

    function eliminaItem(id,fol){
            //alert(id+fol);
            $.ajax({
                type:"GET",
                url: 'http://www.medicavial.net/registro/eliminaItem.php?id='+id+'&fol='+fol,
                //data: id,fol,
                success: function(data){
                    $('#resultado').html(data);
                    $('select').val('-1');
                },
                error: function(){
                    $("#resultado").html('There was an error updating the settings');
                }
            });  //End Ajax
        } 