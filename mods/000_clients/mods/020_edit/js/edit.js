function add(){
	var check_id;
	var check_email;
}
add.check_id = function(id){
	var idata;
	$.ajax({
		type: 'POST',
		url: 'func/check_id.php',
		data: {'id': id},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
};
add.check_email = function(email){
	var idata;
	$.ajax({
		type: 'POST',
		url: 'func/check_email.php',
		data: {'email': email},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
};
add.save_client = function(name, id, address, cp, phone, email, web, vip){
	var idata;
	$.ajax({
		type: 'POST',
		url: 'func/save_client.php',
		data: {
			'name':		name,
			'id':		id,
			'address':	address,
			'cp':		cp,
			'phone':	phone,
			'email':	email,
			'web':		web,
			'vip':		vip
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
			if(!add.check_id($('#id').val()))
				error = error + 'NIF/CIF erróneo o duplicado, es un campo obligatorio para continuar.\n'
			if(!add.check_email($('#email').val()))
				error = error + 'Email erróneo, es un campo obligatorio.\n';
			if(error)
				alert(error);
			else
				if(add.save_client($('#name').val(), $('#id').val(), $('#address').val(), $('#cp').val(), $('#phone').val(), $('#email').val(), $('#web').val(), $("#vip").is(':checked'))){
					alert('El cliente ha sido modificado correctamente!');
					//$('input').val('');
					//$('input[type="checkbox"]').attr('checked', false);
				}else
					alert('Ocurrió un error al intentar modificar el cliente!');
		});
	}
	$('#' + currentPage).ready(function(){
	});
});