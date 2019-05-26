$(window).load(function(){ 
	
		$('#ERROR').hide();

	var text = $('#code').text();
	// $('#code2').text()+$('#code3').text();
    eval(text);
    
// Get the element with id="defaultOpen" and click on it
//sdocument.getElementById("defaultOpen").click();
	});


	function foo(e) {

	// Create a new LI
	var newLi = document.createElement('li');

	// Get the element that the click came from
	var el = e.target || e.srcElement;

	// Get it's parent LI if there is one
	var p = getParent(el);
	if (!p) return;

	// Get child ULs if there are any
	var ul = p.getElementsByTagName('ul')[0];

	// If there's a child UL, add the LI with updated text
	if (ul) {

		// Get the li children ** Original commented line was buggy 
	//    var lis = ul.getElementsByTagName('li');
		var lis = ul.childNodes;

		// Get the text of the last li
		var text = getText(lis[lis.length - 1]);

		// Update the innerText of the new LI and add it
		setText(newLi, text.replace(/\.\d+$/,'.' + lis.length));
		ul.appendChild(newLi);

	// Otherwise, add a UL and LI  
	} else {
		// Create a UL
		ul = document.createElement('ul');

		// Add text to the new LI
		setText(newLi, getText(p) + '.0');
	}
    }



