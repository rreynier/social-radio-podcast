<?php 
/**
 * Template Name: Edit User Profile
*/

/* Get user info. */
global $current_user, $wp_roles, $allowedtags;
get_currentuserinfo();

/* Load the registration file. */
//require_once( ABSPATH . WPINC . '/registration.php' );
$error = array();    
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' && wp_verify_nonce( $_POST[ $current_user->ID . '-user-edit' ], 'edit-user-' . $current_user->ID ) ) {

    /* Update user password. */
    if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        if ( $_POST['pass1'] == $_POST['pass2'] )
            wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
        else
            $error[] = __("The passwords you entered do not match.  Your password was not updated.", "kazaz");
    }

    /* Update user information. */
    if ( !empty( $_POST['url'] ) )
        update_user_meta( $current_user->ID, 'user_url', esc_url( $_POST['url'] ) );
    if ( !empty( $_POST['email'] ) ){
        if (!is_email(esc_attr( $_POST['email'] )))
            $error[] = __("The Email you entered is not valid! Please try again.", "kazaz");
        elseif(email_exists(esc_attr( $_POST['email'] )) != $current_user->ID )
            $error[] = __("This email is already used by another user! Try a different one.", "kazaz");
        else{
            wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
        }
    }

    if ( !empty( $_POST['avatar-url'] ) )
        update_user_meta( $current_user->ID, 'avatar_url', esc_url( $_POST['avatar-url'] ) );
	if ( !empty( $_POST['first-name'] ) )
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
    if ( !empty( $_POST['last-name'] ) )
        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
    if ( !empty( $_POST['location'] ) )
        update_user_meta( $current_user->ID, 'location', esc_attr( $_POST['location'] ) );
    if ( !empty( $_POST['age'] ) )
        update_user_meta( $current_user->ID, 'age', intval( $_POST['age'] ) );
    if ( !empty( $_POST['wmd-input'] ) ) {
        update_user_meta( $current_user->ID, 'description', wp_kses( $_POST['wmd-mirror'], $allowedtags ) );
		update_user_meta( $current_user->ID, 'description_markdown', wp_kses( $_POST['wmd-input'], $allowedtags ) );
	}

    /* Redirect so the page will show updated info.*/
    if ( count( $error ) == 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $current_user->ID);
        wp_redirect( get_author_posts_url( $current_user->ID ) );
        exit;
    }
}

// load header
get_header();
?>

<div class="articles-wrap twelve columns alpha"><!-- articles wrapper -->

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
        <?php if( get_post_meta( get_the_ID(), 'show_title', true ) != 'no' ) : ?>
        
        	<header>
        		<h1><?php the_title(); ?></h1>
        	</header><!-- end article header -->
            
		<?php endif; ?>
    
        <section class="entry-content clearfix">
            <?php the_content(); ?>
        </section> <!-- end article section -->
            
		<?php if ( !is_user_logged_in() ) : ?>
        
                <div class="alertred"><p><?php _e("You must be logged in to edit your profile.", "kazaz"); ?></p></div>
                
        <?php else : ?>
        
            <?php if ( count($error) > 0 ) echo '<div class="alertred"><p>' . implode("<br />", $error) . '</p></div>'; ?>
            
            <form method="post" id="adduser" action="<?php the_permalink(); ?>">
            
                <div class="form-block six columns alpha">
                    <label for="first-name"><?php _e("First Name", "kazaz"); ?></label>
                    <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
                    <span class="form-tip"><?php _e( "Enter at will.", "kazaz" ); ?></span>
                </div>
                
                <div class="form-block six columns omega">
                    <label for="last-name"><?php _e("Last Name", "kazaz"); ?></label>
                    <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
                    <span class="form-tip"><?php _e( "Enter at will.", "kazaz" ); ?></span>
                </div>
                
                <div class="clearfix"></div>
                
                <div class="form-block six columns alpha">
                    <label for="email"><?php _e("* E-mail", "kazaz"); ?></label>
                    <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
                    <span class="form-tip"><?php _e( "E-mail is mandatory, don't leave it empty.", "kazaz" ); ?></span>
                </div>
                
                <div class="form-block six columns omega">
                    <label for="url"><?php _e("Website", "kazaz"); ?></label>
                    <input class="text-input" name="url" type="text" id="url" value="<?php echo get_user_meta( $current_user->ID, 'user_url', true ); ?>" />
                    <span class="form-tip"><?php _e( "Enter at will.", "kazaz" ); ?></span>
                </div>
                
                <div class="clearfix"></div>
                
                <div class="form-block six columns alpha">
                    <label for="location"><?php _e("Location", "kazaz"); ?></label>
                    <input class="text-input" name="location" type="text" id="location" value="<?php the_author_meta( 'location', $current_user->ID ); ?>" />
                    <span class="form-tip"><?php _e( "Enter at will.", "kazaz" ); ?></span>
                </div>
                
                <div class="form-block six columns omega">
                    <label for="age"><?php _e("Age", "kazaz"); ?></label>
                    <input class="text-input" name="age" type="text" id="age" value="<?php the_author_meta( 'age', $current_user->ID ); ?>" />
                    <span class="form-tip"><?php _e( "Enter at will, it must be a number (integer).", "kazaz" ); ?></span>
                </div>
                
                <div class="clearfix"></div>
                
                <div class="form-block six columns alpha">
                    <label for="pass1"><?php _e("* Password", "kazaz"); ?> </label>
                    <input class="text-input" name="pass1" type="password" id="pass1" />
                    <span class="form-tip"><?php _e( "Enter new password here is you like to change old one.", "kazaz" ); ?></span>
                </div>
                
                <div class="form-block six columns omega">
                    <label for="pass2"><?php _e("* Repeat Password", "kazaz"); ?></label>
                    <input class="text-input" name="pass2" type="password" id="pass2" />
                    <span class="form-tip"><?php _e( "Confirm new password by typing it once again.", "kazaz" ); ?></span>
                </div>
                
                <div class="clearfix"></div>
                
                <div class="form-block three columns alpha">
                    <?php echo get_avatar( $current_user->ID, 124, get_user_meta( $current_user->ID, 'avatar_url', true ) ); ?>
                </div>
                
                <div class="form-block nine columns omega">
                    <label for="avatar-url"><?php _e("Avatar URL", "kazaz"); ?></label>
                    <input class="text-input" name="avatar-url" type="text" id="avatar-url" value="<?php echo get_user_meta( $current_user->ID, 'avatar_url', true ); ?>" />
                    <span class="form-tip">&middot; <?php _e( "It should be at least 124px wide!", "kazaz" ); ?></span>
                    <span class="form-tip">&middot; <?php _e( "Create your own at", "kazaz" ); ?> <a href="http://www.faceyourmanga.com/" title="faceyourmanga.com" target="_blank">faceyourmanga.com</a></span>
                    <span class="form-tip">&middot; <?php _e( "Leave empty if Gravatar is preferred.", "kazaz" ); ?></span>
                </div>
                
                <div class="clearfix"></div>
                
                <div class="form-block twelve columns alpha omega">
                    <label for="wmd-input"><?php _e( "About yourself", "kazaz" ); ?></label>
                    <div class="wmd-panel">
                        <div id="wmd-button-bar"></div>
                        <textarea class="wmd-input" id="wmd-input" name="wmd-input"><?php echo get_user_meta( $current_user->ID, 'description_markdown', true ); ?></textarea>
                        <textarea id="wmd-mirror" name="wmd-mirror"><?php echo get_user_meta( $current_user->ID, 'description', true ); ?></textarea>
                        <span class="form-tip"><?php _e( "Enter at will.", "kazaz" ); ?></span>
                        <p class="wmd-preview-title"><?php _e( "Content Preview:", "kazaz" ); ?></p>
                        <div id="wmd-preview" class="wmd-panel wmd-preview"></div>
                    </div>
                </div>

                <?php 
                    //action hook for plugin and extra fields
                    //do_action('edit_user_profile', $current_user ); 
                ?>
                <div class="twelve columns alpha omega">
                    <input name="updateuser" type="submit" id="updateuser" class="button" value="<?php _e("Update", "kazaz"); ?>" />
                    <?php wp_nonce_field( 'edit-user-' . $current_user->ID, $current_user->ID . '-user-edit' ); ?>
                    <input name="action" type="hidden" id="action" value="update-user" />
                </div><!-- .form-submit -->
            </form><!-- #adduser -->
            
            <script language="javascript">
			jQuery( document ).ready( function($) {
				jQuery( '#wmd-input' ).bind( 'keyup keypress blur', function() {
					jQuery( '#wmd-mirror' ).val( jQuery( "#wmd-preview" ).html() );
				} );
			} );
			</script>
            
        <?php endif; ?>
    
    </article> <!-- end article -->
    
    <?php 
	endwhile; 
	else : 
	?>
    
    <?php kazaz_not_found(); // not found section ?>
    
    <?php endif; ?>

</div><!-- end articles wrapper -->
    
<?php get_template_part( 'sidebars/sidebar-page' ); // sidebar ?>

<?php
get_footer();