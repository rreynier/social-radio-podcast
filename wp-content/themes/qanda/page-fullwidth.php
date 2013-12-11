<?php 
/**
 * Template Name: Full Width Page
*/
// load header
get_header(); 
?>
	<div class="articles-wrap sixteen columns alpha omega"><!-- articles wrapper -->
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
    
        <?php if( get_post_meta( get_the_ID(), 'show_title', true ) != 'no' ) : ?>
        
        	<header>
        		<h1><?php the_title(); ?></h1>
        	</header><!-- end article header -->
            
		<?php endif; ?>
    
        <section>
            <?php the_content(); ?>
        </section> <!-- end article section -->
    
    </article> <!-- end article -->
    
    <?php 
	echo kazaz_pagination_page();
	endwhile; 
	else : 
	?>
    
    <?php kazaz_not_found(); // not found section ?>
    
    <?php endif; ?>
    
    </div><!-- end articles wrapper -->
			
<?php
get_footer();