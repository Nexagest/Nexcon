nx.noRigth();
var currentUrl = window.location.href;
function sendForm(form_id){
	
	$('#fui_' + form_id + ' ul > li [eid]').each(function (i){
		alert($($('#fui_' + form_id + ' ul > li [eid]')[i]).attr('eid') + ': ' +
		$($('#fui_' + form_id + ' ul > li [eid]')[i]).val());
	})
}
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	var currentPage = $('.ui-page-active').attr('id');
	$('#' + currentPage).ready(function(){
		if(currentPage == 'forms'){
			
		}
	});
});