( function() {
	tinymce.create( 'tinymce.plugins.sctabber', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcetabber', function() {
				ed.windowManager.open( {
					file : url + '/tabber_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('sctabber.delta_width', 0 ) ), // size of our window
					height : 200 + parseInt( ed.getLang('sctabber.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'sctabber', { title : 'Insert Tabbed Content', cmd : 'mcetabber', image: url + '/images/tabber.png' } );
		}
	} );
	tinymce.PluginManager.add( 'sctabber', tinymce.plugins.sctabber );
} )();