<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert Layout Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />

<script type="text/javascript">

var LayoutDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		LayoutDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var text_align = jQuery( '#layout-dialog select#layout-text-align' ).val();
		var layout_size = jQuery( '#layout-dialog select#layout-size' ).val();
		var layout_position = jQuery( '#layout-dialog select#layout-position' ).val();	 
 
		var output = '';
		
		var c_len = ed.selection.getContent();
		
		if( c_len.length < 1 ) {
			if( layout_position == 'none' ) layout_position = 'first';
			output = '[layout cols="' + layout_size + '" position="' + layout_position + '" textalign="' + text_align + '"] !YOU SHOULD ADD SOME CONTENT HERE! [/layout]';
			ed.selection.setContent( output );
		} else {
			if( layout_position == 'none' ) layout_position = 'first';
			output = '[layout cols="' + layout_size + '" position="' + layout_position + '" textalign="' + text_align + '"]' + LayoutDialog.local_ed.selection.getContent() + '[/layout]';
			tinyMCEPopup.execCommand( 'mceReplaceContent', false, output );
		}
 
		// Return
		tinyMCEPopup.close();
		
	}
};

tinyMCEPopup.onInit.add( LayoutDialog.init, LayoutDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">Insert columns as needed then feel free to fill up with the text (and images).</div>
			<div>
				<label for="layout-text-align">Text Alignment</label>
				<select name="layout-text-align" id="layout-text-align" size="1">
					<option value="left" selected="selected">Align to left</option>
					<option value="center">Align to center</option>
					<option value="right">Align to right</option>
                    <option value="justify">Justify</option>
				</select>
			</div>
			<div>
				<label for="layout-size">Block Size</label>
				<select name="layout-size" id="layout-size" size="1">
					<option value="1-1" selected="selected">Full Width</option>
                    <option value="1-2">1/2 (half)</option>
					<option value="1-3">1/3 (third)</option>
					<option value="1-4">1/4 (fourth)</option>
                    <option value="1-5">1/5 (fifth)</option>
                    <option value="1-6">1/6 (sixth)</option>
					<option value="2-3">2/3 (2 thirds)</option>
                    <option value="2-4">2/4 (half)</option>
                    <option value="3-4">3/4 (3 fourths)</option>
                    <option value="2-5">2/5 (2 fifths)</option>
                    <option value="3-5">3/5 (3 fifths)</option>
                    <option value="4-5">4/5 (4 fifths)</option>
					<option value="2-6">2/6 (third)</option>
                    <option value="3-6">3/6 (half)</option>
                    <option value="4-6">4/6 (2 thirds)</option>
                    <option value="5-6">5/6 (5 sixths)</option>
				</select>
			</div>
			<div>
				<label for="layout-position">Block Position</label>
				<select name="layout-position" id="layout-position" size="1">
					<option value="first" selected="selected">Normal</option>
					<option value="last">Last</option>
				</select>
			</div>
			<div>	
				<a href="javascript:LayoutDialog.insert( LayoutDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>