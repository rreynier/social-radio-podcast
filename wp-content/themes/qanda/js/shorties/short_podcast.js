( function() {
	tinymce.create( 'tinymce.plugins.scpodcast', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcepodcast', function() {
				ed.windowManager.open( {
					file : url + '/podcast_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('scpodcast.delta_width', 0 ) ), // size of our window
					height : 200 + parseInt( ed.getLang('scpodcast.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );

			// Register buttons
			ed.addButton( 'scpodcast', { title : 'Insert Podcasts Shortcode', cmd : 'mcepodcast', image: url + '/images/podcast.png' } );
		}
	} );
	tinymce.PluginManager.add( 'scpodcast', tinymce.plugins.scpodcast );
} )();