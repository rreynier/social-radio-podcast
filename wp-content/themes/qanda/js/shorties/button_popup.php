<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert Button Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/o2k7/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />
<script type="text/javascript">

var ButtonDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		ButtonDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var button_size = jQuery( '#button-size' ).val();	
		var button_font_color  = jQuery( '#button-font-color' ).val();
		var button_bg_color  = jQuery( '#button-bg-color' ).val();
		var button_caption  = jQuery( '#button-caption' ).val();
		var button_font_weight  = jQuery( '#button-font-weight' ).val();
		var button_link  = jQuery( '#button-link' ).val();
		var button_target  = jQuery( '#button-target' ).val();
		var button_align  = jQuery( '#button-align' ).val();
 
		var output = '';
		
		var c_len = ed.selection.getContent();
		
		if( c_len.length < 1 ) {
			output = '<br />[button size="' + button_size + '" color="' + button_font_color + '" bg_color="' + button_bg_color + '" caption="' + button_caption + '" font_weight="' + button_font_weight + '" link="' + button_link + '" target="' + button_target + '" align="' + button_align + '"] !YOU SHOULD WRAP SOME TEXT WITH BUTTON SHORTCODE. TEXT SHOULD REPRESENT BUTTON LABEL! [/button]<br />';
			ed.selection.setContent( output );
		} else {
			output = '<br />[button size="' + button_size + '" color="' + button_font_color + '" bg_color="' + button_bg_color + '" caption="' + button_caption + '" font_weight="' + button_font_weight + '" link="' + button_link + '" target="' + button_target + '" align="' + button_align + '"]' + ButtonDialog.local_ed.selection.getContent() + '[/button]<br />';
			tinyMCEPopup.execCommand( 'mceReplaceContent', false, output );
		}
 
		// Return
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add( ButtonDialog.init, ButtonDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">Be sure to select text that will be used as button label first! Additionally you can set button caption via "Button caption" option.</div>
			<div>
				<label for="button-size">Select Button size</label>
				<select name="button-size" id="button-size" size="1">
					<option value="small" selected="selected">Small</option>
					<option value="medium">Medium</option>
					<option value="large">Large</option>
				</select>
			</div>
			<div>
				<label for="button-font-color">Text Color (must be HEX, like #000000)</label>
				<input type="text" name="button-font-color" value="" id="button-font-color" />
			</div>
			<div>
				<label for="button-bg-color">Background Color (must be HEX, like #FF6600)</label>
				<input type="text" name="button-bg-color" value="" id="button-bg-color" />
			</div>
			<div>
				<label for="button-caption">Button caption</label>
				<input type="text" name="button-caption" value="" id="button-caption" />
			</div>
			<div>
				<label for="button-font-weight">Button font weight</label>
				<select name="button-font-weight" id="button-font-weight" size="1">
					<option value="normal" selected="selected">Normal</option>
					<option value="bold">Bold</option>
				</select>
			</div>
			<div>
				<label for="button-link">Button hyperlink</label>
				<input type="text" name="button-link" value="" id="button-link" />
			</div>
			<div>
				<label for="button-target">Button target window</label>
				<select name="button-target" id="button-target" size="1">
					<option value="_self" selected="selected">Same window (self)</option>
					<option value="_blank">New browser tab/window</option>
				</select>
			</div>
			<div>
				<label for="button-align">Button alignment</label>
				<select name="button-align" id="button-align" size="1">
					<option value="left" selected="selected">Left</option>
					<option value="center">Center</option>
                    <option value="right">Right</option>
				</select>
			</div>
			<div>	
				<a href="javascript:ButtonDialog.insert( ButtonDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>