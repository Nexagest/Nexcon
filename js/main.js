function login(){
	var login;
}
login.login = function(){
	var currentUrl = window.location.href;
	var login_user = $('#login_user').val();
	var login_pass = $('#login_pass').val();
	//alert(login_user + ' ' + login_pass);
	if(nx.login(login_user, login_pass)){
		nx.goPage('main.php');
	}else
		alert('Contraseña errónea!');
}
function main(){
	var get_mods;
	var goMod;
}
main.goMod = function(mod){
	nx.goPage('mods/' + mod + '/main.php');
}
main.get_mods = function(){
	var mods = nx.get_mods('mods').split(';');
	var grid = '<div data-role="grid">';
	for(var i = 0; i < mods.length -1; i++){
		var mod = mods[i].split('|');
		grid += '<div id="main_grid_mod_' + mod[0] + '" data-role="grid_button"><a href="#" onclick="main.goMod(\'' + mod[3] + '\');"><div class="grid_button_icon" style="background: url(imgs/icons/' + mod[2] + ') no-repeat center center;"></div><span>' + mod[1] + '</span></a></div>';
	}
	grid += '</div>';
	$('#main > div[data-role="content"]').html(grid);
	$('#main').trigger('create');
}
nx.noRigth();
var currentUrl = window.location.href;
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	var currentPage = $('.ui-page-active').attr('id');
	if(currentPage == 'login'){
		$('#login').ready(function(){
			if(nx.is_logged())
				nx.goPage('main.php');
			$('#login_button').bind('vclick', function(e){
				login.login();
			});
			$("#login_user").keypress(function(key) {
				if(key.which == 13)
					$("#login_pass").focus();
			});
			$("#login_pass").keypress(function(key) {
				if(key.which == 13)
					login.login();
			});
		});
	}else if(currentPage == 'main'){
		$('#main').ready(function(){
			main.get_mods();
			$(window).resize(function(){
				nx.fix_grid('#main div[data-role="grid"]');
			});
			nx.fix_grid('#main div[data-role="grid"]');
		});
	}
	if(currentPage != 'login'){
			if(!nx.is_logged())
				nx.goPage('index.php');
	}
	$('#' + currentPage).ready(function(){
		$('.logout_button').bind('vclick', function(e){
			if(nx.logout()){
				nx.goPage('index.php');
			}
		});
	});
});
