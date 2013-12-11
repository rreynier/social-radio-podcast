/* count characters entered */
jQuery( document ).ready( function($) {
	var title_max = cc.title_max;
	var q_max = cc.q_max;
	var tag_max = cc.tag_max;
	var a_max = cc.a_max;
	var c_max = cc.c_max;

	// podcast title
	if( jQuery( '#podcast-title' ).length ) jQuery( '#podcast-title' ).limit( title_max, '#count-title' );
	// page ask podcast
	if( jQuery( 'body.page-template-page-askpodcast-php #wmd-input' ).length ) jQuery( 'body.page-template-page-askpodcast-php #wmd-input' ).limit( q_max, '#count-body' );
	// page edit podcast
	if( jQuery( 'body.page-template-page-editpodcast-php #wmd-input' ).length ) jQuery( 'body.page-template-page-editpodcast-php #wmd-input' ).limit( q_max, '#count-body' );
	// answer
	if( jQuery( 'body.single-podcast #wmd-input' ).length ) jQuery( 'body.single-podcast #wmd-input' ).limit( a_max, '#count-body' );
	// edit answer
	if( jQuery( 'body.page-template-page-editanswer-php #wmd-input' ).length ) jQuery( 'body.page-template-page-editanswer-php #wmd-input' ).limit( a_max, '#count-body' );
	// podcast tags
	if( jQuery( '#podcast-tags' ).length ) jQuery( '#podcast-tags' ).limit( tag_max, '#count-tags' );
	// answer comment ... the tricky one :(
	if( jQuery( 'body.single-podcast div.answer-comment-wrapper' ).length ) {
		jQuery( 'body.single-podcast div.answer-comment-wrapper' ).bind( 'acform', function( e, id, val ) {
			jQuery( 'body.single-podcast #answer-comment-form-text-' + id ).limit( c_max, '#count-ac-' + id );
		} );
	}
} );
/* count characters downstairs */
( function($) {
     $.fn.extend( {
         limit: function( limit, element ) {
			var interval, f;
			var self = $( this );
			$( this ).focus( function() {
				interval = window.setInterval( substring, 100 );
			} );
			$( this ).blur( function() {
				clearInterval( interval );
				substring();
			} );
			substringFunction = "function substring(){ var val = $(self).val();var length = val.length;if(length > limit){$(self).val($(self).val().substring(0,limit));}";
			if( typeof element != 'undefined' ) substringFunction += "if($(element).html() != limit-length){$(element).html((limit-length<=0)?'0':limit-length);}"
			substringFunction += "}";
			eval( substringFunction );
			substring();
        }
    } );
} )( jQuery );