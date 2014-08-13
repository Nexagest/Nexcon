nx.noRigth();
var currentUrl = window.location.href;
function saveNoty(forms, limitTime, clients){
	var idata;
	$.ajax({
		type: 'POST',
		url: 'func/save.php',
		data: {f: forms, l: limitTime, c: clients},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
}
function clickSend(){
	var a = saveNoty("" + $('#forms').val(), $('#limitTime').val(), "" + $('#clients').val());
	//alert($('#clients').val());
	if(a == 'ERROR')
		alert("Ocurrio un error!");
	else if(a == 'ERROR FECHA')
		alert("Fecha Erronea!");
	else if(a == 'ERROR CLIENTE')
		alert("No ha seleccionado clientes!");
	else if(a == 'ERROR FORM')
		alert("No ha seleccionado formularios!");
	else
		//alert(a);
		alert("Formulario/s asignado/s!");
}
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	var currentPage = $('.ui-page-active').attr('id');
	if(currentPage == 'documents'){
		$('#clients').val()
		$('#documents').ready(function(){
			//$('#asign').click(function(){
				//clickSend();
				// var a = saveNoty($('#forms').val(), $('#limitTime').val(), $('#clients').val());
				// alert($('#clients').val());
				// if(a == 'ERROR')
					// alert("Ocurrio un error!");
				// else if(a == 'ERROR FECHA')
					// alert("Fecha Erronea!");
				// else if(a == 'ERROR CLIENTE')
					// alert("No ha seleccionado clientes!");
				// else if(a == 'ERROR FORM')
					// alert("No ha seleccionado formularios!");
				// else
					// alert(a);
					// alert("Formulario/s asignado/s!");
			//});
		});
	}
	$('#' + currentPage).ready(function(){
	});
});