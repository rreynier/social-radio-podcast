( function() {
	tinymce.create( 'tinymce.plugins.sclayout', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcelayout', function() {
				ed.windowManager.open( {
					file : url + '/layout_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('sclayout.delta_width', 0 ) ), // size of our window
					height : 250 + parseInt( ed.getLang('sclayout.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'sclayout', { title : 'Insert Layout Shortcode', cmd : 'mcelayout', image: url + '/images/layout.png' } );
		}
	} );
	tinymce.PluginManager.add( 'sclayout', tinymce.plugins.sclayout );
} )();