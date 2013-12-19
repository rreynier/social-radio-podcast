<?php get_header(); ?>

    <?php
    $current_tax = get_query_var( 'podcast_category' );

    if( get_query_var( 'paged' ) ) $paged = get_query_var( 'paged' );
    elseif( get_query_var( 'page' ) ) $paged = get_query_var( 'page' );
    else $paged = 1;

    $sofa_query_args = array(
        'podcast_category' => $current_tax,
        'post_type' => 'podcast',
        'post_status' => 'publish',
        'paged' => $paged
    );

    $sofa_loop = new WP_Query( $sofa_query_args );
    // preserve original query
    $TEMP_query = $wp_query;
    $wp_query = NULL;
    $wp_query = $sofa_loop;
    ?>

    <div class="articles-wrap twelve columns alpha"><!-- articles wrapper -->

    <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( "podcast-cat" ); ?>><!-- post -->

            <section class="meta-data two columns alpha"><!-- post meta -->

                <div class="meta-answers" title="<?php _e( "Number of Answers", "kazaz" ); ?>">
                    <?php echo k_count_answers( get_the_ID() ); ?>
                </div>

                <div class="meta-votes" title="<?php _e( "Number of Votes", "kazaz" ); ?>">
                    <?php
                    $votes = get_post_meta( get_the_ID(), 'votes', true );
                    echo k_round_large( $votes );
                    ?>
                </div>

                <div class="meta-views" title="<?php _e( "Number of this Podcast views", "kazaz" ); ?>">
                    <?php
                    $views = get_post_meta( get_the_ID(), 'views', true );
                    echo k_round_large( $views );
                    ?>
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

                <?php if( of_get_option( 'show_podcast_summary' ) ) { ?>
                    <section class="entry-content">
                        <?php
                        $allowed_tags = array();
                        $cont = wp_kses( get_the_content(), $allowed_tags );
                        echo '<p>' . k_html_truncate( (int)of_get_option( 'podcast_summary_chars' ), $cont ) . '...</p>';
                        ?>
                    </section>
                <?php } ?>

                <div class="entry-time-author">
                    <?php k_time2string(); ?>
                </div>

                <?php
                $tags_list = get_the_term_list( get_the_ID(), 'podcast_tags', '<li class="podcast-tag">', '</li><li class="podcast-tag">', '</li>' );
                if( $tags_list ) echo '<div class="entry-tags-wrap"><ul class="entry-tags">' . $tags_list . '</ul></div>';
                ?>

                <?php
                // find out post status: open or closed (unaccepted or accepted)
                $this_status = get_post_meta( get_the_ID(), 'status', true );
                $my_class = ( $this_status == 'open' ) ? ' status-open' : ' status-closed';
                $my_title = ( $this_status == 'open' ) ? __( "Status: opened", "kazaz" ) : __( "Status: closed!", "kazaz" );
                ?>
                <!-- <div class="entry-status<?php echo $my_class; ?>" title="<?php echo $my_title; ?>"></div> -->

            </section><!-- end post content -->

        </article><!-- post end -->

    <?php
    endwhile;
    echo kazaz_pagination();
    $wp_query = $TEMP_query;
    ?>

    <?php else : ?>

    <?php echo kazaz_not_found(); // not found section ?>

    <?php
    endif;
    wp_reset_query();
    ?>

    </div><!-- end articles wrapper -->

    <?php get_template_part( 'sidebars/sidebar-podcast_category' ); // sidebar ?>

<?php
get_footer();