// leanModal v1.1 by Ray Stone - http://finelysliced.com.au
// Dual licensed under the MIT and GPL

(function($){$.fn.extend({leanModal:function(options){var defaults={top:100,overlay:0.5,closeButton:null};var overlay=$("<div id='lean_overlay'></div>");$("body").append(overlay);options=$.extend(defaults,options);return this.each(function(){var o=options;$(this).click(function(e){var modal_id=$(this).attr("href");$("#lean_overlay").click(function(){close_modal(modal_id)});$(o.closeButton).click(function(){close_modal(modal_id)});var modal_height=$(modal_id).outerHeight();var modal_width=$(modal_id).outerWidth();
$("#lean_overlay").css({"display":"block",opacity:0});$("#lean_overlay").fadeTo(200,o.overlay);$(modal_id).css({"display":"block","position":"fixed","opacity":0,"z-index":11000,"left":50+"%","margin-left":-(modal_width/2)+"px","top":o.top+"px"});$(modal_id).fadeTo(200,1);e.preventDefault()})});function close_modal(modal_id){$("#lean_overlay").fadeOut(200);$(modal_id).css({"display":"none"})}}})})(jQuery);

/* handle podcast, answer voting and favourites save */
jQuery( document ).ready( function($) {

	/* podcast vote pro and con */
	jQuery( document ).on( "click", 'a.q-vote', function() {

		var q_id = jQuery( this ).data( 'id' );
		var q_action = jQuery( this ).data( 'action' );
		var q_author = jQuery( this ).data( 'author' );

		make_temp_cover( 'section.meta-data' );

		jQuery.ajax( { type: 'POST', url: votefaves_vars.ajaxpath, data: { action: 'k_vote_podcast', id: q_id, author_id: q_author, votenonce: votefaves_vars.votenonce, to_do: q_action }, success:
			function( response ) {
				remove_temp_cover( 'section.meta-data' );
				// modal
				jQuery( ".lean-msg" ).text( response.msg );
				jQuery( 'a[data-rel*=leanModal]' ).leanModal( { closeButton: ".lean-close" } );
				jQuery( "#show-lean-modal" ).click();
				// end modal
				jQuery( "div.meta-votes-single" ).text( response.new_votes );
			}
		} );

		return ( false );
	} );

	/* answer vote pro and con */
	jQuery( document ).on( "click", 'a.a-vote', function() {

		var a_id = jQuery( this ).data( 'id' );
		var a_action = jQuery( this ).data( 'action' );
		var a_author = jQuery( this ).data( 'author' );

		make_temp_cover( 'div.am-' + a_id );

		jQuery.ajax( { type: 'POST', url: votefaves_vars.ajaxpath, data: { action: 'k_vote_answer', id: a_id, author_id: a_author, answernonce: votefaves_vars.votenonce, to_do: a_action }, success:
			function( response ) {
				remove_temp_cover( 'div.am-' + a_id );
				// modal
				jQuery( ".lean-msg" ).text( response.msg );
				jQuery( 'a[data-rel*=leanModal]' ).leanModal( { closeButton: ".lean-close" } );
				jQuery( "#show-lean-modal" ).click();
				// end modal
				jQuery( "div#votes-answer-" + a_id ).text( response.new_votes );
			}
		} );

		return ( false );
	} );

	/* save to favourites */
	jQuery( document ).on( "click", 'a.q-add-to-faves', function() {

		var me = jQuery( this );
		var q_id = jQuery( this ).data( 'id' );
		var q_action = jQuery( this ).data( 'action' );

		make_temp_cover( 'section.meta-data' );

		jQuery.ajax( { type: 'POST', url: votefaves_vars.ajaxpath, data: { action: 'k_handle_favourites', id: q_id, favenonce: votefaves_vars.votenonce, to_do: q_action }, success:
			function( response ) {
				remove_temp_cover( 'section.meta-data' );
				// modal
				jQuery( ".lean-msg" ).text( response.msg );
				jQuery( 'a[data-rel*=leanModal]' ).leanModal( { closeButton: ".lean-close" } );
				jQuery( "#show-lean-modal" ).click();
				// end modal
				me.removeClass( 'add-to-faves jq-hover q-add-to-faves' ).addClass( 'q-in-faves' ).removeAttr( 'data-id' ).removeAttr( 'data-action' );
				jQuery( "#times-faved" ).text( response.new_faves );
			}
		} );

		return ( false );
	} );

	/* remove from favourites */
	jQuery( document ).on( "click", 'a.q-remove-fave', function() {

		var me = jQuery( this );
		var q_id = jQuery( this ).data( 'id' );
		var q_action = jQuery( this ).data( 'action' );

		make_temp_cover( 'div.rf-' + q_id );

		jQuery.ajax( { type: 'POST', url: votefaves_vars.ajaxpath, data: { action: 'k_handle_favourites', id: q_id, favenonce: votefaves_vars.votenonce, to_do: q_action }, success:
			function( response ) {
				remove_temp_cover( 'div.rf-' + q_id );
				// modal
				jQuery( ".lean-msg" ).text( response.msg );
				jQuery( 'a[data-rel*=leanModal]' ).leanModal( { closeButton: ".lean-close" } );
				jQuery( "#show-lean-modal" ).click();
				// end modal
				jQuery( "#fave-row-" + q_id ).fadeOut( 450 );
			}
		} );

		return ( false );
	} );

	/* accept answer */
	jQuery( document ).on( "click", 'a.q-accept', function() {

		var me = jQuery( this );
		var a_id = jQuery( this ).data( 'id' );
		var q_id = jQuery( this ).data( 'qid' );
		var a_author = jQuery( this ).data( 'author' );

		make_temp_cover( 'div.am-' + a_id );

		jQuery.ajax( { type: 'POST', url: votefaves_vars.ajaxpath, data: { action: 'k_accept_answer', id: a_id, post_id: q_id, acceptnonce: votefaves_vars.votenonce, author_id: a_author }, success:
			function( response ) {
				remove_temp_cover( 'div.am-' + a_id );
				// modal
				jQuery( ".lean-msg" ).text( response.msg );
				jQuery( 'a[data-rel*=leanModal]' ).leanModal( { closeButton: ".lean-close" } );
				jQuery( "#show-lean-modal" ).click();
				// end modal
				setTimeout( function() {
					if( window.location.hash ) {
						window.location.hash = "comment-" + a_id;
						window.location.reload( true );
					} else window.location.href = response.redir + '/#comment-' + a_id;
				}, 2000);
			}
		} );

		return ( false );
	} );

	/* reject answer */
	jQuery( document ).on( "click", 'a.q-reject', function() {

		var a_id = jQuery( this ).data( 'id' );
		var q_id = jQuery( this ).data( 'qid' );
		var a_author = jQuery( this ).data( 'author' );

		make_temp_cover( 'div.am-' + a_id );

		jQuery.ajax( { type: 'POST', url: votefaves_vars.ajaxpath, data: { action: 'k_decept_answer', id: a_id, post_id: q_id, rejectnonce: votefaves_vars.votenonce, author_id: a_author }, success:
			function( response ) {
				remove_temp_cover( 'div.am-' + a_id );
				// modal
				jQuery( ".lean-msg" ).text( response.msg );
				jQuery( 'a[data-rel*=leanModal]' ).leanModal( { closeButton: ".lean-close" } );
				jQuery( "#show-lean-modal" ).click();
				// end modal
				setTimeout( function() {
					if( window.location.hash ) {
						window.location.hash = "comment-" + a_id;
						window.location.reload( true );
					} else window.location.href = response.redir + '/#comment-' + a_id;
				}, 2000);
			}
		} );

		return ( false );
	} );

	function make_temp_cover( selector ) {
		jQuery( '<div/>', { "class": 'action-cover' } ).appendTo( selector );
		var selector_width = jQuery( selector ).width();
		var selector_height = jQuery( selector ).outerHeight( true );
		jQuery( ".action-cover" ).css( { "width": selector_width, "height": selector_height } );
	}

	function remove_temp_cover( selector ) {
		jQuery( selector + " .action-cover" ).remove();
	}

} );