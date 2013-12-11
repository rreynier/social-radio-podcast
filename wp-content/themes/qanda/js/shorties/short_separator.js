( function() {
	tinymce.create( 'tinymce.plugins.scseparator', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mceseparator', function() {
				ed.windowManager.open( {
					file : url + '/separator_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('scseparator.delta_width', 0 ) ), // size of our window
					height : 220 + parseInt( ed.getLang('scseparator.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'scseparator', { title : 'Insert Separator', cmd : 'mceseparator', image: url + '/images/separator.png' } );
		}
	} );
	tinymce.PluginManager.add( 'scseparator', tinymce.plugins.scseparator );
} )();