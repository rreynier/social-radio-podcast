<?php
/* Podcast - custom post type single template */

// posts view via cookies must be set before header sent
$qid = $wp_query->posts[ 0 ]->ID; // post ID
k_update_podcast_views( $qid ); // update page views meta

// load header
get_header();

global $current_user;
get_currentuserinfo();
?>

<div class="articles-wrap twelve columns alpha"><!-- articles wrapper -->

<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

        <section class="meta-data two columns alpha"><!-- post meta -->

            <div class="meta-pro">
                <?php if( is_user_logged_in() ) { ?>
                    <a href="javascript:void(0);" class="vote-pro jq-hover q-vote" data-action="pro" data-id="<?php the_ID(); ?>" data-author="<?php the_author_meta( 'ID' ); ?>" title="<?php _e( "This Podcast is useful, vote PRO for it!", "kazaz" ); ?>"></a>
                <?php } else { ?>
                    <a href="javascript:void(0);" class="vote-pro q-alien" title="<?php _e( "You are not allowed to vote, sign in first!", "kazaz" ); ?>"></a>
                <?php } ?>
            </div>

            <div class="meta-votes-single" title="<?php _e( "Number of Votes", "kazaz" ); ?>">
                <?php
                $votes = get_post_meta( get_the_ID(), 'votes', true );
                echo k_round_large( $votes );
                ?>
            </div>

            <div class="meta-con">
                <?php if( is_user_logged_in() ) { ?>
                    <a href="javascript:void(0);" class="vote-con jq-hover q-vote" data-action="con" data-id="<?php the_ID(); ?>" data-author="<?php the_author_meta( 'ID' ); ?>" title="<?php _e( "This Podcast is not useful or is unclear, vote CON for it!", "kazaz" ); ?>"></a>
                <?php } else { ?>
                    <a href="javascript:void(0);" class="vote-con q-alien" title="<?php _e( "You are not allowed to vote, sign in first!", "kazaz" ); ?>"></a>
                <?php } ?>
            </div>

            <div class="meta-faved" title="<?php _e( "Number of times saved as a Favourite Podcast", "kazaz" ); ?>">
                <?php
                if( k_fave_exists( get_the_ID(), $current_user->ID ) ) {
                    $fave_class = 'q-in-faves';
                    $title_msg = __( "This Podcast is already saved in your Favourites!", "kazaz" );
                } else {
                    $fave_class = 'add-to-faves jq-hover q-add-to-faves';
                    $title_msg = __( "Add this Podcast to your favourites!", "kazaz" );
                }
                if( is_user_logged_in() ) {
                ?>
                    <a href="javascript:void(0);" class="<?php echo $fave_class; ?>" data-id="<?php the_ID(); ?>" data-action="add" title="<?php echo $title_msg; ?>">
                <?php } else { ?>
                    <a href="javascript:void(0);" class="add-to-faves q-alien" title="<?php _e( "You are not allowed to save to Favourites, sign in first", "kazaz" ); ?>">
                <?php } ?>
                    <?php
                    $faves = get_post_meta( get_the_ID(), 'faves', true );
                    if( $faves != '' ) echo '<span id="times-faved">' . get_post_meta( get_the_ID(), 'faves', true ) . '</span>';
                    else echo '<span id="times-faved">0</span>';
                    ?>
                </a>
            </div>

        </section><!-- end post meta -->

        <section class="true-content ten columns omega"><!-- post content -->

            <header><!-- title -->
                <h1><?php the_title(); ?></h1>
            </header><!-- title end -->

            <section class="entry-content"><!-- content -->
                <?php the_content();?>
            </section><!-- end content -->

            <section class="entry-meta-box"><!-- post meta box -->

                <div class="entry-time-author">
                    <?php
                    printf(
                    __( 'posted: <span class="elapsed">%1$s</span> by <a href="%2$s" title="%3$s">%3$s</a> [ <span class="rep-score" title="%6$s">%5$s</span> ] in %4$s', 'kazaz' ),
                    get_the_date(),
                    esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ),
                    get_the_author(),
                    get_the_term_list( get_the_ID(), 'podcast_category', '', ', ', '' ),
                    k_get_user_reputation_score( get_the_author_meta( "ID" ) ),
                    __( "User reputation score", "kazaz" )
                    );
                    ?>
                </div>

                <?php
                $tags_list = get_the_term_list( get_the_ID(), 'podcast_tags', '<li class="podcast-tag">', '</li><li class="podcast-tag">', '</li>' );
                if( $tags_list ) echo '<div class="entry-tags-wrap"><ul class="entry-tags">' . $tags_list . '</ul></div>';
                ?>

                <?php
                // if podcast author is logged in show up edit link
                if( is_user_logged_in() && ( $current_user->ID == get_the_author_meta( 'ID' ) || current_user_can( 'administrator' ) ) ) {
                    $edit_page_id = (int)of_get_option( 'k_podcast_edit_page' );
                    $edit_podcast_perma = get_permalink( $edit_page_id );
                ?>
                <div class="entry-edit">
                <form id="podcast-edit-form" class="mini-form" method="post" action="<?php echo $edit_podcast_perma; ?>">
                    <?php wp_nonce_field( 'edit_podcast_form', 'edit_podcast_form_submitted' ); ?>
                    <input type="hidden" id="qid" name="qid" value="<?php the_ID(); ?>" />
                    <input type="hidden" id="qaid" name="qaid" value="<?php the_author_meta( 'ID' ); ?>" />
                </form>
                <a id="submit-podcast-edit-form" href="javascript:void(0);" rel="nofollow"><?php _e( "EDIT PODCAST", "kazaz" ); ?></a>
                </div>
                <?php } ?>

                <?php
                // if is user logged in
                if( is_user_logged_in() && ( $current_user->ID != get_the_author_meta( 'ID' ) || current_user_can( 'administrator' ) ) ) {
                ?>
                <div class="entry-flag">
                <a class="k-flag-podcast" href="javascript:void(0);" rel="nofollow" data-type="podcast" data-id="<?php the_ID(); ?>" data-postid="<?php the_ID(); ?>" data-author="<?php the_author_meta( 'ID' ); ?>" title="<?php _e( "Report this Podcast as inappropriate or offensive!", "kazaz" ); ?>"><?php _e( "REPORT", "kazaz" ); ?></a>
                </div>
                <?php } ?>

            </section><!-- end post meta box -->

        </section><!-- end post content -->

    </article><!-- single-portfolio end -->

<?php
comments_template( '', true ); // comments
endwhile; // end loop
else :
kazaz_not_found();
endif;
?>

<div id="showLean" class="lean-alert">
    <span class="lean-close">&times;</span>
    <span class="lean-title"><?php _e( "Notice!", "kazaz" ); ?></span>
    <p class="lean-msg">...</p>
</div>
<a href="#showLean" id="show-lean-modal" style="display: none;" data-rel="leanModal" name="showLean"></a>

<div id="answer-messages">
    <div class="form-message-ok alertyellow">
    <p><?php _e( "Your Answer has been added successfully, thanks for participating! Now refreshing this page...", "kazaz" );?></p>
    </div>

    <div class="form-message-error alertred">
    <p><?php _e( "Your Answer can not be added, server responded with error! Sorry for any inconvenience and please try again later.<br />Thanks for understanding!", "kazaz" ); ?></p>
    </div>
</div>

</div><!-- end articles wrapper -->

<?php get_template_part( 'sidebars/sidebar-podcast' ); // sidebar ?>

<?php
get_footer();