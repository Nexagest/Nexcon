nx.noRigth();
var currentUrl = window.location.href;
clientList = function(){
	get;
	put;
	count;
	getAndPutAll;
}
clientList.get = function(ini, num){
	var idata;
	$.ajax({
		type: 'POST',
		url: 'func/clientListGet.func.php',
		data: {i: ini, l: num},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
}
clientList.put = function(clientsString){
	var clients = clientsString.split(';');
	for(var i = 0; i < clients.length - 1; i++){
		var clientInfo = clients[i].split(':');
		var clientSect = "" +
			"<li data-theme='b' id='" + clientInfo[0] + "' tname='"+ clientInfo[1] +"'><a href='#' onclick='typeoptions(\"" + clientInfo[0] + "\");'>" +
			"	<h3>" + clientInfo[0] + "	<font size='2' color='#FF7373'>" + clientInfo[1] + "</font></h3>" +
			"</a></li>" +
		"";
		var list = $('#clients_list').html() + clientSect;
		$('#clients_list').html(list);
		$('#clients_list').listview('refresh');
	}
}
clientList.count = function(){
	var idata;
	$.ajax({
		type: 'POST',
		url: 'func/clientListCount.func.php',
		data: {},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
}
clientList.getAndPutAll = function(){
	var bufferSize = 100;
	var bufferPages = Math.ceil(clientList.count() / 100);
	for(var pageCount = 0; pageCount < bufferPages; pageCount++){
		var clients = clientList.get(pageCount * bufferSize, bufferSize);
		this.put(clients);
	}
}
var currentType = '';
function typeoptions(file){
	currentType = file;
	$("#nameMod").val($('#'+file).attr('tname'));
	$("#moreinfo" ).popup("open" , {});
}
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	var currentPage = $('.ui-page-active').attr('id');
	if(currentPage == 'documents'){
		$('#documents').ready(function(){
			clientList.getAndPutAll();
			$('#addType').bind('vclick', function(){
				nx.goPage('add.php?i='+$('#newTypeId').val()+'&n='+$('#newTypeName').val());
			});
			$('#mod').bind('vclick', function(){
				nx.goPage('add.php?i='+currentType+'&n='+$('#nameMod').val());
			});
			$('#delthis').bind('vclick', function(){
				nx.goPage('del.php?i='+currentType);
			});
			$('#close').bind('vclick', function(){
				$("#moreinfo" ).popup("close");
			});
		});
	}
	$('#' + currentPage).ready(function(){
	});
});