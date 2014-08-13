nx.noRigth();
var currentUrl = window.location.href;
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	var currentPage = $('.ui-page-active').attr('id');
	$('#' + currentPage).ready(function(){
		$('#send').click(function() {
			$('#form1').submit();
		});
	});
});