function BorrarCliente(cliente, grupo){
	confirmar=confirm("¿Esta seguro que desea quitar el cliente " + cliente + " del grupo?"); 
	if (confirmar){
		var idata;
		$.ajax({
			type: 'POST',
			url: 'func/quitarcliente.php',
			data: {'cliente': cliente, 'grupo': grupo},
			dataType: 'text',
			async: false,
			success: function(result){idata = result;}
		});
		if(idata){
			alert('Se ha quitado el cliente ' + cliente + ' del grupo!');
			window.location.href = window.location.href;
		}else
			alert('Ocurrio un error al intentar quitarlo del grupo!');
	}else
		alert('Operacion abortada por el usuario.'); 
}
function AddClient(){
	var cliente = $('#client').val();
	confirmar=confirm("¿Esta seguro que desea añadir el cliente " + cliente + " al grupo?"); 
	if (confirmar){
		var idata;
		$.ajax({
			type: 'POST',
			url: 'func/addclient.php',
			data: {'cliente': cliente, 'grupo': grupo},
			dataType: 'text',
			async: false,
			success: function(result){idata = result;}
		});
		if(idata){
			alert('Se ha añadido el cliente ' + cliente + ' al grupo!');
			window.location.href = window.location.href;
		}else
			alert('Ocurrio un error al intentar añadirlo al grupo!');
	}else
		alert('Operacion abortada por el usuario.'); 
}
nx.noRigth();
var currentUrl = window.location.href;
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	$('#addclient').bind('vclick', function(e){
		AddClient();
	});
});