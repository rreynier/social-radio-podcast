<?php
// load header
get_header();

global $current_user;
get_currentuserinfo();

if( isset( $_GET[ 'author_name' ] ) ) : $curauth = get_userdatabylogin( $author_name );
else : $curauth = get_userdata( intval( $author ) );
endif;


if( isset( $_GET[ 'show' ] ) ) : $show = esc_attr( $_GET[ 'show' ] );
else : $show = FALSE;
endif;
?>
	<div class="articles-wrap sixteen columns alpha omega"><!-- articles wrapper -->

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header>
        	<h1 class="author-login"><?php echo __( "User profile", "kazaz" ) . ': ' . $curauth->user_login; ?></h1>
        </header><!-- end article header -->

        <div class="author-info eight columns alpha">

                <?php echo get_avatar( $curauth->ID, 124, get_user_meta( $curauth->ID, 'avatar_url', true ) ); ?>

                <span class="meta-row-wrap">
                	<span class="meta-box"><?php echo __( "registered", "kazaz" ) . ': '; ?></span>
                    <span class="meta-info"><?php echo date( get_option( 'date_format' ), strtotime( $curauth->user_registered ) ); ?></span>
                </span>
                <span class="meta-row-wrap">
                	<span class="meta-box"><?php echo __( "website", "kazaz" ) . ': '; ?></span>
                    <?php
					// echo $curauth->user_url; // the most probably this is WordPress bug!!! returned value is empty string
					// another method...
					$user_url_by_meta = get_user_meta( $curauth->ID, 'user_url', true );
					if( $user_url_by_meta != '' ) {
					?>
                    <span class="meta-info">
                    <a href="<?php echo $user_url_by_meta; ?>" target="_blank" title="<?php echo preg_replace( "(https?://)", "", $user_url_by_meta ); ?>"><?php _e( "VISIT", "kazaz" ); ?></a>
                    </span>
                    <?php } ?>
                </span>
                <span class="meta-row-wrap">
                	<span class="meta-box"><?php echo __( "loaction", "kazaz" ) . ': '; ?></span>
                    <span class="meta-info"><?php echo $curauth->location; ?></span>
                </span>
                <span class="meta-row-wrap">
                	<span class="meta-box"><?php echo __( "age", "kazaz" ) . ': '; ?></span>
                    <span class="meta-info"><?php echo $curauth->age; ?></span>
                </span>

                <?php if( $curauth->ID == $current_user->ID ) : ?>
                <div class="meta-profile-button">
                	<a href="<?php echo get_permalink( of_get_option( 'k_profile_edit_page' ) ); ?>" rel="nofollow"><?php echo __( "EDIT PROFILE", "kazaz" ); ?></a>
                </div>
                <?php endif; ?>

        </div>

        <div class="author-about eight columns omega">

                <div class="author-about-title"><h5><?php echo __( "About", "kazaz" ) . ' ' . $curauth->user_firstname . ' ' . $curauth->user_lastname; ?></h5></div>
                <div class="author-about-text"><?php echo $curauth->user_description; ?></div>

        </div>

        <table class="author-numbers">
            <tr>
                <td id="author-reputation" class="number-box bord-right">
                    <span class="number-box-tag"><?php _e( "reputation", "kazaz" ); ?></span>
                    <span class="number-box-data"><?php echo k_get_user_reputation_score( $curauth->ID ); ?></span>
                </td>

                <td id="author-podcasts" class="number-box bord-right">
                    <span class="number-box-tag"><a href="<?php echo add_query_arg( 'show', 'podcasts' ); ?>" title="<?php printf(  __( "Show all Podcasts by %s", "kazaz" ), $curauth->user_login ); ?>">
						<?php _e( "podcasts", "kazaz" ); ?>
                    </a></span>
                    <span class="number-box-data"><?php echo k_get_user_podcasts_count( $curauth->ID ); ?></span>
                </td>

                <td id="author-answers" class="number-box bord-right">
                    <span class="number-box-tag"><a href="<?php echo add_query_arg( 'show', 'answers' ); ?>" title="<?php printf(  __( "Show all Answers by %s", "kazaz" ), $curauth->user_login ); ?>">
						<?php _e( "comments", "kazaz" ); ?>
                    </a></span>
                    <span class="number-box-data"><?php echo k_get_user_comments_count( $curauth->ID ); ?></span>
                </td>

                <td id="author-favourites" class="number-box">
                    <span class="number-box-tag"><a href="<?php echo add_query_arg( 'show', 'favourites' ); ?>" title="<?php printf(  __( "Show all Favourites by %s", "kazaz" ), $curauth->user_login ); ?>">
						<?php _e( "favourites", "kazaz" ); ?>
                    </a></span>
                    <span class="number-box-data"><?php echo k_get_user_favourites_count( $curauth->ID ); ?></span>
                </td>
            </tr>
         </table>

        <?php
		// are there any query strings
		if( $show == 'podcasts' || $show == 'answers' || $show == 'favourites' || !$show ) {
		?>

        <div id="author-activity">

        	<?php
			if( $show == 'podcasts' || !$show ) {

				$sofa_query_args = array(
					'post_type' => 'podcast',
					'post_status' => 'publish',
					'nopaging' => true,
					'posts_per_page' => -1,
					'author' => $curauth->ID
				);

				$sofa_loop = new WP_Query( $sofa_query_args );
				// preserve original query
				$TEMP_query = $wp_query;
				$wp_query = NULL;
				$wp_query = $sofa_loop;

				if( have_posts() ) :
				echo '<h3 class="aa-title">' . __( "Podcasts", "kazaz" ) . '</h3>';
				while( have_posts() ) : the_post();

					$q_votes = (int)get_post_meta( get_the_ID(), 'votes', true );
					$q_answers = (int)k_count_answers( get_the_ID() );
					$q_faves = (int)get_post_meta( get_the_ID(), 'faves', true );
					$q_views = (int)get_post_meta( get_the_ID(), 'views', true );
					// corresponding classes
					$faved_class = 'no';
					if( $q_faves ) $faved_class = 'yes';
			?>

            <div class="author-all-podcasts clearfix">

            	<div class="four columns alpha">
                    <div class="aaq-info w-53 bord-right aaq-votes" title="<?php _e( "Number of Votes", "kazaz" ); ?>"><?php echo k_round_large( $q_votes ); ?></div>
                    <div class="aaq-info w-53 bord-right aaq-answers" title="<?php _e( "Number of Answers", "kazaz" ); ?>"><?php echo k_round_large( $q_answers ); ?></div>
                    <div class="aaq-info w-53 bord-right aaq-faves-<?php echo $faved_class; ?>" title="<?php _e( "Number of times saved as a Favourite Podcast", "kazaz" ); ?>"><?php echo k_round_large( $q_faves ); ?></div>
                    <div class="aaq-info w-53 bord-right aaq-views" title="<?php _e( "Number of this Podcast views", "kazaz" ); ?>"><?php echo k_round_large( $q_views ); ?></div>
                </div>

                <div class="twelve columns omega">
                    <h5 class="aaq-podcast-title">
                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( "Permalink to %s", "kazaz" ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                            <?php the_title(); ?>
                        </a>
                    </h5>
                    <span class="aaq-podcast-meta">
                    <?php printf( __( 'posted: <span class="elapsed">%1$s</span> in %2$s', 'kazaz' ), get_the_date(), get_the_term_list( get_the_ID(), 'podcast_category', '', ', ', '' ) ); ?>
                    </span>
                </div>

            </div>

            <?php
				endwhile;
				else :
				echo '<p>' . __( "No Podcasts found!", "kazaz" ) . '</p>';
				endif;
				$wp_query = $TEMP_query;
				wp_reset_query();

			} elseif( $_GET[ 'show' ] == 'answers' ) {

                global $wpdb;
				$query_table = "SELECT comment_post_ID FROM {$wpdb->prefix}comments WHERE comment_parent = 0 AND comment_approved = 1 AND user_id = $curauth->ID";
				$q_res = $wpdb->get_col( $query_table );

				if( $q_res != NULL ) {
					$q_res_str = implode( ',', $q_res );
					$q_res_arr = json_decode( '[' . $q_res_str . ']', true );
					$q_res_counts_array_dupes = array_count_values( $q_res_arr ); // any duplicates? User has answered more than once!

					$sofa_query_args = array(
						'post_type' => 'podcast',
						'post_status' => 'publish',
						'nopaging' => true,
						'posts_per_page' => -1,
						'post__in' => $q_res_arr,
						'post_author' => $curauth->ID
					);

					$sofa_loop = new WP_Query( $sofa_query_args );
					// preserve original query
					$TEMP_query = $wp_query;
					$wp_query = NULL;
					$wp_query = $sofa_loop;

					if( have_posts() ) :
					echo '<h3 class="aa-title">' . __( "Answers", "kazaz" ) . '</h3>';
					while( have_posts() ) : the_post();

						$q_votes = (int)get_post_meta( get_the_ID(), 'votes', true );
						$q_status = get_post_meta( get_the_ID(), 'status', true );
						$my_title = ( $q_status == 'open' ) ? __( "Status: opened", "kazaz" ) : __( "Status: closed!", "kazaz" );
                ?>

                        <div class="author-all-podcasts clearfix">

                            <div class="two columns alpha">
                                <div class="aaq-info w-48 bord-right aaq-votes" title="<?php _e( "Number of votes for this very Answer!", "kazaz" ); ?>"><?php echo k_round_large( $q_votes ); ?></div>
                                <div class="aaq-info w-48 bord-right aaq-status-<?php echo $q_status; ?>" title="<?php echo $my_title; ?>">&nbsp;</div>
                            </div>

                            <div class="fourteen columns omega">
                                <h5 class="aaq-podcast-title">
                                    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( "Permalink to %s", "kazaz" ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                                        <?php echo esc_attr( get_the_title() ) . ' <sup>[ ' . $q_res_counts_array_dupes[ get_the_ID() ] . ' ]</sup>'; ?>
                                    </a>
                                </h5>
                                <span class="aaq-podcast-meta">
                                <?php printf( __( 'posted: <span class="elapsed">%1$s</span> in %2$s', 'kazaz' ), get_the_date(), get_the_term_list( get_the_ID(), 'podcast_category', '', ', ', '' ) ); ?>
                                </span>
                            </div>

                        </div>

            <?php
					endwhile;
					else :
					echo '<p>' . __( "No Answers found!", "kazaz" ) . '</p>';
					endif;
					$wp_query = $TEMP_query;
					wp_reset_query();

				} else {
					echo '<p>' . __( "No Answers found!", "kazaz" ) . '</p>';
				}

			} elseif( $_GET[ 'show' ] == 'favourites' ) {

				// get all faves for  this user first
				$msg = '';
				$faves_arr = array();

				global $wpdb;
				$query_table = "SELECT faves FROM {$wpdb->prefix}user_activity WHERE user_id = $curauth->ID";
				$q_res = $wpdb->get_var( $query_table );

				if( $q_res != NULL && $q_res != '' ) {
					$faves_arr = array();
					$faves_arr = json_decode( '[' . $q_res . ']', true ); // fast convert to integers

					$sofa_query_args = array(
						'post_type' => 'podcast',
						'post_status' => 'publish',
						'nopaging' => true,
						'posts_per_page' => -1,
						'post__in' => $faves_arr,
						'user_id' => $curauth->ID
					);

					$sofa_loop = new WP_Query( $sofa_query_args );
					// preserve original query
					$TEMP_query = $wp_query;
					$wp_query = NULL;
					$wp_query = $sofa_loop;

					if( have_posts() ) :
					echo '<h3 class="aa-title">' . __( "Favourites", "kazaz" ) . '</h3>';
					while( have_posts() ) : the_post();

						$q_faves = (int)get_post_meta( get_the_ID(), 'faves', true );
						// switch class
						$column_class_first = 'two columns';
						$column_class_second = 'fourteen columns';
						if( $curauth->ID != $current_user->ID ) {
							$column_class_first = 'one column';
							$column_class_second = 'fifteen columns';
						}
			?>

                        <div id="fave-row-<?php the_ID(); ?>" class="author-all-podcasts clearfix">

                            <div class="<?php echo $column_class_first; ?> alpha">
                                <div class="aaq-info w-48 bord-right aaq-faves-yes" title="<?php _e( "Number of times saved as a Favourite Podcast", "kazaz" ); ?>"><?php echo k_round_large( $q_faves ); ?></div>
                                <?php if( $curauth->ID == $current_user->ID ) : ?>
                                <div class="aaq-info w-48 bord-right aaq-remove-fave rf-<?php the_ID(); ?>">
                                	<a href="javascript:void(0);" class="q-remove-fave" data-id="<?php the_ID(); ?>" data-action="remove" rel="nofollow" title="<?php _e( "Remove from Favourites?", "kazaz" ); ?>">&nbsp;</a>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="<?php echo $column_class_second; ?> omega">
                                <h5 class="aaq-podcast-title">
                                    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( "Permalink to %s", "kazaz" ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>
                                <span class="aaq-podcast-meta">
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
                                </span>
                            </div>

                        </div>

            <?php
					endwhile;
					else :
					echo '<p>' . __( "No Favourites found!", "kazaz" ) . '</p>';
					endif;
					$wp_query = $TEMP_query;
					wp_reset_query();

				} else {
					echo '<p>' . __( "No Favourites found!", "kazaz" ) . '</p>';
				}
		 } ?>

        </div>

		<?php } ?>

    </article> <!-- end article -->

    <?php kazaz_not_found(); // not found section ?>

    <div id="showLean" class="lean-alert">
        <span class="lean-close">&times;</span>
        <span class="lean-title"><?php _e( "Notice!", "kazaz" ); ?></span>
        <p class="lean-msg">...</p>
    </div>
    <a href="#showLean" id="show-lean-modal" style="display: none;" data-rel="leanModal" name="showLean"></a>

    </div><!-- end articles wrapper -->

<?php
get_footer();