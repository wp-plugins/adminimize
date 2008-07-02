var bAllChecked = false;
function toggleCheckboxes_menu() {
	var iCountBillingList = 100;
	bAllChecked = !bAllChecked; // switch (= toggle) the state
	document.getElementById( 'ctoggleCheckboxes_menu' ).checked = bAllChecked;		// show state in master checkbox
	document.getElementById( 'atoggleCheckboxes_menu' ).innerHTML = bAllChecked 	// rewrite link text
	? ' All'
	: ' All';
	for (var i = 0; i < iCountBillingList; i++) // set checked bool
	{
		if ( document.getElementById( 'check_menu' + i )) // HACK! iCountBillingList is wrong! -> mak
		document.getElementById( 'check_menu' + i ).checked = bAllChecked;
	}
}

var bAllChecked = false;
function toggleCheckboxes_menuadm() {
	var iCountBillingList = 100;
	bAllChecked = !bAllChecked; // switch (= toggle) the state
	document.getElementById( 'ctoggleCheckboxes_menuadm' ).checked = bAllChecked;		// show state in master checkbox
	document.getElementById( 'atoggleCheckboxes_menuadm' ).innerHTML = bAllChecked 	// rewrite link text
	? ' All'
	: ' All';
	for (var i = 0; i < iCountBillingList; i++) // set checked bool
	{
		if ( document.getElementById( 'check_menuadm' + i )) // HACK! iCountBillingList is wrong! -> mak
		document.getElementById( 'check_menuadm' + i ).checked = bAllChecked;
	}
}
//post
var bAllChecked = false;
function toggleCheckboxes_post() {
	var iCountBillingList = 20;
	bAllChecked = !bAllChecked; // switch (= toggle) the state
	document.getElementById( 'ctoggleCheckboxes_post' ).checked = bAllChecked;		// show state in master checkbox
	document.getElementById( 'atoggleCheckboxes_post' ).innerHTML = bAllChecked 	// rewrite link text
	? ' All'
	: ' All';
	for (var i = 0; i < iCountBillingList; i++) // set checked bool
	{
		if ( document.getElementById( 'check_post' + i )) // HACK! iCountBillingList is wrong! -> mak
		document.getElementById( 'check_post' + i ).checked = bAllChecked;
	}
}

var bAllChecked = false;
function toggleCheckboxes_postadm() {
	var iCountBillingList = 20;
	bAllChecked = !bAllChecked; // switch (= toggle) the state
	document.getElementById( 'ctoggleCheckboxes_postadm' ).checked = bAllChecked;		// show state in master checkbox
	document.getElementById( 'atoggleCheckboxes_postadm' ).innerHTML = bAllChecked 	// rewrite link text
	? ' All'
	: ' All';
	for (var i = 0; i < iCountBillingList; i++) // set checked bool
	{
		if ( document.getElementById( 'check_postadm' + i )) // HACK! iCountBillingList is wrong! -> mak
		document.getElementById( 'check_postadm' + i ).checked = bAllChecked;
	}
}

//page
var bAllChecked = false;
function toggleCheckboxes_page() {
	var iCountBillingList = 20;
	bAllChecked = !bAllChecked; // switch (= toggle) the state
	document.getElementById( 'ctoggleCheckboxes_page' ).checked = bAllChecked;		// show state in master checkbox
	document.getElementById( 'atoggleCheckboxes_page' ).innerHTML = bAllChecked 	// rewrite link text
	? ' All'
	: ' All';
	for (var i = 0; i < iCountBillingList; i++) // set checked bool
	{
		if ( document.getElementById( 'check_page' + i )) // HACK! iCountBillingList is wrong! -> mak
		document.getElementById( 'check_page' + i ).checked = bAllChecked;
	}
}

var bAllChecked = false;
function toggleCheckboxes_pageadm() {
	var iCountBillingList = 20;
	bAllChecked = !bAllChecked; // switch (= toggle) the state
	document.getElementById( 'ctoggleCheckboxes_pageadm' ).checked = bAllChecked;		// show state in master checkbox
	document.getElementById( 'atoggleCheckboxes_pageadm' ).innerHTML = bAllChecked 	// rewrite link text
	? ' All'
	: ' All';
	for (var i = 0; i < iCountBillingList; i++) // set checked bool
	{
		if ( document.getElementById( 'check_pageadm' + i )) // HACK! iCountBillingList is wrong! -> mak
		document.getElementById( 'check_pageadm' + i ).checked = bAllChecked;
	}
}