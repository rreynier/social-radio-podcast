jQuery( document ).ready( function($) {

	// ----- Flash sorting -----
	if( jQuery.browser.msie ) {
		var frames = document.getElementsByTagName( "iframe" );
		for( var i = 0; i < frames.length; i++ ) {
			frames[ i ].src += "?wmode=opaque";
		}
	}
	// ----- End Flash sorting -----

	// ----- Scroll to top -----
	jQuery( "#go-top" ).click( function() {
		jQuery( "html, body" ).animate( { scrollTop: 0, easingType: 'easeOutQuart' }, 450 );
		return false;
	} );
	// ----- End scroll to top -----

	// ----- strip empty P (aragraphs) usually inserted via shortcode -----
	jQuery( 'p' ).each( function() {
		var $this = jQuery( this );
		if( $this.html().replace(/\s|&nbsp;/g, '').length == 0 ) $this.remove();
	} );
	jQuery( 'div.script br' ).remove();
	jQuery( 'article.podcast section.entry-content br' ).remove();
	// ----- End strip empty P (aragraphs) usually inserted via shortcode -----

	// ----- Animate .button -----
	jQuery( '.jq-hover' ).hover( function() {
		jQuery( this ).stop().animate( { 'opacity': 1 }, 100 );
	  }, function() {
		jQuery( this ).stop().animate( { 'opacity': 0.7 }, 100 );
	} );
	jQuery( '.button' ).hover( function() {
		jQuery( this ).stop().animate( { 'opacity': 0.7 }, 100 );
	  }, function() {
		jQuery( this ).stop().animate( { 'opacity': 1 }, 100 );
	} );
	// ----- End animate .button -----

	// ----- Mobile/alternative navigation -----
	jQuery( '#menu-icon' ).click( function() {
		if( jQuery( '#altermenu' ).hasClass( "menu-closed" ) ) jQuery( this ).removeClass( "menu-closed" );
		else( jQuery( '#altermenu' ).addClass( "menu-closed" ) );
		jQuery( '#altermenu' ).slideToggle( 200, 'easeInOutExpo' );
		return false;
	} );
	// ----- End Mobile/alternative navigation -----

	// ----- Hide RSS Widget icon -----
	if( jQuery( '.widget_rss .widget-title' ).length ) {
		jQuery( '.widget_rss .widget-title a:first' ).css( "display", "none" );
	};
	// ----- End Hide RSS Widget icon -----

	// ----- Submit Podcast edit form  -----
	jQuery( 'a#submit-podcast-edit-form' ).click( function() {
		jQuery( 'form#podcast-edit-form' ).submit();
	} );
	// ----- End Submit Podcast edit form -----

	// ----- Submit Answer edit form  -----
	jQuery( 'a.submit-answer-edit-form' ).click( function() {
		var id = jQuery( this ).data( 'id' );
		jQuery( 'form#answer-edit-form-' + id ).submit();
	} );
	// ----- End Submit Answer edit form -----

	// ----- Show/Hide Toggler -----
	jQuery( '[id^=toggler]' ).click( function() {
		if( jQuery( this ).hasClass( "t-opened" ) ) jQuery( this ).removeClass( "t-opened" );
		else( jQuery( this ).addClass( "t-opened" ) );
		var me = jQuery( this );
		var x = me.attr( "id" );
		var who = "#toggle-item-" + x;
		jQuery( who ).slideToggle( 200, 'easeInOutExpo' );
		return false;
	} );
	// ----- End Show/Hide Toggler -----

	var naviTimer;
	jQuery( window ).resize( function() {
		clearTimeout( naviTimer );
		naviTimer = setTimeout( handle_navi_thing, 100 );
	} );

	// ----- Tabber -----
	if( jQuery( '[id^=tabber]' ).length ) {
		jQuery( '[id^=tabber]' ).each( function() {
			var me = jQuery( this );
			var me_id = me.attr( "id" );
			// tab labels and stuff
			var tab_labels = [];
			var tab_contents = [];
			var menu_items = [];
			// split content
			var all_content = me.html();
			jQuery( all_content )
				.filter( 'h1' )
				.each( function() {
					menu_items.push( {
						title: jQuery( this ).text(),
						contents: jQuery( this ).nextUntil( 'h1' ).map( function() {
							return '<' + this.nodeName.toLowerCase() + '>' + jQuery( this ).html() + '</' + this.nodeName.toLowerCase() + '>';
						} ).get()
					} );
				} );
			// allocate data
			var pusher = '';
			var obj_len = menu_items.length;
			var iii = 0;
			if( obj_len > 0 ) {
				while( iii < obj_len ) {
					var m_o = menu_items[ iii ];
					for( var o in m_o ) {
						pusher += ( o + ": " + m_o[ o ] );
						if( o == 'title' ) tab_labels.push( m_o[ o ] );
						else if( o == 'contents' ) tab_contents.push( m_o[ o ] );
					}
					iii ++;
				}
				// tabs - buttons
				iii = 0;
				var a_class = '';
				var output_tabs = '<ul class="tabbertabs">';
				var tl_len = tab_labels.length;
				while( iii < tl_len ) {
					if( iii == 0 ) a_class = ' tabactive first-tab';
					else a_class = '';
					output_tabs += '<li class="tabbertab"><a href="javascript:;" class="tablink' + a_class + '" rel="' + me_id + '_' + iii + '">' + tab_labels[ iii ] + '</a></li>';
					iii ++;
				}
				output_tabs += '</ul>';
				// replace tab content
				iii = 0;
				var output_divs = '';
				var tc_len = tab_contents.length;
				while( iii < tc_len ) {
					var ob_to_str = tab_contents[ iii ].toString().split( '>,<' ).join( '><' );
					if( iii > 0 ) output_divs += '<div style="display: none;" class="tabberdiv" id="' + me_id + '_' + iii + '">' + ob_to_str + '</div>';
					else output_divs += '<div class="tabberdiv" id="' + me_id + '_' + iii + '">' + ob_to_str + '</div>';
					iii ++;
				}
				me.html( '' );
				me.append( output_tabs + output_divs );
				// make me visible (hidden by default in CSS)
				me.css( 'display', 'block' );
				// tab switching
				jQuery( '#' + me_id + ' ' + '.tabbertab a' ).click( function() {
					var parent_wrapper = jQuery( this ).parent().parent().parent().attr( 'id' );
					var current_rel = jQuery( this ).parent().parent().find( 'a.tabactive' ).attr( 'rel' );
					if( !jQuery( this ).is( '.tabactive' ) ) switch_tabs( jQuery( this ), parent_wrapper, current_rel );
				} );
			}
		} );
	}
	// ----- End Tabber -----

	jQuery( window ).on( 'load', function() {
		// ----- Avatar size -----
		jQuery( 'img.avatar' ).each( function() {
			var me = jQuery( this );
			var wid = me.attr( 'width' );
			var size = me.data( 'size' );
			if( size !== undefined ) me.css( { "width": size, "height": size, "visibility": "visible" } );
			else me.css( { "width": wid, "height": wid, "visibility": "visible" } );
		} );
		// ----- End Avatar size -----
	} );

	/* functions */
	// handle tabbed content switching
	function switch_tabs( obj, p_w, c_r ) {
		jQuery( '#' + c_r ).slideUp( { duration: 250, easing: 'easeInOutCubic' } );
		jQuery( '#' + obj.attr( 'rel' ) ).slideDown( { duration: 250, easing: 'easeInOutCubic' } );
		jQuery( '#' + p_w + ' .tabbertab a' ).removeClass( 'tabactive' );
		obj.addClass( 'tabactive' );
	}

	function handle_navi_thing() {
		if( jQuery( "#altermenu:not(.menu-closed)" ) ) jQuery( '#altermenu' ).css( "display", "none" ).addClass( "menu-closed" );
	}

} );