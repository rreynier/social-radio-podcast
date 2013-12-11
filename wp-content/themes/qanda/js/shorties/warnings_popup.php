<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert Warnings/Alerts Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/o2k7/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />
<script type="text/javascript">

var WarningsDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		WarningsDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var warning_type = jQuery( '#layout-dialog select#layout-warning-type' ).val();	
		var text_align = jQuery( '#layout-dialog select#layout-text-align' ).val(); 
		
		var output = '';
		
		var c_len = ed.selection.getContent();
		
		if( c_len.length < 1 ) {
			output = '[alert type="' + warning_type + '" textalign="' + text_align + '"] !YOU SHOULD ADD SOME CONTENT HERE! [/alert]'
			ed.selection.setContent( output );
		} else {
			output = '[alert type="' + warning_type + '" textalign="' + text_align + '"]' + WarningsDialog.local_ed.selection.getContent() + '[/alert]';
			tinyMCEPopup.execCommand( 'mceReplaceContent', false, output );
		}
 
		// Return
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add( WarningsDialog.init, WarningsDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">Select some text prior to applying this shortcode!</div>
			<div>
				<label for="layout-warning-type">Select Warning/Alert type</label>
				<select name="layout-warning-type" id="layout-warning-type" size="1">
					<option value="blue" selected="selected">Blue background Warning/Alert</option>
					<option value="yellow">Yellow background Warning/Alert</option>
					<option value="green">Green background Warning/Alert</option>
                    <option value="red">Red background Warning/Alert</option>
				</select>
			</div>
			<div>
				<label for="layout-text-align">Text Alignment</label>
				<select name="layout-text-align" id="layout-text-align" size="1">
					<option value="left" selected="selected">Align to Left</option>
					<option value="center">Align to Center</option>
					<option value="right">Align to Right</option>
                    <option value="justify">Justify</option>
				</select>
			</div>
			<div>	
				<a href="javascript:WarningsDialog.insert( WarningsDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>