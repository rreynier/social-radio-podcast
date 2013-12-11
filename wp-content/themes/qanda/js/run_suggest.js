// suggest tags in new entry or edit entry form
jQuery( function($) {
	jQuery( '#podcast-tags' ).suggest( run_suggest_vars.ajaxpath + "?action=k_suggest_tag", { minchars: 3, multiple: true, multipleSep: "," } );
} );