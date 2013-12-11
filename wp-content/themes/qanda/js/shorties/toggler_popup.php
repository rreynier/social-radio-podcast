<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert Toggler Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/o2k7/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />
<script type="text/javascript">

var TogglerDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		TogglerDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var toggler_label = jQuery( '#layout-dialog input#toggler-label' ).val();	 
 
		var output = '';
		
		var c_len = ed.selection.getContent();
		
		if( c_len.length < 1 ) {
			output = '[toggler title="' + toggler_label + '"] !YOU SHOULD ADD SOME CONTENT HERE! [/toggler]';
			ed.selection.setContent( output );
		} else {
			output = '[toggler title="' + toggler_label + '"]';
			output += '<br \/>' + TogglerDialog.local_ed.selection.getContent() + '<br \/>';
			output += '[/toggler]';
			tinyMCEPopup.execCommand( 'mceReplaceContent', false, output );
		}

		// Return
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add( TogglerDialog.init, TogglerDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">Be sure to select text before applying this shortcode. Selected text will be hidden by toggler.</div>
			<div>
				<label for="toggler-label">Toggler Label</label>
				<input type="text" name="toggler-label" value="" id="toggler-label" />
			</div>
			<div>	
				<a href="javascript:TogglerDialog.insert( TogglerDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>