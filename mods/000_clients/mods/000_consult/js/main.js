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
			"<li>" +
			"	<div data-inset='false' data-content-theme='b'>" +
			"		<h3>" + clientInfo[1] + "	<font size='2' color='#FF7373'>" + clientInfo[0] + "</font>" +
			"		<span class='secret_tags'>trimestral</span></h3>" +
			"		<p>Telefono: " + clientInfo[3] + "<br/>" +
			"		Email: " + clientInfo[5] + "<br/>" +
			"		Dirección: " + clientInfo[7] + "<br/>" +
			"		CP: " + clientInfo[8] + "<br/>" +
			"		Web: <a href='" + clientInfo[4] + "'>" + clientInfo[4] + "</a><br/>" +
			"	<div>" +
			"</li>" +
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
nx.noRigth();
var currentUrl = window.location.href;
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	var currentPage = $('.ui-page-active').attr('id');
	if(currentPage == 'client_list'){
		$('#client_list').ready(function(){
			clientList.getAndPutAll();
		});
	}
	$('#' + currentPage).ready(function(){
		$('.back_button').bind('vclick', function(e){
			nx.goPage('../');
		});
	});
});
