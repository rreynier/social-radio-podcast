( function() {
	tinymce.create( 'tinymce.plugins.sclists', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcelists', function() {
				ed.windowManager.open( {
					file : url + '/lists_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('sclists.delta_width', 0 ) ), // size of our window
					height : 200 + parseInt( ed.getLang('sclists.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'sclists', { title : 'Insert List Shortcodes', cmd : 'mcelists', image: url + '/images/lists.png' } );
		}
	} );
	tinymce.PluginManager.add( 'sclists', tinymce.plugins.sclists );
} )();