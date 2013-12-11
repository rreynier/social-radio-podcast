( function() {
	tinymce.create( 'tinymce.plugins.scgooglemaps', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcegooglemaps', function() {
				ed.windowManager.open( {
					file : url + '/googlemaps_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('scgooglemaps.delta_width', 0 ) ), // size of our window
					height : 200 + parseInt( ed.getLang('scgooglemaps.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'scgooglemaps', { title : 'Insert GoogleMap', cmd : 'mcegooglemaps', image: url + '/images/googlemaps.png' } );
		}
	} );
	tinymce.PluginManager.add( 'scgooglemaps', tinymce.plugins.scgooglemaps );
} )();