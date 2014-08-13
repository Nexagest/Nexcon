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
		if(clientInfo[7] != '')
			var clientName = '<font size="2" color="#00FF00">[ ' + clientInfo[7] + ' ]</font>';
		else
			var clientName = '';
		var clientSect = "" +
			"<li>" +
			"	<a href='edit.php?c="+clientInfo[0]+"' data-inset='false' data-content-theme='b'>" +
			"		<h3 style='top:-5px;margin-bottom:0px;'>" + clientInfo[1] + "	<font size='2' color='#FF7373'>" + clientInfo[3] + " " + clientName + "</font></h3>" +
			"		<div style='visibility:hidden; position:absolute; width:0px; height:0px'>"+clientInfo[0]+", "+clientInfo[1]+", "+clientInfo[2]+", "+clientInfo[3]+", "+clientInfo[4]+", "+clientInfo[5]+", "+clientInfo[6]+", "+clientInfo[7]+"</div>" +
			"	</a>" +
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
	var bufferSize = 1000;
	var bufferPages = Math.ceil(clientList.count() / bufferSize);
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
