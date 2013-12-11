( function() {
	tinymce.create( 'tinymce.plugins.scbreak', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcebreak', function() {
				ed.windowManager.open( {
					file : url + '/break_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('scbreak.delta_width', 0 ) ), // size of our window
					height : 200 + parseInt( ed.getLang('scbreak.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'scbreak', { title : 'Insert Break (empty or lined)', cmd : 'mcebreak', image: url + '/images/break.png' } );
		}
	} );
	tinymce.PluginManager.add( 'scbreak', tinymce.plugins.scbreak );
} )();