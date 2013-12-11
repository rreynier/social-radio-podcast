<?php 
// load header
get_header(); 
?>
	<div class="articles-wrap twelve columns alpha"><!-- articles wrapper -->
    
    <article id="post-0" class="page clearfix" role="article" itemscope itemtype="http://schema.org/BlogPosting">
        
        <header>
            <h1><?php _e( "404 - Not found!", "kazaz" ); ?></h1>
            <h6><?php _e( "Sorry, requested Page can not be found.", "kazaz" ); ?></h6>
        </header><!-- end article header -->
        
        <span class="clearline" style="height: 80px;"><span class="inner-line"></span></span>
        
        <figure class="error-image"><img src="<?php echo get_template_directory_uri() . '/images/404_error_image.png'; ?>" alt="<?php _e( "404 - Not found!", "kazaz" ); ?>" /></figure>
    
        <section class="entry-content clearfix" itemprop="articleBody">
        	<span class="clearline" style="height: 80px;"><span class="inner-line"></span></span>
            <p>
            <?php wp_tag_cloud( array( 'taxonomy' => array( 'post_tag', 'catalog' ) ) ); ?>
            </p>
        </section> <!-- end article section -->
    
    </article> <!-- end article -->
    
    </div><!-- article end -->
			
<?php
get_footer();