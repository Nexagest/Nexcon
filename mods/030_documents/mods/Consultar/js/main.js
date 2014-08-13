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
			"<li data-theme='c'><a href='files.php?c="+clientInfo[0]+"'>" +
			"	<h3>" + clientInfo[0] + "	<font size='2' color='#FF7373'>" + clientInfo[1] + "</font>" +
			"	<span class='secret_tags'></span></h3>" +
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
var currentFile = '';
function fileoptions(file){
	currentFile = file;
	$("#moreinfo" ).popup("open" , {});
}
var currentMod = '';
function filemode(file){
	currentMod = file;
	$('input[name="mode-choice"]').each(function(index) {
		$('#'+this.id).prop("checked",false).checkboxradio("refresh");
	});
	if(file.split('/')[1].split('[nx]')[0] == '00'){
		$('#invisible').prop("checked", true).checkboxradio("refresh");
	}else if(file.split('/')[1].split('[nx]')[0] == '01'){
		$('#visible').prop("checked", true).checkboxradio("refresh");
	}else if(file.split('/')[1].split('[nx]')[0] == '02'){
		$('#vip').prop("checked", true).checkboxradio("refresh");
	}
	$("#modewin").popup("open", {});
}
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	var currentPage = $('.ui-page-active').attr('id');
	if(currentPage == 'documents'){
		$('#client_list').ready(function(){
			clientList.getAndPutAll();
		});
	}else if(currentPage == 'documentsversion'){
		$('#downloadthis').ready(function(){
			$('#downloadthis').bind('vclick', function(e){
				nx.goPage('download.php?fv='+currentFile);
			});
		});
		$('#setlast').ready(function(){
			$('#setlast').bind('vclick', function(e){
				nx.goPage('setlast.php?fv='+currentFile);
			});
		});
		$('#delothers').ready(function(){
			$('#delothers').bind('vclick', function(e){
				nx.goPage('del.php?o&fv='+currentFile);
			});
		});
		$('#delthis').ready(function(){
			$('#delthis').bind('vclick', function(e){
				nx.goPage('del.php?fv='+currentFile);
			});
		});
		$('#close').ready(function(){
			$('#close').bind('vclick', function(e){
				$("#moreinfo" ).popup("close" , {});
			});
		});
	}else if(currentPage == 'documentsclient'){
		$('#modClose').bind('vclick', function(e){
			$("#modewin" ).popup("close" , {});
		});
		$('#modSave').bind('vclick', function(e){
			$('input[name="mode-choice"]').each(function(index) {
				if($('#'+this.id).prop("checked"))
					nx.goPage('modvi.php?f='+currentMod+'&m='+index);
			});
		});
	}
	$('#' + currentPage).ready(function(){
	});
});