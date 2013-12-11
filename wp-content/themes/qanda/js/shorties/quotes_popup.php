<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert Quotes Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/o2k7/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />
<script type="text/javascript">

var QuotesDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		QuotesDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var quotes_author = jQuery( '#layout-dialog input#quotes_author' ).val();	 
 
		var output = '';
		
		var c_len = ed.selection.getContent();
		
		if( c_len.length < 1 ) {
			output = '[quotes author="' + quotes_author + '"] !YOU SHOULD ADD QUOTES HERE! [/quotes]';
			ed.selection.setContent( output );
		} else {
			output = '[quotes author="' + quotes_author + '"]' + QuotesDialog.local_ed.selection.getContent() + '[/quotes]';
			tinyMCEPopup.execCommand( 'mceReplaceContent', false, output );
		}

		// Return
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add( QuotesDialog.init, QuotesDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">Be sure to select text before applying this shortcode!</div>
			<div>
				<label for="quotes_author">Quotes author</label>
				<input type="text" name="quotes_author" value="" id="quotes_author" />
			</div>
			<div>	
				<a href="javascript:QuotesDialog.insert( QuotesDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>