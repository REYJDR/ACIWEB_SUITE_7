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

    alert('elimnar el user '+id);

}