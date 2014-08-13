nx.noRigth();
var currentUrl = window.location.href;
function saveNoty(msg, link, clients){
	var idata;
	$.ajax({
		type: 'POST',
		url: 'func/save.php',
		data: {m: msg, l: link, c: clients},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
}
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	var currentPage = $('.ui-page-active').attr('id');
	if(currentPage == 'documents'){
		$('#documents').ready(function(){
			$('#addType').bind('vclick', function(){
				var a = saveNoty($('#newTypeText').val(), $('#newTypeName').val(), $('#clients').val());
				if(a == 'ERROR')
					alert("Ocurrio un error!");
				else
					alert("Notificacion creada!");
			});
		});
	}
	$('#' + currentPage).ready(function(){
	});
});