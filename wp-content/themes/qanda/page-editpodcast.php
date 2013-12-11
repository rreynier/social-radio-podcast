<?php
/**
 * Template Name: Edit Podcast Page
*/
// load header
get_header();

global $current_user;
get_currentuserinfo();

$msg = '';
$can_edit = TRUE;
if( !(int)$_POST[ 'qid' ] || !(int)$_POST[ 'qaid' ] ) {
    $can_edit = FALSE;
    $msg = __( "You are trying to cheat, huh? That's bad idea.", "kazaz" );
} else {
    $q_id = (int)$_POST[ 'qid' ];
    $q_author_id = (int)$_POST[ 'qaid' ];
}
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

        <?php
        if( !is_user_logged_in() ) {
            $can_edit = FALSE;
            $msg = __( "You are not signed in and thus not allowed to edit Podcast. Please sign in or create an account then get back.", "kazaz" );
        } elseif( is_user_logged_in() && ( $current_user->ID != $q_author_id ) ) {
            if( current_user_can( 'administrator' ) ) $can_edit = TRUE;
            else $can_edit = FALSE;
            $msg = __( "You are not allowed to EDIT this Podcast, you are not the author.", "kazaz" );
        } elseif( !wp_verify_nonce( $_POST[ 'edit_podcast_form_submitted' ], 'edit_podcast_form' ) ) {
            $can_edit = FALSE;
            $msg = __( "You are trying to cheat, huh? That's bad idea.", "kazaz" );
        }

        if( $can_edit ) {
            // everything is all right, let's make the edit form show up

            $podcast_obj = get_post( $q_id );
            $podcast_markdown = get_post_meta( $q_id, 'markdown_text', true );
        ?>

            <form id="podcast-edit" class="qanda-form" method="post" action="">

            <div class="form-loader"><p><?php _e( "Processing...", "kazaz" ); ?></p></div><!-- loading animation -->
            <div class="form-cover"></div><!-- form cover -->

            <!-- post title -->
            <p class="form-block">
            <label for="podcast-title"><?php _e( "Podcast", "kazaz" ); ?> (<span id="count-title"><?php of_get_option( 'k_answer_cont_chars_max' ); ?></span>)</label>
            <input type="text" id="podcast-title" name="podcast-title" autocomplete="off" value="<?php echo $podcast_obj->post_title; ?>" />
            <span class="form-tip"><?php printf( __( 'Podcast is mandatory (between %1$s and %2$s characters)!', "kazaz" ), of_get_option( 'k_podcast_chars_min' ), of_get_option( 'k_podcast_chars_max' ) ); ?></span>
            <span id="tip-podcast-title" class="form-tip tip-error"><?php printf( __( 'ERROR: Podcast should be at least %1$s and max %2$s characters long!', 'kazaz' ), of_get_option( 'k_podcast_chars_min' ), of_get_option( 'k_podcast_chars_max' ) ); ?></span>
            </p>
            <!-- end post title -->

            <!-- post content -->
            <div class="form-block">
                <label for="wmd-input"><?php _e( "Content", "kazaz" ); ?> (<span id="count-body"><?php echo of_get_option( 'k_answer_cont_chars_max' ); ?></span>)</label>
                <div class="wmd-panel">
                    <div id="wmd-button-bar"></div>
                    <textarea class="wmd-input" id="wmd-input"><?php echo $podcast_markdown; ?></textarea>
                    <span class="form-tip"><?php printf( __( 'Content is mandatory (between %1$s and %2$s characters)!', "kazaz" ), of_get_option( 'k_answer_cont_chars_min' ), of_get_option( 'k_answer_cont_chars_max' ) ); ?></span>
                    <span id="tip-podcast-content" class="form-tip tip-error"><?php printf( __( 'ERROR: Content should be at least %1$s and max %2$s characters long!', 'kazaz' ), of_get_option( 'k_podcast_cont_chars_min' ), of_get_option( 'k_podcast_cont_chars_max' ) ); ?></span>
                    <p class="wmd-preview-title"><?php _e( "Content Preview:", "kazaz" ); ?></p>
                    <div id="wmd-preview" class="wmd-panel wmd-preview"></div>
                </div>
            </div>
            <!-- end post content -->

            <!-- post tags -->
            <?php
            if( of_get_option( 'enable_podcast_tags' ) ) :

                $entry_terms_list = '';
                $entry_terms = wp_get_object_terms( $q_id, 'podcast_tags' );
                if( !empty( $entry_terms ) ) {
                    if( !is_wp_error( $entry_terms ) ) {
                        foreach( $entry_terms as $term ) {
                            $entry_terms_list .= $term->name . ', ';
                        }
                        $entry_terms_list = rtrim( $entry_terms_list, ', ' );
                    }
                }
            ?>
            <p class="form-block">
            <label for="podcast-tags"><?php _e( "Podcast Tags", "kazaz" ); ?> (<span id="count-tags"><?php of_get_option( 'k_podcast_tags_chars_max' ); ?></span>)</label>
            <input type="text" id="podcast-tags" name="podcast-tags" autocomplete="off" value="<?php echo $entry_terms_list; ?>" />
            <span class="form-tip"><?php _e( "Comma separated keywords, for example: lorem, ipsum, dolor", "kazaz" ); ?></span>
            <span id="tip-podcast-tags" class="form-tip tip-error"><?php printf( __( 'ERROR: Tags shouldn\'t exceed %1$s characters in total!', 'kazaz' ), of_get_option( 'k_podcast_tags_chars_max' ) ); ?></span>
            </p>
            <?php endif; ?>
            <!-- end post tags -->

            <!-- post category -->
            <p class="form-block">
            <label for="podcast-category"><?php _e( "Publish in", "kazaz" ); ?></label>
            <?php
            $arr_term_ids = array();
            $entry_termz = get_the_terms( $q_id, 'podcast_category' );
            foreach( $entry_termz as $term ) { array_push( $arr_term_ids, $term->term_id ); }
            echo k_categories_dropdown( 'podcast_category', $arr_term_ids[ 0 ] );
            ?>
            <span class="form-tip"><?php _e( "Your Podcast will be published in selected category!", "kazaz" ); ?></span>
            </p>
            <!-- end post category -->

            <!-- publish content -->
            <p class="form-block form-block-mcut">
            <input type="hidden" id="podcast-id" name="podcast-id" value="<?php echo $q_id; ?>" />
            <input type="submit" id="podcast-submit" class="button" name="podcast-submit" value="<?php _e( "Submit Podcast", "kazaz" ); ?>">
            </p>
            <!-- end publish content -->

            </form>

            <div id="answer-messages">

                <div class="form-message-ok alertyellow">
                    <p><?php _e( "Your Podcast has been saved successfully!<br />Right now redirecting to Podcast details page...", "kazaz" ); ?></p>
                </div>
                <div class="form-message-error alertred">
                    <p><?php _e( "Your Podcast can not be saved, server responded with error! Sorry for any inconvenience and please try again later.<br />Thanks for understanding!", "kazaz" ); ?></p>
                </div>

            </div>

        <?php
        } else {
        ?>
        <div class="alertred">
            <p>
                <?php echo $msg; ?>
            </p>
        </div>
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