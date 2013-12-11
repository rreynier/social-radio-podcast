<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert Video Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/o2k7/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />
<script type="text/javascript">

var VideoDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		VideoDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var video_code = jQuery( '#layout-dialog textarea#layout-video' ).val();	 
 
		var output = '';
		
		output = '[video]' + video_code + '[/video]';
		
		ed.selection.setContent( output );
 
		// Return
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add( VideoDialog.init, VideoDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        <div id="help">NOTE: Video sharing services provide ready made Embed code! Such code is wrapped with IFRAME element. If you omit IFRAME element your video might not be displayed properly!</div>
			<div>
				<label for="layout-video">Video embed code</label>
				<textarea id="layout-video" name="layout-video" rows="8" style="width: 99%;"></textarea>
			</div>
			<div>	
				<a href="javascript:VideoDialog.insert( VideoDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>