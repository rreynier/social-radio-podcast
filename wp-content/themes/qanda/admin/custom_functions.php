<?php

// theme init
if( !function_exists( 'kazaz_setup' ) ) {
	function kazaz_setup() {
		// content width
		if( !isset( $content_width ) ) $content_width = 940;
		// add editor-style.css to match the theme style
		add_editor_style();

		// post thumbnails
		add_theme_support( 'post-thumbnails' );

		// posts and comments RSS feed links
		add_theme_support( 'automatic-feed-links' );

		// available menus
		register_nav_menus( array( 'primary' => __( 'Primary Navigation', 'kazaz' ), 'secondary' => __( 'Functional Navigation', 'kazaz' ) ) );

		// localization
		load_theme_textdomain( 'kazaz', get_stylesheet_directory() . '/languages' );
		$locale = get_locale();
		$locale_file = get_stylesheet_directory() . "/languages/$locale.php";
		if( is_readable( $locale_file ) ) require_once( $locale_file );

		// remove default, it's gonna be available thru theme options!
		remove_theme_support( 'custom-header' );
		remove_theme_support( 'custom-background' );

	}

} // end theme init
add_action( 'after_setup_theme', 'kazaz_setup' );

// load theme required stylesheets
if( !function_exists( 'kazaz_registerstyles' ) ) {

	add_action( 'get_header', 'kazaz_registerstyles' );
	function kazaz_registerstyles() {
		if( !is_admin() ) {
			$theme = wp_get_theme();
			$version = $theme[ 'Version' ];
			$stylesheets = wp_enqueue_style( 'googlefonts', kazaz_header_style(), array(), NULL );
			$stylesheets .= wp_enqueue_style( 'base', get_template_directory_uri() . '/base.css', 'theme', $version, 'screen, projection' );
			$stylesheets .= wp_enqueue_style( 'skeleton', get_template_directory_uri() . '/skeleton.css', 'theme', $version, 'screen, projection' );
			$stylesheets .= wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', 'theme', $version, 'screen, projection' );
			$stylesheets .= wp_enqueue_style( 'ddsmoothmenu', get_template_directory_uri() . '/js/navigation/ddsmoothmenu.css', 'theme', $version, 'screen, projection' );
			// wmd editor
			$stylesheets .= wp_enqueue_style( 'wmd', get_template_directory_uri() . '/js/wmd_pagedown/wmd.css', 'theme', $version, 'screen, projection' );

			echo apply_filters( 'child_add_stylesheets', $stylesheets );
		}
	}

}

// load theme required javascript
if ( !function_exists( 'kazaz_header_scripts' ) ) {

	add_action( 'init', 'kazaz_header_scripts' );
	function kazaz_header_scripts() {
		if( !is_admin() ) {
			// jquery
			wp_enqueue_script( 'jquery' );
			// suggest
			wp_enqueue_script( 'suggest' );
			// modernizr
			wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/modernizr/modernizr.custom.13768.js', array( 'jquery' ), NULL, false );
			// easing
			wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/easing.js', '', NULL, true );
			// main navig
			wp_enqueue_script( 'smoothmenu', get_template_directory_uri() . '/js/navigation/ddsmoothmenu.js', '', NULL, true );
			wp_enqueue_script( 'smoothmenuinit', get_template_directory_uri() . '/js/navigation/ddsmoothmenu-init.js', '', NULL, true );
			wp_localize_script( 'smoothmenuinit', 'menu_init', array( 'down_path' => get_template_directory_uri() . '/js/navigation/down_light.png', 'right_path' => get_template_directory_uri() . '/js/navigation/right_light.png' ) );
			// theme required
			wp_enqueue_script( 'helpers', get_template_directory_uri() . '/js/helpers.js', '', NULL, true );
			//echo apply_filters( 'child_add_javascripts', $javascripts );
		}
	}

}

// load stuff after WP is loaded
function k_later_head() {
	if( !is_admin() ) {
		if( ( is_singular( 'podcast' ) || is_page_template( 'page-askpodcast.php' ) || is_page_template( 'page-editpodcast.php' ) || is_page_template( 'page-editanswer.php' ) || is_page_template( 'page-edituser.php' ) ) && is_user_logged_in() ) {
			// editor
			wp_enqueue_script( 'wmdconverter', get_template_directory_uri() . '/js/wmd_pagedown/Markdown.Converter.js', '', NULL, true );
			wp_enqueue_script( 'wmdsanitizer', get_template_directory_uri() . '/js/wmd_pagedown/Markdown.Sanitizer.js', '', NULL, true );
			wp_enqueue_script( 'wmdeditor', get_template_directory_uri() . '/js/wmd_pagedown/Markdown.Editor.js', '', NULL, true );
			// init editor
			wp_enqueue_script( 'wmdadd', get_template_directory_uri() . '/js/wmd_pagedown/wmd-add.js', '', NULL, true );
			// characters counter
			wp_enqueue_script( 'charcount', get_template_directory_uri() . '/js/count-chars.js', '', NULL, true );
			wp_localize_script( 'charcount', 'cc', array(
			'title_min' => of_get_option( 'k_podcast_chars_min' ),
			'title_max' => of_get_option( 'k_podcast_chars_max' ),
			'q_min' => of_get_option( 'k_podcast_cont_chars_min' ),
			'q_max' => of_get_option( 'k_podcast_cont_chars_max' ),
			'tag_max' => of_get_option( 'k_podcast_tags_chars_max' ),
			'a_min' => of_get_option( 'k_answer_cont_chars_min' ),
			'a_max' => of_get_option( 'k_answer_cont_chars_max' ),
			'c_min' => of_get_option( 'k_answer_comment_chars_min' ),
			'c_max' => of_get_option( 'k_answer_comment_chars_max' )
			) );

		}
		if( is_page_template( 'page-askpodcast.php' ) ) {

			// ajax stuff new podcast
			wp_enqueue_script( 'newpodcast', get_template_directory_uri() . '/js/add-podcast.js', '', NULL, true );
			wp_localize_script( 'newpodcast', 'nq_vars', array(
			'ajaxpath' => admin_url( 'admin-ajax.php' ),
			'podcastnonce' => wp_create_nonce( 'add_new_podcast' ),
			'qt_min' => of_get_option( 'k_podcast_chars_min' ),
			'qt_max' => of_get_option( 'k_podcast_chars_max' ),
			'qc_min' => of_get_option( 'k_podcast_cont_chars_min' ),
			'qc_max' => of_get_option( 'k_podcast_cont_chars_max' ),
			'qtg_max' => of_get_option( 'k_podcast_tags_chars_max' ),
			'do_tag' => of_get_option( 'enable_podcast_tags' )
			) );

			wp_enqueue_script( 'runsuggest', get_template_directory_uri() . '/js/run_suggest.js', '', NULL, true );
			wp_localize_script( 'runsuggest', 'run_suggest_vars', array( 'ajaxpath' => admin_url( 'admin-ajax.php' ) ) );

		}
		if( is_page_template( 'page-editpodcast.php' ) ) {

			// ajax stuff new podcast
			wp_enqueue_script( 'editpodcast', get_template_directory_uri() . '/js/edit-podcast.js', '', NULL, true );
			wp_localize_script( 'editpodcast', 'eq_vars', array(
			'ajaxpath' => admin_url( 'admin-ajax.php' ),
			'podcastnonce' => wp_create_nonce( 'edit_podcast' ),
			'qt_min' => of_get_option( 'k_podcast_chars_min' ),
			'qt_max' => of_get_option( 'k_podcast_chars_max' ),
			'qc_min' => of_get_option( 'k_podcast_cont_chars_min' ),
			'qc_max' => of_get_option( 'k_podcast_cont_chars_max' ),
			'qtg_max' => of_get_option( 'k_podcast_tags_chars_max' ),
			'do_tag' => of_get_option( 'enable_podcast_tags' )
			) );

			wp_enqueue_script( 'runsuggest', get_template_directory_uri() . '/js/run_suggest.js', '', NULL, true );
			wp_localize_script( 'runsuggest', 'run_suggest_vars', array( 'ajaxpath' => admin_url( 'admin-ajax.php' ) ) );

		}
		if( is_singular( 'podcast' ) ) {

			// voting and faving
			wp_enqueue_script( 'votefaves', get_template_directory_uri() . '/js/vote_faves.js', '', NULL, true );
			wp_localize_script( 'votefaves', 'votefaves_vars', array( 'ajaxpath' => admin_url( 'admin-ajax.php' ), 'votenonce' => wp_create_nonce( 'podcast_vote' ) ) );
			// new answer
			wp_enqueue_script( 'newanswer', get_template_directory_uri() . '/js/add-answer.js', '', NULL, true );
			wp_localize_script( 'newanswer', 'na_vars', array(
			'ajaxpath' => admin_url( 'admin-ajax.php' ),
			'answernonce' => wp_create_nonce( 'add_new_answer' ),
			'ac_min' => of_get_option( 'k_answer_cont_chars_min' ),
			'ac_max' => of_get_option( 'k_answer_cont_chars_max' )
			) );
			// answer reply
			wp_enqueue_script( 'commentanswer', get_template_directory_uri() . '/js/comment-answer.js', '', NULL, true );
			wp_localize_script( 'commentanswer', 'ca_vars', array(
			'ajaxpath' => admin_url( 'admin-ajax.php' ),
			'commentnonce' => wp_create_nonce( 'add_answer_comment' ),
			'ca_min' => of_get_option( 'k_answer_comment_chars_min' ),
			'ca_max' => of_get_option( 'k_answer_comment_chars_max' )
			) );
			// reports
			wp_enqueue_script( 'report', get_template_directory_uri() . '/js/flag-stuff.js', '', NULL, true );
			wp_localize_script( 'report', 'flag_vars', array(
			'ajaxpath' => admin_url( 'admin-ajax.php' ),
			'flagnonce' => wp_create_nonce( 'flag_report' )
			) );
		}
		if( is_page_template( 'page-editanswer.php' ) ) {
			// edit answer
			wp_enqueue_script( 'editanswer', get_template_directory_uri() . '/js/edit-answer.js', '', NULL, true );
			wp_localize_script( 'editanswer', 'ea_vars', array(
			'ajaxpath' => admin_url( 'admin-ajax.php' ),
			'answernonce' => wp_create_nonce( 'edit_answer' ),
			'ac_min' => of_get_option( 'k_answer_cont_chars_min' ),
			'ac_max' => of_get_option( 'k_answer_cont_chars_max' )
			) );
		}
		if( is_author() ) {
			// voting and faving
			wp_enqueue_script( 'votefaves', get_template_directory_uri() . '/js/vote_faves.js', '', NULL, true );
			wp_localize_script( 'votefaves', 'votefaves_vars', array( 'ajaxpath' => admin_url( 'admin-ajax.php' ), 'votenonce' => wp_create_nonce( 'podcast_vote' ) ) );
		}

	}
}
add_action( 'wp', 'k_later_head' );

///////////////////////////////////////////// install database tables and columns required by this theme
if( !function_exists( 'k_db_installer' ) ) {
	function k_db_installer( $oldname, $oldtheme = FALSE ) {
		// create new table for users
		global $wpdb;
		$msg = '';
		$table_name = $wpdb->prefix . 'user_activity';

		if( !$wpdb->query( "SHOW TABLES LIKE '{$wpdb->prefix}user_activity'" ) ) {
			$sql_ua = "CREATE TABLE $table_name (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
			  user_id mediumint(9) NOT NULL,
			  vote_pro_podcast text NOT NULL,
			  vote_con_podcast text NOT NULL,
			  vote_pro_answer text NOT NULL,
			  vote_con_answer text NOT NULL,
			  accepted_answers text NOT NULL,
			  faves text NOT NULL,
			  reputation mediumint(9) NOT NULL DEFAULT '0',
			  PRIMARY KEY  (id)
			);";

			$create_table_user_activity = $wpdb->query( $sql_ua );
			if( $create_table_user_activity ) $msg .= '<div class="updated"><p>Database table "' . $wpdb->prefix . 'user_activity" has been created successfully!</p></div>';
			else $msg .= '<div class="error"><p>Unfortunately database table "' . $wpdb->prefix . 'user_activity" can\'t be created. Your theme will not operate properly!.</p></div>';
		} else {
			$msg .= '<div class="updated"><p>Database table "' . $wpdb->prefix . 'user_activity" exist! Great, your theme needs it!</p></div>';
		}

		add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
	}

	add_action( "after_switch_theme", "k_db_installer", 10, 2 );
}
/* helper function to find out whether a column in our db table exist */
if( !function_exists( 'k_check_column' ) ) {
	function k_check_column( $table, $column ) {
		global $wpdb;
		$result = $wpdb->query( "SHOW COLUMNS FROM " . $table . " LIKE '" . $column . "'" );
		if( $result ) return true;
		else return false;
	}
}
////////////////////////////////////////// END install database tables and columns required by this theme

// better wp_title
if( !function_exists( 'k_wp_title' ) ) {
	function k_wp_title( $title, $sep ) {
		global $paged, $page;
		if( is_feed() ) return $title;
		$title .= get_bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		if( $site_description && ( is_home() || is_front_page() ) ) $title = "$title $sep $site_description";
		if( $paged >= 2 || $page >= 2 ) $title = "$title $sep " . sprintf( __( 'Page %s', 'kazaz' ), max( $paged, $page ) );
		return $title;
	}
	add_filter( 'wp_title', 'k_wp_title', 10, 2 );
}

// main navig
if( !function_exists( 'kazaz_navig_head' ) ) {
	function kazaz_navig_head() {
		echo '<nav id="smoothmenu" class="thirteen columns alpha" role="navigation">';
		wp_nav_menu( array( 'menu' => 'Main Menu', 'menu_id' => 'header-menu', 'container_id' => 'mainmenu', 'container_class' => 'ddsmoothmenu', 'theme_location' => 'primary' ) );
		// alternative
		//wp_nav_menu( array( 'menu' => 'Main Menu', 'menu_id' => 'alternative-menu', 'menu_class' => 'alternative-menu-class', 'container_id' => 'altermenu', 'container_class' => 'menu-closed', 'theme_location' => 'primary' ) );
		echo '<div id="altermenu" class="menu-closed"><ul id="alternative-menu">';
		wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '', 'container_id' => '', 'items_wrap' => '%3$s' ) );
		wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => '', 'container_id' => '', 'items_wrap' => '%3$s' ) );
		echo '</ul></div>';
		echo '</nav>';
	}
}
// functional navig
if( !function_exists( 'kazaz_navig_functional' ) ) {
	function kazaz_navig_functional() {
		echo '<nav id="functional-menu" class="ten columns alpha omega" role="navigation">';
		wp_nav_menu( array( 'menu' => 'Functional Menu', 'menu_id' => 'f-menu', 'container_id' => 'fmenu', 'theme_location' => 'secondary' ) );
		echo '</nav>';
	}
}

// alternative menu
if( !function_exists( 'k_menu_alternative' ) ) {
	function k_menu_alternative( $args = array() ) {
		extract( $args );
		$menu_code_block = '';
		//$menu_name = 'primary';
		$display = 'select';
		$menu_1 = 'primary';
		$menu_2 = 'secondary';
		if( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_1 ] ) && isset( $locations[ $menu_2 ] ) ) {
			$menu_p = wp_get_nav_menu_object( $locations[ $menu_1 ] );
			$menu_s = wp_get_nav_menu_object( $locations[ $menu_2 ] );
			$menu_items_p = wp_get_nav_menu_items( $menu_p->term_id );
			$menu_items_s = wp_get_nav_menu_items( $menu_s->term_id );
			$menu = array_merge( $menu_items_p, $menu_items_s );
			$menu_code_block = '<select id="navig-alternative" name="navig-alternative">';
			$menu_code_block .= '<option value="" selected="selected">' . __( "Select...", "kazaz" ) . '</option>';
			foreach( $menu as $key => $menu_item ) {
				$title = $menu_item->title;
				$url = $menu_item->url;
				if( $menu_item->menu_item_parent ) $title = ' - ' . $title;
				$menu_code_block .= '<option value="' . $url . '">' . $title . '</option>';
			}
			$menu_code_block .= '</select>';
		}
		return $menu_code_block;
	}
}

// call dynamic CSS
add_filter( 'query_vars', 'kazaz_add_dynamic_css' );
function kazaz_add_dynamic_css( $css_query_vars ) {
    $css_query_vars[] = 'dynamic_css';
    return $css_query_vars;
}

add_action( 'template_redirect', 'kazaz_css_display' );
function kazaz_css_display() {
    $css = get_query_var( 'dynamic_css' );
    if( $css == 'css' ) {
        include_once( get_template_directory() . '/style.php' );
        exit;
    }
}

// google fonts
if ( !function_exists( 'kazaz_header_style' ) ) {

	function kazaz_header_style() {
		// handle font selection
		$to_parse = '';
		$title_font = of_get_option( 'k_title_font' );
		$content_font = of_get_option( 'k_content_font' );
		if( $title_font == 'default' && $content_font == 'default' ) return;
		elseif( $title_font == 'default' && $content_font != 'default' ) $to_parse = "http://fonts.googleapis.com/css?family=$content_font";
		elseif( $title_font != 'default' && $content_font == 'default' ) $to_parse = "http://fonts.googleapis.com/css?family=$title_font";
		elseif( $title_font != 'default' && $content_font != 'default' ) {
			if( $title_font != $content_font ) $to_parse = "http://fonts.googleapis.com/css?family=$content_font|$title_font";
			else $to_parse = "http://fonts.googleapis.com/css?family=$title_font";
		}

		return $to_parse;

	}

}
if ( !function_exists( 'font_parser' ) ) {

	function font_parser( $my_font = '' ) {
		// handle font selection
		if( $my_font == 'default' ) {
			return '"Helvetica Neue", Helvetica, Arial, sans-serif';
		} else {
			$google_fonts = $my_font;
			$font_str = $google_fonts;
			$font_str_arr = explode( ':', $font_str );
			$font_name = $font_str_arr[ 0 ];
			$clean_font_arr = explode( '+', $font_name );
			$clean_font_name = implode( ' ', $clean_font_arr );
			return $clean_font_name;
		}
	}

}

/* PAGINATION */
if( !function_exists( 'k_get_pagenum_link' ) ) :
function k_get_pagenum_link($pagenum = 1, $escape = true ) {
	global $wp_rewrite;

	$pagenum = (int) $pagenum;
	$request = remove_query_arg( 'paged' );
	$home_root = parse_url( home_url() );
	$home_root = ( isset( $home_root[ 'path' ] ) ) ? $home_root[ 'path' ] : '';
	$home_root = preg_quote( $home_root, '|' );

	$request = preg_replace( '|^'. $home_root . '|i', '', $request );
	$request = preg_replace( '|^/+|', '', $request );

	// behave as if there are no pretty permalinks
	$base = trailingslashit( get_bloginfo( 'url' ) );
	if( $pagenum > 1 ) $result = add_query_arg( 'paged', $pagenum, $base . $request );
	else $result = $base . $request;
	// end
	$result = apply_filters( 'k_get_pagenum_link', $result );

	if( $escape ) return esc_url( $result );
	else return esc_url_raw( $result );
}
endif;
if( !function_exists( 'kazaz_pagination' ) ) :
	function kazaz_pagination() {
		$output = '';
		global $wp_query;
		global $wp_rewrite;

		if( function_exists( 'wp_pagenavi' ) ) wp_pagenavi();
		else {
			if( $wp_query->max_num_pages > 1 ) {
				$big = 999999999;
				$base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
				if( $wp_rewrite->using_permalinks() && get_option( 'is_fp' ) ) $base = str_replace( $big, '%#%', esc_url( k_get_pagenum_link( $big ) ) );
				$output .= '<div class="pagination clearfix">';
				$output .= paginate_links( array(
					'base' => $base,
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var( 'paged' ) ),
					'total' => $wp_query->max_num_pages,
					'prev_text' => __( "&larr; Previous", "kazaz" ),
					'next_text' => __( "Next &rarr;", "kazaz" ),
					'add_args' => array()
				) );
				$output .= '</div>';
			}
			return $output;
		} // end else; if wp_pagenavi doesn't exist
	}
endif;

// pagination for pages
if( !function_exists( 'kazaz_pagination_page' ) ) :
	function kazaz_pagination_page() {
		$output = '';
		global $wp_query;
		$output .= wp_link_pages( array(
			'before'           => '<div class="pagination clearfix">' . __( "<span class=\"page-numbers no-left-padding\">Pages: </span>", "kazaz" ),
			'after'            => '</div>',
			'link_before'      => '<span class="page-numbers">',
			'link_after'       => '</span>',
			'next_or_number'   => 'number',
			'nextpagelink'     => __( "Next &rarr;", "kazaz" ),
			'previouspagelink' => __( "&larr; Previous", "kazaz" ),
			'pagelink'         => '%',
			'echo'             => 0 ) );
		return $output;
	}
endif;

// not found
if( !function_exists( 'kazaz_not_found' ) ) :
	function kazaz_not_found() {
		$output = '';
		$output .= '<h1>' . __("Nothing Found!", "kazaz") . '</h1>';
		if( is_search() ) $output .= '<p>' . __("Sorry, nothing found for the requested search term.", "kazaz") . '</p>';
		else $output .= '<p>' . __("Sorry, no results were found for the requested page.", "kazaz") . '</p>';
		return $output;
	}
endif;

// search: search podcasts redirect to another template
if( !function_exists( 'k_search_podcast_redir' ) ) :
	function k_search_podcast_redir( $template ) {
		global $wp_query;
		$post_type = get_query_var( 'post_type' );
		if( $wp_query->is_search && $post_type == 'podcast' ) {
			return locate_template( 'search-podcast.php' );
		}
		return $template;
	}
endif;
add_filter( 'template_include', 'k_search_podcast_redir' );

// search: search blog only
if( !function_exists( 'kazaz_search' ) ) :
	function kazaz_search( $query ) {
		$post_type = get_query_var( 'post_type' );
		if( $query->is_search && $post_type != 'podcast' ) $query->set( 'post_type', 'post' );
		return $query;
	}
endif;
add_filter( 'pre_get_posts', 'kazaz_search' );

// comments
if( !function_exists( 'kazaz_comment' ) ) :
	function kazaz_comment( $comment, $args, $depth ) {

		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 40, get_user_meta( $comment->user_id, 'avatar_url', true ) ); ?>
				<?php printf( __( '%s <span class="says">says:</span>', 'kazaz' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( "Your comment is awaiting moderation.", "kazaz" ); ?></em>
			<?php endif; ?>

			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					printf( __( '%1$s at %2$s', 'kazaz' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( "(Edit)", "kazaz" ), ' ' );
				?>
			</div><!-- .comment-meta .commentmetadata -->

			<div class="comment-body"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</div><!-- #comment-##  -->

		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( "Pingback:", "kazaz" ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( "(Edit)", "kazaz" ), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
endif;

//////////////////////////////////////////////////// DIFFERENT COMMENTS FOR PODCAST POST TYPE \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
if( !function_exists( 'k_podcast_comment' ) ) :
	function k_podcast_comment( $comment, $args, $depth ) {

		global $post;
		global $current_user;
		get_currentuserinfo();
		$GLOBALS[ 'comment' ] = $comment;

		$comment_class = ( $comment->comment_parent == 0 ) ? 'podcast-comment' : 'podcast-comment-child';
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class( $comment_class ); ?> id="li-comment-<?php comment_ID(); ?>">

        	<div class="answer-wrap">

            	<?php
				// different styling for top level and child comments
				if( $comment->comment_parent == 0 ) {
				?>

                <div class="answer-meta two columns alpha am-<?php comment_ID(); ?>">

                    <div class="meta-pro">
                        <?php if( is_user_logged_in() ) { ?>
                            <a href="javascript:void(0);" class="vote-pro jq-hover a-vote" data-action="pro" data-id="<?php comment_ID(); ?>" data-author="<?php echo $comment->user_id; ?>" title="<?php _e( "This Comment is useful, vote PRO for it!", "kazaz" ); ?>"></a>
                        <?php } else { ?>
                            <a href="javascript:void(0);" class="vote-pro q-alien" title="<?php _e( "You are not allowed to vote, sign in first!", "kazaz" ); ?>"></a>
                        <?php } ?>
                    </div>

                    <div class="meta-votes-answer" id="votes-answer-<?php comment_ID(); ?>" title="<?php _e( "Number of Votes", "kazaz" ); ?>">
                        <?php
                        $votes = get_comment_meta( $comment->comment_ID, 'votes', true );
                        if( $votes != '' ) {
                            if( (int)$votes > 1000 ) {
                                $votes = round( ( (int)$votes / 1000 ), 1 );
                                echo $votes . 'k';
                            } else echo $votes;
                        } else echo '0';
                        ?>
                    </div>

                    <div class="meta-con">
                        <?php if( is_user_logged_in() ) { ?>
                            <a href="javascript:void(0);" class="vote-con jq-hover a-vote" data-action="con" data-id="<?php comment_ID(); ?>" data-author="<?php echo $comment->user_id; ?>" title="<?php _e( "This Podcast is not useful or is unclear, vote CON for it!", "kazaz" ); ?>"></a>
                        <?php } else { ?>
                            <a href="javascript:void(0);" class="vote-con q-alien" title="<?php _e( "You are not allowed to vote, sign in first!", "kazaz" ); ?>"></a>
                        <?php } ?>
                    </div>

                    <div class="meta-accept">
                        <?php if( (int)get_the_author_meta( 'ID' ) === (int)$current_user->ID && get_post_meta( $post->ID, 'status', TRUE ) == 'open' ) { ?>
                            <!-- <a href="javascript:void(0);" class="jq-hover q-accept" data-id="<?php comment_ID(); ?>" data-qid="<?php echo $post->ID; ?>" data-author="<?php echo $comment->user_id; ?>" title="<?php _e( "Accept this Comment!", "kazaz" ); ?>"></a> -->
                        <?php
						} else {
							if( get_comment_meta( get_comment_ID(), 'status', TRUE ) == 'accepted' && get_the_author_meta( 'ID' ) !== $current_user->ID ) {
						?>
                        	<a href="javascript:void(0);" class="q-alien q-accepted" title="<?php _e( "Podcast author has accepted this Comment as the most reliable one.", "kazaz" ); ?>"></a>
                        <?php
							} elseif( get_comment_meta( get_comment_ID(), 'status', TRUE ) == 'accepted' && (int)get_the_author_meta( 'ID' ) === (int)$current_user->ID ) {
						?>
                        	<a href="javascript:void(0);" class="jq-hover q-accepted q-reject" data-id="<?php comment_ID(); ?>" data-qid="<?php echo $post->ID; ?>" data-author="<?php echo $comment->user_id; ?>" title="<?php _e( "Reject this Comment!", "kazaz" ); ?>"></a>
                        <?php
							}
						}
						?>
                    </div>

                </div>

                <div id="comment-<?php comment_ID(); ?>" class="answer-main ten columns omega">

                    <div class="comment-body clearfix">
                    	<?php comment_text(); ?>
                    </div>

                    <div class="comment-author vcard">
                        <?php echo get_avatar( $comment->user_id, 40, get_user_meta( $comment->user_id, 'avatar_url', true ) ); ?>
                    </div><!-- .comment-author .vcard -->

                    <div class="comment-meta commentmetadata">
                        <?php
                        printf(
                        __( 'answered: %1$s by <a href="%3$s" title="%2$s">%2$s</a> [ <span class="rep-score" title="%5$s">%4$s</span> ]', 'kazaz' ),
                        get_comment_date(),
						$comment->comment_author,
                        get_author_posts_url( $comment->user_id ),
                        k_get_user_reputation_score( $comment->user_id ),
                        __( "User reputation score", "kazaz" )
                        );
                        echo '<div class="edit-answer-link eal-' . get_comment_ID() . '">';
						// user can edit the answer only if author
						if( is_user_logged_in() && ( (int)$comment->user_id === (int)$current_user->ID ) || current_user_can( 'administrator' ) ) {
							$edit_page_id = (int)of_get_option( 'k_answer_edit_page' );
							$edit_podcast_perma = get_permalink( $edit_page_id );
							// echo '<form id="answer-edit-form-' . get_comment_ID() . '" class="mini-form" method="post" action="' . $edit_podcast_perma . '">';
							// wp_nonce_field( 'edit_answer_form', 'edit_answer_form_submitted-' . get_comment_ID() );
							// echo '<input type="hidden" id="qid-' . get_comment_ID() . '" name="qid" value="' . $post->ID . '" />';
							// echo '<input type="hidden" id="aid-' . get_comment_ID() . '" name="aid" value="' . get_comment_ID() . '" />';
							// echo '<input type="hidden" id="aaid-' . get_comment_ID() . '" name="aaid" value="' . $comment->user_id . '" />';
							// echo '</form>';
       //        echo '<div class="wrap-a-butt saef-' . get_comment_ID() . '"><a href="javascript:void(0);" class="submit-answer-edit-form" data-id="' . get_comment_ID() . '" rel="nofollow">' . __( "Edit Comment", "kazaz" ) . '</a></div>';
						}
						if( is_user_logged_in() ) {
							echo '<div class="wrap-a-butt aac-' . get_comment_ID() . '"><a href="javascript:void(0);" class="add-answer-comment" data-id="' . get_comment_ID() . '" rel="nofollow">' . __( "Add Comment", "kazaz" ) . '</a></div>';
						}
						if( is_user_logged_in() && ( (int)$comment->user_id !== (int)$current_user->ID ) || current_user_can( 'administrator' ) ) {
							echo '<div class="wrap-a-butt kfa-' . get_comment_ID() . '"><a href="javascript:void(0);" class="k-flag-answer" data-type="answer" data-id="' . get_comment_ID() . '" data-author="' . $comment->user_id . '" data-postid="' . $post->ID . '" rel="nofollow" title="' . __( "Report this Comment as inappropriate or offensive!", "kazaz" ) . '">' . __( "Report", "kazaz" ) . '</a></div>';
						}
                        echo '&nbsp;</div>';
                        ?>
                    </div><!-- .comment-meta .commentmetadata -->

                    <div id="ac-form-<?php comment_ID(); ?>"><!-- answer comment form -->
                    <div class="answer-comment-wrapper clearfix">
                    	<form id="answer-comment-form-<?php comment_ID(); ?>" class="answer-comment-form" data-id="<?php comment_ID(); ?>" data-qid="<?php echo $post->ID; ?>" method="post" action="javascript:void(0);">
                            <span class="form-tip">
							<?php _e( "TIP: Use Markdown to format text!", "kazaz" ); ?>
                            <a href="http://five.squarespace.com/display/ShowHelp?section=Markdown" rel="nofollow" title="Markdown syntax" target="_blank"><?php _e( "Need help?", "kazaz" ); ?></a>
                            </span>
                        	<label for="answer-comment-form-text-<?php comment_ID(); ?>" class="answer-comment-form-label"><?php _e( "Your comment:", "kazaz" ); ?> (<span id="count-ac-<?php comment_ID(); ?>"><?php echo of_get_option( 'k_answer_comment_chars_max' ); ?></span>)</label>
                            <textarea class="answer-comment-textarea" id="answer-comment-form-text-<?php comment_ID(); ?>" name="answer-comment-form-text-<?php comment_ID(); ?>"></textarea>
                            <span class="form-tip">
							<?php printf( __( 'Min %1$s and max %2$s characters allowed!', 'kazaz' ), of_get_option( 'k_answer_comment_chars_min' ), of_get_option( 'k_answer_comment_chars_max' ) ); ?>
                            </span>
                            <span id="tip-comment-<?php comment_ID(); ?>" class="form-tip tip-error"><?php printf( __( 'ERROR: Comment should be at least %1$s and max %2$s characters long!', 'kazaz' ), of_get_option( 'k_answer_comment_chars_min' ), of_get_option( 'k_answer_comment_chars_max' ) ); ?></span>
                            <input type="submit" id="answer-comment-submit-<?php comment_ID(); ?>" class="button answer-comment-button" name="answer-comment-submit-<?php comment_ID(); ?>" value="<?php _e( "Comment", "kazaz" ); ?>">
                            <div class="hackett"><?php _e( "Processing...", "kazaz" ); ?></div>
                        </form>
                    </div>
                    </div><!-- end answer comment form -->

            </div>

            <?php
			} else {
			// we are dealing with child comments
			?>
            <div id="comment-<?php comment_ID(); ?>" class="answer-child offset-by-two ten columns alpha omega">
                <div class="comment-body clearfix">
                	<span class="meta-child-comment">
                	<?php
					printf(
					__( '%1$s, by <a href="%3$s" title="%2$s">%2$s</a>', 'kazaz' ),
					get_comment_date(),
					$comment->comment_author,
					get_author_posts_url( $comment->user_id )
					);
					?>
                    </span>
					<?php comment_text(); ?>

                    <?php
					if( is_user_logged_in() ) {
						echo '<div class="ac-wrap-delete-flag">';
						if( is_user_logged_in() && ( (int)$comment->user_id === (int)$current_user->ID ) || current_user_can( 'administrator' ) ) {
							echo '<div class="answer-comment-delete acd-' . get_comment_ID() . '">';
                        	echo '<a href="javascript:void(0);" class="k-delete-comment" data-id="' . get_comment_ID() . '" data-author="' . $comment->user_id . '" rel="nofollow">' . __( "Delete?", "kazaz" ) . '</a>';
							echo '</div>';
						}

						if( is_user_logged_in() && ( (int)$comment->user_id !== (int)$current_user->ID ) || current_user_can( 'administrator' ) ) {
							echo '<div class="answer-comment-flag kfa-' . get_comment_ID() . '">';
                        	echo '<a href="javascript:void(0);" class="k-flag-comment" data-type="comment" data-id="' . get_comment_ID() . '" data-author="' . $comment->user_id . '" data-postid="' . $post->ID . '" rel="nofollow" title="' . __( "Report this Comment as inappropriate or offensive!", "kazaz" ) . '">' . __( "Report", "kazaz" ) . '</a>';
							echo '</div>';
						}
						echo '</div>';
					}
					?>

                </div>
            </div>
            <?php } ?>

		</div><!-- answer wrap end  -->

		<?php
			break;
			case 'pingback'  :
			break;
			case 'trackback' :
			break;
		endswitch;
	}
endif;

// insert new answer via AJAX
if( !function_exists( 'k_ajax_add_new_answer' ) ) :
	function k_ajax_add_new_answer() {

		global $current_user;
		get_currentuserinfo();

		$podcast_id = (int)$_POST[ 'q_id' ];
		$answer_content = trim( $_POST[ 'answer_content' ] );
		$answer_content_markdown = trim( $_POST[ 'answer_content_markdown' ] );
		$answer_nonce = $_POST[ 'answernonce' ];
		if( !wp_verify_nonce( $answer_nonce, 'add_new_answer' ) ) die ( __( 'You are not allowed to perform such action!', 'kazaz' ) );

		$answer_data = array(
			'comment_post_ID' => $podcast_id,
			'comment_author' => $current_user->user_login,
			'comment_author_email' => $current_user->user_email,
			'comment_author_url' => '',
			'comment_content' => $answer_content,
			'comment_karma' => 29,
			'comment_parent' => 0,
			'user_id' => $current_user->ID,
			'comment_author_IP' => $_SERVER[ 'SERVER_ADDR' ],
			'comment_agent' => $_SERVER[ 'HTTP_USER_AGENT' ],
			'comment_date' => current_time( 'mysql' ),
			'comment_approved' => '1'
		);

		$new_answer = wp_insert_comment( $answer_data );
		if( $new_answer ) {
			// insert comment meta: a) comment markdown b) comment votes num
			add_comment_meta( $new_answer, 'markdown_text', $answer_content_markdown );
			add_comment_meta( $new_answer, 'votes', 0 );
			// notify Podcast author
			k_wp_notify_postauthor( $new_answer, 'comment' );
		}

		$response = json_encode(
			array(
			'success' => true,
			'answer_ID' => $new_answer,
			'answer_perma' => get_permalink( $podcast_id )
			)
		);

		header( "Content-Type: application/json" );
		echo $response;
		exit;

	}
endif;
add_action( 'wp_ajax_nopriv_k_ajax_add_new_answer', 'k_ajax_add_new_answer' );
add_action( 'wp_ajax_k_ajax_add_new_answer', 'k_ajax_add_new_answer' );

// answer comment
if( !function_exists( 'k_add_answer_comment' ) ) :
	function k_add_answer_comment() {

		global $current_user;
		get_currentuserinfo();

		$podcast_id = (int)$_POST[ 'q_id' ];
		$answer_id = (int)$_POST[ 'answer_id' ];
		$answer_content = trim( $_POST[ 'answer_content' ] ); // markdown
		$answer_content_html = trim( $_POST[ 'answer_content_html' ] ); // html
		$comment_nonce = $_POST[ 'commentnonce' ];
		if( !wp_verify_nonce( $comment_nonce, 'add_answer_comment' ) ) die ( __( 'You are not allowed to perform such action!', 'kazaz' ) );

		$answer_data = array(
			'comment_post_ID' => $podcast_id,
			'comment_author' => $current_user->user_login,
			'comment_author_email' => $current_user->user_email,
			'comment_author_url' => '',
			'comment_content' => $answer_content_html,
			'comment_type' => '',
			'comment_parent' => $answer_id,
			'comment_karma' => 29,
			'user_id' => $current_user->ID,
			'comment_author_IP' => $_SERVER[ 'SERVER_ADDR' ],
			'comment_agent' => $_SERVER[ 'HTTP_USER_AGENT' ],
			'comment_date' => current_time( 'mysql' ),
			'comment_approved' => '1'
		);

		$new_answer = wp_insert_comment( $answer_data );
		if( $new_answer ) {
			// insert comment meta: a) comment markdown b) comment votes num
			add_comment_meta( $new_answer, 'markdown_text', $answer_content );
			add_comment_meta( $new_answer, 'votes', 0 );
		}

		$response = json_encode(
			array(
			'success' => true,
			'answer_ID' => $new_answer,
			'answer_perma' => get_permalink( $podcast_id )
			)
		);

		header( "Content-Type: application/json" );
		echo $response;
		exit;

	}
endif;
add_action( 'wp_ajax_nopriv_k_add_answer_comment', 'k_add_answer_comment' );
add_action( 'wp_ajax_k_add_answer_comment', 'k_add_answer_comment' );

// update comment via AJAX
if( !function_exists( 'k_ajax_update_answer' ) ) :
	function k_ajax_update_answer() {

		$podcast_id = (int)$_POST[ 'q_id' ];
		$answer_id = (int)$_POST[ 'a_id' ];
		$answer_content = trim( $_POST[ 'answer_content' ] );
		$answer_content_markdown = trim( $_POST[ 'answer_content_markdown' ] );
		$answer_nonce = $_POST[ 'answernonce' ];
		if( !wp_verify_nonce( $answer_nonce, 'edit_answer' ) ) die ( __( 'You are not allowed to perform such action!', 'kazaz' ) );

		// check if comment content is changed, if not wp_update_comment() will return 0
		$answer_old = get_comment( $answer_id );
		$is_equal = strcmp( $answer_content, $answer_old->comment_content );

		if( $is_equal != 0 ) {
			$answer_data = array(
				'comment_content' => $answer_content,
				'comment_ID' => $answer_id
			);

			$update_answer = wp_update_comment( $answer_data );
			if( $update_answer ) { // according to wp codex it should return 1 or 0
				update_comment_meta( $answer_id, 'markdown_text', $answer_content_markdown );
			}
		} else $update_answer = $answer_id;

		$response = json_encode(
			array(
			'success' => true,
			'answer_ID' => $update_answer,
			'answer_perma' => get_permalink( $podcast_id )
			)
		);

		header( "Content-Type: application/json" );
		echo $response;
		exit;

	}
endif;
add_action( 'wp_ajax_nopriv_k_ajax_update_answer', 'k_ajax_update_answer' );
add_action( 'wp_ajax_k_ajax_update_answer', 'k_ajax_update_answer' );

////////////////////////////////////////////////// END DIFFERENT COMMENTS FOR PODCAST POST TYPE \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

// related podcasts
if( !function_exists( 'k_related_podcasts' ) ) :
	function k_related_podcasts( $num_related = 10 ) {
		global $post;
		$cnt = 0;
		$out = '';
		$current_entry_id = $post->ID;
		$argz = array( 'posts_per_page' => $num_related );
		$related_entries = k_get_posts_related_by_taxonomy( $current_entry_id, 'podcast_tags', $argz ); // we need match in tags

		if( $related_entries->have_posts() ) :
			$out .= '<ul class="related-podcasts">';
		while( $related_entries->have_posts() ): $related_entries->the_post();
			$out .= '<li>';
			$out .= '<a href="' . get_permalink() . '" rel="bookmark" title="' . get_the_title() . '">' . get_the_title() . '</a>';
			$out .= '</li>';
			$cnt ++;
		endwhile;
			$out .= '</ul>';
		else :
			$out .= '<p>' . __( "No related Podcasts found.", "kazaz" ) . '</p>';
		endif;
		wp_reset_query();

		return $out;

	}
endif;

if( !function_exists( 'k_get_posts_related_by_taxonomy' ) ) :
	function k_get_posts_related_by_taxonomy( $post_id, $taxonomy, $args = array() ) {
		$q_query = new WP_Query();
		$terms = wp_get_object_terms( $post_id, $taxonomy );
		$term_ids = wp_list_pluck( $terms, 'term_id' );
		if( count( $terms ) ) {
			$q_post = get_post( $post_id );
			$args = wp_parse_args( $args, array(
				'ignore_sticky_posts' => 1,
				'post_type' => $q_post->post_type,
				'post__not_in' => array( $post_id ),
				'post_status' => 'publish',
				'tax_query' => array( array( 'taxonomy' => $taxonomy, 'field' => 'id', 'terms' => $term_ids, 'operator'=> 'IN' ) )
			) );
			$q_query = new WP_Query( $args );

		}
		return $q_query;
	}
endif;

// time elapsed since
if( !function_exists( 'k_time2string' ) ) :
	function k_time2string() {
		global $post;
		$gmt_timestamp = get_post_time( 'c', $post->ID );
		$timeline = time() - strtotime( $gmt_timestamp );
		$the_day   = __( "day", "kazaz" );
		$the_days  = __( "days", "kazaz" );
		$the_hour  = __( "hr", "kazaz" );
		$the_hours = __( "hrs", "kazaz" );
		$the_min   = __( "min", "kazaz" );
		$the_mins  = __( "mins", "kazaz" );

		$arr_plurals = array( $the_days, $the_hours, $the_mins );
		$periods = array( $the_day => 86400, $the_hour => 3600, $the_min => 60 );
		$loop_cntr = 0;

		$ret  = '';
		foreach( $periods as $name => $seconds ) {
			$num = floor( $timeline / $seconds );
			if( $num > 0 ) {
				$timeline -= ( $num * $seconds );
				//$ret .= $num . ' ' . $name . ( ( $num > 1 ) ? 's' : '' ) . ' ';
				$ret .= $num . ' ' . ( ( $num > 1 ) ? $arr_plurals[ $loop_cntr ] : $name ) . ' ';
			}
			$loop_cntr ++;
		}

		if( trim( $ret ) == '' ) $ret = __( "Few seconds", "kazaz" ) . ' ';

		printf(
		__( 'posted: <span class="elapsed">%1$s</span> ago by <a href="%2$s" title="%3$s">%3$s</a> [ <span class="rep-score" title="%6$s">%5$s</span> ] in %4$s', 'kazaz' ),
		$ret,
		esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ),
		get_the_author(),
		get_the_term_list( get_the_ID(), 'podcast_category', '', ', ', '' ),
		k_get_user_reputation_score( get_the_author_meta( "ID" ) ),
		__( "User reputation score", "kazaz" )
		);
	}
endif;

/* Truncate HTML, close opened tags
*
* @param int, maxlength of the string
* @param string, html
* @return $html
*/
function k_html_truncate( $maxLength, $html ) {

	mb_internal_encoding("UTF-8");

	$printedLength = 0;
	$position = 0;
	$tags = array();

	ob_start();

	while ($printedLength < $maxLength && preg_match('{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}', $html, $match, PREG_OFFSET_CAPTURE, $position)){

		list($tag, $tagPosition) = $match[0];

		// Print text leading up to the tag.
		$str = mb_strcut($html, $position, $tagPosition - $position);

		if ($printedLength + mb_strlen($str) > $maxLength){
			print(mb_strcut($str, 0, $maxLength - $printedLength));
			$printedLength = $maxLength;
			break;
		}

		print($str);
		$printedLength += mb_strlen($str);

		if ($tag[0] == '&'){
			// Handle the entity.
			print($tag);
			$printedLength++;
		}
		else{
			// Handle the tag.
			$tagName = $match[1][0];
			if ($tag[1] == '/'){
				// This is a closing tag.

				$openingTag = array_pop($tags);
				assert($openingTag == $tagName); // check that tags are properly nested.

				print($tag);
			}
			else if ($tag[mb_strlen($tag) - 2] == '/'){
				// Self-closing tag.
				print($tag);
			}
			else{
				// Opening tag.
				print($tag);
				$tags[] = $tagName;
			}
		}

		// Continue after the tag.
		$position = $tagPosition + mb_strlen($tag);
	}

	// Print any remaining text.
	if ($printedLength < $maxLength && $position < mb_strlen($html)) print(mb_strcut($html, $position, $maxLength - $printedLength));

	// Close any open tags.
	while (!empty($tags)) printf('</%s>', array_pop($tags));

	$bufferOuput = ob_get_contents();

	ob_end_clean();

	$html = $bufferOuput;

	return $html;

}

// make drop-down list of existing Podcast categories
if( !function_exists( 'k_categories_dropdown' ) ) :
	function k_categories_dropdown( $taxonomy, $selected ) {
		return wp_dropdown_categories( array( 'taxonomy' => $taxonomy, 'name' => 'podcast-category', 'selected' => $selected, 'hide_empty' => 0, 'echo' => 0 ) );
	}
endif;

// modify tinyMCE a little bit...
if( !function_exists( 'k_change_mce_buttons' ) ) :
	function k_change_mce_buttons( $initArray ) {
		if( !is_admin() ) {
			$ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';
			if ( isset( $initArray['extended_valid_elements'] ) ) $initArray['extended_valid_elements'] .= ',' . $ext;
			else $initArray['extended_valid_elements'] = $ext;
			$initArray['theme_advanced_blockformats'] = 'h2,h3,h4,p,pre';
			$initArray['theme_advanced_disable'] = 'forecolor';
		}
		return $initArray;
	}
endif;
add_filter( 'tiny_mce_before_init', 'k_change_mce_buttons' );

// update podcast views
if( !function_exists( 'k_update_podcast_views' ) ) :
	function k_update_podcast_views( $qid ) {
		if( !isset( $_COOKIE[ 'k_usr_q_' . $qid ] ) ) {
			$c_expire = time() + 60 * 60 * 24 * 7; // 7 days
			setcookie( ( 'k_usr_q_' . $qid ), $qid, $c_expire );
			// update post meta views
			$curr_views = (int)get_post_meta( $qid, 'views', true );
			$new_views = $curr_views + 1;
			update_post_meta( $qid, 'views', $new_views );
		}
	}
endif;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// submit new podcast
if( !function_exists( 'k_submit_podcast' ) ) :
	function k_submit_podcast() {
		global $current_user;
		get_currentuserinfo();

		$podcast_title = sanitize_text_field( $_POST[ 'podcast_title' ] );
		$podcast_content = wp_kses_post( $_POST[ 'podcast_content' ] );
		$podcast_content_markdown = wp_kses_post( $_POST[ 'podcast_content_markdown' ] );
		$podcast_tags = sanitize_text_field( $_POST[ 'podcast_tags' ] );
		$podcast_category = (int)$_POST[ 'podcast_category' ];
		$podcast_nonce = $_POST[ 'podcastnonce' ];
		if( !wp_verify_nonce( $podcast_nonce, 'add_new_podcast' ) ) die ( __( 'You are not allowed to perform such action!', 'kazaz' ) );

		$podcast_pub_status = ( of_get_option( 'autopublish_podcast' ) ) ? 'publish' : 'draft';
		$entry_data = array(
			'post_title' => $podcast_title,
			'post_content' => $podcast_content,
			'post_status' => $podcast_pub_status,
			'post_author' => $current_user->ID,
			'post_type' => 'podcast'
		);

		$do_redirect = 0;
		if( of_get_option( 'autopublish_podcast' ) ) $do_redirect = 1;
		$new_entry_ID = wp_insert_post( $entry_data );
		if( $new_entry_ID ) {
			wp_set_object_terms( $new_entry_ID, $podcast_category, 'podcast_category' ); // taxonomy
			if( isset( $podcast_tags ) ) wp_set_post_terms( $new_entry_ID, trim( $podcast_tags ), 'podcast_tags', true ); // post tags
			add_post_meta( $new_entry_ID, 'markdown_text', $podcast_content_markdown, true ); // markdown version
			add_post_meta( $new_entry_ID, 'views', 0, true );
			add_post_meta( $new_entry_ID, 'status', 'open', true );
			add_post_meta( $new_entry_ID, 'votes', 0, true );
			add_post_meta( $new_entry_ID, 'faves', 0, true );
		}

		$response = json_encode( array(
		'success' => true,
		'podcast_ID' => $new_entry_ID,
		'podcast_perma' => get_permalink( $new_entry_ID ),
		'do_redirect' => $do_redirect )
		);

		header( "Content-Type: application/json" );
		echo $response;
		exit;
	}
endif;
add_action( 'wp_ajax_nopriv_k_submit_podcast', 'k_submit_podcast' );
add_action( 'wp_ajax_k_submit_podcast', 'k_submit_podcast' );

// edit podcast
if( !function_exists( 'k_edit_podcast' ) ) :
	function k_edit_podcast() {
		global $current_user;
		get_currentuserinfo();

		$podcast_id = (int)$_POST[ 'q_id' ];
		$podcast_title = sanitize_text_field( $_POST[ 'podcast_title' ] );
		$podcast_content = trim( $_POST[ 'podcast_content' ] );
		$podcast_content_markdown = trim( $_POST[ 'podcast_content_markdown' ] );
		$podcast_tags = sanitize_text_field( $_POST[ 'podcast_tags' ] );
		$podcast_category = (int)$_POST[ 'podcast_category' ];
		$podcast_nonce = $_POST[ 'podcastnonce' ];
		if( !wp_verify_nonce( $podcast_nonce, 'edit_podcast' ) ) die ( __( 'You are not allowed to perform such action!', 'kazaz' ) );

		$entry_data = array(
			'ID' => $podcast_id,
			'post_title' => $podcast_title,
			'post_content' => $podcast_content
		);

		$entry_ID = wp_update_post( $entry_data );
		if( $entry_ID ) { // according to codex it should return post ID or 0 upon failure
			wp_set_object_terms( $entry_ID, $podcast_category, 'podcast_category' ); // taxonomy
			if( isset( $podcast_tags ) ) wp_set_post_terms( $entry_ID, trim( $podcast_tags ), 'podcast_tags', true ); // post tags
			update_post_meta( $entry_ID, 'markdown_text', $podcast_content_markdown ); // markdown version
		}

		$response = json_encode( array( 'success' => true, 'podcast_ID' => $entry_ID, 'podcast_perma' => get_permalink( $entry_ID ) ) );
		header( "Content-Type: application/json" );
		echo $response;
		exit;
	}
endif;
add_action( 'wp_ajax_nopriv_k_edit_podcast', 'k_edit_podcast' );
add_action( 'wp_ajax_k_edit_podcast', 'k_edit_podcast' );

// suggest for tags
if( !function_exists( 'k_suggest_tag' ) ) :
	function k_suggest_tag() {
		global $wpdb;
		$input = $_GET[ 'q' ];
		$q_res = "SELECT $wpdb->terms.term_id, $wpdb->terms.name, $wpdb->term_taxonomy.term_id, $wpdb->term_taxonomy.taxonomy
					FROM $wpdb->terms
					INNER JOIN $wpdb->term_taxonomy ON $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id
					WHERE $wpdb->terms.name LIKE '%$input%'
					AND $wpdb->term_taxonomy.taxonomy = 'podcast_tags'";
		$q_res_run = $wpdb->get_results( $q_res );
		if( $q_res_run ) {
			foreach( $q_res_run as $result ) echo $result->name . "\n";
		}
		exit;
	}
	add_action( 'wp_ajax_nopriv_k_suggest_tag', 'k_suggest_tag' );
	add_action( 'wp_ajax_k_suggest_tag', 'k_suggest_tag' );
endif;

// voting
if( !function_exists( 'k_vote_podcast' ) ) :
	function k_vote_podcast() {
		$id = (int)$_POST[ 'id' ];
		$post_author_id = (int)$_POST[ 'author_id' ];
		$action = $_POST[ 'to_do' ]; // pro or con?
		$nonce = $_POST[ 'votenonce' ];
		if( !wp_verify_nonce( $nonce, 'podcast_vote' ) ) die( __( 'You are not allowed to perform such action!', 'kazaz' ) );
		if( !is_user_logged_in() ) die( __( 'You are not allowed to perform such action!', 'kazaz' ) );
		// proceed...
		global $wpdb;
		global $current_user;
		get_currentuserinfo();
		$msg = '';

		// can't vote for its own podcast
		if( $post_author_id != $current_user->ID ) {

			// get record
			$query_table = "SELECT * FROM {$wpdb->prefix}user_activity WHERE user_id = $current_user->ID";
			$query_res = $wpdb->get_row( $query_table );

			if( $query_res != NULL ) {
				$all_votes_pro = ( $query_res->vote_pro_podcast == '' ) ? array() : explode( ',', $query_res->vote_pro_podcast );
				$all_votes_con = ( $query_res->vote_con_podcast == '' ) ? array() : explode( ',', $query_res->vote_con_podcast );

				if( in_array( $id, $all_votes_pro ) || in_array( $id, $all_votes_con ) ) {
					// already voted this podcast pro or con
					$msg = __( "You already voted for this Podcast! Multiple votes are not allowed.", "kazaz" );
				} else {
					if( $action == 'pro' ) {
						array_push( $all_votes_pro, $id );
						$votes_pro_string = implode( ',', $all_votes_pro );
						// this user
						$qs_res = $wpdb->update( $wpdb->prefix . 'user_activity', array( 'vote_pro_podcast' => $votes_pro_string ), array( 'user_id' => $current_user->ID ), array( '%s' ) );
						// podcast author
						$author_reputation = k_update_reputation_points( $post_author_id, 'pro', 'podcast' );
						if( $qs_res && $author_reputation ) {
							// update post meta
							k_update_post_meta( $id, 'pro', 'podcast' );
							$msg = __( "Your vote has been accepted.", "kazaz" );
						} else $msg = __( "Error, your vote can't be accepted! Please try again later.", "kazaz" );
					} elseif( $action == 'con' ) {
						// is reputation score sufficient for voting CON?!?
						if( (int)$query_res->reputation >= (int)of_get_option( 'k_vote_con_limit' ) ) {
							array_push( $all_votes_con, $id );
							$votes_con_string = implode( ',', $all_votes_con );
							// this user
							$qs_res = $wpdb->update( $wpdb->prefix . 'user_activity', array( 'vote_con_podcast' => $votes_con_string ), array( 'user_id' => $current_user->ID ), array( '%s' ) );
							// podcast author
							$author_reputation = k_update_reputation_points( $post_author_id, 'con', 'podcast' );
							if( $qs_res && $author_reputation ) {
								// update post meta
								k_update_post_meta( $id, 'con', 'podcast' );
								$msg = __( "Your vote has been accepted.", "kazaz" );
							} else $msg = __( "Error, your vote can't be accepted! Please try again later.", "kazaz" );
						} else $msg = __( "You are not allowed to vote CON yet, your reputation score is too low.", "kazaz" );
					}
				}

			} else {
				// it's a brand new record
				if( $action == 'pro' ) {
					$insert_rec = $wpdb->insert(
						$wpdb->prefix . 'user_activity',
						array( 'user_id' => $current_user->ID, 'vote_pro_podcast' => $id ),
						array( '%d', '%s' )
					);
					$author_reputation = k_update_reputation_points( $post_author_id, 'pro', 'podcast' );
					if( $insert_rec && $author_reputation ) {
						// update post meta
						k_update_post_meta( $id, $action, 'podcast' );
						$msg = __( "Your vote has been accepted.", "kazaz" );
					} else $msg = __( "Error, your vote can't be accepted! Please try again later.", "kazaz" );
				} elseif( $action == 'con' ) {
					if( (int)$query_res->reputation >= (int)of_get_option( 'k_vote_con_limit' ) ) {
						// this user
						$insert_rec = $wpdb->insert(
							$wpdb->prefix . 'user_activity',
							array( 'user_id' => $current_user->ID, 'vote_con_podcast' => $id ),
							array( '%d', '%s' )
						);
						// podcast author
						$author_reputation = k_update_reputation_points( $post_author_id, 'con', 'podcast' );
						if( $insert_rec && $author_reputation ) {
							// update post meta
							k_update_post_meta( $id, $action, 'podcast' );
							$msg = __( "Your vote has been accepted.", "kazaz" );
						} else $msg = __( "Error, your vote can't be accepted! Please try again later.", "kazaz" );
					} else $msg = __( "You are not allowed to vote CON yet, your reputation score is too low.", "kazaz" );
				}
			}

		} else $msg = __( "You can't vote for your own Podcast!", "kazaz" );

		$response = json_encode( array( 'success' => true, 'new_votes' => get_post_meta( $id, 'votes', true ), 'msg' => $msg ) );
		header( "Content-Type: application/json" );
		echo $response;
		exit;
	}
endif;
add_action( 'wp_ajax_nopriv_k_vote_podcast', 'k_vote_podcast' );
add_action( 'wp_ajax_k_vote_podcast', 'k_vote_podcast' );

// vote answers
if( !function_exists( 'k_vote_answer' ) ) :
	function k_vote_answer() {

		$id = (int)$_POST[ 'id' ];
		$answer_author_id = (int)$_POST[ 'author_id' ];
		$action = $_POST[ 'to_do' ]; // pro or con?
		$nonce = $_POST[ 'answernonce' ];
		if( !wp_verify_nonce( $nonce, 'podcast_vote' ) ) die( __( 'You are not allowed to perform such action!', 'kazaz' ) );
		if( !is_user_logged_in() ) die( __( 'You are not allowed to perform such action!', 'kazaz' ) );

		// proceed...
		global $wpdb;
		global $current_user;
		get_currentuserinfo();
		$msg = '';

		// can't vote for its own answer
		if( $answer_author_id != $current_user->ID ) {

			// get record
			$query_table = "SELECT * FROM {$wpdb->prefix}user_activity WHERE user_id = $current_user->ID";
			$query_res = $wpdb->get_row( $query_table );

			if( $query_res != NULL ) {
				$all_votes_pro = ( $query_res->vote_pro_answer == '' ) ? array() : explode( ',', $query_res->vote_pro_answer );
				$all_votes_con = ( $query_res->vote_con_answer == '' ) ? array() : explode( ',', $query_res->vote_con_answer );

				if( in_array( $id, $all_votes_pro ) || in_array( $id, $all_votes_con ) ) {
					// already voted this podcast pro or con
					$msg = __( "You already voted for this Comment! Multiple votes are not allowed.", "kazaz" );
				} else {
					if( $action == 'pro' ) {
						array_push( $all_votes_pro, $id );
						$votes_pro_string = implode( ',', $all_votes_pro );
						// this user
						$qs_res = $wpdb->update( $wpdb->prefix . 'user_activity', array( 'vote_pro_answer' => $votes_pro_string ), array( 'user_id' => $current_user->ID ), array( '%s' ) );
						// podcast author
						$author_reputation = k_update_reputation_points( $answer_author_id, 'pro', 'answer' );
						if( $qs_res && $author_reputation ) {
							// update post meta
							k_update_post_meta( $id, 'pro', 'answer' );
							$msg = __( "Your vote has been accepted.", "kazaz" );
						} else $msg = __( "Error, your vote can't be accepted! Please try again later.", "kazaz" );
					} elseif( $action == 'con' ) {
						// is reputation score sufficient for voting CON?!?
						if( (int)$query_res->reputation >= (int)of_get_option( 'k_vote_con_limit' ) ) {
							array_push( $all_votes_con, $id );
							$votes_con_string = implode( ',', $all_votes_con );
							// this user
							$qs_res = $wpdb->update( $wpdb->prefix . 'user_activity', array( 'vote_con_answer' => $votes_con_string ), array( 'user_id' => $current_user->ID ), array( '%s' ) );
							// podcast author
							$author_reputation = k_update_reputation_points( $answer_author_id, 'con', 'answer' );
							if( $qs_res && $author_reputation ) {
								// update post meta
								k_update_post_meta( $id, 'con', 'answer' );
								$msg = __( "Your vote has been accepted.", "kazaz" );
							} else $msg = __( "Error, your vote can't be accepted! Please try again later.", "kazaz" );
						} else $msg = __( "You are not allowed to vote CON yet, your reputation score is too low.", "kazaz" );
					}
				}

			} else {
				// it's a brand new record
				if( $action == 'pro' ) {
					$insert_rec = $wpdb->insert(
						$wpdb->prefix . 'user_activity',
						array( 'user_id' => $current_user->ID, 'vote_pro_answer' => $id ),
						array( '%d', '%s' )
					);
					$author_reputation = k_update_reputation_points( $answer_author_id, 'pro', 'answer' );
					if( $insert_rec && $author_reputation ) {
						// update post meta
						k_update_post_meta( $id, $action, 'answer' );
						$msg = __( "Your vote has been accepted.", "kazaz" );
					} else $msg = __( "Error, your vote can't be accepted! Please try again later.", "kazaz" );
				} elseif( $action == 'con' ) {
					if( (int)$query_res->reputation >= (int)of_get_option( 'k_vote_con_limit' ) ) {
						// this user
						$insert_rec = $wpdb->insert(
							$wpdb->prefix . 'user_activity',
							array( 'user_id' => $current_user->ID, 'vote_con_answer' => $id ),
							array( '%d', '%s' )
						);
						// podcast author
						$author_reputation = k_update_reputation_points( $answer_author_id, 'con', 'answer' );
						if( $insert_rec && $author_reputation ) {
							// update post meta
							k_update_post_meta( $id, $action, 'answer' );
							$msg = __( "Your vote has been accepted.", "kazaz" );
						} else $msg = __( "Error, your vote can't be accepted! Please try again later.", "kazaz" );
					} else $msg = __( "You are not allowed to vote CON yet, your reputation score is too low.", "kazaz" );
				}
			}

		} else $msg = __( "You can't vote for your own Comment!", "kazaz" );

		$response = json_encode( array( 'success' => true, 'new_votes' => get_comment_meta( $id, 'votes', true ), 'msg' => $msg ) );
		header( "Content-Type: application/json" );
		echo $response;
		exit;

	}
endif;
add_action( 'wp_ajax_nopriv_k_vote_answer', 'k_vote_answer' );
add_action( 'wp_ajax_k_vote_answer', 'k_vote_answer' );

// handle favourites
if( !function_exists( 'k_handle_favourites' ) ) :
	function k_handle_favourites() {

		$postid = (int)$_POST[ 'id' ];
		$add_or_remove = $_POST[ 'to_do' ]; // add or remove?
		$nonce = $_POST[ 'favenonce' ];
		if( !wp_verify_nonce( $nonce, 'podcast_vote' ) ) die( __( 'You are not allowed to perform such action!', 'kazaz' ) );
		if( !is_user_logged_in() ) die( __( 'You are not allowed to perform such action!', 'kazaz' ) );

		global $wpdb;
		global $current_user;
		get_currentuserinfo();
		$userid = $current_user->ID;
		$msg = '';

		// check whether user exist in our table
		$query_table = "SELECT * FROM {$wpdb->prefix}user_activity WHERE user_id = $userid";
		$q_res = $wpdb->get_row( $query_table );

		if( $q_res != NULL ) {
			$all_faves = ( $q_res->faves == '' ) ? array() : explode( ',', $q_res->faves );
			if( $add_or_remove == 'add' ) {
				if( !in_array( $postid, $all_faves ) ) {
					array_push( $all_faves, $postid );
					$faves_string = implode( ',', $all_faves );
					$insert_res = $wpdb->update( $wpdb->prefix . 'user_activity', array( 'faves' => $faves_string ), array( 'user_id' => $userid ), array( '%s' ) );
					if( $insert_res ) {
						// update post meta
						k_update_post_meta( $postid, 'add', 'faves' );
						$msg = __( "Podcast added to your Favourites!", "kazaz" );
					} else $msg = __( "Error, this Podcast can not be added to your Favourites! Please try again later.", "kazaz" );
				} else $msg = __( "This Podcast is already saved in your Favourites!", "kazaz" );
			} elseif( $add_or_remove == 'remove' ) {
				$all_faves = explode( ',', $q_res->faves );
				$key = array_search( $postid, $all_faves );
				if( $key !== NULL ) {
					if( count( $all_faves ) > 1 ) {
						unset( $all_faves[ $key ] );
						$all_faves = array_values( $all_faves );
						$faves_string = implode( ',', $all_faves );
					} else {
						unset( $all_faves ); // not really necessary but still a good practice
						$faves_string = '';
					}
					$insert_res = $wpdb->update( $wpdb->prefix . 'user_activity', array( 'faves' => $faves_string ), array( 'user_id' => $userid ), array( '%s' ) );
					if( $insert_res ) {
						// update post meta
						k_update_post_meta( $postid, 'remove', 'faves' );
						$msg = __( "Podcast removed from your Favourites!", "kazaz" );
					} else $msg = __( "Error, this Podcast can not be removed from your Favourites! Please try again later.", "kazaz" );
				}
			}
		} else {
			// new record is needed
			$insert_rec = $wpdb->insert(
				$wpdb->prefix . 'user_activity',
				array( 'user_id' => $userid, 'faves' => $postid ),
				array( '%d', '%s' )
			);
			if( $insert_rec ) $msg = __( "Podcast added to your Favourites!", "kazaz" );
			else $msg = __( "Error, this Podcast can not be added to your Favourites! Please try again later.", "kazaz" );
		}

		$response = json_encode( array( 'success' => true, 'new_faves' => get_post_meta( $postid, 'faves', true ), 'msg' => $msg ) );
		header( "Content-Type: application/json" );
		echo $response;
		exit;
	}
endif;
add_action( 'wp_ajax_nopriv_k_handle_favourites', 'k_handle_favourites' );
add_action( 'wp_ajax_k_handle_favourites', 'k_handle_favourites' );

// accept answer
if( !function_exists( 'k_accept_answer' ) ) :
	function k_accept_answer() {

		$id = (int)$_POST[ 'id' ]; // answer id
		$postid = (int)$_POST[ 'post_id' ]; // podcast id
		$answer_author_id = (int)$_POST[ 'author_id' ];
		$nonce = $_POST[ 'acceptnonce' ];
		if( !wp_verify_nonce( $nonce, 'podcast_vote' ) ) die( __( 'You are not allowed to perform such action!', 'kazaz' ) );
		if( !is_user_logged_in() ) die( __( 'You are not allowed to perform such action!', 'kazaz' ) );

		global $wpdb;
		global $current_user;
		get_currentuserinfo();
		$userid = $current_user->ID;
		$msg = '';

		// update user record
		$query_table = "SELECT * FROM {$wpdb->prefix}user_activity WHERE user_id = $userid";
		$q_res = $wpdb->get_row( $query_table );

		if( $q_res != NULL ) {
			$all_accepted = ( $q_res->accepted_answers == '' ) ? array() : explode( ',', $q_res->accepted_answers );
			if( !in_array( $id, $all_accepted ) ) {
				array_push( $all_accepted, $id );
				$all_accepted_string = implode( ',', $all_accepted );
				$insert_res = $wpdb->update( $wpdb->prefix . 'user_activity', array( 'accepted_answers' => $all_accepted_string ), array( 'user_id' => $userid ), array( '%s' ) );
				if( $insert_res ) {
					// add comment meta
					add_comment_meta( $id, 'status', 'accepted' );
					// update post meta
					update_post_meta( $postid, 'status', 'closed' );
					// update answer author reputation score
					k_update_reputation_points( $answer_author_id, '', 'accepted' );
					$msg = __( "Comment accepted!", "kazaz" );
				} else $msg = __( "Error, Comment can not be accepted! Please try again later.", "kazaz" );
			} else $msg = __( "This Comment has already been accepted before!", "kazaz" );
		} else {
			// new record is needed
			$insert_rec = $wpdb->insert(
				$wpdb->prefix . 'user_activity',
				array( 'user_id' => $userid, 'accepted_answers' => $id ),
				array( '%d', '%s' )
			);
			if( $insert_rec ) {
				// add comment meta
				add_comment_meta( $id, 'status', 'accepted' );
				// update post meta
				update_post_meta( $postid, 'status', 'closed' );
				// update answer author reputation score
				k_update_reputation_points( $answer_author_id, '', 'accepted' );
				$msg = __( "Comment accepted!", "kazaz" );
			} else $msg = __( "Error, Comment can not be accepted! Please try again later.", "kazaz" );
		}

		$response = json_encode( array( 'success' => true, 'msg' => $msg, 'redir' => get_permalink( $postid ) ) );
		header( "Content-Type: application/json" );
		echo $response;
		exit;

	}
endif;
add_action( 'wp_ajax_nopriv_k_accept_answer', 'k_accept_answer' );
add_action( 'wp_ajax_k_accept_answer', 'k_accept_answer' );

// decept answer
if( !function_exists( 'k_decept_answer' ) ) :
	function k_decept_answer() {

		$id = (int)$_POST[ 'id' ]; // answer id
		$postid = (int)$_POST[ 'post_id' ]; // podcast id
		$answer_author_id = (int)$_POST[ 'author_id' ];
		$nonce = $_POST[ 'rejectnonce' ];
		if( !wp_verify_nonce( $nonce, 'podcast_vote' ) ) die( __( 'You are not allowed to perform such action!', 'kazaz' ) );
		if( !is_user_logged_in() ) die( __( 'You are not allowed to perform such action!', 'kazaz' ) );

		global $wpdb;
		global $current_user;
		get_currentuserinfo();
		$userid = $current_user->ID;
		$msg = '';

		$query_table = "SELECT * FROM {$wpdb->prefix}user_activity WHERE user_id = $userid";
		$q_res = $wpdb->get_row( $query_table );
		if( $q_res != NULL ) {

			$all_accepted = explode( ',', $q_res->accepted_answers );
			$key = array_search( $id, $all_accepted, true );
			if( $key !== NULL ) {
				if( count( $all_accepted ) > 1 ) {
					unset( $all_accepted[ $key ] );
					$all_accepted = array_values( $all_accepted );
					$accepted_string = implode( ',', $all_accepted );
				} else {
					unset( $all_accepted ); // not really necessary but still a good practice
					$accepted_string = '';
				}
				$insert_res = $wpdb->update( $wpdb->prefix . 'user_activity', array( 'accepted_answers' => $accepted_string ), array( 'user_id' => $userid ), array( '%s' ) );
				if( $insert_res ) {
					// add comment meta
					delete_comment_meta( $id, 'status', 'accepted' );
					// update post meta
					update_post_meta( $postid, 'status', 'open' );
					// update answer author reputation score
					k_update_reputation_points( $answer_author_id, '', 'reject' );
					$msg = __( "Comment has been rejected!", "kazaz" );
				} else $msg = __( "Error, Comment can not be rejected! Please try again later.", "kazaz" );
			} else $msg = __( "Error, Comment can not be rejected! Please try again later.", "kazaz" );

		} else $msg = __( "Error, Comment can not be rejected! Please try again later.", "kazaz" );

		$response = json_encode( array( 'success' => true, 'msg' => $msg, 'redir' => get_permalink( $postid ) ) );
		header( "Content-Type: application/json" );
		echo $response;
		exit;

	}
endif;
add_action( 'wp_ajax_nopriv_k_decept_answer', 'k_decept_answer' );
add_action( 'wp_ajax_k_decept_answer', 'k_decept_answer' );

// handle reports - flagged content
if( !function_exists( 'k_flag_report' ) ) :
	function k_flag_report() {

		$id = (int)$_POST[ 'id' ];
		$com_id = (int)$_POST[ 'postid' ];
		$type = $_POST[ 'type' ];
		$author = (int)$_POST[ 'author' ];
		$nonce = $_POST[ 'flagnonce' ];
		if( !wp_verify_nonce( $nonce, 'flag_report' ) ) die( __( "You are not allowed to perform such action!", "kazaz" ) );
		if( !is_user_logged_in() ) die( __( "You are not allowed to perform such action!", "kazaz" ) );

		global $current_user;
		get_currentuserinfo();
		$msg = '';

		if( $type == 'podcast' ) {
			$view_details = get_permalink( $id );
			$edit_admin = esc_url( home_url( '/' ) ) . 'wp-admin/post.php?post=' . $id . '&action=edit';
		} elseif( $type == 'answer' || $type == 'comment' ) {
			$view_details = get_permalink( $com_id ) . '/#comment-' . $id;
			$edit_admin = esc_url( home_url( '/' ) ) . 'wp-admin/comment.php?action=editcomment&c=' . $id;
		}

		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		$title = sprintf( __( "[%s] Inappropriate content report!", "kazaz" ), $blogname );
		$sent_report_to = of_get_option( 'k_flag_email' );
		$user_profile_link = '( ' . get_author_posts_url( $current_user->ID ) . ' )';

		$message = __( "There's maybe an inappropriate or offensive content on your website that requires your attention!", "kazaz" ) . "\r\n";
		$message .= sprintf( __( 'It has been reported by %1$s, %2$s', 'kazaz' ), $current_user->user_login, $user_profile_link ) . "\r\n\r\n";
		$message .= sprintf( __( 'Entry content front-end: %s', 'kazaz' ), $view_details ) . "\r\n\r\n";
		$message .= sprintf( __( 'Entry content Admin: %s', 'kazaz' ), $edit_admin ) . "\r\n\r\n";
		$message .= __( "Beware: Both Podcast and Comment (answer comment too) content is saved simultaneously as HTML and Markdown. If you decide to edit either of these two be sure to edit correspondingly!", "kazaz" ) . "\r\n\r\n";

		if( $message && !wp_mail( $sent_report_to, $title, $message ) ) $msg = __( "Report could not be sent! Possible reason: your host may have disabled PHP\'s mail() function.", "kazaz" );
		else $msg = __( "Report has been sent successfully. Thanks for participating!", "kazaz" );

		$response = json_encode( array( 'success' => true, 'msg' => $msg ) );
		header( "Content-Type: application/json" );
		echo $response;
		exit;
	}
endif;
add_action( 'wp_ajax_nopriv_k_flag_report', 'k_flag_report' );
add_action( 'wp_ajax_k_flag_report', 'k_flag_report' );

// delete answer comment
if( !function_exists( 'k_delete_answer_comment' ) ) :
	function k_delete_answer_comment() {

		$id = (int)$_POST[ 'id' ];
		$author = (int)$_POST[ 'author' ];
		$nonce = $_POST[ 'flagnonce' ];
		if( !wp_verify_nonce( $nonce, 'flag_report' ) ) die( __( "You are not allowed to perform such action!", "kazaz" ) );
		if( !is_user_logged_in() ) die( __( "You are not allowed to perform such action!", "kazaz" ) );

		global $current_user;
		get_currentuserinfo();
		$msg = __( "Can't proceed, you are not the author of this Comment.", "kazaz" );

		if( (int)$current_user->ID == $author || current_user_can( 'administrator' ) ) {
			$del_my_comment = wp_delete_comment( $id ); // second param is false by default, deleted comment should be retrievable from Trash
			if( $del_my_comment ) $msg = __( "Your Comment has been removed successfully!", "kazaz" );
			else $msg = __( "Error, Comment can not be removed! Please try again later.", "kazaz" );
		}

		$response = json_encode( array( 'success' => true, 'msg' => $msg ) );
		header( "Content-Type: application/json" );
		echo $response;
		exit;
	}
endif;
add_action( 'wp_ajax_nopriv_k_delete_answer_comment', 'k_delete_answer_comment' );
add_action( 'wp_ajax_k_delete_answer_comment', 'k_delete_answer_comment' );


// update reputation points
// it will only affect reputation column!
if( !function_exists( 'k_update_reputation_points' ) ) :
	function k_update_reputation_points( $userid, $pro_or_con, $q_or_a ) {
		global $wpdb;
		$all_right = TRUE;
		$points = 0;
		if( $q_or_a == 'podcast' ) {
			// handle vote PRO podcast
			if( $pro_or_con == 'pro' ) $points = (int)of_get_option( 'k_votes_podcast_pro' );
			elseif( $pro_or_con == 'con' ) $points = (int)of_get_option( 'k_votes_podcast_con' ) * -1;
		} elseif( $q_or_a == 'answer' ) {
			// handle vote CON podcast
			if( $pro_or_con == 'pro' ) $points = (int)of_get_option( 'k_votes_answer_pro' );
			elseif( $pro_or_con == 'con' ) $points = (int)of_get_option( 'k_votes_answer_con' ) * -1;
		} elseif( $q_or_a == 'accepted' ) {
			$points = (int)of_get_option( 'k_accepted_answer_points' );
		} elseif( $q_or_a == 'reject' ) {
			$points = (int)of_get_option( 'k_accepted_answer_points' ) * -1;
		}
		if( !$points ) $all_right = FALSE; // something went wrong
		// check whether user exist in our table
		$query_table = "SELECT reputation FROM {$wpdb->prefix}user_activity WHERE user_id = $userid";
		$q_res = $wpdb->get_var( $query_table );
		if( $q_res != NULL ) {
			$new_points = (int)$q_res + $points;
			$insert_res = $wpdb->update( $wpdb->prefix . 'user_activity', array( 'reputation' => $new_points ), array( 'user_id' => $userid ), array( '%d' ) );
			if( !$insert_res ) $all_right = FALSE;
		} else {
			// new record is needed
			$insert_rec = $wpdb->insert(
				$wpdb->prefix . 'user_activity',
				array( 'user_id' => $userid, 'reputation' => $points ),
				array( '%d', '%d' )
			);
			if( !$insert_rec ) $all_right = FALSE;
		}

		return $all_right;
	}
endif;

// fave exists already?
if( !function_exists( 'k_fave_exists' ) ) :
	function k_fave_exists( $postid, $userid ) {
		global $wpdb;
		$query_table = "SELECT faves FROM {$wpdb->prefix}user_activity WHERE user_id = $userid";
		$q_res = $wpdb->get_var( $query_table );
		if( $q_res != NULL ) {
			$all_faves = ( $q_res == '' ) ? array() : explode( ',', $q_res );
			if( !in_array( $postid, $all_faves ) ) return false; // it's not in favourites
			else return true; // it's already in favourites
		} else return false; // record doesn't exist, it's not in favourites
	}
endif;

// update post meta votes
if( !function_exists( 'k_update_post_meta' ) ) :
	function k_update_post_meta( $postid, $pro_or_con, $field = 'podcast' ) {
		if( $field == 'podcast' ) {
			$num_votes = (int)get_post_meta( $postid, 'votes', TRUE );
			if( $pro_or_con == 'con' ) $new_votes = $num_votes - 1;
			elseif( $pro_or_con == 'pro' ) $new_votes = $num_votes + 1;
			update_post_meta( $postid, 'votes', $new_votes );
		} elseif( $field == 'faves' ) {
			$num_faves = (int)get_post_meta( $postid, 'faves', TRUE );
			if( $pro_or_con == 'remove' ) $new_faves = $num_faves - 1;
			elseif( $pro_or_con == 'add' ) $new_faves = $num_faves + 1;
			update_post_meta( $postid, 'faves', $new_faves );
		} elseif( $field == 'answer' ) {
			$num_votes = (int)get_comment_meta( $postid, 'votes', TRUE );
			if( $pro_or_con == 'con' ) $new_votes = $num_votes - 1;
			elseif( $pro_or_con == 'pro' ) $new_votes = $num_votes + 1;
			update_comment_meta( $postid, 'votes', $new_votes );
		} elseif( $field == 'status' ) {
			update_post_meta( $postid, 'status', 'closed' );
		}
	}
endif;

// get reputation points by user id
if( !function_exists( 'k_get_user_reputation_score' ) ) :
	function k_get_user_reputation_score( $userid ) {
		global $wpdb;
		$query_table = "SELECT reputation FROM {$wpdb->prefix}user_activity WHERE user_id = $userid";
		$q_res = $wpdb->get_var( $query_table );
		if( $q_res != NULL ) {
			return k_round_large( $q_res );
		} else return '0';
	}
endif;

// count user podcast
if( !function_exists( 'k_get_user_podcasts_count' ) ) :
	function k_get_user_podcasts_count( $userid ) {
		global $wpdb;
		$query_table = "SELECT COUNT(*) FROM {$wpdb->prefix}posts WHERE post_author = $userid AND post_status = 'publish' AND post_type = 'podcast'";
		$q_res = $wpdb->get_var( $query_table );
		if( $q_res != NULL ) {
			return $q_res;
		} else return '0';
	}
endif;

// count user comments
if( !function_exists( 'k_get_user_comments_count' ) ) :
	function k_get_user_comments_count( $userid ) {
		global $wpdb;
		$query_table = "SELECT COUNT(*) FROM {$wpdb->prefix}comments WHERE user_id = $userid AND (comment_approved = 1 AND comment_parent = 0 AND comment_karma = 29)";
		$q_res = $wpdb->get_var( $query_table );
		if( $q_res != NULL ) {
			return $q_res;
		} else return '0';
	}
endif;

// count user favourites
if( !function_exists( 'k_get_user_favourites_count' ) ) :
	function k_get_user_favourites_count( $userid ) {
		global $wpdb;
		$query_table = "SELECT * FROM {$wpdb->prefix}user_activity WHERE user_id = $userid";
		$q_res = $wpdb->get_row( $query_table );
		if( $q_res != NULL ) {
			$all_faves = ( $q_res->faves == '' ) ? array() : explode( ',', $q_res->faves );
			return count( $all_faves );
		} else return '0';
	}
endif;

// count answers
if( !function_exists( 'k_count_answers' ) ) :
	function k_count_answers( $podcast_id ) {
		$comment_args = array(
			'status' => 'approve',
			'post_id' => $podcast_id,
			'parent' => 0,
			'count' => TRUE
		);
		return get_comments( $comment_args );
	}
endif;

// site stats
if( !function_exists( 'k_site_stats' ) ) :
	function k_site_stats( $show_Q = 1, $show_A = 1, $show_U = 1 ) {

		global $wpdb;
		$stats_string = '<table class="author-numbers"><tr>';

		// how many podcasts
		if( $show_Q ) {
			$count_posts = wp_count_posts( 'podcast' );
			$published_posts = k_round_large( $count_posts->publish );
			$stats_string .= '<td class="number-box bord-right"><span class="number-box-tag">' . __( "podcasts", "kazaz" ) . '</span><span class="number-box-data">' . $published_posts . '</span></td>';
		}

		// how many answers
		if( $show_A ) {
			$comment_args = array(
				'status' => 'approve',
				'parent' => 0,
				'count' => TRUE
			);
			$approved_answers = k_round_large( get_comments( $comment_args ) );
			$stats_string .= '<td class="number-box"><span class="number-box-tag">' . __( "comments", "kazaz" ) . '</span><span class="number-box-data">' . $approved_answers . '</span></td>';
		}

		// how many users
		/*
		if( $show_U ) {
			$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->users" );
			$total_uc = 0;
			if( $user_count != NULL && $user_count != '' ) $total_uc = k_round_large( $user_count );
			$stats_string .= '<td class="number-box"><span class="number-box-tag">' . __( "users", "kazaz" ) . '</span><span class="number-box-data">' . $total_uc . '</span></td>';
		}
		*/

		$stats_string .= '</tr></table>';

		return $stats_string;
	}
endif;

// elite users
if( !function_exists( 'k_elite_users' ) ) :
	function k_elite_users( $show_users_num ) {

		global $wpdb;
		$top_list = '';

		// trigger all
		$query_table = "SELECT * FROM {$wpdb->prefix}user_activity WHERE reputation != '' ORDER BY reputation DESC LIMIT $show_users_num";
		$myrows = $wpdb->get_results( $query_table );

		if( $myrows != NULL && $myrows ) {
			$top_list .= '<ul class="elite-list">';
			foreach( $myrows as $row ) {
				$top_list .= '<li>';
				$top_list .= get_avatar( $row->user_id, 50, get_user_meta( $row->user_id, 'avatar_url', true ) );
				$top_list .= '<span class="meta-row-wrap">';
				$top_list .= '<span class="meta-box" title="' . __( "Reputation score", "kazaz" ) . '">';
				$top_list .= k_get_user_reputation_score( get_the_author_meta( 'ID', $row->user_id ) );
				$top_list .= '</span>';
				$top_list .= '</span>';
				$top_list .= '<span class="meta-row-wrap">';
				$top_list .= '<span class="meta-info">';
				$top_list .= '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID', $row->user_id ) ) ) . '" title="' . get_the_author_meta( 'user_login', $row->user_id ) . '">' . get_the_author_meta( 'user_login', $row->user_id ) . '</a>';
				$top_list .= '</span>';
				$top_list .= '</span>';
				$top_list .= '</li>';
			}
			$top_list .= '</ul>';
		}

		return $top_list;
	}
endif;

// notify Podcast author about new answer/comment
if( !function_exists( 'k_wp_notify_postauthor' ) ) :
	function k_wp_notify_postauthor( $comment_id, $comment_type = '' ) {
		$comment = get_comment( $comment_id );
		$post    = get_post( $comment->comment_post_ID );
		$user    = get_userdata( $post->post_author );

		if( '' == $user->user_email ) return false;

		$comment_author_domain = @gethostbyaddr( $comment->comment_author_IP );
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

		if( empty( $comment_type ) ) $comment_type = 'comment';

		if( 'comment' == $comment_type ) {
			$notify_message  = sprintf( __( 'New Comment to your Podcast "%1$s"', 'kazaz' ), $post->post_title ) . "\n";
			$notify_message .= sprintf( __( 'Author : %1$s', 'kazaz' ), $comment->comment_author ) . "\n";
			$notify_message .= __( 'Comment/Comment: ', 'kazaz' ) . "\n" . $comment->comment_content . "\n";
			$notify_message .= __( 'Check it out here: ', 'kazaz' ) . "\n";
			$subject = sprintf( __( 'New Comment: "%1$s"', 'kazaz' ), $post->post_title );
		} else return false;

		$notify_message .= get_permalink( $comment->comment_post_ID ) . "#comment-" . $comment_id . "\n";

		$wp_email = 'qanda@' . preg_replace( '#^www\.#', '', strtolower( $_SERVER[ 'SERVER_NAME' ] ) );

		if( '' == $comment->comment_author ) {
			$from = "From: \"$blogname\" <$wp_email>";
			if( '' != $comment->comment_author_email ) $reply_to = "Reply-To: $comment->comment_author_email";
		} else {
			$from = "From: \"$comment->comment_author\" <$wp_email>";
			if( '' != $comment->comment_author_email ) $reply_to = "Reply-To: \"$comment->comment_author_email\" <$comment->comment_author_email>";
		}

		$message_headers = "$from\n"
			. "Content-Type: text/html; charset=\"" . get_option( 'blog_charset' ) . "\"\n";

		if( isset( $reply_to ) ) $message_headers .= $reply_to . "\n";

		$notify_message = apply_filters( 'comment_notification_text', $notify_message, $comment_id );
		$subject = apply_filters( 'comment_notification_subject', $subject, $comment_id );
		$message_headers = apply_filters( 'comment_notification_headers', $message_headers, $comment_id );

		@wp_mail( $user->user_email, $subject, $notify_message, $message_headers );

		return true;
	}
endif;

// allowed tags in comments
if( !function_exists( 'k_extend_allowed_tags' ) ) :
	function k_extend_allowed_tags() {
		global $allowedtags;
		$unwanted_tags = array(
			'abbr',
			'acronym',
			'cite',
			'del',
			'strike',
			'b',
			'i',
			'q',
			'br'
		);
		foreach( $unwanted_tags as $tg ) unset( $allowedtags[ $tg ] ); // remove those that don't match Markdown

		$new_tags = array(
			'p' => array(),
			'h3' => array(),
			'h4' => array(),
			'strong' => array(),
			'em' => array(),
			'a' => array(
				'title' => true,
				'href' => true
			),
			'blockquote' => array(),
			'pre' => array(),
			'code' => array(),
			'img' => array(
				'title' => true,
				'src' => true
			),
			'ul' => array(),
			'ol' => array(),
			'li' => array(),
			'hr' => array()
		);
		$allowedtags = array_merge( $allowedtags, $new_tags );
	}
endif;
add_action( 'init', 'k_extend_allowed_tags', 11 );

/* kustom login */
// css
function k_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/custom-login.css" />';
	if( of_get_option( 'k_logo' ) ) {
		echo '
			<style type="text/css">
			.login h1 a {
				background: url(' . of_get_option( 'k_logo' ) . ' ) no-repeat center center transparent !important;
				background-size: auto;
			}
			</style>
		';
	}
}
add_action( 'login_head', 'k_custom_login' );
// link of logo on login page
function k_login_custom_site_url( $url ) {
    return get_home_url(); //return the current wp blog url
}
add_filter( 'login_headerurl', 'k_login_custom_site_url' );
// change link title of logo
function k_login_header_title( $message ) {
    return FALSE;
}
add_filter( 'login_headertitle', 'k_login_header_title' );

/* kustom avatar */
function k_custom_avatar( $gravatar, $id_or_email, $size, $default, $alt ) {

	$avatar = get_the_author_meta( 'avatar_url', $id_or_email );
	$alt = get_the_author_meta( 'display_name' );

	if( $avatar ) {
		//retrieve avatar from URL found in 'custom_avatar_url' user_meta field.
		$image = '<img class="avatar avatar-' . $size . ' photo" data-size="' . $size . '" src="' . $avatar . '" width="' . $size . '" height="' . $size . '" alt="' . $alt . '" />';
	} elseif( $gravatar ) {
		//if no custom $avatar is set then return a [gravatar] if found
		$image = $gravatar;
	} else {
		//if no $gravatar found, revert to default placeholder for user avatar
		$image = '<img class="avatar avatar-' . $size . ' photo" data-size="' . $size . '" src="' . $default . '" width="' . $size . '" height="' . $size . '" alt="' . $alt . '" />';
	}

	return $image;
}
add_filter( 'get_avatar', 'k_custom_avatar', 10, 5 );

// round large numbers
if( !function_exists( 'k_round_large' ) ) :
	function k_round_large( $value ) {
		if( $value > 999 && $value <= 999999 ) $result = floor( $value / 1000 ) . 'K';
		elseif( $value > 999999 ) $result = floor( $value / 1000000 ) . 'M';
		else $result = $value;
		return $result;
	}
endif;


// shortcodes everywhere
add_filter( 'term_description', 'shortcode_unautop' );
add_filter( 'term_description', 'do_shortcode' );
add_filter( 'the_excerpt', 'shortcode_unautop' );
add_filter( 'the_excerpt', 'do_shortcode' );
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );


//////////////////////////////// FIXING STUFF :::::>

// prevent access to dashboard for all but alpha-admin
if( !function_exists( 'k_redirect_dashboard' ) ) :
	function k_redirect_dashboard() {
		if( !current_user_can( 'administrator' ) ) wp_redirect( home_url() );
	}
endif;
add_action( 'admin_menu', 'k_redirect_dashboard' );

// show admin bar only for admins
if( !current_user_can( 'manage_options' ) ) {
	add_filter( 'show_admin_bar', '__return_false' );
}

/* excerpt read more */
function custom_excerpt_length( $length ) {
	return 9999;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function k_excerpt_more( $more ) {
    global $post;
	return '<a class="moretag" href="'. get_permalink( $post->ID ) . '">' . __( "READ ON &rarr;", "kazaz" ) . '</a>';
}
add_filter( 'excerpt_more', 'k_excerpt_more' );

/* html5 invalid rel */
add_filter( 'the_category', 'add_nofollow_cat' );
function add_nofollow_cat( $text ) {
	$strings = array( 'rel="category"', 'rel="category tag"', 'rel="whatever may need"' );
	$text = str_replace( 'rel="category tag"', "", $text );
	return $text;
}

// remove Galley inline styles
add_filter( 'use_default_gallery_style', '__return_false' );

// cleaner shortcode content
if ( !function_exists( 'parse_shortcode_content' ) ) :
	function parse_shortcode_content( $content ) {
		/* Parse nested shortcodes and add formatting. */
		$content = trim( wpautop( do_shortcode( $content ) ) );
		/* Remove '</p>' from the start of the string. */
		if ( substr( $content, 0, 4 ) == '</p>' )
			$content = substr( $content, 4 );
		/* Remove '<p>' from the end of the string. */
		if ( substr( $content, -3, 3 ) == '<p>' )
			$content = substr( $content, 0, -3 );
		/* Remove any instances of '<p></p>'. */
		$content = str_replace( array( '<p></p>' ), '', $content );
		return $content;
	}
endif;

// orphan paragraphs fix
if( !function_exists( 'k_remove_empty_p' ) ) :
function k_remove_empty_p( $content ) {
    $content = force_balance_tags( $content );
    return preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
}
endif;
add_filter( 'the_content', 'k_remove_empty_p', 20, 1 );

// fix captions
function cleaner_caption( $output, $attr, $content ) {
	if ( is_feed() ) return $output;
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);
	$attr = shortcode_atts( $defaults, $attr );
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) ) return $content;
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';
	$output = '<div' . $attributes .'>';
	$output .= do_shortcode( $content );
	$output .= '<p class="wp-caption-text">' . $attr['caption'] . '</p>';
	$output .= '</div>';
	return $output;
}
add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );

// filter for shortcode [podcasts]
if( !function_exists( 'k_filter_comment_count' ) ) :
	function k_filter_comment_count( $where ) {
		global $wpdb;
		$clause = " AND {$wpdb->posts}.comment_count = 0 ";
		$where = $clause . $where;
		return $where;
	}
endif;
if( !function_exists( 'k_pre_podcasts_filter' ) ) :
	function k_pre_podcasts_filter( $query ) {
		if( isset( $query->query_vars[ 'comment_clause' ] ) && $query->query_vars[ 'comment_clause' ] === 'yeap' ) add_filter( 'posts_where', 'k_filter_comment_count' );
		return $query;
	}
endif;
if( !function_exists( 'k_filter_comment_count_remove' ) ) :
	function k_filter_comment_count_remove() {
		remove_filter( 'posts_orderby', 'k_filter_comment_count' );
	}
endif;
add_action( 'pre_get_posts', 'k_pre_podcasts_filter' );

// comment meta boxes
if( !function_exists( 'k_latest_tweet' ) ) :
function cme_admin_init() {
	if(isset( $_REQUEST[ 'action' ] ) ) {
		if( $_REQUEST[ 'action' ] == "editcomment" ) {
			add_meta_box( 'cme-meta-box', __( "Comment Meta", "kazaz" ), 'cme_comment_meta_box', 'comment', 'normal' );
		}
	}
}
endif;
add_action( 'admin_init', 'cme_admin_init' );

function cme_comment_meta_box( $comment ) {
	global $wpdb;
	$comment_id = $comment->comment_ID;
	?>
	<div id="postcustomstuff">
	<div id="ajax-response"></div>
	<?php
	$comment_meta = $wpdb->get_results( "SELECT * FROM $wpdb->commentmeta WHERE comment_id = $comment_id", ARRAY_A );
	$update_nonce = '';
	if( $comment_meta) :
		?>
		<table id="list-table">
			<thead>
			<tr>
				<th class="left"><?php _ex( 'Name', 'meta name' ); ?></th>
				<th><?php _e( 'Value', 'kazaz' ); ?></th>
			</tr>
			</thead>
			<tbody id='the-list' class='list:meta'>
		<?php
		$count = 0;
		foreach( $comment_meta as $entry ) :
			if( !$update_nonce ) $update_nonce = wp_create_nonce( 'add-meta' );
			$r = '';
			++ $count;
			if( $count % 2 ) $style = 'alternate';
			else $style = '';
			if( '_' == $entry[ 'meta_key' ] { 0 } ) $style .= ' hidden';
			if( is_serialized( $entry[ 'meta_value' ] ) ) {
				if( is_serialized_string( $entry[ 'meta_value' ] ) ) $entry[ 'meta_value' ] = maybe_unserialize( $entry[ 'meta_value' ] );
				else {
					--$count;
					return;
				}
			}
			$entry[ 'meta_key' ] = esc_attr( $entry[ 'meta_key' ] );
			$entry[ 'meta_value' ] = esc_textarea( $entry[ 'meta_value' ] );
			$entry[ 'meta_id' ] = (int)$entry[ 'meta_id' ];
			$delete_nonce = wp_create_nonce( 'delete-meta_' . $entry[ 'meta_id' ] );
			echo "\n\t<tr id='meta-{$entry['meta_id']}' class='$style'>";
			echo "\n\t\t<td class='left'><label class='screen-reader-text' for='meta[{$entry['meta_id']}][key]'>" . __( "Key", "kazaz" ) . "</label><input name='meta[{$entry['meta_id']}][key]' id='meta[{$entry['meta_id']}][key]' tabindex='6' type='text' size='20' value='" . $entry[ 'meta_key' ] . "' />";
			echo "</td>";
			echo "\n\t\t<td><label class='screen-reader-text' for='meta[{$entry['meta_id']}][value]'>" . __( "Value", "kazaz" ) . "</label><textarea name='meta[{$entry['meta_id']}][value]' id='meta[{$entry['meta_id']}][value]' tabindex='6' rows='2' cols='30'>{$entry['meta_value']}</textarea></td>\n\t</tr>";

		endforeach;
		?>
			</tbody>
		</table>
		<?php else : ?>
		<script type="text/javascript">
        jQuery( document ).ready( function($) {
            jQuery( "#cme-meta-box" ).hide();
        } );
        </script>
	<?php endif; ?>
</div>
<?php
}

// Redefine user notification function
if( !function_exists( 'k_filter_wp_mail_from' ) ) {
	function k_filter_wp_mail_from( $email ) {
		return 'qanda@' . preg_replace( '#^www\.#', '', strtolower( $_SERVER[ 'SERVER_NAME' ] ) );
	}
}
add_filter( 'wp_mail_from', 'k_filter_wp_mail_from' );

if( !function_exists( 'k_filter_wp_mail_from_name' ) ) {
	function k_filter_wp_mail_from_name( $from_name ){
		return get_option( 'blogname' );
	}
}
add_filter( 'wp_mail_from_name', 'k_filter_wp_mail_from_name' );

// more data to user profile
if( !function_exists( 'k_extra_user_profile_fields' ) ) :
	function k_extra_user_profile_fields( $user ) {
	?>
        <h3><?php _e( "Extra user info", "kazaz" ); ?></h3>
        <table class="form-table">
            <tr>
            	<th><label for="avatar-url"><?php _e( "Avatar URL", "kazaz" ); ?></label></th>
            	<td>
                	<?php echo get_avatar( $user->email, 40, get_user_meta( $user->ID, 'avatar_url', true ) ); ?><br />
            		<input class="regular-text" name="avatar-url" type="text" id="avatar-url" value="<?php echo esc_attr( get_the_author_meta( 'avatar_url', $user->ID ) ); ?>" />
            	</td>
            </tr>
            <tr>
            	<th><label for="age"><?php _e( "Age", "kazaz" ); ?></label></th>
            	<td>
            		<input class="regular-text" name="age" type="text" id="age" value="<?php echo esc_attr( get_the_author_meta( 'age', $user->ID ) ); ?>" />
            	</td>
            </tr>
            <tr>
            	<th><label for="location"><?php _e( "Location", "kazaz" ); ?></label></th>
            	<td>
            		<input class="regular-text" name="location" type="text" id="location" value="<?php echo esc_attr( get_the_author_meta( 'location', $user->ID ) ); ?>" />
            	</td>
            </tr>
        </table>
	<?php
	}
endif;
add_action( 'show_user_profile', 'k_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'k_extra_user_profile_fields' );

if( !function_exists( 'k_save_extra_user_profile_fields' ) ) :
	function k_save_extra_user_profile_fields( $user_id ) {
		$saved = false;
		if( current_user_can( 'edit_user', $user_id ) ) {
			update_user_meta( $user_id, 'avatar_url', $_POST[ 'avatar-url' ] );
			update_user_meta( $user_id, 'age', $_POST[ 'age' ] );
			update_user_meta( $user_id, 'location', $_POST[ 'location' ] );
			$saved = true;
		}
		return true;
	}
endif;
add_action( 'personal_options_update', 'k_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'k_save_extra_user_profile_fields' );

if( !function_exists( 'k_hide_profile_fields' ) ) :
	function k_hide_profile_fields( $contactmethods ) {
		unset( $contactmethods[ 'aim' ] );
		unset( $contactmethods[ 'jabber' ] );
		unset( $contactmethods[ 'yim' ] );
		return $contactmethods;
	}
endif;
add_filter( 'user_contactmethods', 'k_hide_profile_fields', 10, 1 );

// more columns to comments
if( !function_exists( 'k_comment_columns' ) ) :
	function k_comment_columns( $columns ) {
		return array_merge( $columns, array( 'type' => __( "Comment Type", "kazaz" ) ) );
	}
endif;
add_filter( 'manage_edit-comments_columns', 'k_comment_columns' );
if( !function_exists( 'k_comment_column' ) ) :
	function k_comment_column( $column, $comment_ID ) {
		$comment_obj = get_comment( $comment_ID );
		$comment_par = (int)$comment_obj->comment_parent;
		$comment_kar = (int)$comment_obj->comment_karma;
		switch ( $column ) {
			case 'type':
				if( $comment_kar === 29 ) {
					if( $comment_par ) _e( "Comment comment", "kazaz" );
					elseif( !$comment_par ) _e( "Comment", "kazaz" );
				} else {
					_e( "Post comment", "kazaz" );
				}
			break;
		}
	}
endif;
add_filter( 'manage_comments_custom_column', 'k_comment_column', 10, 2 );

// more options to FILTER drop-down
function k_filter_comments_extra( $comment_types ) {
	$filters = array(
		'regular_comments' => __( "Reguar Comments", "kazaz" ),
		'podcast_answers' => __( "Podcast Comments", "kazaz" ),
		'answer_comments' => __( "Comment Comments", "kazaz" )
	);

	return array_merge( $comment_types, $filters );
}
add_filter( 'admin_comment_types_dropdown', 'k_filter_comments_extra' );

// filter comments by condition
if( !function_exists( 'k_comment_type' ) ) :
	function k_comment_type( $screen ) {
		if( $screen->id != 'edit-comments' ) return;
		if( isset( $_GET[ 'comment_type' ] ) && $_GET[ 'comment_type' ] == 'regular_comments' ) add_action( 'comments_clauses', 'k_filter_comments_regular' );
		elseif( isset( $_GET[ 'comment_type' ] ) && $_GET[ 'comment_type' ] == 'podcast_answers' ) add_action( 'comments_clauses', 'k_filter_comments_answers' );
		elseif( isset( $_GET[ 'comment_type' ] ) && $_GET[ 'comment_type' ] == 'answer_comments' ) add_action( 'comments_clauses', 'k_filter_comments_answers_comment' );
	}
endif;
add_action( 'current_screen', 'k_comment_type', 10, 2 );
if( !function_exists( 'k_filter_comments_regular' ) ) :
	function k_filter_comments_regular( $where ) {
		// if is search
		if( isset( $_GET[ 's' ] ) ) {
			$srch = $_GET[ 's' ];
			$where[ 'where' ] = "( comment_approved = '0' OR comment_approved = '1' AND comment_karma != '29' ) AND ( comment_author LIKE '%$srch%' OR comment_author_email LIKE '%$srch%' OR comment_author_url LIKE '%$srch%' OR comment_author_IP LIKE '%$srch%' OR comment_content LIKE '%$srch%' )";
		} else
		$where[ 'where' ] = "( comment_approved = '0' OR comment_approved = '1' AND comment_karma != '29' )";
		return $where;
	}
endif;
if( !function_exists( 'k_filter_comments_answers' ) ) :
	function k_filter_comments_answers( $where ) {
		// if is search
		if( isset( $_GET[ 's' ] ) ) {
			$srch = $_GET[ 's' ];
			$where[ 'where' ] = "( comment_approved = '0' OR comment_approved = '1' AND comment_karma = '29' AND comment_parent = '0' ) AND ( comment_author LIKE '%$srch%' OR comment_author_email LIKE '%$srch%' OR comment_author_url LIKE '%$srch%' OR comment_author_IP LIKE '%$srch%' OR comment_content LIKE '%$srch%' )";
		} else
		$where[ 'where' ] = "( comment_approved = '0' OR comment_approved = '1' AND comment_karma = '29' AND comment_parent = '0' )";
		return $where;
	}
endif;
if( !function_exists( 'k_filter_comments_answers_comment' ) ) :
	function k_filter_comments_answers_comment( $where ) {
		// if is search
		if( isset( $_GET[ 's' ] ) ) {
			$srch = $_GET[ 's' ];
			$where[ 'where' ] = "( comment_approved = '0' OR comment_approved = '1' AND comment_karma = '29' AND comment_parent != '0' ) AND ( comment_author LIKE '%$srch%' OR comment_author_email LIKE '%$srch%' OR comment_author_url LIKE '%$srch%' OR comment_author_IP LIKE '%$srch%' OR comment_content LIKE '%$srch%' )";
		} else $where[ 'where' ] = "( comment_approved = '0' OR comment_approved = '1' AND comment_karma = '29' AND comment_parent != '0' )";
		return $where;
	}
endif;

// style out new column in comments table
if( !function_exists( 'k_admin_head_style' ) ) :
function k_admin_head_style() {
    echo '<style>';
	echo '.comments th.column-type { width: 10%; }';
	echo '#the-comment-list td.column-type { font-size: 116%; font-weight: bold; }';
	echo '</style>';
}
endif;
add_action( 'admin_head', 'k_admin_head_style' );

///////////////////////////////////// WIDGETS :::::>

// grab my twitts
if( !function_exists( 'k_latest_tweet' ) ) :

    function k_latest_tweet( $username, $count ) {
		$key = "tweet-{$username}";
		$all_twitts = get_transient( $key );
		if( false === $all_twitts || '' === $all_twitts ) {

			$args = array(
				'screen_name' => $username,
				'count' => $count,
				'trim_user' => 1,
			);
			$url = 'http://api.twitter.com/1/statuses/user_timeline.json';
			$url_qa = add_query_arg( $args, $url );
			$request = wp_remote_get( $url_qa );
			if( is_wp_error( $request ) ) return '<li>' . __( "Error by connecting to Twitter!", "kazaz" ) . ', ' . $request->get_error_message() . '</li>';

			$body = wp_remote_retrieve_body( $request );
			$body = json_decode( $body );

			$all_twitts = '';
			$for_key = '';
			$twitt_len = count( $body );
			$cnt = 0;
			while( $cnt < $twitt_len ) {
				if( ( $cnt + 1 ) == $twitt_len ) $all_twitts .= '<li class="last-twitt">';
				else $all_twitts .= '<li>';
				$all_twitts .= '<span class="twitt-date">' . convert_twitter_time( $body[ $cnt ]->created_at ) . '</span> ';
				$tweet = $body[ $cnt ]->text;
				$tweet = utf8_decode( $tweet );
				$tweet = preg_replace('@(https?://([-\w\.]+)+(d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $tweet );
				$all_twitts .= $tweet;
				$for_key .= $tweet;
				$all_twitts .= '</li>';
				$cnt ++;
			}

			set_transient( $key, $all_twitts, 3600 );

		}

		return $all_twitts;
    }
	function convert_twitter_time( $twitter_datetime = '' ) {
		$mysql_format = date( "M j, H:i:s", strtotime( $twitter_datetime ) );
		return $mysql_format;
	}

endif;

// sidebar

add_action( 'widgets_init', 'kazaz_widgets_init' );
function kazaz_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Sidebar Index', 'kazaz' ),
		'id' => 'sidebar-widgets-index',
		'description' => __( 'Sidebar for content: Home Page', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Page', 'kazaz' ),
		'id' => 'sidebar-widgets-page',
		'description' => __( 'Sidebar for content: Page', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Category', 'kazaz' ),
		'id' => 'sidebar-widgets-category',
		'description' => __( 'Sidebar for content: Category', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Single', 'kazaz' ),
		'id' => 'sidebar-widgets-single-post',
		'description' => __( 'Sidebar for content: Single Post', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Podcasts Category', 'kazaz' ),
		'id' => 'sidebar-widgets-podcasts-category',
		'description' => __( 'Sidebar for content: Podcasts Category', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Podcast Single', 'kazaz' ),
		'id' => 'sidebar-widgets-single-podcast',
		'description' => __( 'Sidebar for content: Single Podcast', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Archives', 'kazaz' ),
		'id' => 'sidebar-widgets-archives',
		'description' => __( 'Sidebar for content: Archives', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Search Results', 'kazaz' ),
		'id' => 'sidebar-widgets-search-results',
		'description' => __( 'Sidebar for content: Search Results', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Podcast Search Results', 'kazaz' ),
		'id' => 'sidebar-widgets-podcast-search-results',
		'description' => __( 'Sidebar for content: Podcast Search Results', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Column First', 'kazaz' ),
		'id' => 'sidebar-widgets-fcf',
		'description' => __( 'Content: Footer, column first', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Column Second', 'kazaz' ),
		'id' => 'sidebar-widgets-fcs',
		'description' => __( 'Content: Footer, column second', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Column Third', 'kazaz' ),
		'id' => 'sidebar-widgets-fct',
		'description' => __( 'Content: Footer, column third', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Column Fourth', 'kazaz' ),
		'id' => 'sidebar-widgets-fcl',
		'description' => __( 'Content: Footer, column fourth', 'kazaz' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

}

// WIDGET VCard
class SOFA_Widget_Vcard extends WP_Widget {

	function SOFA_Widget_Vcard() {
		$widget_ops = array( 'classname' => 'widget_sofa_vcard', 'description' => __( 'Vcard generator', 'kazaz' ) );
		$this->WP_Widget( 'sofa_vcard', 'Vcard generator', $widget_ops );
	}

	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		$s_vcard_img_url = empty( $instance[ 's_vcard_img_url' ] ) ? '' : apply_filters( 'widget_s_vcard_img_url', $instance[ 's_vcard_img_url' ] );
		$s_vcard_title = empty( $instance[ 's_vcard_title' ] ) ? '' : apply_filters( 'widget_s_vcard_title', $instance[ 's_vcard_title' ] );
		$s_vcard_about = empty( $instance[ 's_vcard_about' ] ) ? '' : apply_filters( 'widget_s_vcard_about', $instance[ 's_vcard_about' ] );
		$s_vcard_name = empty( $instance[ 's_vcard_name' ] ) ? '' : apply_filters( 'widget_s_vcard_name', $instance[ 's_vcard_name' ] );
		$s_vcard_phone_label = empty( $instance[ 's_vcard_phone_label' ] ) ? '' : apply_filters( 'widget_s_vcard_phone_label', $instance[ 's_vcard_phone_label' ] );
		$s_vcard_phone_numbr = empty( $instance[ 's_vcard_phone_numbr' ] ) ? '' : apply_filters( 'widget_s_vcard_phone_numbr', $instance[ 's_vcard_phone_numbr' ] );
		$s_vcard_email_addr = empty( $instance[ 's_vcard_email_addr' ] ) ? '' : apply_filters( 'widget_s_vcard_email_addr', $instance[ 's_vcard_email_addr' ] );
		$s_vcard_street_adr = empty( $instance[ 's_vcard_street_adr' ] ) ? '' : apply_filters( 'widget_s_vcard_street_adr', $instance[ 's_vcard_street_adr' ] );
		$s_vcard_zip_code = empty( $instance[ 's_vcard_zip_code' ] ) ? '' : apply_filters( 'widget_s_vcard_zip_code', $instance[ 's_vcard_zip_code' ] );
		$s_vcard_city = empty( $instance[ 's_vcard_city' ] ) ? '' : apply_filters( 'widget_s_vcard_city', $instance[ 's_vcard_city' ] );
		$s_vcard_country = empty( $instance[ 's_vcard_country' ] ) ? '' : apply_filters( 'widget_s_vcard_country', $instance[ 's_vcard_country' ] );

		echo $before_widget;
		$title_echo = '';
		if( $s_vcard_title != '' ) $title_echo = $before_title . $s_vcard_title . $after_title;

		echo '<div class="vcardwidget vcard clearfix">';
		if( !empty( $s_vcard_img_url ) ) echo '<p><img src="' . $s_vcard_img_url . '" alt="' . __( "Myself photo", "kazaz" ) . '" /></p>';
		echo $title_echo;
		if( !empty( $s_vcard_about ) ) echo '<p>' . $s_vcard_about . '</p>';
		echo '<ul class="communication">';
		echo '<li class="fn">' . $s_vcard_name . '</li>';
		echo '<li class="tel">';
		echo '<span class="type">' . $s_vcard_phone_label . '</span>';
		echo '<span class="numbers">' . $s_vcard_phone_numbr . '</span>';
		echo '</li>';
		echo '<li class="email">';
		echo '<span><a href="mailto:' . $s_vcard_email_addr . '" title="">' . $s_vcard_email_addr . '</a></span>';
		echo '</li>';
		echo '</ul>';
		echo '<ul class="adr">';
		echo '<li class="street-address"><span class="numbers">' . $s_vcard_street_adr . '</span></li>';
		echo '<li class="postal-code"><span class="numbers">' . $s_vcard_zip_code . '</span><span class="locality"> ' . $s_vcard_city . '</span></li>';
		echo '<li class="country-name">' . $s_vcard_country . '</li>';
		echo '</ul>';
		echo '</div>';

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 's_vcard_img_url' ] = $new_instance[ 's_vcard_img_url' ];
		$instance[ 's_vcard_title' ] = strip_tags( $new_instance[ 's_vcard_title' ] );
		$instance[ 's_vcard_about' ] = $new_instance[ 's_vcard_about' ];
		$instance[ 's_vcard_name' ] = $new_instance[ 's_vcard_name' ];
		$instance[ 's_vcard_phone_label' ] = $new_instance[ 's_vcard_phone_label' ];
		$instance[ 's_vcard_phone_numbr' ] = $new_instance[ 's_vcard_phone_numbr' ];
		$instance[ 's_vcard_email_addr' ] = $new_instance[ 's_vcard_email_addr' ];
		$instance[ 's_vcard_street_adr' ] = $new_instance[ 's_vcard_street_adr' ];
		$instance[ 's_vcard_zip_code' ] = $new_instance[ 's_vcard_zip_code' ];
		$instance[ 's_vcard_city' ] = $new_instance[ 's_vcard_city' ];
		$instance[ 's_vcard_country' ] = $new_instance[ 's_vcard_country' ];
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( ( array ) $instance, array( 's_vcard_img_url' => '', 's_vcard_title' => '', 's_vcard_about' => '', 's_vcard_name' => '', 's_vcard_phone_label' => '', 's_vcard_phone_numbr' => '', 's_vcard_email_addr' => '', 's_vcard_street_adr' => '', 's_vcard_zip_code' => '', 's_vcard_city' => '', 's_vcard_country' => '' ) );
		$s_vcard_img_url = $instance[ 's_vcard_img_url' ];
		$s_vcard_title = strip_tags( $instance[ 's_vcard_title' ] );
		$s_vcard_name = $instance[ 's_vcard_name' ];
		$s_vcard_about = $instance[ 's_vcard_about' ];
		$s_vcard_phone_label = $instance[ 's_vcard_phone_label' ];
		$s_vcard_phone_numbr = $instance[ 's_vcard_phone_numbr' ];
		$s_vcard_email_addr = $instance[ 's_vcard_email_addr' ];
		$s_vcard_street_adr = $instance[ 's_vcard_street_adr' ];
		$s_vcard_zip_code = $instance[ 's_vcard_zip_code' ];
		$s_vcard_city = $instance[ 's_vcard_city' ];
		$s_vcard_country = $instance[ 's_vcard_country' ];
?>

<p>
<label for="<?php echo $this->get_field_id( 's_vcard_img_url' ); ?>">
Full path to VCard image:
<input class="widefat" id="<?php echo $this->get_field_id( 's_vcard_img_url' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_img_url' ); ?>" type="text" value="<?php echo $s_vcard_img_url; ?>" />
</label>
</p>
<p>
<label for="<?php echo $this->get_field_id( 's_vcard_title' ); ?>">
Title:
<input class="widefat" id="<?php echo $this->get_field_id( 's_vcard_title' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_title' ); ?>" type="text" value="<?php echo esc_attr( $s_vcard_title ); ?>" />
</label>
</p>
<label for="<?php echo $this->get_field_id( 's_vcard_about' ); ?>">
About text:
</label>
<textarea class="widefat" rows="16" cols="50" id="<?php echo $this->get_field_id( 's_vcard_about' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_about' ); ?>" type="text" value="<?php echo esc_attr( $s_vcard_about ); ?>"><?php echo $s_vcard_about; ?></textarea>
<p>
<label for="<?php echo $this->get_field_id( 's_vcard_name' ); ?>">
Name or Company:
<input class="widefat" id="<?php echo $this->get_field_id( 's_vcard_name' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_name' ); ?>" type="text" value="<?php echo esc_attr( $s_vcard_name ); ?>" />
</label>
</p>
<p>
<label for="<?php echo $this->get_field_id( 's_vcard_phone_label' ); ?>">
Label for phone number (for example: Tel:, Phone, Cell, etc.):
<input class="widefat" id="<?php echo $this->get_field_id( 's_vcard_phone_label' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_phone_label' ); ?>" type="text" value="<?php echo esc_attr( $s_vcard_phone_label ); ?>" />
</label>
</p>
<p>
<label for="<?php echo $this->get_field_id( 's_vcard_phone_numbr' ); ?>">
Phone number:
<input class="widefat" id="<?php echo $this->get_field_id( 's_vcard_phone_numbr' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_phone_numbr' ); ?>" type="text" value="<?php echo esc_attr( $s_vcard_phone_numbr ); ?>" />
</label>
</p>
<p>
<label for="<?php echo $this->get_field_id( 's_vcard_email_addr' ); ?>">
E-mail address:
<input class="widefat" id="<?php echo $this->get_field_id( 's_vcard_email_addr' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_email_addr' ); ?>" type="text" value="<?php echo esc_attr( $s_vcard_email_addr ); ?>" />
</label>
</p>
<p>
<label for="<?php echo $this->get_field_id( 's_vcard_street_adr' ); ?>">
Street address:
<input class="widefat" id="<?php echo $this->get_field_id( 's_vcard_street_adr' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_street_adr' ); ?>" type="text" value="<?php echo esc_attr( $s_vcard_street_adr ); ?>" />
</label>
</p>
<p>
<label for="<?php echo $this->get_field_id( 's_vcard_zip_code' ); ?>">
ZIP code:
<input class="widefat" id="<?php echo $this->get_field_id( 's_vcard_zip_code' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_zip_code' ); ?>" type="text" value="<?php echo esc_attr( $s_vcard_zip_code ); ?>" />
</label>
</p>
<p>
<label for="<?php echo $this->get_field_id( 's_vcard_city' ); ?>">
City:
<input class="widefat" id="<?php echo $this->get_field_id( 's_vcard_city' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_city' ); ?>" type="text" value="<?php echo esc_attr( $s_vcard_city ); ?>" />
</label>
</p>
<p>
<label for="<?php echo $this->get_field_id( 's_vcard_country' ); ?>">
Country:
<input class="widefat" id="<?php echo $this->get_field_id( 's_vcard_country' ); ?>" name="<?php echo $this->get_field_name( 's_vcard_country' ); ?>" type="text" value="<?php echo esc_attr( $s_vcard_country ); ?>" />
</label>
</p>

<?php
	}
}
register_widget( 'SOFA_Widget_Vcard' );

// TWITTER
class SOFA_Twitter extends WP_Widget {
	function SOFA_Twitter() {
		$widget_ops = array( 'classname' => 'widget_sofa_twitter', 'description' => 'Display Twitter Twitts for target user.' );
		$this->WP_Widget( 'sofa_twitter', 'Twitter', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$s_twitter_title = empty( $instance[ 's_twitter_title' ] ) ? '' : apply_filters( 'widget_s_twitter_title', $instance[ 's_twitter_title' ] );
		$s_twitter_user  = empty( $instance[ 's_twitter_user' ] ) ? 'dameer' : apply_filters( 'widget_s_twitter_user', $instance[ 's_twitter_user' ] );
		$s_twitts_number = empty( $instance[ 's_twitts_number' ] ) ? 'dameer' : apply_filters( 'widget_s_twitts_number', $instance[ 's_twitts_number' ] );

		echo $before_widget;

		if( $s_twitter_title != '' ) echo $before_title . $s_twitter_title . $after_title;

		k_latest_tweet( $s_twitter_user, $s_twitts_number );
		echo '<div class="clearfix">';
		echo '<ol id="twitter_update_list">';
		echo k_latest_tweet( $s_twitter_user, $s_twitts_number );
		echo '</ol>';
		echo '</div>';

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 's_twitter_title' ] = strip_tags( $new_instance[ 's_twitter_title' ] );
		$instance[ 's_twitter_user' ]  = strip_tags( $new_instance[ 's_twitter_user' ] );
		$instance[ 's_twitts_number' ] = strip_tags( $new_instance[ 's_twitts_number' ] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( ( array ) $instance, array( 's_twitter_title' => '', 's_twitter_user' => '', 's_twitts_number' => '' ) );
		$s_twitter_title = strip_tags( $instance[ 's_twitter_title' ] );
		$s_twitter_user  = strip_tags( $instance[ 's_twitter_user' ] );
		$s_twitts_number = strip_tags( $instance[ 's_twitts_number' ] );
?>

<p>
<label for="<?php echo $this->get_field_id( 's_twitter_title' ); ?>">
Title:
<input class="widefat" id="<?php echo $this->get_field_id( 's_twitter_title' ); ?>" name="<?php echo $this->get_field_name( 's_twitter_title' ); ?>" type="text" value="<?php echo esc_attr( $s_twitter_title ); ?>" />
</label>
</p>

<p>
<label for="<?php echo $this->get_field_id( 's_twitter_user' ); ?>">
Twitter Username:
<input class="widefat" id="<?php echo $this->get_field_id( 's_twitter_user' ); ?>" name="<?php echo $this->get_field_name( 's_twitter_user' ); ?>" type="text" value="<?php echo esc_attr( $s_twitter_user ); ?>" />
</label>
</p>

<p>
<label for="<?php echo $this->get_field_id( 's_twitts_number' ); ?>">
Number of Twitts to show:
<input id="<?php echo $this->get_field_id( 's_twitts_number' ); ?>" name="<?php echo $this->get_field_name( 's_twitts_number' ); ?>" type="text" size="3" value="<?php echo esc_attr( $s_twitts_number ); ?>" />
</label>
</p>

<?php
	}
}
register_widget( 'SOFA_Twitter' );

// RELATED PODCASTS
class SOFA_RelatedPodcasts extends WP_Widget {
	function SOFA_RelatedPodcasts() {
		$widget_ops = array( 'classname' => 'widget_sofa_rq', 'description' => 'Display related podcasts on Podcast details page only!' );
		$this->WP_Widget( 'sofa_rq', 'Related Podcasts', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$rq_title = empty( $instance[ 'rq_title' ] ) ? '' : apply_filters( 'widget_rq_title', $instance[ 'rq_title' ] );
		$rq_noi   = empty( $instance[ 'rq_noi' ] ) ? 10 : apply_filters( 'widget_rq_noi', $instance[ 'rq_noi' ] );

		echo $before_widget;

		if( $rq_title != '' ) echo $before_title . $rq_title . $after_title;

		echo k_related_podcasts( $rq_noi );

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'rq_title' ]  = strip_tags( $new_instance[ 'rq_title' ] );
		$instance[ 'rq_noi' ] = strip_tags( $new_instance[ 'rq_noi' ] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( ( array ) $instance, array( 'rq_title' => '', 'rq_noi' => '' ) );
		$rq_title  = strip_tags( $instance[ 'rq_title' ] );
		$rq_noi = strip_tags( $instance[ 'rq_noi' ] );
?>

<p>
<label for="<?php echo $this->get_field_id( 'rq_title' ); ?>">
Title:
<input class="widefat" id="<?php echo $this->get_field_id( 'rq_title' ); ?>" name="<?php echo $this->get_field_name( 'rq_title' ); ?>" type="text" value="<?php echo esc_attr( $rq_title ); ?>" />
</label>
</p>

<p>
<label for="<?php echo $this->get_field_id( 'rq_noi' ); ?>">
Number of related Podcasts to show:
<input id="<?php echo $this->get_field_id( 'rq_noi' ); ?>" name="<?php echo $this->get_field_name( 'rq_noi' ); ?>" type="text" size="3" value="<?php echo esc_attr( $rq_noi ); ?>" />
</label>
</p>

<?php
	}
}
register_widget( 'SOFA_RelatedPodcasts' );

// SITE STATS
class SOFA_SiteStats extends WP_Widget {
	function SOFA_SiteStats() {
		$widget_ops = array( 'classname' => 'widget_sofa_ss', 'description' => 'Display site statistics.' );
		$this->WP_Widget( 'sofa_ss', 'Site Stats', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$ss_title = empty( $instance[ 'ss_title' ] ) ? '' : apply_filters( 'widget_ss_title', $instance[ 'ss_title' ] );

		echo $before_widget;

		if( $ss_title != '' ) echo $before_title . $ss_title . $after_title;

		echo k_site_stats( 1, 1 );

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'ss_title' ]  = strip_tags( $new_instance[ 'ss_title' ] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( ( array ) $instance, array( 'ss_title' => '' ) );
		$ss_title  = strip_tags( $instance[ 'ss_title' ] );
?>

<p>
<label for="<?php echo $this->get_field_id( 'ss_title' ); ?>">
Title:
<input class="widefat" id="<?php echo $this->get_field_id( 'ss_title' ); ?>" name="<?php echo $this->get_field_name( 'ss_title' ); ?>" type="text" value="<?php echo esc_attr( $ss_title ); ?>" />
</label>
</p>

<?php
	}
}
register_widget( 'SOFA_SiteStats' );

// ELITE
class SOFA_Elite extends WP_Widget {
	function SOFA_Elite() {
		$widget_ops = array( 'classname' => 'widget_sofa_elite', 'description' => 'Display top rated users.' );
		$this->WP_Widget( 'sofa_elite', 'Elite Users', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$elite_title = empty( $instance[ 'elite_title' ] ) ? '' : apply_filters( 'widget_elite_title', $instance[ 'elite_title' ] );
		$elite_noi   = empty( $instance[ 'elite_noi' ] ) ? 10 : apply_filters( 'widget_elite_noi', $instance[ 'elite_noi' ] );

		echo $before_widget;

		if( $elite_title != '' ) echo $before_title . $elite_title . $after_title;

		echo k_elite_users( $elite_noi );

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'elite_title' ]  = strip_tags( $new_instance[ 'elite_title' ] );
		$instance[ 'elite_noi' ] = strip_tags( $new_instance[ 'elite_noi' ] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( ( array ) $instance, array( 'elite_title' => '', 'elite_noi' => '' ) );
		$elite_title  = strip_tags( $instance[ 'elite_title' ] );
		$elite_noi = strip_tags( $instance[ 'elite_noi' ] );
?>

<p>
<label for="<?php echo $this->get_field_id( 'elite_title' ); ?>">
Title:
<input class="widefat" id="<?php echo $this->get_field_id( 'elite_title' ); ?>" name="<?php echo $this->get_field_name( 'elite_title' ); ?>" type="text" value="<?php echo esc_attr( $elite_title ); ?>" />
</label>
</p>

<p>
<label for="<?php echo $this->get_field_id( 'elite_noi' ); ?>">
Number of top rated users to show:
<input id="<?php echo $this->get_field_id( 'elite_noi' ); ?>" name="<?php echo $this->get_field_name( 'elite_noi' ); ?>" type="text" size="3" value="<?php echo esc_attr( $elite_noi ); ?>" />
</label>
</p>

<?php
	}
}
register_widget( 'SOFA_Elite' );