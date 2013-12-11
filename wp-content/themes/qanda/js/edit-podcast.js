/* edit podcast */
jQuery( document ).ready( function($) {

	jQuery( "#podcast-edit" ).submit( function(e) {

		e.preventDefault();
		// validate form flag
		var form_valid = 1;

		var form_w = jQuery( this ).width();
		var form_h = jQuery( this ).height();

		// scroll to the top of page
		jQuery( 'html, body' ).animate( { scrollTop: jQuery( "#k-content" ).offset().top }, 250 );
		// reveal elements
		jQuery( "div.form-loader" ).css( { "display": "block", "left": ( ( form_w - 150 ) / 2 ), "top": 20 } );
		jQuery( "div.form-cover" ).css( { "display": "block", "width": form_w, "height": form_h } );

		var qid        = jQuery( "#podcast-id" ).val();
		var q_title    = jQuery( "#podcast-title" ).val();
		var q_cont_md  = jQuery( "#wmd-input" ).val();
		var q_cont     = jQuery( "#wmd-preview" ).html();
		var q_tags     = jQuery( "#podcast-tags" ).val();
		var q_cat      = jQuery( "#podcast-category" ).val();

		// validate simple: qt_min, qt_max, qc_min, qc_max, qtg_max, do_tag
		if( q_title.length < eq_vars.qt_min || q_title.length > eq_vars.qt_max ) {
			form_valid = 0;
			jQuery( "#tip-podcast-title" ).css( { "display": "block" } );
		}
		if( q_cont_md.length < eq_vars.qc_min || q_cont_md.length > eq_vars.qc_max ) {
			form_valid = 0;
			jQuery( "#tip-podcast-content" ).css( { "display": "block" } );
		}
		if( q_tags.length > eq_vars.qtg_max && eq_vars.do_tag ) {
			form_valid = 0;
			jQuery( "#tip-podcast-tags" ).css( { "display": "block" } );
		}

		if( form_valid ) {
			jQuery.ajax( { type: 'POST', url: eq_vars.ajaxpath, data: {
				action: 'k_edit_podcast',
				q_id: qid,
				podcast_title: q_title,
				podcast_content: q_cont,
				podcast_content_markdown: q_cont_md,
				podcast_tags: q_tags,
				podcast_category: q_cat,
				podcastnonce: eq_vars.podcastnonce
				}, success:
				function( response ) {
					// response: 1. podcast_ID, 2. podcast_perma 3. do_redirect

					// hide the form and release submission message
					jQuery( "#podcast-edit" ).fadeOut( 250, function() {
						// hide elements
						jQuery( "div.form-loader" ).css( { "display": "none" } );
						jQuery( "div.form-cover" ).css( { "display": "none" } );

						if( response.podcast_ID > 0 ) {
							// show up message
							jQuery( "div.form-message-ok" ).fadeIn( 250 );
								setTimeout( function() {
									window.location.href = response.podcast_perma;
							}, 3000);
						} else {
							// we are dealing with an error...
							// show up different message
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