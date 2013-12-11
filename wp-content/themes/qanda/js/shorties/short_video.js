( function() {
	tinymce.create( 'tinymce.plugins.scvideo', {
		init : function( ed, url ) {
			// Register commands
			ed.addCommand( 'mcevideos', function() {
				ed.windowManager.open( {
					file : url + '/video_popup.php', // file that contains HTML for our modal window
					width : 695 + parseInt( ed.getLang('scvideo.delta_width', 0 ) ), // size of our window
					height : 300 + parseInt( ed.getLang('scvideo.delta_height', 0 ) ), // size of our window
					inline : 1
				} );
			} );
 
			// Register buttons
			ed.addButton( 'scvideo', { title : 'Insert Video Shortcode', cmd : 'mcevideos', image: url + '/images/video.png' } );
		}
	} );
	tinymce.PluginManager.add( 'scvideo', tinymce.plugins.scvideo );
} )();