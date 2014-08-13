const LVL_MOD = 1;
function main(){
	var get_mods;
	var get_curr_dir;
	var goMod;
}
main.get_curr_dir = function(){
	var url = window.location.href;
	var sects = url.split('/');
	var last = sects.length;
	var curr = last - 1;
	var curr_dir = '';
	for(var i = curr - (2 * LVL_MOD); i < curr; i++){
		curr_dir = curr_dir + sects[i] + '/';
	}
	return curr_dir;
}
main.goMod = function(mod){
	nx.goPage('mods/' + mod + '/main.php');
}
main.get_mods = function(){
	var mods_dir = main.get_curr_dir() + 'mods';
	var lvl_dir = '';
	for(var i = 0; i < LVL_MOD; i++){
		lvl_dir = lvl_dir + '../../';
	}
	var mods = nx.get_mods(mods_dir).split(';');
	var grid = '<div data-role="grid">';
	for(var i = 0; i < mods.length -1; i++){
		var mod = mods[i].split('|');
		grid += '<div id="main_grid_mod_' + mod[0] + '" data-role="grid_button"><a href="#" onclick="main.goMod(\'' + mod[3] + '\');"><div class="grid_button_icon" style="background: url(' + lvl_dir + 'imgs/icons/' + mod[2] + ') no-repeat center center;"></div><span>' + mod[1] + '</span></a></div>';
	}
	grid += '</div>';
	$('#main > div[data-role="content"]').html(grid);
	$('#main').trigger('create');
}
nx.noRigth();
var currentUrl = window.location.href;
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	if(!nx.is_logged())
		nx.goPage('../');
	var currentPage = $('.ui-page-active').attr('id');
	if(currentPage == 'main'){
		$('#main').ready(function(){
			main.get_mods();
			$(window).resize(function(){
				nx.fix_grid('#main div[data-role="grid"]');
			});
			nx.fix_grid('#main div[data-role="grid"]');
		});
	}
	$('#' + currentPage).ready(function(){
		$('.back_button').bind('vclick', function(e){
			nx.goPage('../');
		});
	});
});
