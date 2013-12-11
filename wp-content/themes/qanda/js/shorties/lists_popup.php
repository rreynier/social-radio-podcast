<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert List(s) Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/o2k7/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />
<script type="text/javascript">

var ListsDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		ListsDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var list_type = jQuery( '#layout-dialog select#layout-list-type' ).val();	 
 
		var output = '';
		
		var c_len = ed.selection.getContent();
		
		if( c_len.length < 1 ) {
			output = '[list type="' + list_type + '"] !YOU SHOULD WRAP UNORDERED LIST WITH THIS SHORTCODE! [/list]';
			ed.selection.setContent( output );
		} else {
			output = '[list type="' + list_type + '"]' + ListsDialog.local_ed.selection.getContent() + '[/list]';
			tinyMCEPopup.execCommand( 'mceReplaceContent', false, output );
		}
 
		// Return
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add( ListsDialog.init, ListsDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">Be sure to select unordered list first then apply this shortcode on it.</div>
			<div>
				<label for="layout-list-type">Select List type</label>
				<select name="layout-list-type" id="layout-list-type" size="1">
					<option value="arrow-black" selected="selected">Black Arrow List</option>
					<option value="arrow-red">Red Arrow List</option>
					<option value="check">Check List</option>
                    <option value="exclamation">Exclamation List</option>
                    <option value="watch">Watch List</option>
                    <option value="pen">To-Do List</option>
				</select>
			</div>
			<div>	
				<a href="javascript:ListsDialog.insert( ListsDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>