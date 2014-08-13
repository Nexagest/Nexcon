function add(){
}
add.save_client = function(name){
	var idata;
	$.ajax({
		type: 'POST',
		url: 'func/save_client.php',
		data: {
			'name':		name
		},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
};
nx.noRigth();
var currentUrl = window.location.href;
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	var currentPage = $('.ui-page-active').attr('id');
	if(currentPage == 'add_client'){
		$('#id').blur(function(){
			//if(!add.check_id($('#id').val()))
			//	alert('NIF/CIF erróneo, es un campo obligatorio para continuar.');
		});
		$('input[type="button"]').bind('vclick', function() {
			var error = '';
			if(!$('#name').val())
				error = error + 'Nombre vacio, es un campo obligatorio\n';
			if(error)
				alert(error);
			else
				if(add.save_client($('#name').val()) == ''){
					alert('El grupo ha sido creado correctamente!');
					$('input').val('');
					$('input[type="checkbox"]').attr('checked', false);
				}else
					alert('Ocurrió un error al intentar crear el grupo!');
		});
	}
	$('#' + currentPage).ready(function(){
	});
});