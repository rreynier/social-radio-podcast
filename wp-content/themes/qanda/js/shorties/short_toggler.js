( function() {
	tinymce.create( 'tinymce.plugins.sctoggler', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcetoggler', function() {
				ed.windowManager.open( {
					file : url + '/toggler_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('sctoggler.delta_width', 0 ) ), // size of our window
					height : 200 + parseInt( ed.getLang('sctoggler.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'sctoggler', { title : 'Insert Toggler Shortcode', cmd : 'mcetoggler', image: url + '/images/toggler.png' } );
		}
	} );

	tinymce.PluginManager.add( 'sctoggler', tinymce.plugins.sctoggler );
} )();