<?php get_header(); ?>

    <div class="articles-wrap twelve columns alpha"><!-- articles wrapper -->

    <div class="page-pre-title">
	<?php echo __( "Posts tagged: #", "kazaz" ) . get_query_var( 'tag' ); ?>
    </div>

	<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( "podcast-cat" ); ?>><!-- post -->

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
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'kazaz' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                </header><!-- title end -->

                <section class="entry-content">
                	<?php
					if( has_excerpt() ) echo '<p>' . get_the_excerpt() . '</p>';
					else the_content( __( "READ ON &rarr;", "kazaz" ) );
					?>
                </section>

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

        </article><!-- post end -->

    <?php
	endwhile;
	echo kazaz_pagination();
	else :
    	echo kazaz_not_found(); // not found section
	endif;
	?>

    </div><!-- end articles wrapper -->

    <?php get_template_part( 'sidebars/sidebar-category' ); // sidebar ?>

<?php
get_footer();