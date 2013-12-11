( function() {
	tinymce.create( 'tinymce.plugins.scwarnings', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcewarnings', function() {
				ed.windowManager.open( {
					file : url + '/warnings_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('scwarnings.delta_width', 0 ) ), // size of our window
					height : 200 + parseInt( ed.getLang('scwarnings.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'scwarnings', { title : 'Insert Warning/Alert Shortcodes', cmd : 'mcewarnings', image: url + '/images/warnings.png' } );
		}
	} );
	tinymce.PluginManager.add( 'scwarnings', tinymce.plugins.scwarnings );
} )();