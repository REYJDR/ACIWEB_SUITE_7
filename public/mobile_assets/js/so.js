
window.addEventListener("load", function(){
    spin_show();
 
    addItemList('');
 
    var e = document.getElementById("taxid");
    var Taxval = e.options[e.selectedIndex].value;
    var TaxID = e.options[e.selectedIndex].text;
   
    set_taxid(Taxval,1);
 
    spin_hide();
 });
 