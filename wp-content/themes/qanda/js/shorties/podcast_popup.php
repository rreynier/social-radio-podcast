<?php
$this_file = str_replace( '\\', '/', __FILE__ );
$this_file = explode( 'wp-content', $this_file );
$this_file = $this_file[ 0 ];
require_once( $this_file . 'wp-load.php' );
?>
<!DOCTYPE html>
<html class="my">
<head>
<title>Insert Podcasts Shortcode</title>
<?php wp_print_scripts( 'jquery' ); ?>
<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css"></style>
<link rel="stylesheet" href="<?php echo( get_template_directory_uri() . '/js/shorties/dialog_elements.css' ); ?>" type="text/css" media="all" />

<script type="text/javascript">

var PodcastDialog = {
	local_ed : 'ed',
	init : function( ed ) {
		PodcastDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton( ed ) {

		// set up variables to contain our input values
		var filter = jQuery( '#podcast-filter' ).val();
 		var summary = jQuery( '#podcast-summary' ).val();
		var output = '';

		output = '[podcast filter="' + filter + '" summary="' + summary + '"]';

		ed.selection.setContent( output );

		// Return
		tinyMCEPopup.close();

	}
};

tinyMCEPopup.onInit.add( PodcastDialog.init, PodcastDialog );

</script>

</head>
<body>
	<div id="layout-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div id="help">Insert shortcode that will make the list of Podcasts according to filter/parameter selected below.</div>
			<div>
				<label for="podcast-filter">Filter Podcasts</label>
				<select name="podcast-filter" id="podcast-filter" size="1">
                	<option value="default" selected="selected">By date of post</option>
					<option value="votes" selected="selected">By number of votes</option>
					<option value="comments">By number of comments</option>
                    <option value="views">By number of views</option>
					<option value="unanswered">Unanswered only</option>
                    <option value="unaccepted">Status Open</option>
                    <option value="accepted">Status Closed</option>
                    <option value="alphabetically">Alphabetically</option>
                    <option value="randomly">Randomly</option>
                    <option value="mostfaved">The most faved</option>
				</select>
			</div>
			<div>
				<label for="podcast-summary">Show Podcast summary?</label>
				<select name="podcast-summary" id="podcast-summary" size="1">
					<option value="yes" selected="selected"> - YES - </option>
					<option value="no"> - NO - </option>
				</select>
			</div>
			<div>
				<a href="javascript:PodcastDialog.insert( PodcastDialog.local_ed )" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>