/* flag inappropriate content, delete answer comment */
jQuery( document ).ready( function($) {

	/* report */
	jQuery( 'a[class^="k-flag-"]' ).click( function() {

		var me = jQuery( this );
		var o_id = jQuery( this ).data( 'id' );
		var o_postid = jQuery( this ).data( 'postid' );
		var o_type = jQuery( this ).data( 'type' );
		var o_author = jQuery( this ).data( 'author' );

		if( o_type == 'answer' || o_type == 'comment' ) make_temp_cover( 'div.kfa-' + o_id, 0 );
		else if( o_type == 'podcast' ) make_temp_cover( 'div.entry-flag', 1 );

		jQuery.ajax( { type: 'POST', url: flag_vars.ajaxpath, data: {
			action: 'k_flag_report',
			id: o_id,
			postid: o_postid,
			type: o_type,
			author: o_author,
			flagnonce: flag_vars.flagnonce
			}, success:
			function( response ) {
				if( o_type == 'answer' || o_type == 'comment' ) remove_temp_cover( 'div.kfa-' + o_id );
				else if( o_type == 'podcast' ) remove_temp_cover( 'div.entry-flag' );
				// modal
				jQuery( ".lean-msg" ).text( response.msg );
				jQuery( 'a[data-rel*=leanModal]' ).leanModal( { closeButton: ".lean-close" } );
				jQuery( "#show-lean-modal" ).click();
			}
		} );

	} );

	/* delete */
	jQuery( 'a.k-delete-comment' ).click( function() {

		var me = jQuery( this );
		var o_id = jQuery( this ).data( 'id' );
		var o_author = jQuery( this ).data( 'author' );

		make_temp_cover( 'div.acd-' + o_id, 0 );

		jQuery.ajax( { type: 'POST', url: flag_vars.ajaxpath, data: {
			action: 'k_delete_answer_comment',
			id: o_id,
			author: o_author,
			flagnonce: flag_vars.flagnonce
			}, success:
			function( response ) {
				remove_temp_cover( 'div.acd-' + o_id );
				// modal
				jQuery( ".lean-msg" ).text( response.msg );
				jQuery( 'a[data-rel*=leanModal]' ).leanModal( { closeButton: ".lean-close" } );
				jQuery( "#show-lean-modal" ).click();
				// remove comment visually too
				jQuery( "#li-comment-" + o_id ).fadeOut( 450 );
			}
		} );

	} );

	function make_temp_cover( selector, pos ) {
		jQuery( '<div/>', { "class": 'action-cover' } ).appendTo( selector );
		var selector_width = jQuery( selector ).width();
		var selector_height = jQuery( selector ).outerHeight( true );
		if( !pos ) jQuery( ".action-cover" ).css( { "width": selector_width, "height": selector_height } );
		else jQuery( ".action-cover" ).css( { "width": selector_width, "height": selector_height, "backgroundPosition": "30px top" } );
	}

	function remove_temp_cover( selector ) {
		jQuery( selector + " .action-cover" ).remove();
	}

} );