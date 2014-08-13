nx.noRigth();
var currentUrl = window.location.href;
var form;
function sendFile(){
	var form = $('#theuploadform');
	$('#form_id').val(window.form);
	form.attr("file", $('#form_file').val());
	form.submit();
}
function delNewElement(id){
	$('#form_elements > li[eId="' + id + '"]').remove();
}
function addNewElement(){
	var type = parseInt($('#nx-controller #newElementType').val());
	var name = $('#nx-controller #newElementName').val();
	var id = parseInt($('#form_elements > li').last().attr('eId'));
	if(!id)
		id = 0;
	id++;
	var label = "";
	var newElementHtml = "";
	var newElement = "" +
		"<li eType='" + type + "' eName = '" + name + "' eId='" + id + "' data-theme='a'>" +
		"	<div style='position:relative;float:left;width:calc(100% - 30px);'>" +
		"		%LABEL_ELEMENT%" +
		"		%NEW_ELEMENT%" +
		"	</div>" +
		"	<div style='position:relative;float:left;'>" +
		"		<div style='position:absolute;left:10px;top:5px'>" +
		"			<input type='button' data-icon='delete' onclick='delNewElement(" + id + ")' data-iconpos='notext' value='Quitar'/>" +
		"		</div>" +
		"	</div>" +
		"	<div style='clear:both;'></div>" +
		"</li>" +
	"";
	switch(type){
		case 1:
		  newElement = newElement.replace("%NEW_ELEMENT%", "<input type='text' placeholder='" + name + "' class='newElement'/>");
		  newElementHtml = newElement.replace("%LABEL_ELEMENT%", label);
		  break;
		case 2:
		  newElement = newElement.replace("%NEW_ELEMENT%", "<input type='number' placeholder='" + name + "' class='newElement'/>");
		  newElementHtml = newElement.replace("%LABEL_ELEMENT%", label);
		  break;
		case 3:
		  newElement = newElement.replace("%NEW_ELEMENT%", "<input type='password' placeholder='" + name + "' class='newElement'/>");
		  newElementHtml = newElement.replace("%LABEL_ELEMENT%", label);
		  break;
		case 4:
		  newElement = newElement.replace("%NEW_ELEMENT%", "<input type='datetime-local' placeholder='" + name + "' class='newElement'/>");
		  label = '<label>' + name + '</label>';
		  newElementHtml = newElement.replace("%LABEL_ELEMENT%", label);
		  break;
		case 5:
		  newElement = newElement.replace("%NEW_ELEMENT%", "<input type='file' placeholder='" + name + "' class='newElement'/>");
		  label = '<label>' + name + '</label>';
		  newElementHtml = newElement.replace("%LABEL_ELEMENT%", label);
		  break;
		case 6:
		  newElement = newElement.replace("%NEW_ELEMENT%", "<textarea placeholder='" + name + "' class='newElement'></textarea>");
		  newElementHtml = newElement.replace("%LABEL_ELEMENT%", label);
		  break;
	}
	$('#form_elements').html($('#form_elements').html() + newElementHtml);
	$('#form_elements > li[eId="' + id + '"]').trigger('create');
	$('#form_elements').listview('refresh');
}
function saveForm(){
	var idata = true;
	var formName = $('#form_name').val();
	if($('#form_elements > li').length > 0){
		$.ajax({
			type: 'POST',
			url: 'func/addForm.php',
			data: {n: formName},
			dataType: 'text',
			async: false,
			success: function(result){
				window.form = result;
			}
		});
		$('#form_elements > li').each(function (i){
			var name = $($('#form_elements > li')[i]).attr('eName');
			var type = $($('#form_elements > li')[i]).attr('eType');
			$.ajax({
				type: 'POST',
				url: 'func/add.php',
				data: {n: name, t: type, f: window.form},
				dataType: 'text',
				async: false,
				success: function(result){
					if(result == '0')
						result = false;
					else
						result = true;
					if(idata)
						idata = result;
				}
			});
		});
	}else{
		return false;
	}
	return idata;
}
$(document).bind('pageshow', function() {
	nx.fix_externalLink(currentUrl);
	var currentPage = $('.ui-page-active').attr('id');
	if(currentPage == 'documents'){
		$('#documents').ready(function(){
			$('#addType').bind('vclick', function(){
				var a = saveForm();
				if(!a){
					alert("Ocurrió un error!");
				}else{
					sendFile();
				}
			});
		});
	}
	$('#' + currentPage).ready(function(){
	});
});