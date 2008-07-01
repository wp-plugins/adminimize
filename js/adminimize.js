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
