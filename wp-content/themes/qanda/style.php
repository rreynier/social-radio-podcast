<?php header( "Content-type: text/css; charset: UTF-8" ); ?>

<?php
$body_typo_style = of_get_option( 'k_main_typography' );
$body_appearance = of_get_option( 'k_main_background' );
?>
/* body appearance and typography */
section, body p { line-height: <?php echo (int)$body_typo_style[ 'size' ] + 11 . 'px'; ?> !important; }
body { font: <?php echo $body_typo_style[ 'size' ]; ?>/24px <?php echo font_parser( of_get_option( 'k_content_font' ) ); ?> !important; color: <?php echo $body_typo_style[ 'color' ]; ?>; font-weight: <?php echo $body_typo_style[ 'style' ]; ?>; }
<?php if( $body_appearance[ 'image' ] ) : ?>
body { background-image: url(<?php echo $body_appearance[ 'image' ]; ?>); background-repeat: <?php echo $body_appearance[ 'repeat' ]; ?>; background-position: <?php echo $body_appearance[ 'position' ]; ?>; background-attachment: <?php echo $body_appearance[ 'attachment' ]; ?>; background-color: <?php echo $body_appearance[ 'color' ]; ?>; }
<?php else : ?>
body { background-color: <?php echo $body_appearance[ 'color' ]; ?>; }
<?php endif; ?>

/* links */
#k-main-wrap a, #k-main-wrap a:link { color: <?php echo of_get_option( 'k_main_link' ); ?>; }
#k-main-wrap a:visited { color: <?php echo of_get_option( 'k_main_visited' ); ?>; }
#k-main-wrap a:hover, #k-main-wrap a:focus { color: <?php echo of_get_option( 'k_main_hover' ); ?>; }
.q-alien:link, .q-alien:hover, .q-alien:visited, .q-alien:focus,
.q-in-faves:link, .q-in-faves:hover, .q-in-faves:visited, .q-in-faves:focus { color: <?php echo $body_typo_style[ 'color' ]; ?> !important; }

#f-menu li.current-menu-item a { color: <?php echo of_get_option( 'k_main_hover' ); ?>; }
#count-title, #count-body, #count-tags, label.answer-comment-form-label span { color: <?php echo of_get_option( 'k_main_link' ); ?>; }
div.action-cover { background-color: <?php echo $body_appearance[ 'color' ]; ?>; }

/* titles */
<?php
$title_h1 = of_get_option( 'k_main_h1' );
$title_h2 = of_get_option( 'k_main_h2' );
$title_h3 = of_get_option( 'k_main_h3' );
$title_h4 = of_get_option( 'k_main_h4' );
$title_h5 = of_get_option( 'k_main_h5' );
$title_h6 = of_get_option( 'k_main_h6' );
?>
h1 { font-size: <?php echo $title_h1[ 'size' ]; ?>; color: <?php echo $title_h1[ 'color' ]; ?>; font-weight: <?php echo $title_h1[ 'style' ]; ?>; line-height: <?php echo (int)$title_h1[ 'size' ] + 5 . 'px'; ?>; margin: 0 0 <?php echo (int)$title_h1[ 'size' ] / 2 . 'px'?> 0; }
h2 { font-size: <?php echo $title_h2[ 'size' ]; ?>; color: <?php echo $title_h2[ 'color' ]; ?>; font-weight: <?php echo $title_h2[ 'style' ]; ?>; line-height: <?php echo (int)$title_h2[ 'size' ] + 5 . 'px'; ?>; margin: 0 0 <?php echo (int)$title_h2[ 'size' ] / 2 . 'px'?> 0; }
h3 { font-size: <?php echo $title_h3[ 'size' ]; ?>; color: <?php echo $title_h3[ 'color' ]; ?>; font-weight: <?php echo $title_h3[ 'style' ]; ?>; line-height: <?php echo (int)$title_h3[ 'size' ] + 5 . 'px'; ?>; margin: 0 0 <?php echo (int)$title_h3[ 'size' ] / 2 . 'px'?> 0; }
h4 { font-size: <?php echo $title_h4[ 'size' ]; ?>; color: <?php echo $title_h4[ 'color' ]; ?>; font-weight: <?php echo $title_h4[ 'style' ]; ?>; line-height: <?php echo (int)$title_h4[ 'size' ] + 5 . 'px'; ?>; margin: 0 0 <?php echo (int)$title_h4[ 'size' ] / 2 . 'px'?> 0; }
h5 { font-size: <?php echo $title_h5[ 'size' ]; ?>; color: <?php echo $title_h5[ 'color' ]; ?>; font-weight: <?php echo $title_h5[ 'style' ]; ?>; line-height: <?php echo (int)$title_h5[ 'size' ] + 5 . 'px'; ?>; margin: 0 0 <?php echo (int)$title_h5[ 'size' ] / 2 . 'px'?> 0; }
h6 { font-size: <?php echo $title_h6[ 'size' ]; ?>; color: <?php echo $title_h6[ 'color' ]; ?>; font-weight: <?php echo $title_h6[ 'style' ]; ?>; line-height: <?php echo (int)$title_h6[ 'size' ] + 5 . 'px'; ?>; margin: 0 0 <?php echo (int)$title_h6[ 'size' ] / 2 . 'px'?> 0; }

h1, h2, h3, h4, h5, h6, #site-title, #site-description { font-family: <?php echo font_parser( of_get_option( 'k_title_font' ) ); ?>; }

h1 a:link, h1 a:visited { color: <?php echo $title_h1[ 'color' ]; ?> !important; }
h2 a:link, h2 a:visited { color: <?php echo $title_h2[ 'color' ]; ?> !important; }
h3 a:link, h3 a:visited { color: <?php echo $title_h3[ 'color' ]; ?> !important; }
h4 a:link, h4 a:visited { color: <?php echo $title_h4[ 'color' ]; ?> !important; }
h5 a:link, h5 a:visited { color: <?php echo $title_h5[ 'color' ]; ?> !important; }
h6 a:link, h6 a:visited { color: <?php echo $title_h6[ 'color' ]; ?> !important; }

h1 a:hover, h1 a:focus, h2 a:hover, h2 a:focus, h3 a:hover, h3 a:focus,
h4 a:hover, h4 a:focus, h5 a:hover, h5 a:focus, h6 a:hover, h6 a:focus { color: <?php echo of_get_option( 'k_main_hover' ); ?> !important; }

<?php
/* titles in answer always use the same size - it is regular H4 */
$titles_answer = of_get_option( 'k_answer_titles_size' );
?>
.answer-main h1, .answer-main h2, .answer-main h3, .answer-main h4, .answer-main h5, .answer-main h6,
#wmd-preview h1, #wmd-preview h2, #wmd-preview h3, #wmd-preview h4, #wmd-preview h5,
#wmd-preview h6 { font-size: <?php echo $titles_answer[ 'size' ]; ?>; color: <?php echo $titles_answer[ 'color' ]; ?>; font-weight: <?php echo $titles_answer[ 'style' ]; ?>; line-height: <?php echo (int)$titles_answer[ 'size' ] + 5 . 'px'; ?>; margin: 0 0 <?php echo (int)$titles_answer[ 'size' ] / 2 . 'px'?> 0; }

/* main other */
.category-description { color: <?php echo $title_h1[ 'color' ]; ?>; }

#k-search-functional { margin-top: <?php echo of_get_option( 'k_search_alignment' ); ?>px; }

.entry-excerpt { color: <?php echo $title_h1[ 'color' ]; ?>; }
ol#comments { border-top-color: <?php echo of_get_option( 'k_separators_color' ); ?>; }
.reply { border-bottom-color: <?php echo of_get_option( 'k_separators_color' ); ?>; }
#related li { border-bottom: 1px dotted <?php echo of_get_option( 'k_separators_color' ); ?>; }

.author-info .avatar, .author-info img, .elite-list img { background-color: <?php echo $body_appearance[ 'color' ]; ?>; }

span.separator-short-fat, span.separator-mid-fat, span.separator-full-fat,
span.separator-short-tiny, span.separator-mid-tiny, span.separator-full-tiny,
.liner, span.inner-line, span.ss-line { background-color: <?php echo of_get_option( 'k_separators_color' ); ?>; }

.toggle-button, .tabbertab a, div.gallery { border: 1px solid <?php echo of_get_option( 'k_separators_color' ); ?>; }
.tabberdiv { border-top: 1px solid <?php echo of_get_option( 'k_separators_color' ); ?>; }
.tabbertab a.first-tab, blockquote { border-left: 1px solid <?php echo of_get_option( 'k_separators_color' ); ?> !important; }
td, th { border-bottom-color: <?php echo of_get_option( 'k_separators_color' ); ?> !important; }
li.podcast-comment, .lean-title { border-bottom: 5px solid <?php echo of_get_option( 'k_separators_color' ); ?>; }
.pagination { border-top: 5px solid <?php echo of_get_option( 'k_separators_color' ); ?>; }

.entry-meta-box { border-top: 1px dashed <?php echo of_get_option( 'k_separators_color' ); ?>; border-bottom: 1px dashed <?php echo of_get_option( 'k_separators_color' ); ?>; }
span.meta-row-wrap, .elite-list li { border-bottom: 1px dashed <?php echo of_get_option( 'k_separators_color' ); ?>; }

.answer-child .comment-body, .author-all-podcasts { border-top: 1px solid <?php echo of_get_option( 'k_separators_color' ); ?>; }
table.author-numbers { border-top: 1px solid <?php echo of_get_option( 'k_separators_color' ); ?>; border-bottom: 1px solid <?php echo of_get_option( 'k_separators_color' ); ?>; }
.bord-right { border-right: 1px solid <?php echo of_get_option( 'k_separators_color' ); ?> }

.wmd-preview { border: 1px dashed <?php echo of_get_option( 'k_separators_color' ); ?>; }
.wmd-spacer { background-color: <?php echo of_get_option( 'k_separators_color' ); ?> !important; }

.comment-reply-link,
.button, button, input[type="submit"], input[type="reset"], input[type="button"] { background-color: <?php echo of_get_option( 'k_main_link' ); ?>; color: <?php echo $body_appearance[ 'color' ]; ?>; }
.comment-reply-link:hover,
.button:hover, button:hover, input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover { background-color: <?php echo $title_h1[ 'color' ]; ?>; }
.comment-reply-link:link, .comment-reply-link:visited, .comment-reply-link:hover, .comment-reply-link:focus { color: <?php echo $body_appearance[ 'color' ]; ?> !important; }

pre, code { background-color: <?php echo of_get_option( 'k_pre_bg_color' ); ?>; }
pre { color: <?php echo of_get_option( 'k_pre_font_color' ); ?> !important; }

.lean-title { color: <?php echo of_get_option( 'k_main_link' ); ?>; }
.lean-close { background-color: <?php echo of_get_option( 'k_main_link' ); ?>; }

.widget_search #searchsubmit { color: <?php echo of_get_option( 'k_search_btn_font_color' ); ?> !important; background-color: <?php echo of_get_option( 'k_search_btn_background' ); ?> !important; }
.widget_search #searchsubmit:hover { background-color: <?php echo of_get_option( 'k_search_btn_hover_background' ); ?> !important; }

.tabbertab a.tabactive { border-bottom: 4px solid <?php echo $body_appearance[ 'color' ]; ?>; color: <?php echo of_get_option( 'k_main_hover' ); ?> !important; }

.meta-answers, .meta-votes, .meta-votes-answer, .meta-views, .meta-votes-single, .meta-pro, .meta-con, .meta-faved, .meta-date, .meta-comments { border-bottom: 1px dashed <?php echo of_get_option( 'k_separators_color' ); ?>; }

.tip-error { color: <?php echo of_get_option( 'k_main_link' ); ?>; }

span.rep-score { color: <?php echo $title_h1[ 'color' ]; ?>; }

hr { border-color: <?php echo of_get_option( 'k_separators_color' ); ?> !important; }

/* sidebar */
<?php
$site_title = of_get_option( 'k_site_title' );
$site_description = of_get_option( 'k_site_description' );
$widget_title = of_get_option( 'k_widget_title' );
?>

#site-title { font-size: <?php echo $site_title[ 'size' ]; ?>; color: <?php echo $site_title[ 'color' ]; ?>; font-weight: <?php echo $site_title[ 'style' ]; ?>; }
#site-description { font-size: <?php echo $site_description[ 'size' ]; ?>; color: <?php echo $site_description[ 'color' ]; ?>; font-weight: <?php echo $site_description[ 'style' ]; ?>; }

h1#site-title a, h1#site-title a:link, h1#site-title a:visited,
h1#site-title a:hover, h1#site-title a:focus { color: <?php echo $site_title[ 'color' ]; ?> !important; }

.widget-title { font-size: <?php echo $widget_title[ 'size' ]; ?>; color: <?php echo $widget_title[ 'color' ]; ?>; font-weight: <?php echo $widget_title[ 'style' ]; ?>; line-height: <?php echo (int)$widget_title[ 'size' ] + 10 . 'px'; ?>; }

/* main navigation */
<?php
$main_navig = of_get_option( 'k_menu_font_style' );
$main_navig_uppercase = ( of_get_option( 'k_menu_uppercase' ) ) ? 'uppercase' : 'normal';
?>
ul#header-menu li.menu-item a,
ul#alternative-menu li.menu-item a { font-family: <?php echo font_parser( of_get_option( 'k_content_font' ) ); ?>; font-size: <?php echo $main_navig[ 'size' ]; ?>; color: <?php echo $main_navig[ 'color' ]; ?> !important; font-weight: <?php echo $main_navig[ 'style' ]; ?>; text-transform: <?php echo $main_navig_uppercase; ?>; }

ul#header-menu li a:visited,
ul#header-menu li a:focus,
ul#header-menu li ul.sub-menu li a,
ul#header-menu li a:active,
ul#alternative-menu li a:visited,
ul#alternative-menu li a:focus,
ul#alternative-menu li ul.sub-menu li a,
ul#alternative-menu li a:active { color: <?php echo $main_navig[ 'color' ]; ?> !important; }

ul#header-menu li.current-menu-item a,
ul#header-menu ul.sub-menu li.current-menu-item a,
ul#header-menu li a:hover,
ul#header-menu ul.sub-menu li a:hover,
ul#header-menu li a.selected,
ul#header-menu ul.sub-menu li a.selected,
ul#alternative-menu li.current-menu-item a,
ul#alternative-menu ul.sub-menu li.current-menu-item a,
ul#alternative-menu li a:hover,
ul#alternative-menu ul.sub-menu li a:hover,
ul#alternative-menu li a.selected,
ul#alternative-menu ul.sub-menu li a.selected { color: <?php echo of_get_option( 'k_menu_hover_color' ); ?> !important; }

<?php $sub_menu_font_size = (int)$main_navig[ 'size' ] - 2 . 'px'; ?>
ul#header-menu ul.sub-menu li a,
ul#alternative-menu ul.sub-menu li a { font-size: <?php echo $sub_menu_font_size ?>; }

ul#header-menu ul.sub-menu li { background-color: <?php echo of_get_option( 'k_menu_sub_bg_color' ); ?>; }

#twitter_update_list li { border-bottom: 1px solid <?php echo of_get_option( 'k_separators_color' ); ?>; }
ul#alternative-menu li a { border-bottom: 1px dotted <?php echo of_get_option( 'k_separators_color' ); ?>; }

#k-subheader { border-top: 1px solid <?php echo of_get_option( 'k_separators_color' ); ?>; border-bottom: 1px solid <?php echo of_get_option( 'k_separators_color' ); ?>; }
#k-footer-copy, #k-footer-widgets { border-top: 4px double <?php echo of_get_option( 'k_separators_color' ); ?>; }

/* icon invertion */
<?php if( of_get_option( 'k_content_invert_icons' ) ) { ?>

	.meta-answers, .aaq-answers { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/answers_light.png'; ?>) !important; }
    .meta-votes, .aaq-votes { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/votes_light.png'; ?>) !important; }
    .meta-views, .aaq-views { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/views_light.png'; ?>) !important; }
	.vote-pro { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/vote_pro_light.png'; ?>) !important; }
    .vote-con { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/vote_con_light.png'; ?>) !important; }
    .aaq-faves-no { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/faved_no_light.png'; ?>) !important; }
    .add-to-faves { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/faved_light.png'; ?>) !important; }

    .entry-time-author { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/time_light.png'; ?>) !important; }
    .entry-tags-wrap { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/tag_light.png'; ?>) !important; }
    .entry-edit, .meta-profile-button a { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/edit_light.png'; ?>) !important; }
    .entry-flag { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/flag_light.png'; ?>) !important; }

    .submit-answer-edit-form { background-image: url(<?php echo get_template_directory_uri() . '/images/edit_answer_light.png'; ?>) !important; }
    .add-answer-comment { background-image: url(<?php echo get_template_directory_uri() . '/images/reply_light.png'; ?>) !important; }
    .k-flag-answer { background-image: url(<?php echo get_template_directory_uri() . '/images/flag_small_light.png'; ?>) !important; }
    a.k-delete-comment { background-image: url(<?php echo get_template_directory_uri() . '/images/del_comment_light.png'; ?>) !important; }
    a.k-flag-comment { background-image: url(<?php echo get_template_directory_uri() . '/images/flag_small_light.png'; ?>) !important; }
    .meta-date { background-image: url(<?php echo get_template_directory_uri() . '/images/clock_light.png'; ?>) !important; }
    .meta-comments { background-image: url(<?php echo get_template_directory_uri() . '/images/comments_light.png'; ?>) !important; }

    #menu-icon { background-image: url(<?php echo get_template_directory_uri() . '/images/menu_icon32.png'; ?>) !important; }

    span.twitt-date { background-image: url(<?php echo get_template_directory_uri() . '/images/twitter_bird.png'; ?>) !important; }
    .vcard .fn { background-image: url(<?php echo get_template_directory_uri() . '/images/v_card_icons/me.png'; ?>) !important; }
    .vcard .tel { background-image: url(<?php echo get_template_directory_uri() . '/images/v_card_icons/phone.png'; ?>) !important; }
    .vcard .email { background-image: url(<?php echo get_template_directory_uri() . '/images/v_card_icons/email.png'; ?>) !important; }
    .vcard .street-address { background-image: url(<?php echo get_template_directory_uri() . '/images/v_card_icons/address.png'; ?>) !important; }

    .status-open, .aaq-status-open { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/status_open_light.png'; ?>) !important; }

    .aaq-remove-fave { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/delete_light.png'; ?>) !important; }

    .q-accept { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/accept_light.png'; ?>) !important; }

    .wmd-preview-title { background-image: url(<?php echo get_template_directory_uri() . '/images/icons_article/views_light.png'; ?>) !important; }

    span.toggle-icon { background-image: url(<?php echo get_template_directory_uri() . '/images/toggle_light.png'; ?>) !important; }

    #lean_overlay { background-color: #FFFFFF !important; }
    .lean-alert { background-color: <?php echo $body_appearance[ 'color' ]; ?> !important; }

    .form-cover { background-color: #000000 !important; }
    .comment-form-author dd, .comment-form-email dd, .comment-form-url dd, .cfp { background-image: url(<?php echo get_template_directory_uri() . '/images/stripes_light.png'; ?>) !important; }

    #go-top { background-image: url(<?php echo get_template_directory_uri() . '/images/gotop_light.png'; ?>) !important; }
<?php } ?>