<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert Break Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/o2k7/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />
<script type="text/javascript">

var BreakDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		BreakDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {
 
		//tinyMCEPopup.execCommand( 'mceRemoveNode', false, null );
 
		// set up variables to contain our input values
		var break_height = jQuery( '#break-height' ).val();
		var break_line = jQuery( '#break-line' ).val();
		var output = '';
		
		output = '[break height="' + break_height + '" line="' + break_line + '"]';
		
		ed.selection.setContent( output );
		
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add( BreakDialog.init, BreakDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">This shortcode doesn't require text selection. Simply insert where ever is needed.</div>
			<div>
				<label for="break-height">Break height</label>
				<select name="break-height" id="break-height" size="1">
					<option value="10" selected="selected">10px break</option>
					<option value="20">20px break</option>
					<option value="30">30px break</option>
                    <option value="40">40px break</option>
                    <option value="50">50px break</option>
                    <option value="60">60px break</option>
                    <option value="70">70px break</option>
                    <option value="80">80px break</option>
                    <option value="90">90px break</option>
                    <option value="100">100px break</option>
				</select>
			</div>
			<div>
				<label for="break-line">Use line?</label>
				<select name="break-line" id="break-line" size="1">
					<option value="no" selected="selected">-- NO --</option>
					<option value="yes">-- YES --</option>
				</select>
			</div>
			<div>	
				<a href="javascript:BreakDialog.insert( BreakDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>