<?php 
/**
 * Template Name: Contact Page
*/
// load header
get_header(); 

$hasError = FALSE;
$emailSent = FALSE;
$name = '';
$nameError = '';
$email = '';
$emailError = '';
$comments = '';
$commentError = '';
$spamError = '';
if( isset( $_POST[ 'submitted' ] ) ) {
	/* name */
	if( trim( $_POST[ 'yourname' ] ) === '') {
		$nameError = __( "Please enter your name.", "kazaz" );
		$hasError = TRUE;
	} else {
		$name = esc_attr( $_POST[ 'yourname' ] );
	}
	/* email */
	if( trim( $_POST[ 'email' ] ) === '' )  {
		$emailError = __( "Please enter your email address.", "kazaz" );
		$hasError = TRUE;
	} else if( !preg_match( "/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim( $_POST[ 'email' ] ) ) ) {
		$emailError = __( "You entered an invalid email address.", "kazaz" );
		$hasError = TRUE;
	} else {
		$email = esc_attr( $_POST[ 'email' ] );
	}
	/* message */
	if( trim( $_POST[ 'message' ] ) === '' ) {
		$commentError = __( "Please enter a message.", "kazaz" );
		$hasError = TRUE;
	} else {
		$comments = esc_attr( $_POST[ 'message' ] );
	}
	/* spam */
	if( trim( $_POST[ 'spam' ] ) === '' ) {
		$spamError = __( "Summarize!", "kazaz" );
		$hasError = TRUE;
	} else {
		$sum = (int)$_POST[ 'spam' ];
		$v_1 = $_POST[ 'v_1' ]; 
		$v_1 = str_replace( 'sx', '', $v_1 );
		$v_2 = $_POST[ 'v_2' ]; 
		$v_2 = str_replace( 'sy', '', $v_2 );
		$sum_now = (int)$v_1 + (int)$v_2;
		if( $sum != $sum_now ) {
			$spamError = __( "Incorrect!", "kazaz" );
			$hasError = TRUE;
		}
	}
	
	if( !$hasError ) {
		$emailTo = of_get_option( 'k_contact_email' );
		$subject = '[ ' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' ] From ' . $name;
		$body = "Name: $name \n\nEmail: $email \n\nMessage:\n $comments";
		$headers = 'From: ' . $name . ' <' . $emailTo . '>' . "\r\n" . 'Reply-To: ' . $email;

		wp_mail( $emailTo, $subject, $body, $headers );
		$emailSent = TRUE;
	}
}
?>
        
	<div class="articles-wrap twelve columns alpha"><!-- articles wrapper -->
    
	<?php while (have_posts()) : the_post(); ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
    
        <?php if( get_post_meta( get_the_ID(), 'show_title', true ) != 'no' ) : ?>
        
        	<header>
        		<h1><?php the_title(); ?></h1>
        	</header><!-- end article header -->
            
		<?php endif; ?>
    
        <section class="entry-content clearfix">
        
        	<?php the_content(); ?>
            
			<?php if( strlen( of_get_option( 'k_gmap_address' ) ) > 40 ) { ?>
                <div id="gmap-wrapper">
                    <div class="gmap">
                        <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo of_get_option( 'k_gmap_address' ); ?>&output=embed"></iframe>
                    </div><!-- end gmap -->
                </div>
            <?php } ?>
            
            <?php if( !$emailSent ) { ?>
        
            <form id="contactform" method="post" action="<?php the_permalink(); ?>">
            
                <dl class="contact-form-name">
                    <dt><label for="yourname">* <?php _e( "Name", "kazaz" ); ?>:</label> <?php if( $nameError !== '' ) { echo '<span class="contact-error">' . $nameError . '</span>'; }; ?></dt>
                    <dd class="cfp"><input type="text" size="45" id="yourname" name="yourname" value="<?php if( isset( $_POST[ 'yourname' ] ) ) echo esc_attr( $_POST[ 'yourname' ] );?>" tabindex="444" /></dd>
                </dl>

                <dl class="contact-form-email">
                    <dt><label for="email">* <?php _e( "E-mail", "kazaz" ); ?>:</label> <?php if( $emailError !== '' ) { echo '<span class="contact-error">' . $emailError . '</span>'; }; ?></dt>
                    <dd class="cfp"><input type="text" size="45" id="email" name="email" value="<?php if( isset( $_POST[ 'email' ] ) ) echo esc_attr( $_POST[ 'email' ] );?>" tabindex="445" /></dd>
                </dl>
                
                <dl class="contact-form-phone">
                    <dt><label for="phone"><?php _e( "Phone/Cell", "kazaz" ); ?>:</label></dt>
                    <dd class="cfp"><input type="text" size="45" id="phone" name="phone" value="<?php if( isset( $_POST[ 'phone' ] ) ) echo esc_attr( $_POST[ 'phone' ] );?>" tabindex="446" /></dd>
                </dl>
                
                <dl class="contact-form-message">
                    <dt><label for="message">* <?php _e( "YOUR MESSAGE", "kazaz" ); ?></label> <?php if( $commentError !== '' ) { echo '<span class="contact-error">' . $commentError . '</span>'; }; ?></dt>
                    <dd><textarea rows="10" cols="52" id="message" name="message" tabindex="447"><?php if( isset( $_POST[ 'message' ] ) ) echo esc_attr( $_POST[ 'message' ] );?></textarea></dd>
                </dl>
                
                <dl class="contact-form-spam">
                   <?php
                   $v_1 = rand( '1', '10' );
                   $v_2 = rand( '1', '10' );
                   ?>
                   <dt></dt>
                   <dd>
                   <label id="spamlabel" for="spam" class="left">* <?php _e( "Enter the sum", "kazaz" ); ?>: &nbsp; <?php echo $v_1 . ' + ' . $v_2 . ' = '; ?></label>
                   <input type="text" name="spam" id="spam" size="2" value="" class="left" tabindex="448" /> <?php if( $spamError !== '' ) { echo '<span class="contact-error spam-error">&nbsp;' . $spamError . '</span>'; }; ?>
                   </dd>
                </dl>
                
                <dl class="form-submit">
                	<dt></dt>
                    <dd><input type="submit" value="<?php _e( "SEND YOUR MESSAGE", "kazaz" ); ?>" id="submit" name="submit" class="right" tabindex="449" /></dd>
                </dl>
                
                <p style="display: none;">
                   <input type="hidden" name="v_1" value="sx<?php echo $v_1; ?>" />
                   <input type="hidden" name="v_2" value="sy<?php echo $v_2; ?>" />
                   <input type="hidden" name="submitted" id="submitted" value="true" />
                </p>
                
            </form>
            
            <?php 
			} else { 
				echo '<div class="alertyellow"><p>' . __( "Thanks for contacting us! Your message has been sent successfully and we will get back to you as soon as possible.", "kazaz" ) . '</p></div>';
			}
			?>
            
        </section> <!-- end article section -->
    
    </article><!-- end article -->
    
    <?php endwhile; ?>
    
    </div><!-- article end -->
    
    <?php get_template_part( 'sidebars/sidebar-page' ); // sidebar ?>
			
<?php
get_footer();