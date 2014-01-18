<!DOCTYPE html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- mobile meta -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<link rel="shortcut icon" href="<?php echo of_get_option( 'k_favicon' ); ?>">
  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <!-- dynamic stylesheet -->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo home_url(); ?>/?dynamic_css=css" />

		<!-- wordpress head functions -->
		<?php
		if( is_singular() && !is_singular( 'podcast' ) && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
		if( is_page( get_option( 'page_on_front' ) ) ) {
			$fp = get_post( (int)get_option( 'page_on_front' ) );
			update_option( 'is_fp', $fp->post_name );
		} else {
			delete_option( 'is_fp' );
		}
		wp_head();
		?>

        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-47039129-2']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>

	</head>

	<body <?php body_class(); ?>>

    <div id="k-main-wrap" class="container"><!-- k main wrap -->

    	<div id="k-header" class="sixteen columns"><!-- k header -->

            <header id="k-header-group" class="six columns alpha">

                <?php
                // <!-- k logo -->
                $header = '<hgroup id="k-logo" class="six columns alpha">';
                if( of_get_option( 'k_logo' ) ) {
                    $header .= '<h1 id="site-title-logo"><a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"><img id="site-logo-img" src="' . of_get_option( 'k_logo' ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" /></a></h1>'. "\n";
                } else {
                    $header.= '<h1 id="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">' . get_bloginfo( 'name' ) . '</a></h1>'. "\n";
                    if( !of_get_option( 'k_site_description_remove' ) ) $header.= '<h5 id="site-description">' . get_bloginfo( 'description' ) . '</h5>'. "\n";
                }
                $header.= '</hgroup>';
                echo $header;
                // <!-- end k logo -->
                ?>

            </header>

        	<div id="k-search-functional" class="ten columns omega"><!-- k search and functional navig -->

            	<section id="k-search" class="offset-by-five five columns alpha omega"><!-- k search -->
                	<?php echo kazaz_wpsearch(); ?>
                </section><!-- end k search -->

            	<!-- k functional navig -->
				<?php kazaz_navig_functional(); ?>
                <!-- end k functional navig -->

            </div><!-- end k search and functional navig -->

        </div><!-- end k header -->

        <div id="k-subheader" class="sixteen columns"><!-- k sub-header -->

        	<!-- k main navig -->
			<?php kazaz_navig_head(); ?>
            <div id="menu-icon"></div>
            <!-- end k main navig -->

            <section id="k-login" class="three columns omega"><!-- k login -->
            	<?php if( !is_user_logged_in() ) : ?>
            	<a href="<?php echo wp_login_url( home_url() ); ?>" id="sign-in" title="<?php _e( "Sign in", "kazaz" ); ?>"><?php _e( "Sign in", "kazaz" ); ?></a>
                <span class="spacer"> / </span>
                <a href="<?php echo wp_login_url(); ?>?action=register" id="sign-up" title="<?php _e( "Sign up", "kazaz" ); ?>"><?php _e( "Sign up", "kazaz" ); ?></a>
                <?php
				else :
				global $current_user;
				get_currentuserinfo();
				?>
                <a href="<?php echo get_author_posts_url( $current_user->ID ); ?>" id="sign-name" title="<?php echo $current_user->user_login; ?>"><?php echo $current_user->user_login; ?></a>
                <span class="spacer"> / </span>
                <a href="<?php echo wp_logout_url( home_url() ); ?>" id="sign-out" title="<?php _e( "Sign out", "kazaz" ); ?>"><?php _e( "Sign out", "kazaz" ); ?></a>
                <?php endif; ?>
            </section><!-- end k login -->

        </div><!-- end k sub-header -->

        <div id="k-content" class="sixteen columns"><!-- k content -->
