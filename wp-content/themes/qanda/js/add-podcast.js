/* add new podcast */
jQuery( document ).ready( function($) {

	jQuery( "#podcast-add" ).submit( function(e) {

		e.preventDefault();
		// validate form flag
		var form_valid = 1;

		var form_w = jQuery( this ).width();
		var form_h = jQuery( this ).height();

		// scroll to the top of page
		jQuery( 'html, body' ).animate( { scrollTop: jQuery( "#k-content" ).offset().top }, 250 );
		// reveal elements
		jQuery( "div.form-loader", this ).css( { "display": "block", "left": ( ( form_w - 150 ) / 2 ), "top": 20 } );
		jQuery( "div.form-cover", this ).css( { "display": "block", "width": form_w, "height": form_h } );

		var q_title    = jQuery( "#podcast-title", this ).val();
		var q_cont_md  = jQuery( "#wmd-input", this ).val();
		var q_cont     = jQuery( "#wmd-preview" ).html();
		var q_tags     = jQuery( "#podcast-tags", this ).val();
		var q_cat      = jQuery( "#podcast-category", this ).val();

		// validate simple: qt_min, qt_max, qc_min, qc_max, qtg_max, do_tag
		if( q_title.length < nq_vars.qt_min || q_title.length > nq_vars.qt_max ) {
			form_valid = 0;
			jQuery( "#tip-podcast-title", this ).css( { "display": "block" } );
		}
		if( q_cont_md.length < nq_vars.qc_min || q_cont_md.length > nq_vars.qc_max ) {
			form_valid = 0;
			jQuery( "#tip-podcast-content", this ).css( { "display": "block" } );
		}
		if( q_tags.length > nq_vars.qtg_max && nq_vars.do_tag ) {
			form_valid = 0;
			jQuery( "#tip-podcast-tags", this ).css( { "display": "block" } );
		}

		if( form_valid ) {
			jQuery.ajax( { type: 'POST', url: nq_vars.ajaxpath, data: {
				action: 'k_submit_podcast',
				podcast_title: q_title,
				podcast_content: q_cont,
				podcast_content_markdown: q_cont_md,
				podcast_tags: q_tags,
				podcast_category: q_cat,
				podcastnonce: nq_vars.podcastnonce
				}, success:
				function( response ) {
					// response: 1. podcast_ID, 2. podcast_perma 3. do_redirect

					// hide the form and release submission message
					jQuery( "#podcast-add" ).fadeOut( 250, function() {
						// hide elements
						jQuery( "div.form-loader" ).css( { "display": "none" } );
						jQuery( "div.form-cover" ).css( { "display": "none" } );

						if( response.podcast_ID > 0 ) {
							// show up message
							jQuery( "div.form-message-ok" ).fadeIn( 250 );
							// do redirect?
							if( response.do_redirect === 1 ) {
								setTimeout( function() {
									window.location.href = response.podcast_perma;
								}, 3000);
							}
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