<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert Tabbed Content</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/o2k7/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />
<script type="text/javascript">

var TabsDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		TabsDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var text_align = jQuery( '#layout-dialog select#layout-text-align' ).val();
		
		var output = '';
		
		var c_len = ed.selection.getContent();
		
		if( c_len.length < 1 ) {
			output = '[tabber textalign="' + text_align + '"] !YOU SHOULD ADD SOME CONTENT HERE! [/tabber]';
			ed.selection.setContent( output );
		} else {
			output = '[tabber textalign="' + text_align + '"]' + TabsDialog.local_ed.selection.getContent() + '[/tabber]';
			tinyMCEPopup.execCommand( 'mceReplaceContent', false, output );
		}
 
		// Return
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add( TabsDialog.init, TabsDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">NOTE: Select chunk of text first. It has to contain at least two H1 elements. All of H1 elements will automatically be converted to tab labels. It means that you can use any other title tag (H2 to H6) within tabbed content but H1 remains "reserved"!</div>
			<div>
				<label for="layout-text-align">Inner Text Alignment</label>
				<select name="layout-text-align" id="layout-text-align" size="1">
					<option value="left" selected="selected">Align to left</option>
					<option value="center">Align to center</option>
					<option value="right">Align to right</option>
                    <option value="justify">Justify</option>
				</select>
			</div>
			<div>	
				<a href="javascript:TabsDialog.insert( TabsDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>