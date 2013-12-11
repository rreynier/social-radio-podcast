<?php
/************************************ Theme Shortcodes ************************************/

// shortcode: layout
function sc_layout( $atts, $content = NULL ) {
	extract( shortcode_atts( array( 'textalign' => 'left', 'cols' => 'sc-1-1', 'position' => 'first' ), $atts ) );
	$content = parse_shortcode_content( $content );
	$pos = ( $position == 'first' ) ? '' : ' sc_last_column';
	$clear_last = ( $position == 'last' ) ? '<div class="clearfix"></div>' : '';
	if( $cols == 'sc-1-1' ) {
		$pos = '';
		$clear_last = '<div class="clearfix"></div>';
	}
	return "<div class=\"sc-column sc-{$cols}{$pos}\" style=\"text-align: {$textalign};\">" . do_shortcode( $content ) . "</div>" . $clear_last;
}
add_shortcode( "layout", "sc_layout" );

// shortcode: podcasts
function sc_podcast_shortcode( $atts, $content = NULL ) {
	update_option( 'sc_podcast_atts', $atts );
	ob_start();
	get_template_part( 'js/shorties/sc', 'allpodcasts' );
	return ob_get_clean();
}
add_shortcode( "podcast", "sc_podcast_shortcode" );

// shortcodes: lists
function sc_list( $atts, $content = NULL ) {
	extract( shortcode_atts( array( 'type' => 'black-arrow' ), $atts ) );
	$content = parse_shortcode_content( $content );
	return "<div class=\"list-{$type}\">{$content}</div>";
}
add_shortcode( "list", "sc_list" );

// shortcodes: warning
function sc_warning( $atts, $content = NULL ) {
	extract( shortcode_atts( array( 'textalign' => 'left', 'type' => 'blue' ), $atts ) );
	$content = parse_shortcode_content( $content );
	return "<div class=\"alert{$type}\" style=\"text-align: {$textalign};\">{$content}</div>";
}
add_shortcode( "alert", "sc_warning" );


// shortcodes: toggler
function sc_toggler( $atts, $content = NULL ) {
	extract( shortcode_atts( array( 'title' => 'Toggle content' ), $atts ) );
	$content = parse_shortcode_content( $content );
	// generate random id
	$toggler_id = '';
	$str_leng = 8;
	$chars_in = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$real_len = strlen( $chars_in ) - 1;
	for( $iii = 0; $iii < $str_leng; $iii ++ ) { $toggler_id .= $chars_in[ mt_rand( 0, $real_len ) ]; }
	// the rest
	if( $title == '' ) $title = __( "Toggle this!", "sofa_ideal" );
	$out_code = '<div class="toggle-wrap">';
	$out_code .= '<span class="toggle-button" id="toggler' . $toggler_id . '"><span class="toggle-icon">&nbsp;</span><span class="toggle-title">' . $title . '</span></span>';
	$out_code .= '<div id="toggle-item-toggler' . $toggler_id . '" class="toggled-content">'  . do_shortcode( $content ) . '</div>';
	$out_code .= '</div>';
	return $out_code;
}
add_shortcode( "toggler", "sc_toggler" );

/* shortcodes: GoogleMaps */
function sc_gmaps( $atts, $content = NULL ) {
	extract( shortcode_atts( array( 'src' => 'https://maps.google.com/maps?q=40.716617,-74.008171&num=1&t=m&z=12' ), $atts ) );
	$map_id = '';
	$str_leng = 8;
	$chars_in = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$real_len = strlen( $chars_in ) - 1;
	for( $iii = 0; $iii < $str_leng; $iii ++ ) { $map_id .= $chars_in[ mt_rand( 0, $real_len ) ]; }
	return '<div class="gmap"><iframe id="g-map' . $map_id . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . $src . '&output=embed"></iframe></div>';
}
add_shortcode( "googlemap", "sc_gmaps" );

// shortcodes: tabber
function sc_tabber( $atts, $content = NULL ) {
	extract( shortcode_atts( array( 'textalign' => 'left' ), $atts ) );
	$content = parse_shortcode_content( $content );
	// generate random id
	$tabber_id = '';
	$str_leng = 8;
	$chars_in = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$real_len = strlen( $chars_in ) - 1;
	for( $iii = 0; $iii < $str_leng; $iii ++ ) { $tabber_id .= $chars_in[ mt_rand( 0, $real_len ) ]; }
	// the rest
	$out_code = '<div id="tabber' . $tabber_id . '" class="tab-wrap" style="text-align: ' . $textalign . '">' . do_shortcode( $content ) . '</div>';
	return $out_code;
}
add_shortcode( "tabber", "sc_tabber" );

// shortcodes: video
function sc_video( $atts, $content = NULL ) {
	extract( shortcode_atts( array(), $atts ) );
	$content = parse_shortcode_content( $content );
	// generate random id
	$video_id = '';
	$str_leng = 8;
	$chars_in = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$real_len = strlen( $chars_in ) - 1;
	for( $iii = 0; $iii < $str_leng; $iii ++ ) { $video_id .= $chars_in[ mt_rand( 0, $real_len ) ]; }
	// the rest
	$out_code = '<div id="video' . $video_id . '" class="entry-media"><div class="entry-media-video-wrap">' . do_shortcode( $content ) . '</div></div>';
	return $out_code;
}
add_shortcode( "video", "sc_video" );

// shortcode: separator
function sc_separators( $atts, $content = NULL ) {
	extract( shortcode_atts( array( 'type' => 'big', 'weight' => 'fat' ), $atts ) );
	return "<span class=\"separator-{$type}-{$weight}\"></span>";
}
add_shortcode( "separator", "sc_separators" );

// shortcode: break
function sc_break( $atts, $content = null ) {
	extract( shortcode_atts( array( 'height' => 20, 'line' => 'no' ), $atts ) );
	$inner_line = '';
	if( $line == 'yes' ) {
		$inner_line = '<span class="inner-line"></span>';
	}
	return "<span class=\"clearline\" style=\"height: {$height}px;\">{$inner_line}</span>";
}
add_shortcode( 'break', 'sc_break' );

// shortcode: buttons
function sc_button( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link' => '',
		'size' => 'medium',
		'color' => '#000000',
		'bg_color' => '#F1F1F1',
		'target' => '_self',
		'caption' => '',
		'font_weight' => 'normal',
		'align' => 'right'
    ), $atts));
	$button = '';
	$button .= '<span class="button-wrap bt-' . $size . ' text-' .  $align . ' clearfix">';
	$button .= '<a target="' . $target . '" class="button" style="color: ' . $color . ' !important; background-color: ' . $bg_color . '; font-weight: ' . $font_weight . '" href="' . $link . '">';
	$button .= '<span>' . do_shortcode( $content ) . '</span>';
	if( $caption != '' ) $button .= '<br /><span class="btn_caption">' . $caption . '</span>';
	$button .= '</a></span>';
	return $button;
}
add_shortcode( 'button', 'sc_button' );

// shorcode: quotes
function sc_quotes( $atts, $content = NULL ) {
	extract( shortcode_atts( array( 'author' => 'Quote Author' ), $atts ) );
	return '<div class="wrap-quotes"><blockquote><p>"' . do_shortcode( $content ) . '"</p></blockquote><p class="quotes-author"> &mdash; ' . $author . '</p></div>';
}
add_shortcode( "quotes", "sc_quotes" );

/* ===== TinyMCE integration ===== */
add_action( 'init', 'add_buttons' );
function add_buttons() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {

		// layout
		add_filter( 'mce_external_plugins', 'add_plugin_sclayout' );
		add_filter( 'mce_buttons_3', 'register_sclayout' );
		// podcasts
		add_filter( 'mce_external_plugins', 'add_plugin_scpodcast' );
		add_filter( 'mce_buttons_3', 'register_scpodcast' );
		// lists
		add_filter( 'mce_external_plugins', 'add_plugin_sclists' );
		add_filter( 'mce_buttons_3', 'register_sclists' );
		// warnings or alerts
		add_filter( 'mce_external_plugins', 'add_plugin_scwarnings' );
		add_filter( 'mce_buttons_3', 'register_scwarnings' );
		// toggler
		add_filter( 'mce_external_plugins', 'add_plugin_sctoggler' );
		add_filter( 'mce_buttons_3', 'register_sctoggler' );
		// google maps
		add_filter( 'mce_external_plugins', 'add_plugin_scgooglemaps' );
		add_filter( 'mce_buttons_3', 'register_scgooglemaps' );
		// tabbed content
		add_filter( 'mce_external_plugins', 'add_plugin_sctabber' );
		add_filter( 'mce_buttons_3', 'register_sctabber' );
		// video
		add_filter( 'mce_external_plugins', 'add_plugin_scvideo' );
		add_filter( 'mce_buttons_3', 'register_scvideo' );
		// separator
		add_filter( 'mce_external_plugins', 'add_plugin_scseparator' );
		add_filter( 'mce_buttons_3', 'register_scseparator' );
		// break
		add_filter( 'mce_external_plugins', 'add_plugin_scbreak' );
		add_filter( 'mce_buttons_3', 'register_scbreak' );
		// button
		add_filter( 'mce_external_plugins', 'add_plugin_scbutton' );
		add_filter( 'mce_buttons_3', 'register_scbutton' );
		// quotes
		add_filter( 'mce_external_plugins', 'add_plugin_scquotes' );
		add_filter( 'mce_buttons_3', 'register_scquotes' );

	}
}
// layout
function register_sclayout( $buttons ) {
   array_push( $buttons, "sclayout" );
   return $buttons;
}
function add_plugin_sclayout( $plugin_array ) {
   $plugin_array[ 'sclayout' ] = get_template_directory_uri() . '/js/shorties/short_layout.js';
   return $plugin_array;
}
// podcast
function register_scpodcast( $buttons ) {
   array_push( $buttons, "scpodcast" );
   return $buttons;
}
function add_plugin_scpodcast( $plugin_array ) {
   $plugin_array[ 'scpodcast' ] = get_template_directory_uri() . '/js/shorties/short_podcast.js';
   return $plugin_array;
}
// lists
function register_sclists( $buttons ) {
   array_push( $buttons, "sclists" );
   return $buttons;
}
function add_plugin_sclists( $plugin_array ) {
   $plugin_array[ 'sclists' ] = get_template_directory_uri() . '/js/shorties/short_lists.js';
   return $plugin_array;
}
// warnings or alerts
function register_scwarnings( $buttons ) {
   array_push( $buttons, "scwarnings" );
   return $buttons;
}
function add_plugin_scwarnings( $plugin_array ) {
   $plugin_array[ 'scwarnings' ] = get_template_directory_uri() . '/js/shorties/short_warnings.js';
   return $plugin_array;
}
// toggler
function register_sctoggler( $buttons ) {
   array_push( $buttons, "sctoggler" );
   return $buttons;
}
function add_plugin_sctoggler( $plugin_array ) {
   $plugin_array[ 'sctoggler' ] = get_template_directory_uri() . '/js/shorties/short_toggler.js';
   return $plugin_array;
}
// google maps
function register_scgooglemaps( $buttons ) {
   array_push( $buttons, "scgooglemaps" );
   return $buttons;
}
function add_plugin_scgooglemaps( $plugin_array ) {
   $plugin_array[ 'scgooglemaps' ] = get_template_directory_uri() . '/js/shorties/short_googlemaps.js';
   return $plugin_array;
}
// tabbed content
function register_sctabber( $buttons ) {
   array_push( $buttons, "sctabber" );
   return $buttons;
}
function add_plugin_sctabber( $plugin_array ) {
   $plugin_array[ 'sctabber' ] = get_template_directory_uri() . '/js/shorties/short_tabber.js';
   return $plugin_array;
}
// video
function register_scvideo( $buttons ) {
   array_push( $buttons, "scvideo" );
   return $buttons;
}
function add_plugin_scvideo( $plugin_array ) {
   $plugin_array[ 'scvideo' ] = get_template_directory_uri() . '/js/shorties/short_video.js';
   return $plugin_array;
}
function add_plugin_scaudio( $plugin_array ) {
   $plugin_array[ 'scaudio' ] = get_template_directory_uri() . '/js/shorties/short_audio.js';
   return $plugin_array;
}
// separator
function register_scseparator( $buttons ) {
   array_push( $buttons, "scseparator" );
   return $buttons;
}
function add_plugin_scseparator( $plugin_array ) {
   $plugin_array[ 'scseparator' ] = get_template_directory_uri() . '/js/shorties/short_separator.js';
   return $plugin_array;
}
function add_plugin_scsectionheader( $plugin_array ) {
   $plugin_array[ 'scsectionheader' ] = get_template_directory_uri() . '/js/shorties/short_sectionheader.js';
   return $plugin_array;
}
// break
function register_scbreak( $buttons ) {
   array_push( $buttons, "scbreak" );
   return $buttons;
}
function add_plugin_scbreak( $plugin_array ) {
   $plugin_array[ 'scbreak' ] = get_template_directory_uri() . '/js/shorties/short_break.js';
   return $plugin_array;
}
// button
function register_scbutton( $buttons ) {
   array_push( $buttons, "scbutton" );
   return $buttons;
}
function add_plugin_scbutton( $plugin_array ) {
   $plugin_array[ 'scbutton' ] = get_template_directory_uri() . '/js/shorties/short_button.js';
   return $plugin_array;
}
// quotes
function register_scquotes( $buttons ) {
   array_push( $buttons, "scquotes" );
   return $buttons;
}
function add_plugin_scquotes( $plugin_array ) {
   $plugin_array[ 'scquotes' ] = get_template_directory_uri() . '/js/shorties/short_quotes.js';
   return $plugin_array;
}