// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){
    
    $('#ERROR').hide();

    
});

function avatar_trash(val){
    
    $('#blah').attr('src' , val);

    document.getElementById('trash_img').value = 1;
    
}

function removerUser(id){

   var a =  confirm('Esta seguro de querer eliminar el perfil del usuario? ');

    if(a==true){


        URL = document.getElementById('URL').value;
        link = URL+"index.php";
        DATOS = "url=home/removerUser/"+id;
        
        $.ajax({
            type: "GET",
            url: link,
            data: DATOS,
        
            success: function(res){
        
                 alert('Usuario eliminado');

                 var elements = document.getElementsByClassName('tablinks');
                 var requiredElement = elements[6].click();
               
        
            } 
        });

    }
 
}