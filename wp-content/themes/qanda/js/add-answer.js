/* add answer */
jQuery( document ).ready( function($) {

	jQuery( "#answerform" ).submit( function(e) {

		e.preventDefault();
		// validate form flag
		var form_valid = 1;

		var form_w = jQuery( this ).width();
		var form_h = jQuery( this ).outerHeight( true );

		// scroll to the top of page
		jQuery( 'html, body' ).animate( { scrollTop: jQuery( "#answerform" ).offset().top }, 250 );
		// reveal elements
		jQuery( "div.form-loader", this ).css( { "display": "block", "left": ( ( form_w - 150 ) / 2 ), "top": 20 } );
		jQuery( "div.form-cover", this ).css( { "display": "block", "width": form_w, "height": form_h } );

		var podcast_id = jQuery( this ).find( "#wmd-input" ).data( "qid" );
		var a_cont_md   = jQuery( "#wmd-input", this ).val();
		var a_cont      = jQuery( "#wmd-preview" ).html();

		// validate simple: qt_min, qt_max, qc_min, qc_max, qtg_max, do_tag
		if( a_cont_md.length < na_vars.ac_min || a_cont_md.length > na_vars.ac_max ) {
			form_valid = 0;
			jQuery( "#tip-podcast-content", this ).css( { "display": "block" } );
		}

		if( form_valid ) {
			jQuery.ajax( { type: 'POST', url: na_vars.ajaxpath, data: {
				action: 'k_ajax_add_new_answer',
				q_id: podcast_id,
				answer_content: a_cont,
				answer_content_markdown: a_cont_md,
				answernonce: na_vars.answernonce
				}, success:
				function( response ) {

					// hide the form and release submission message
					jQuery( "#answerform" ).fadeOut( 250, function() {
						// hide elements
						jQuery( "div.form-loader" ).css( { "display": "none" } );
						jQuery( "div.form-cover" ).css( { "display": "none" } );

						if( response.answer_ID > 0 ) {
							jQuery( "#commentswrapper" ).css( { "marginBottom": 20 } );
							// show up message
							jQuery( 'html, body' ).animate( { scrollTop: jQuery( "#answer-messages" ).offset().top }, 250 );
							jQuery( "div.form-message-ok" ).fadeIn( 250 );
							// refresh window
							setTimeout( function() {
								if( window.location.hash ) {
									window.location.hash = "comment-" + response.answer_ID;
									window.location.reload( true );
								} else window.location.href = response.answer_perma + '/#comment-' + response.answer_ID;
							}, 3000 );
						} else {
							jQuery( "#commentswrapper" ).css( { "marginBottom": 20 } );
							jQuery( 'html, body' ).animate( { scrollTop: jQuery( "#answer-messages" ).offset().top }, 250 );
							jQuery( "div.form-message-error" ).fadeIn( 250 );
						}
					} );

				}
			} );

		} else {
			jQuery( "div.form-loader" ).css( { "display": "none" } );
			jQuery( "div.form-cover" ).css( { "display": "none" } );
		}

	} );

} );