function add(){
	var check_email;
}
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
add.save_client = function(user, pass, name, email, type, client){
	var idata;
	$.ajax({
		type: 'POST',
		url: 'func/save_client.php',
		data: {
			'user':		user,
			'pass':		pass,
			'name':		name,
			'email':	email,
			'type':		type,
			'client':	client
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
			if(!add.check_email($('#email').val()))
				error = error + 'Email erróneo, es un campo obligatorio.\n';
			if(error)
				alert(error);
			else
				if(add.save_client($('#user').val(), $('#pass').val(), $('#name').val(), $('#email').val(), $("#type").val(), $("#client").val())){
					alert('El usuario ha sido añadido correctamente!');
					$('input').val('');
					$('input[type="checkbox"]').attr('checked', false);
				}else
					alert('Ocurrió un error al intentar añadir el usuario!');
		});
	}
	$('#' + currentPage).ready(function(){
	});
});