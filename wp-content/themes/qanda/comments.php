<!-- comments block start -->
<div id="commentswrapper">

<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e( "This post is password protected. Enter the password to view comments.", "kazaz" ); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php
if( !is_singular( 'podcast' ) ) :
	if( have_comments() ) { ?>

        <h3 id="commenttitle" class="main inset-line clearfix"><?php _e( "Users feedback", "kazaz" ); ?> ( <?php comments_number( '0', '1', '%' ); ?> )</h3>

		<ol class="commentlist" id="comments">
				<?php wp_list_comments( 'callback=kazaz_comment' ); ?>
		</ol>

		<div class="clearfix"><div><?php paginate_comments_links( array( 'prev_text' => __( "Previous", "kazaz" ), 'next_text' => __( "Next", "kazaz" ) ) ); ?></div></div>

<?php } else { // this is displayed if there are no comments so far ?>

<?php if( !comments_open() && !is_page() ) { ?>

		<p class="nocomments"><?php _e( "Comments are closed!", "kazaz" ); ?></p>

<?php } // end ! comments_open() ?>

<?php } // end have_comments() ?>

<?php
$fields = array(
		'author' => '<dl class="comment-form-author clearfix">' .
		'<dt><label for="author">' . __( "* Name", "kazaz" ) . '</label></dt><dd><input class="inputfield" id="author" name="author" type="text" value="' . esc_attr( $commenter[ 'comment_author' ] ) . '" tabindex="111" /></dd></dl>',
		'email'  => '<dl class="comment-form-email clearfix">' .
		'<dt><label for="email">' . __( "* E-mail", "kazaz" ) . '</label></dt><dd><input class="inputfield" id="email" name="email" type="text" value="' . esc_attr( $commenter[ 'comment_author_email' ] ) . '" tabindex="112" /></dd></dl>',
		'url'    => '<dl class="comment-form-url clearfix">' .
		'<dt><label for="url">' . __( "Website", "kazaz" ) . '</label></dt><dd><input class="inputfield" id="url" name="url" type="text" value="' . esc_attr( $commenter[ 'comment_author_url' ] ) . '" tabindex="113" /></dd></dl>',
		);
$args = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_notes_before' => '',
		'comment_field'        => '<dl class="comment-form-comment clearfix"><dt><label for="comment">' .
		 __( "* YOUR COMMENT", "kazaz" ) . '</label></dt><dd><textarea aria-required="true" rows="10" name="comment" id="comment" tabindex="114"></textarea></dd></dl>',
		'comment_notes_after'  => '',
		'title_reply'          => __( "Share your opinion", "kazaz" ),
		'title_reply_to'       => __( "Comment", "kazaz" ),
		'cancel_reply_link'    => __( "Cancel", "kazaz" ),
		'label_submit'         => __( "POST COMMENT", "kazaz" )
		);

comment_form( $args );

else :

global $post;
// we are dealing with Podcast comments...
if( have_comments() ) { ?>

    <h2 id="commenttitle" class="main inset-line clearfix">
	<?php _e( "Comments", "kazaz" ); ?> ( <?php echo k_count_answers( $post->ID ); ?> )
    </h2>

    <ol class="commentlist" id="comments">
            <?php wp_list_comments( 'callback=k_podcast_comment' ); ?>
    </ol>

    <div class="clearfix"><div><?php paginate_comments_links( array( 'prev_text' => __( "Previous", "kazaz" ), 'next_text' => __( "Next", "kazaz" ) ) ); ?></div></div>

<?php } else { // this is displayed if there are no comments so far ?>

<?php if( !comments_open() ) { ?>

        <p class="nocomments"><?php _e( "Comments are closed!", "kazaz" ); ?></p>

<?php } // end ! comments_open()

} // end have_comments()

if( is_user_logged_in() ) {
	$fields = array();

	global $comment;
	$field_comment = '
	<dl class="answer-form-comment clearfix">
	<dt><label for="wmd-input">' . __( "Content", "kazaz" ) . ' (<span id="count-body">' . of_get_option( 'k_answer_cont_chars_max' ) . '</span>)</label></dt>
	<dd>
	<div class="wmd-panel">
	<div id="wmd-button-bar"></div>
	<textarea class="wmd-input" id="wmd-input" data-qid="' . $post->ID . '"></textarea>
	<span class="form-tip">' . sprintf ( __( 'Content is mandatory (between %1$s and %2$s characters)!', "kazaz" ), of_get_option( 'k_answer_cont_chars_min' ), of_get_option( 'k_answer_cont_chars_max' ) ) . '</span>
	<span id="tip-podcast-content" class="form-tip tip-error">' . sprintf( __( 'ERROR: Content should be at least %1$s and max %2$s characters long!', 'kazaz' ), of_get_option( 'k_answer_cont_chars_min' ), of_get_option( 'k_answer_cont_chars_max' ) ) . '</span>
	<p class="wmd-preview-title">' . __( "Content Preview:", "kazaz" ) . '</p>
	<div id="wmd-preview" class="wmd-panel wmd-preview"></div>
	</div>
	</dd>
	</dl>
	';
	$args = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_notes_before' => '',
			'comment_field'        => $field_comment,
			'comment_notes_after'  => '<div class="form-loader"><p>' . __( "Processing...", "kazaz" ) . '</p></div><div class="form-cover"></div>',
			'logged_in_as'         => '',
			'id_form'              => 'answerform',
			'title_reply'          => __( "Answer the Podcast", "kazaz" ),
			'title_reply_to'       => __( "Answer", "kazaz" ),
			'cancel_reply_link'    => __( "Cancel", "kazaz" ),
			'label_submit'         => __( "POST ANSWER", "kazaz" )
		);

	comment_form( $args );

} else { ?>

	<div class="alertred"><p class="force-user-login-msg"><?php _e( "You must be signed in if you want to answer the podcast!", "kazaz" ); ?></p></div>

<?php
}

endif; // end if not singular podcast
?>

</div>

<!-- comments block end -->