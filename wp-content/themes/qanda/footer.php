		
        </div><!-- end k content -->
        
        <div id="k-footer-wrap"><!-- k footer wrap -->
        
        	<div id="k-footer-widgets" class="sixteen columns"><!-- k footer widgets -->
            
            	<div class="four columns alpha"><!-- widgets col 1 -->
                
                    <ul id="widgets-column-1">
                        <?php if( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Footer Column First' ) ) : ?>
                        
                        <?php endif; ?>
                    </ul>
                
                </div><!-- end widgets col 1 -->
                
            	<div class="four columns"><!-- widgets col 2 -->
                
                    <ul id="widgets-column-2">
                        <?php if( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Footer Column Second' ) ) : ?>
                        
                        <?php endif; ?>
                    </ul>
                
                </div><!-- end widgets col 2 -->
                
            	<div class="four columns"><!-- widgets col 3 -->
                
                    <ul id="widgets-column-3">
                        <?php if( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Footer Column Third' ) ) : ?>
                        
                        <?php endif; ?>
                    </ul>
                
                </div><!-- end widgets col 3 -->
                
            	<div class="four columns omega"><!-- widgets col 4 -->
                
                    <ul id="widgets-column-4">
                        <?php if( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Footer Column Fourth' ) ) : ?>
                        
                        <?php endif; ?>
                    </ul>
                
                </div><!-- end widgets col 4 -->
            
            </div><!-- end k footer widgets -->
        
        	<div id="k-footer-copy" class="sixteen columns"><!-- k footer menu and copyright -->
            
            	<p><?php echo of_get_option( 'k_copyright' ); ?><span id="go-top"></span></p>
            
            </div><!-- end k footer menu and copyright -->
        
        </div><!-- end k footer wrap -->
    
    </div><!-- end k main wrap -->
    
	<!-- drop Google Analytics Here -->
    <?php if( strlen( of_get_option( 'k_analytics' ) ) > 10 ) { echo '<script type="text/javascript">' . of_get_option( 'k_analytics' ) . '</script>'; } ?>
	<!-- end analytics -->
	
	<?php wp_footer(); ?>

	</body>

</html>