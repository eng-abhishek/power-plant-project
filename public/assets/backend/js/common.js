$(document).ready(function(){
	
	$(".m-select2").select2();

	$(".m-select2-multiple").select2({
		placeholder : "Select"
	});

	$(".m-select2-tag").select2({
		placeholder:"Add a tag",
		tags:!0
	});

});

/* Copy to clipboard */
function copy_to_clipboard(target_id) {
	var target_element = $('#'+target_id);
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val($(target_element).val()).select();
	document.execCommand("copy");
	$temp.remove();
	toastr.info('Copied');
}

/* Convert string to slug */
function slugify(string) {
	return string.trim()
	.toLowerCase()
	.replace(/[^a-z0-9]+/g,'-')
	.replace(/^-+/, '')
	.replace(/-+$/, '');
}