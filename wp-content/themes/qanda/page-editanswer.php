<?php
/**
 * Template Name: Edit Answer Page
*/
// load header
get_header();

global $current_user;
get_currentuserinfo();

$msg = '';
$can_edit = TRUE;
if( !(int)$_POST[ 'aid' ] || !(int)$_POST[ 'aaid' ] || !(int)$_POST[ 'qid' ] ) {
	$can_edit = FALSE;
	$msg = __( "You are trying to cheat, huh? That's bad idea.", "kazaz" );
} else {
	$q_id = (int)$_POST[ 'qid' ];
	$a_id = (int)$_POST[ 'aid' ];
	$a_author_id = (int)$_POST[ 'aaid' ];
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
			$msg = __( "You are not signed in and thus not allowed to edit Comment. Please sign in or create an account then get back.", "kazaz" );
		} elseif( is_user_logged_in() && ( (int)$current_user->ID !== $a_author_id ) ) {
			if( current_user_can( 'administrator' ) ) $can_edit = TRUE;
			else $can_edit = FALSE;
			$msg = __( "You are not allowed to EDIT this Comment, you are not the author.", "kazaz" );
		} elseif( !wp_verify_nonce( $_POST[ 'edit_answer_form_submitted-' . $a_id ], 'edit_answer_form' ) ) {
			$can_edit = FALSE;
			$msg = __( "You are trying to cheat, huh? That's bad idea.", "kazaz" );
		}

		if( $can_edit ) {
			// everything is all right, let's make the edit form show up

			$answer_markdown = get_comment_meta( $a_id, 'markdown_text', true );
		?>

            <form id="answer-edit" class="qanda-form" method="post" action="">

            <div class="form-loader"><p><?php _e( "Processing...", "kazaz" ); ?></p></div><!-- loading animation -->
            <div class="form-cover"></div><!-- form cover -->

            <!-- post title -->

            <!-- end post title -->

            <!-- post content -->
            <div class="form-block">
                <label for="wmd-input"><?php _e( "Content", "kazaz" ); ?> (<span id="count-body"><?php echo of_get_option( 'k_answer_cont_chars_max' ); ?></span>)</label>
                <div class="wmd-panel">
                    <div id="wmd-button-bar"></div>
                    <textarea class="wmd-input" id="wmd-input" data-aid="<?php echo $a_id; ?>" data-qid="<?php echo $q_id; ?>"><?php echo $answer_markdown; ?></textarea>
                    <span class="form-tip"><?php printf( __( 'Content is mandatory (between %1$s and %2$s characters)!', "kazaz" ), of_get_option( 'k_answer_cont_chars_min' ), of_get_option( 'k_answer_cont_chars_max' ) ); ?></span>
                    <span id="tip-podcast-content" class="form-tip tip-error"><?php printf( __( 'ERROR: Content should be at least %1$s and max %2$s characters long!', 'kazaz' ), of_get_option( 'k_podcast_cont_chars_min' ), of_get_option( 'k_podcast_cont_chars_max' ) ); ?></span>
                    <p class="wmd-preview-title"><?php _e( "Content Preview:", "kazaz" ); ?></p>
                    <div id="wmd-preview" class="wmd-panel wmd-preview"></div>
                </div>
            </div>
            <!-- end post content -->

            <!-- publish content -->
            <p class="form-block form-block-mcut">
            <input type="submit" id="podcast-submit" class="button" name="podcast-submit" value="<?php _e( "Submit Comment", "kazaz" ); ?>">
            </p>
            <!-- end publish content -->

            </form>

            <div id="answer-messages">

                <div class="form-message-ok alertyellow">
                	<p><?php _e( "Your Comment has been saved successfully!<br />Right now redirecting to Podcast details page...", "kazaz" ); ?></p>
                </div>

                <div class="form-message-error alertred">
                	<p><?php _e( "Your Comment can not be saved, server responded with error! Sorry for any inconvenience and please try again later.<br />Thanks for understanding!", "kazaz" ); ?></p>
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