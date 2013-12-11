<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'kazaz'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// easing
	$options_easing = array(
		'jswing' => 'jswing',
		'easeInQuad' => 'easeInQuad',
		'easeOutQuad' => 'easeOutQuad',
		'easeInOutQuad' => 'easeInOutQuad',
		'easeInCubic' => 'easeInCubic',
		'easeOutCubic' => 'easeOutCubic',
		'easeInOutCubic' => 'easeInOutCubic',
		'easeInQuart' => 'easeInQuart',
		'easeOutQuart' => 'easeOutQuart',
		'easeInOutQuart' => 'easeInOutQuart',
		'easeInQuint' => 'easeInQuint',
		'easeOutQuint' => 'easeOutQuint',
		'easeInOutQuint' => 'easeInOutQuint',
		'easeInSine' => 'easeInSine',
		'easeOutSine' => 'easeOutSine',
		'easeInOutSine' => 'easeInOutSine',
		'easeInExpo' => 'easeInExpo',
		'easeOutExpo' => 'easeOutExpo',
		'easeInOutExpo' => 'easeInOutExpo',
		'easeInCirc' => 'easeInCirc',
		'easeOutCirc' => 'easeOutCirc',
		'easeInOutCirc' => 'easeInOutCirc',
		'easeInElastic' => 'easeInElastic',
		'easeOutElastic' => 'easeOutElastic',
		'easeInOutElastic' => 'easeInOutElastic',
		'easeInBack' => 'easeInBack',
		'easeOutBack' => 'easeOutBack',
		'easeInOutBack' => 'easeInOutBack',
		'easeInBounce' => 'easeInBounce',
		'easeOutBounce' => 'easeOutBounce',
		'easeInOutBounce' => 'easeInOutBounce'
	);

	// The real typography
	$google_fonts_list = array(
		"default" => "Default (Helvetica, Arial, sans-serif)",
		"Droid+Sans:400,700" => "Droid Sans",
		"Yanone+Kaffeesatz:light,regular,bold" => "Yanone Kaffeesatz",
		"News+Cycle:400,700" => "News Cycle",
		"Oswald:300,700" => "Oswald",
		"Ubuntu+Condensed" => "Ubuntu Condensed",
		"Rokkitt:400,700" => "Rokkitt",
		"Maven+Pro:400,500" => "Maven Pro",
		"Open+Sans:300,800" => "Open Sans",
		"Open+Sans+Condensed:300,700" => "Open Sans Condensed",
		"PT+Serif:400,700" => "PT Serif",
		"Share:400,700" => "Share",
		"Asap:400,700" => "Asap",
		"Gudea:400,700" => "Gudea",
		"Signika+Negative:300,700" => "Signika Negative",
		"Magra:400,700" => "Magra",
		"Cabin:400,700" => "Cabin",
		"Cabin+Condensed:400,700" => "Cabin Condensed",
		"Questrial" => "Questrial",
		"Abel" => "Abel",
		"Istok+Web:400,700" => "Istok Web",
		"Overlock:400,900" => "Overlock",
		"PT+Sans+Narrow:400,700" => "PT Sans Narrow"
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '#111111',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '14px',
		'face' => 'default',
		'style' => 'normal',
		'color' => '#666666' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '10','11','12','13','14','15','16','17','18','19','20' ),
		'faces' => false,
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => '#666666'
	);

	// Typography Titles
	$typography_titles = array(
		'sizes' => array( '50','48','46','44','42','40','38','36','34','32','30','28','26','24','22','20','18','16','15','14','13','12','11','10' ),
		'faces' => false,
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => '#111111'
	);

	// voting
	$reputation_votes = array( '1' => ' - 1 - ', '2' => ' - 2 - ', '3' => ' - 3 - ', '4' => ' - 4 - ', '5' => ' - 5 - ', '6' => ' - 6 - ', '7' => ' - 7 - ', '8' => ' - 8 - ', '9' => ' - 9 - ', '10' => ' - 10 - ' );
	$reputation_minimum = array( '10' => ' - 10 - ', '20' => ' - 20 - ', '30' => ' - 30 - ', '40' => ' - 40 - ', '50' => ' - 50 - ', '60' => ' - 60 - ', '70' => ' - 70 - ', '80' => ' - 80 - ', '90' => ' - 90 - ', '100' => ' - 100 - ' );

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = __( "Select...", "kazaz" );
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array(
		'name' => __('Basic stuff', 'kazaz'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Site Logo', 'kazaz'),
		'desc' => __('Browse to then upload your logo. It should either be JPEG, PNG or GIF file type.', 'kazaz'),
		'id' => 'k_logo',
		'std' => $imagepath . 'site_logo.png',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Site Favicon', 'kazaz'),
		'desc' => __('Browse to then upload your site favicon. It should be ".ico" file type, 16x16px.', 'kazaz'),
		'id' => 'k_favicon',
		'std' => $imagepath . 'favicon.ico',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Titles font-family', 'kazaz'),
		'desc' => __('Pick preferred font-family for titles.', 'kazaz'),
		'id' => "k_title_font",
		'std' => 'Droid+Sans:400,700',
		'type' => 'select',
		'options' => $google_fonts_list );

	$options[] = array(
		'name' => __('Content font-family', 'kazaz'),
		'desc' => __('Pick preferred font-family for content.', 'kazaz'),
		'id' => "k_content_font",
		'std' => 'Droid+Sans:400,700',
		'type' => 'select',
		'options' => $google_fonts_list );

	$options[] = array(
		'name' => __('BODY background', 'kazaz'),
		'desc' => __('Set the background color and/or upload image background. You will be able to set CONTENT background later!', 'kazaz'),
		'id' => 'k_main_background',
		'std' => $background_defaults,
		'type' => 'background' );

	$options[] = array(
		'name' => __('Website title and tagline', 'kazaz'),
		'desc' => __('Site title (will be H1). If you didn\'t upload logo, plain text will be used.', 'kazaz'),
		'id' => "k_site_title",
		'std' => array( 'size' => '50px', 'color' => '#45a37c', 'style' => 'bold' ),
		'type' => 'typography',
		'options' => $typography_titles );

	$options[] = array(
		'name' => '',
		'desc' => __('Site tagline (will be H5). It won\'t be visible if site logo is uploaded.', 'kazaz'),
		'id' => "k_site_description",
		'std' => array( 'size' => '13px', 'color' => '#666666', 'style' => 'normal' ),
		'type' => 'typography',
		'options' => $typography_titles );

	$options[] = array(
		'name' => '',
		'desc' => __('Tick to hide site tagline.', 'kazaz'),
		'id' => 'k_site_description_remove',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Content styling', 'kazaz'),
		'desc' => __('Main section H1 titles.', 'kazaz'),
		'id' => "k_main_h1",
		'std' => array( 'size' => '28px', 'color' => '#999999', 'style' => 'bold' ),
		'type' => 'typography',
		'options' => $typography_titles );

	$options[] = array(
		'name' => '',
		'desc' => __('Main section H2 titles.', 'kazaz'),
		'id' => "k_main_h2",
		'std' => array( 'size' => '24px', 'color' => '#999999', 'style' => 'bold' ),
		'type' => 'typography',
		'options' => $typography_titles );

	$options[] = array(
		'name' => '',
		'desc' => __('Main section H3 titles.', 'kazaz'),
		'id' => "k_main_h3",
		'std' => array( 'size' => '22px', 'color' => '#999999', 'style' => 'normal' ),
		'type' => 'typography',
		'options' => $typography_titles );

	$options[] = array(
		'name' => '',
		'desc' => __('Main section H4 titles.', 'kazaz'),
		'id' => "k_main_h4",
		'std' => array( 'size' => '20px', 'color' => '#999999', 'style' => 'normal' ),
		'type' => 'typography',
		'options' => $typography_titles );

	$options[] = array(
		'name' => '',
		'desc' => __('Main section H5 titles.', 'kazaz'),
		'id' => "k_main_h5",
		'std' => array( 'size' => '18px', 'color' => '#999999', 'style' => 'normal' ),
		'type' => 'typography',
		'options' => $typography_titles );

	$options[] = array(
		'name' => '',
		'desc' => __('Main section H6 titles.', 'kazaz'),
		'id' => "k_main_h6",
		'std' => array( 'size' => '16px', 'color' => '#999999', 'style' => 'normal' ),
		'type' => 'typography',
		'options' => $typography_titles );

	$options[] = array(
		'name' => '',
		'desc' => __('Widget title. H2 tag will be used!', 'kazaz'),
		'id' => "k_widget_title",
		'std' => array( 'size' => '16px', 'color' => '#999999', 'style' => 'bold' ),
		'type' => 'typography',
		'options' => $typography_titles );

	$options[] = array(
		'name' => '',
		'desc' => __('Uniform title size for the podcast Answer. It will be the same for all H1, H2, H3, H4, H5 and H6 tags!', 'kazaz'),
		'id' => "k_answer_titles_size",
		'std' => array( 'size' => '20px', 'color' => '#999999', 'style' => 'normal' ),
		'type' => 'typography',
		'options' => $typography_titles );

	$options[] = array(
		'name' => '',
		'desc' => __('Main section content typography.', 'kazaz'),
		'id' => "k_main_typography",
		'std' => array( 'size' => '14px', 'color' => '#666666', 'style' => 'normal' ),
		'type' => 'typography',
		'options' => $typography_options );

	$options[] = array(
		'name' => '',
		'desc' => __('Main section Link color.', 'kazaz'),
		'id' => 'k_main_link',
		'std' => '#f69679',
		'type' => 'color' );

	$options[] = array(
		'name' => '',
		'desc' => __('Main section Link HOVER color.', 'kazaz'),
		'id' => 'k_main_hover',
		'std' => '#EEEEEE',
		'type' => 'color' );

	$options[] = array(
		'name' => '',
		'desc' => __('Main section Link VISITED color.', 'kazaz'),
		'id' => 'k_main_visited',
		'std' => '#f69679',
		'type' => 'color' );

	$options[] = array(
		'name' => '',
		'desc' => __('All separators in main section will use that color.', 'kazaz'),
		'id' => "k_separators_color",
		'std' => '#333333',
		'type' => 'color' );

	$options[] = array(
		'name' => '',
		'desc' => __('Preformated and code (PRE and CODE) HTML elements background color.', 'kazaz'),
		'id' => "k_pre_bg_color",
		'std' => '#222222',
		'type' => 'color' );

	$options[] = array(
		'name' => '',
		'desc' => __('Preformated and code (PRE and CODE) HTML elements font color.', 'kazaz'),
		'id' => "k_pre_font_color",
		'std' => '#999999',
		'type' => 'color' );

	$options[] = array(
		'name' => '',
		'desc' => __('Invert color of icons in main content? Default content icons are made for light background. Tick this option if your main content background is dark.', 'kazaz'),
		'id' => 'k_content_invert_icons',
		'std' => '1',
		'type' => 'checkbox' );

// :::::::::::::::::::::::::::::: PODCAST ::::::::::::::::::::::::::::: \\

	$options[] = array(
		'name' => __('Qusetions and Answers', 'kazaz'),
		'desc' => __('Customize, enable, disable, etc.', 'kazaz'),
		'type' => 'heading');

	$options[] = array(
		'name' => '',
		'desc' => __('In order to be able to select 2 mandatory pages, you will have to create them first. If you did not create them yet, from Dashboard select:
		Pages > Add New
		...enter the title for each of your pages and apply "Edit Podcast Page" or "Edit Answer Page" Template correspondingly from Page Attributes panel (right hand sidebar).
		Once done get back to this Options screen and your two new pages should be selectable from the drop-down list.', 'kazaz'),
		'type' => 'info');

	$options[] = array(
		'name' => __( 'Podcast EDIT and Answer EDIT pages', 'kazaz' ),
		'desc' => __( 'From the drop-down select Podcast EDIT page.', 'kazaz' ),
		'id' => 'k_podcast_edit_page',
		'std' => '',
		'type' => 'select',
		'options' => $options_pages );

	$options[] = array(
		'name' => '',
		'desc' => __( 'From the drop-down select Answer EDIT page.', 'kazaz' ),
		'id' => 'k_answer_edit_page',
		'std' => '',
		'type' => 'select',
		'options' => $options_pages );

	$options[] = array(
		'name' => '',
		'desc' => __('Enable Podcast tags input field when posting new Podcast? It\'s good for SEO, easier site browsing and will make related Podcasts to work properly.', 'kazaz' ),
		'id' => 'enable_podcast_tags',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => '',
		'desc' => __('Autopublish new Podcast? Otherwise it is saved as Draft and will need Admin approval.', 'kazaz' ),
		'id' => 'autopublish_podcast',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => '',
		'desc' => __('Show Podcast summary text? Podcast summary is visible on category, tag and search results page.', 'kazaz' ),
		'id' => 'show_podcast_summary',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => '',
		'desc' => __( 'If Podcast summary enabled, how many characters to show? Default is 160.', 'kazaz' ),
		'id' => 'podcast_summary_chars',
		'std' => '160',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __( 'Minimum and maximum number of characters per Podcast title', 'kazaz' ),
		'desc' => __( 'Minimum number of characters', 'kazaz' ),
		'id' => 'k_podcast_chars_min',
		'std' => '10',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => '',
		'desc' => __('Maximum number of characters', 'kazaz'),
		'id' => 'k_podcast_chars_max',
		'std' => '160',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __( 'Minimum and maximum number of characters per Podcast content/description', 'kazaz' ),
		'desc' => __( 'Minimum number of characters', 'kazaz' ),
		'id' => 'k_podcast_cont_chars_min',
		'std' => '25',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => '',
		'desc' => __('Maximum number of characters', 'kazaz'),
		'id' => 'k_podcast_cont_chars_max',
		'std' => '1600',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __( 'Maximum number of characters per Podcast tags', 'kazaz' ),
		'desc' => __( 'Maximum number of characters', 'kazaz' ),
		'id' => 'k_podcast_tags_chars_max',
		'std' => '65',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __( 'Minimum and maximum number of characters per Answer', 'kazaz' ),
		'desc' => __( 'Minimum number of characters', 'kazaz' ),
		'id' => 'k_answer_cont_chars_min',
		'std' => '10',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => '',
		'desc' => __('Maximum number of characters', 'kazaz'),
		'id' => 'k_answer_cont_chars_max',
		'std' => '1600',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __( 'Minimum and maximum number of characters per Answer comment', 'kazaz' ),
		'desc' => __( 'Users are allowed to post comments on Answer. Enter minimum number of characters', 'kazaz' ),
		'id' => 'k_answer_comment_chars_min',
		'std' => '10',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => '',
		'desc' => __('Enter maximum number of characters per Answer comment', 'kazaz'),
		'id' => 'k_answer_comment_chars_max',
		'std' => '800',
		'class' => 'mini',
		'type' => 'text');

// :::::::::::::::::::::::::::::: REPUTATION ::::::::::::::::::::::::::::: \\

	$options[] = array(
		'name' => __('Reputation', 'kazaz'),
		'desc' => __('How users are supposed to gather reputation points?', 'kazaz'),
		'type' => 'heading');

	$options[] = array(
		'name' => __( 'Podcast - vote PRO', 'kazaz' ),
		'desc' => __( 'When site members vote PRO for certain Podcast, how many reputation points that Podcast author is supposed to earn?', 'kazaz' ),
		'id' => 'k_votes_podcast_pro',
		'std' => '5',
		'type' => 'select',
		'options' => $reputation_votes );

	$options[] = array(
		'name' => __( 'Podcast - vote CON', 'kazaz' ),
		'desc' => __( 'When site members vote CON for certain Podcast, how many reputation points that Podcast author is supposed to lose?', 'kazaz' ),
		'id' => 'k_votes_podcast_con',
		'std' => '1',
		'type' => 'select',
		'options' => $reputation_votes );

	$options[] = array(
		'name' => __( 'Answer - vote PRO', 'kazaz' ),
		'desc' => __( 'When site members vote PRO for certain Answer, how many reputation points that Answer author is supposed to earn?', 'kazaz' ),
		'id' => 'k_votes_answer_pro',
		'std' => '2',
		'type' => 'select',
		'options' => $reputation_votes );

	$options[] = array(
		'name' => __( 'Answer - vote CON', 'kazaz' ),
		'desc' => __( 'When site members vote CON for certain Answer, how many reputation points that Answer author is supposed to lose?', 'kazaz' ),
		'id' => 'k_votes_answer_con',
		'std' => '1',
		'type' => 'select',
		'options' => $reputation_votes );

	$options[] = array(
		'name' => __( 'Accepted Answer', 'kazaz' ),
		'desc' => __( 'When Podcast author accepts certain Answer, how many reputation points is that Answer author supposed to earn?', 'kazaz' ),
		'id' => 'k_accepted_answer_points',
		'std' => '10',
		'type' => 'select',
		'options' => $reputation_votes );

	$options[] = array(
		'name' => __( 'Points limit for voting CON', 'kazaz' ),
		'desc' => __( 'What is the minimum reputation score required before site members are allowed to vote CON (for either Podcast or Answer)?', 'kazaz' ),
		'id' => 'k_vote_con_limit',
		'std' => '50',
		'type' => 'select',
		'options' => $reputation_minimum );

// :::::::::::::::::::::::::: NAVIGATION :::::::::::::::::::::::::: \\

	$options[] = array(
		'name' => __('Navigation', 'kazaz'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Main menu', 'kazaz'),
		'desc' => __('Set font color, font size...', 'kazaz'),
		'id' => "k_menu_font_style",
		'std' => array( 'size' => '15px', 'color' => '#f69679', 'style' => 'bold' ),
		'type' => 'typography',
		'options' => $typography_options );

	$options[] = array(
		'name' => '',
		'desc' => __('Main Menu item HOVER color.', 'kazaz'),
		'id' => 'k_menu_hover_color',
		'std' => '#45a37c',
		'type' => 'color' );

	$options[] = array(
		'name' => '',
		'desc' => __('Drop-down (sub-menu) background color.', 'kazaz'),
		'id' => 'k_menu_sub_bg_color',
		'std' => '#000000',
		'type' => 'color' );

	$options[] = array(
		'name' => '',
		'desc' => __('Make all Main menu items uppercased!', 'kazaz'),
		'id' => 'k_menu_uppercase',
		'std' => '1',
		'type' => 'checkbox');

// ::::::::::::::::::::::::::::: CONTACT ::::::::::::::::::::::::::::: \\

	$options[] = array(
		'name' => __('Contact Page', 'kazaz'),
		'type' => 'heading');

	$options[] = array(
		'name' => 'Recipient e-mail address',
		'desc' => __('Please provide an e-mail address where contact form inquiry should be sent to.', 'kazaz'),
		'id' => 'k_contact_email',
		'std' => 'you@youremail.address.com',
		'type' => 'text');

	$options[] = array(
		'name' => '',
		'desc' => __('GoogleMap Address. You can obtain the address from GoogleMaps official page (look up for "Link" icon). DON\'T INSERT IFRAME!!!', 'kazaz'),
		'id' => 'k_gmap_address',
		'std' => 'https://maps.google.com/maps?q=40.716617,-74.008171&num=1&t=m&z=12',
		'type' => 'textarea');

// :::::::::::::::::::::::::::::: OTHER :::::::::::::::::::::::::::::: \\

	$options[] = array(
		'name' => __('Other', 'kazaz'),
		'type' => 'heading');

	$options[] = array(
		'name' => '',
		'desc' => __('In order to be able to select "EDIT User Profile Page", you will have to create it first. If you did not create it yet, from Dashboard select:
		Pages > Add New
		...enter the title and apply "Edit User Profile" Template from Page Attributes panel (right hand sidebar).
		Once done get back to this Options screen and your new page should be selectable from the drop-down list.', 'kazaz'),
		'type' => 'info');

	$options[] = array(
		'name' => __( 'EDIT User Profile Page', 'kazaz' ),
		'desc' => __( 'Select that page (by title) from the drop-down menu below.', 'kazaz' ),
		'id' => 'k_profile_edit_page',
		'std' => '',
		'type' => 'select',
		'options' => $options_pages );

	$options[] = array(
		'name' => 'Inappropriate content report',
		'desc' => __('Please provide an e-mail address where users may report inappropriate or offensive content.', 'kazaz'),
		'id' => 'k_flag_email',
		'std' => 'you@youremail.address.com',
		'type' => 'text');

	$options[] = array(
		'name' => 'Main search top margin',
		'desc' => __('Fine tune logo and search alignment by adding top margin. Enter the number (integer) of pixels without "px" at the end!', 'kazaz'),
		'id' => 'k_search_alignment',
		'std' => '15',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array( "name" => "Copyright Info",
		"desc" => __( 'Enter copyright information that will appear in your website footer.', 'kazaz' ),
		"id" => "k_copyright",
		"std" => "&copy; Theme by Sofarider inc. 2020 All rights reserved.",
		"type" => "textarea");

	$options[] = array( "name" => "Google Analytics",
		"desc" => __( 'Copy JS code provided by Google Analytics and paste it here. BEWARE: &lt;script type="text/javascript"&gt; and &lt;/script&gt; tags will be stripped from this text area but properly added to page. So no need to worry if you can\'t see them wrapping up your GA code!', 'kazaz' ),
		"id" => "k_analytics",
		"std" => "",
		"type" => "textarea");


	return $options;
}