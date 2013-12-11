<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert GoogleMaps Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/o2k7/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />
<script type="text/javascript">

var GoogleMapsDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		GoogleMapsDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var map_src = jQuery( '#layout-dialog input#map-src' ).val();
 
		var output = '';
		
		output = '[googlemap src="' + map_src + '"]';
		
		ed.selection.setContent( output );
		
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add( GoogleMapsDialog.init, GoogleMapsDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">Map Source should be copied from <a href="http://maps.google.com" target="_blank">GoogleMaps</a>. It has to be in form of URL, for example: https://maps.google.com/maps?q=40.716617,-74.008171&amp;num=1&amp;t=m&amp;z=12</div>
			<div>
				<label for="map-src">Map Source</label>
				<input type="text" name="map-src" value="" id="map-src" />
			</div>
			<div>	
				<a href="javascript:GoogleMapsDialog.insert( GoogleMapsDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>