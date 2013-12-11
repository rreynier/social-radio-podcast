( function() {
	tinymce.create( 'tinymce.plugins.scbutton', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcebutton', function() {
				ed.windowManager.open( {
					file : url + '/button_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('scbutton.delta_width', 0 ) ), // size of our window
					height : 495 + parseInt( ed.getLang('scbutton.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'scbutton', { title : 'Insert Button', cmd : 'mcebutton', image: url + '/images/button.png' } );
		}
	} );
	tinymce.PluginManager.add( 'scbutton', tinymce.plugins.scbutton );
} )();