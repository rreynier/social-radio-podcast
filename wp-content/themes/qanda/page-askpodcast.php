<?php
/**
 * Template Name: Ask Podcast Page
*/
// load header
get_header();

global $current_user;
get_currentuserinfo();
?>
    <div class="articles-wrap twelve columns alpha"><!-- articles wrapper -->

    <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

        <?php if( get_post_meta( get_the_ID(), 'show_title', true ) != 'no' ) : ?>

            <header>
                <h1><?php the_title(); ?></h1>
            </header><!-- end article header -->

        <?php endif; ?>

        <section class="entry-content clearfix" itemprop="articleBody">
            <?php the_content(); ?>
        </section> <!-- end article section -->

        <?php if( is_user_logged_in() ) { ?>

            <form id="podcast-add" class="qanda-form" method="post" action="">

            <div class="form-loader"><p><?php _e( "Processing...", "kazaz" ); ?></p></div><!-- loading animation -->
            <div class="form-cover"></div><!-- form cover -->

            <!-- post title -->
            <p class="form-block">
            <label for="podcast-title"><?php _e( "Podcast", "kazaz" ); ?> (<span id="count-title"><?php of_get_option( 'k_answer_cont_chars_max' ); ?></span>)</label>
            <input type="text" id="podcast-title" name="podcast-title" autocomplete="off" value="" />
            <span class="form-tip"><?php printf( __( 'Podcast is mandatory (between %1$s and %2$s characters)!', "kazaz" ), of_get_option( 'k_podcast_chars_min' ), of_get_option( 'k_podcast_chars_max' ) ); ?></span>
            <span id="tip-podcast-title" class="form-tip tip-error"><?php printf( __( 'ERROR: Podcast should be at least %1$s and max %2$s characters long!', 'kazaz' ), of_get_option( 'k_podcast_chars_min' ), of_get_option( 'k_podcast_chars_max' ) ); ?></span>
            </p>
            <!-- end post title -->

            <!-- post content -->
            <div class="form-block">
                <label for="wmd-input"><?php _e( "Content", "kazaz" ); ?> (<span id="count-body"><?php echo of_get_option( 'k_answer_cont_chars_max' ); ?></span>)</label>
                <div class="wmd-panel">
                    <div id="wmd-button-bar"></div>
                    <textarea class="wmd-input" id="wmd-input"></textarea>
                    <span class="form-tip"><?php printf( __( 'Content is mandatory (between %1$s and %2$s characters)!', "kazaz" ), of_get_option( 'k_podcast_cont_chars_min' ), of_get_option( 'k_podcast_cont_chars_max' ) ); ?></span>
                    <span id="tip-podcast-content" class="form-tip tip-error"><?php printf( __( 'ERROR: Content should be at least %1$s and max %2$s characters long!', 'kazaz' ), of_get_option( 'k_podcast_cont_chars_min' ), of_get_option( 'k_podcast_cont_chars_max' ) ); ?></span>
                    <p class="wmd-preview-title"><?php _e( "Content Preview:", "kazaz" ); ?></p>
                    <div id="wmd-preview" class="wmd-panel wmd-preview"></div>
                </div>
            </div>
            <!-- end post content -->

            <!-- post tags -->
            <?php if( of_get_option( 'enable_podcast_tags' ) ) : ?>
            <p class="form-block">
            <label for="podcast-tags"><?php _e( "Podcast Tags", "kazaz" ); ?> (<span id="count-tags"><?php of_get_option( 'k_podcast_tags_chars_max' ); ?></span>)</label>
            <input type="text" id="podcast-tags" name="podcast-tags" autocomplete="off" value="" />
            <span class="form-tip"><?php _e( "Comma separated keywords, for example: lorem, ipsum, dolor", "kazaz" ); ?></span>
            <span id="tip-podcast-tags" class="form-tip tip-error"><?php printf( __( 'ERROR: Tags shouldn\'t exceed %1$s characters in total!', 'kazaz' ), of_get_option( 'k_podcast_tags_chars_max' ) ); ?></span>
            </p>
            <?php endif; ?>
            <!-- end post tags -->

            <!-- post category -->
            <p class="form-block">
            <label for="podcast-category"><?php _e( "Publish in", "kazaz" ); ?></label>
            <?php echo k_categories_dropdown( 'podcast_category', 0 ); ?>
            <span class="form-tip"><?php _e( "Your Podcast will be published in selected category!", "kazaz" ); ?></span>
            </p>
            <!-- end post category -->

            <!-- publish content -->
            <p class="form-block form-block-mcut">
            <input type="submit" id="podcast-submit" class="button" name="podcast-submit" value="<?php _e( "Submit Podcast", "kazaz" ); ?>">
            </p>
            <!-- end publish content -->

            </form>

            <div class="form-message-ok alertyellow">
            <p>
            <?php
            if( of_get_option( 'autopublish_podcast' ) ) :
                _e( "Your Podcast has been added successfully, thanks for participating!<br />Right now redirecting to your new Podcast page...", "kazaz" );
            else :
                _e( "Your Podcast has been added successfully, thanks for participating! However, it won't be visible immediately, site staff approval is required!", "kazaz" );
            endif;
            ?>
            </p>
            </div>

            <div class="form-message-error alertred">
            <p><?php _e( "Your Podcast can not be added, server responded with error! Sorry for any inconvenience and please try again later.<br />Thanks for understanding!", "kazaz" ); ?></p>
            </div>

        <?php } else { ?>
        <div class="alertred"><p>
        <?php _e( "You are not signed in and thus not allowed to ask a Podcast. Please sign in or create an account then get back.", "kazaz" ); ?>
        </p></div>
        <?php } ?>

    </article> <!-- end article -->

    <?php
    // echo kazaz_pagination_page(); // not really needed here...
    endwhile;
    else :
    ?>

    <?php kazaz_not_found(); // not found section ?>

    <?php endif; ?>

    </div><!-- end articles wrapper -->

    <?php get_template_part( 'sidebars/sidebar-page' ); // sidebar ?>

<?php
get_footer();