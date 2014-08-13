<?php
if(isset($_REQUEST['mod_lv'])){
	$lv = $_REQUEST['mod_lv'];
	$dir = '';
	for($i = 0; $i < $lv; $i++){
		$dir .= '../../';
	}
}else{
	$dir = '';
}
?>
function nx(){
	var fix_externalLink;
	var is_logged;
	var login;
	var get_mods;
	var fix_grid;
	var goPage;
	var noRigth;
	var logout;
	var clearElements;
	var check_nif_cif;
	var check_email;
	var check_web;
	var noBack;
}
nx.check_nif_cif = function(nif_cif){

};
nx.fix_externalLink = function(orig){
	var newUrl = window.location.href;
	if(orig.split('#')[0] != newUrl.split('#')[0])
		window.location.reload();
};
nx.is_logged = function(){
	var idata;
	$.ajax({
		type: 'POST',
		url: '<?php echo $dir;?>func/session/is_logged.func.php',
		data: {},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
};
nx.login = function(user, pass){
	var idata;
	$.ajax({
		type: 'POST',
		url: '<?php echo $dir;?>func/session/login.func.php',
		data: {'user': user, 'pass': pass},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
}
nx.get_mods = function(dir){
	var idata;
	$.ajax({
		type: 'POST',
		url: '<?php echo $dir;?>func/mods/get_mods.func.php?dir='+dir,
		data: {},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
}

nx.fix_grid = function(element){
	var grid_width = $(element).parent().width();
	var buttons_size = $(element + ' > div').width();
	var width = (buttons_size + 5 + 2);
	var max_buttons = Math.floor(grid_width / width);
	var buttons = $(element + '>div').length;
	if(buttons < max_buttons)
		grid_width = (buttons * width) + 5;
	else
		grid_width = (max_buttons * width) + 5;
	$(element).attr('style', 'width:' + grid_width + 'px');
}
nx.goPage = function(page){
	var currentPage = $('.ui-page-active').attr('id');
	var currentUrl = window.location.href;
	//this.clearElements('#' + currentPage);
	//$.mobile.changePage(page, {transition: 'none'});
	window.location.assign(page);
	//console.log(page);
};
nx.noBack = function(){
	var currentUrl = window.location.href;
	nx.fix_externalLink(currentUrl);
}
nx.noRigth = function(){
	$(document).ready(function(){
	   $(document).bind("contextmenu",function(e){
			  return false;
	   });
	}); 
}
nx.logout = function(){
	var idata;
	$.ajax({
		type: 'POST',
		url: '<?php echo $dir;?>func/session/logout.func.php',
		data: {},
		dataType: 'text',
		async: false,
		success: function(result){idata = result;}
	});
	return idata;
}
nx.clearElements = function(page){
	$(page + ' input').val('');
}
nx.noBack();