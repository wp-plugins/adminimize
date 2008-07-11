jQuery(function(){
	jQuery("input#ctoggleCheckboxes_menu, input#ctoggleCheckboxes_menuadm, input#ctoggleCheckboxes_post, input#ctoggleCheckboxes_postadm, input#ctoggleCheckboxes_page, input#ctoggleCheckboxes_pageadm").css("display", "none");
});

var bAllChecked = false;
function toggleCheckboxes_menu() {
	jQuery("input[id^='check_menu']").not("input[id^='check_menuadm']").attr("checked", !bAllChecked);
	bAllChecked = !bAllChecked; jQuery('#atoggleCheckboxes_menu').text( bAllChecked ? 'None' : 'All' );
}

var bAllChecked = false;
function toggleCheckboxes_menuadm() {
	jQuery("input[id^='check_menuadm']").attr("checked", !bAllChecked);
	bAllChecked = !bAllChecked; jQuery('#atoggleCheckboxes_menuadm').text( bAllChecked ? 'None' : 'All' );
}

//post
var bAllChecked = false;
function toggleCheckboxes_post() {
	jQuery("input[id^='check_post']").not("input[id^='check_postadm']").attr("checked", !bAllChecked);
	bAllChecked = !bAllChecked; jQuery('#atoggleCheckboxes_post').text( bAllChecked ? 'None' : 'All' );
}

var bAllChecked = false;
function toggleCheckboxes_postadm() {
	jQuery("input[id^='check_postadm']").attr("checked", !bAllChecked);
	bAllChecked = !bAllChecked; jQuery('#atoggleCheckboxes_postadm').text( bAllChecked ? 'None' : 'All' );
}

//page
var bAllChecked = false;
function toggleCheckboxes_page() {
	jQuery("input[id^='check_page']").not("input[id^='check_pageadm']").attr("checked", !bAllChecked);
	bAllChecked = !bAllChecked; jQuery('#atoggleCheckboxes_page').text( bAllChecked ? 'None' : 'All' );
}

var bAllChecked = false;
function toggleCheckboxes_pageadm() {
	jQuery("input[id^='check_pageadm']").attr("checked", !bAllChecked);
	bAllChecked = !bAllChecked; jQuery('#atoggleCheckboxes_pageadm').text( bAllChecked ? 'None' : 'All' );
}