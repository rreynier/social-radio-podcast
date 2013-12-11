<?php
/************* INCLUDES ***************/

// options framework
if( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/' );
	require_once dirname( __FILE__ ) . '/admin/options-framework.php';
}

include( get_stylesheet_directory() . '/admin/custom_post_definitions.php' ); // custom post definitions
include( get_stylesheet_directory() . '/admin/shortcodes.php' ); // shortcodes
include( get_stylesheet_directory() . '/admin/custom_functions.php' ); // custom functions

/************* SEARCH FORM *****************/

function kazaz_wpsearch( $form = '' ) {
    $form = '<form role="search" method="get" id="qsearchform" class="form-wrapper cf"  action="' . home_url( '/' ) . '" >
	<button id="searchsubmit" name="searchsubmit" type="submit">' . __( 'SEARCH', 'kazaz' ) . '</button>
	<input type="hidden" name="post_type" value="podcast" />
    <input type="text" name="s" id="search" placeholder="' . esc_attr__( 'Search for...', 'kazaz' ) . '" value="' . get_search_query() . '" required />
    </form>';
    return $form;
}