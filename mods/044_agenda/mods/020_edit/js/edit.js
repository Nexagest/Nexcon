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
add.save_client = function(id, user, pass, name, email, type, client){
	var idata;
	$.ajax({
		type: 'POST',
		url: 'func/save_client.php',
		data: {
			'id':		id,
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
			// if(!add.check_id($('#id').val()))
				// error = error + 'NIF/CIF erróneo o duplicado, es un campo obligatorio para continuar.\n'
			if(!add.check_email($('#email').val()))
				error = error + 'Email erróneo, es un campo obligatorio.\n';
			if(error)
				alert(error);
			else{
				var tmp = add.save_client($('#id').val(), $('#user').val(), $('#pass').val(), $('#name').val(), $('#email').val(), $('#type').val(), $('#client').val());
				if(tmp){
					alert('El usuario ha sido modificado correctamente!');
				}else
					alert('Ocurrió un error al intentar modificar el usuario!');
				}
		});
	}
	$('#' + currentPage).ready(function(){
	});
});