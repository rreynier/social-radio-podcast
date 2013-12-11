<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert Separator Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/o2k7/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />
<script type="text/javascript">

var SeparatorDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		SeparatorDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var separator_type = jQuery( '#separator-type' ).val();
 		var separator_weight = jQuery( '#separator-weight' ).val();
		var output = '';
		
		output = '[separator type="' + separator_type + '" weight="' + separator_weight + '"]';
		
		ed.selection.setContent( output );
		
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add( SeparatorDialog.init, SeparatorDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">No need to make any selection prior to this shortcode insertion, simply decide where to insert by placing cursor to that position.</div>
			<div>
				<label for="separator-type">Separator Type</label>
				<select name="separator-type" id="separator-type" size="1">
					<option value="short" selected="selected">Short (10%)</option>
					<option value="mid">Mid size (50%)</option>
					<option value="full">Full width</option>
                    <option value="zipper">Zig-zag</option>
				</select>
			</div>
			<div>
				<label for="separator-weight">Separator Weight</label>
				<select name="separator-weight" id="separator-weight" size="1">
					<option value="fat">Fat (3px)</option>
					<option value="tiny">Tiny (hairline)</option>
				</select>
			</div>
			<div>	
				<a href="javascript:SeparatorDialog.insert( SeparatorDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>