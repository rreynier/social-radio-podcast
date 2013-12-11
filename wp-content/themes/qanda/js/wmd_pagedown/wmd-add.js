jQuery( document ).ready( function($) {
	var converter1 = Markdown.getSanitizingConverter();
   /*
	converter1.hooks.chain( "preBlockGamut", function( text, rbg ) {
		return text.replace(/^ {0,3}""" *\n((?:.*?\n)+?) {0,3}""" *$/gm, function( whole, inner ) {
			return "<blockquote>" + rbg( inner ) + "</blockquote>\n";
		} );
	} );
   */
	var opts = {};
	opts.helpButton = { handler: helpButtonFunc };
	var editor1 = new Markdown.Editor( converter1, '', opts );
   
	editor1.run();
	
	function helpButtonFunc() {
		window.location.href = "http://five.squarespace.com/display/ShowHelp?section=Markdown";
	}
	
} );