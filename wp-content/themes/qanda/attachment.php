<?php 
// load header
get_header();
?>

	<?php
	global $post;
	$featured_image_id = get_post_thumbnail_id();
	$large_image_url = wp_get_attachment_image_src( $featured_image_id, 'large' );
	$post_thumb = $large_image_url[ 0 ];
	?>
    
    <div id="post-featured-image-wrap">
        <div id="post-featured-image">
            <figure class="stretchy"><a href="<?php echo $post_thumb; ?>" class="cboxElement" title=""><img class="colorbox-24680" src="<?php echo $post_thumb; ?>" alt="" /></a></figure>
        </div><!-- end featured image -->
    </div>
    <script type="text/jscript">

        jQuery( document ).ready( function() {
            var wid = jQuery( '.article-wrapper' ).outerWidth( true );
            
            jQuery( window ).load( function() {				
                jQuery( '#post-featured-image' ).css( { 'width': wid } );
                jQuery( '.stretchy' ).css( { 'opacity': 0, 'display': 'block' } );
                jQuery( '.stretchy' ).animate( { 'opacity': 1 }, 400 ); // show it up now...
            } );
            
            jQuery( window ).resize( function() {	
                wid = jQuery( '.article-wrapper' ).outerWidth( true );			
                jQuery( '#post-featured-image' ).css( { 'width': wid } );
            } );
            
        } );
    
    </script>

	<div class="article-wrapper"><!-- article -->

	<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
    
        <header>
        	<?php echo kazaz_post_format_title( 'single' ); ?>
        </header><!-- end article header -->
        
		<?php if( has_excerpt() ) : ?>
            <section class="entry-excerpt">
                <?php the_excerpt(); ?>
            </section>
        <?php endif; ?>

    </article> <!-- end article -->
    
    <?php endwhile; ?>			
    
    <?php else : ?>
    
    <?php kazaz_not_found(); // not found section ?>
    
    <?php endif; ?>
    
    </div><!-- article end -->
			
<?php
get_footer();