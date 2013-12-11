<?php
// load header
get_header();
?>
	<div class="articles-wrap twelve columns alpha"><!-- articles wrapper -->

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

        <section class="meta-data two columns alpha"><!-- post meta -->

            <div class="meta-date">
                <?php the_time( "d/m/y" ); ?>
            </div>

            <div class="meta-comments">
                <?php comments_popup_link( __( "0", "kazaz" ), __( "1", "kazaz" ), __( "%", "kazaz" ) ); ?>
            </div>

            <div class="meta-category">
                <?php the_category( ' ' ); ?>
            </div>

        </section><!-- end post meta -->

        <section class="true-content ten columns omega"><!-- post content -->

            <header><!-- title -->
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header><!-- title end -->

			<?php
            if( has_post_thumbnail( get_the_ID() ) ) {
                $post_thumb = get_the_post_thumbnail( get_the_ID(), 'large' );
                $featured_image_id = get_post_thumbnail_id();
                $large_image_url = wp_get_attachment_image_src( $featured_image_id, 'full' );
                $post_thumb_big = $large_image_url[ 0 ];
            ?>
                <figure class="clearfix"><!-- featured image -->
                    <a href="<?php echo $post_thumb_big; ?>" title="<?php the_title(); ?>"><?php echo $post_thumb; ?></a>
                </figure><!-- end featured image -->
            <?php } ?>

            <section class="entry-content"><!-- content -->
                <?php the_content(); ?>
            </section><!-- end content -->

            <?php
            $tags_list = get_the_tag_list( '<ul class="entry-tags"><li class="podcast-tag">','</li><li class="podcast-tag">','</li></ul>' );
            if( $tags_list ) :
            ?>
            <section class="entry-meta-box">
                <div class="entry-tags-wrap">
                    <?php echo $tags_list; ?>
                </div>
            </section>
            <?php endif; ?>

        </section><!-- end post content -->

    </article> <!-- end article -->

    <?php
	comments_template( '', true ); // comments
	endwhile;
	else :
	?>

    <?php kazaz_not_found(); // not found section ?>

    <?php endif; ?>

    </div><!-- end articles wrapper -->

    <?php get_template_part( 'sidebars/sidebar-single' ); // sidebar ?>

<?php
get_footer();