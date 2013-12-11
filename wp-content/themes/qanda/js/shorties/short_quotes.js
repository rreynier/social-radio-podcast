( function() {
	tinymce.create( 'tinymce.plugins.scquotes', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcequotes', function() {
				ed.windowManager.open( {
					file : url + '/quotes_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('scquotes.delta_width', 0 ) ), // size of our window
					height : 200 + parseInt( ed.getLang('scquotes.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'scquotes', { title : 'Insert Quotes Shortcode', cmd : 'mcequotes', image: url + '/images/quotes.png' } );
		}
	} );

	tinymce.PluginManager.add( 'scquotes', tinymce.plugins.scquotes );
} )();