/* comment answer */
jQuery( document ).ready( function($) {

	/* show/hide comment form */
	jQuery( "a.add-answer-comment" ).click( function() {

		var me = jQuery( this );
		var form_id = jQuery( this ).data( 'id' );
		jQuery( "div.answer-comment-wrapper" ).trigger( "acform", [ form_id ] );

		if( me.hasClass( "form-opened" ) ) {
			jQuery( "#answer-comment-form-" + form_id ).fadeOut( 100, function() {

				if( jQuery( '#acf-temp-' + form_id ).length ) {
					var answer_comment_form = jQuery( "#acf-temp-" + form_id ).contents();
					jQuery( '#ac-form-' + form_id ).append( answer_comment_form );
					jQuery( "#acf-temp-" + form_id ).remove();
					jQuery( "#tip-comment-" + form_id ).css( { "display": "none" } );
				}

				me.removeClass( 'form-opened' );
			} );
		} else {
			// are there any comments? if true, we should move the form below all existing comments
			if( me.parents( '#li-comment-' + form_id ).find( 'ul.children' ).length ) {
				var answer_comment_form = jQuery( "#ac-form-" + form_id ).contents();
				jQuery( '#li-comment-' + form_id + ' ul.children' ).after( '<div id="acf-temp-' + form_id + '" class="offset-by-two ten columns alpha omega clearfix" />' );
				jQuery( '#acf-temp-' + form_id ).append( answer_comment_form );
			}

			jQuery( "#answer-comment-form-" + form_id ).fadeIn( 250, function() {
				jQuery( 'html, body' ).animate( { scrollTop: jQuery( "#answer-comment-form-" + form_id ).offset().top }, 250 );
				me.addClass( 'form-opened' );
			} );
		}
	} );

	jQuery( 'form[id^="answer-comment-form-"]' ).submit( function(e) {

		e.preventDefault();
		// validate form flag
		var form_valid = 1;
		var me = jQuery( this );
		var my_id = me.data( "id" );
		var podcast_id = me.data( "qid" );
		var a_cont = jQuery( "#answer-comment-form-text-" + my_id ).val(); // markdown
		var converter = Markdown.getSanitizingConverter();
		var a_cont_html = converter.makeHtml( a_cont ); // html

		// validate simple: qt_min, qt_max, qc_min, qc_max, qtg_max, do_tag
		if( a_cont.length < ca_vars.ca_min || a_cont.length > ca_vars.ca_max ) {
			form_valid = 0;
			jQuery( "#tip-comment-" + my_id, this ).css( { "display": "block" } );
		}

		if( form_valid ) {
			jQuery( "#answer-comment-submit-" + my_id, this ).css( { "display": "none" } );
			jQuery( "div.hackett", this ).css( { "display": "block" } );

			jQuery.ajax( { type: 'POST', url: ca_vars.ajaxpath, data: {
				action: 'k_add_answer_comment',
				q_id: podcast_id,
				answer_id: my_id,
				answer_content: a_cont,
				answer_content_html: a_cont_html,
				commentnonce: ca_vars.commentnonce
				}, success:
				function( response ) {

					// hide the form and release submission message
					me.fadeOut( 250, function() {
						if( response.answer_ID > 0 ) {
							// refresh window
							if( window.location.hash ) {
								window.location.hash = "comment-" + response.answer_ID;
								window.location.reload( true );
							} else window.location.href = response.answer_perma + '/#comment-' + response.answer_ID;
						} else {
							alert( 'ERROR, unable to add comment! Please try again later.' );
						}
					} );

				}
			} );

		}


	} );

} );