<?php
/**
 * The Header for our theme.
 */
ikit_ssl_redirect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- Breakpoint body defines the responsive breakpoints -->
<html class="html cat-plugin-breakpoint-body" xml:lang="en" lang="en"
    cat_plugin_breakpoint_body_class="breakpoint-body"
    cat_plugin_breakpoint_body_size_class_prefix="breakpoint-body-size"
    cat_plugin_breakpoint_body_names="s,m,l,xl,2xl"
    cat_plugin_breakpoint_body_widths="640,960,1280,1440,1680">

<?php

// Define global variables here
global $g_main_nav_menu_items; // Only the parent menu items
global $g_main_nav_menu_items_by_parent_id; // Sub menu items by parent
global $g_main_nav_menu_items_all; // Flat listing of all nav menu items
global $g_theme_options; // Theme options
global $g_options; // Plugin options, set within the ikit plugin

// Get the main navigation menu
$nav_menu_locations = get_nav_menu_locations();
$nav_menu = wp_get_nav_menu_object( $nav_menu_locations[ 'nav-menu-main' ] );
$nav_menu_items = wp_get_nav_menu_items($nav_menu->term_id);
$g_main_nav_menu_items_all = $nav_menu_items;

// Store in hierachy, supports two levels of hiearchy only
$g_main_nav_menu_items = array(); // Only the top level
$g_main_nav_menu_items_by_parent_id = array(); // Secondary level by top level id
foreach((array)$nav_menu_items as $key => $nav_menu_item ) {
    if(intval($nav_menu_item->menu_item_parent) == 0) {
        array_push($g_main_nav_menu_items, $nav_menu_item);
        $g_main_nav_menu_items_by_parent_id[$nav_menu_item->ID] = array();
    }
}

foreach((array)$nav_menu_items as $key => $nav_menu_item ) {
    if(intval($nav_menu_item->menu_item_parent) != 0) {
        // Again only supports two levels of hierarchy
        if(array_key_exists(intval($nav_menu_item->menu_item_parent), $g_main_nav_menu_items_by_parent_id)) {
            array_push($g_main_nav_menu_items_by_parent_id[intval($nav_menu_item->menu_item_parent)], $nav_menu_item);
        }
    }
}

$g_theme_options = get_option(IKIT_THREE_THEME_OPTION_GROUP_GENERAL);

?>

<head>

<?php

$page_title = null;

global $page, $paged;

// Add the title of the page, followed by | separator, followed by site name,
// note that if the site name is already contained in the page title, in the case
// of using Yoast SEO etc. the site name is not appended.
$page_title = ikit_get_blog_title();
$page_title = wp_title("|", false, "right");
if(ikit_string_contains($page_title, ikit_get_blog_title()) == false) {
    $page_title .= ikit_get_blog_title();
}
$page_slug = null;

// Add the blog description for the home/front page.
$site_description = get_bloginfo('description', 'display');
if(is_home() || is_front_page()) {
    $page_title = empty($site_description) ? ikit_get_blog_title() : ikit_get_blog_title() . " | " . $site_description;
}

// If page, set the page slug
if(is_singular(array('page'))) {
    $page_slug = $post->post_name;
}

// If post or event, add open graph tags for sharing
if(is_singular(array('post', IKIT_POST_TYPE_IKIT_EVENT, IKIT_POST_TYPE_IKIT_EVENT_INTERNAL, 'page'))) {

    $page_slug = $post->post_name;

    // Image
    $feed_image_url = null;
    if($post->post_type == 'post') {
        $feed_image_url = ikit_post_get_image_url($post->ID, 'full', null);
    }
    else if($post->post_type == IKIT_POST_TYPE_IKIT_EVENT || $post->post_type == IKIT_POST_TYPE_IKIT_EVENT_INTERNAL) {
        $ikit_event_meta = ikit_event_get_meta($post->ID);
        $feed_image_url = ikit_event_get_image_url($post->ID, $ikit_event_meta, null);
    }

    // Description
    $page_description = htmlspecialchars(strip_tags($post->post_content));
    if (strlen($page_description) > IKIT_THREE_PAGE_DESCRIPTION_MAX_LENGTH) { // Truncate description
      $page_description = substr($page_description, 0, IKIT_THREE_PAGE_DESCRIPTION_MAX_LENGTH-3) . '...';
    }
    $preview_description = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_GENERIC_PREVIEW_DESCRIPTION, true);
    if(empty($preview_description) == false) {
        $page_description = $preview_description;
    }
    if(empty($page_description)) {
        $page_description = $site_description;
    }

    ?>

    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $page_description; ?>"/>
    <meta property="og:title" content="<?php echo $page_title; ?>"></meta>
    <meta property="og:description" content="<?php echo $page_description; ?>"></meta>
    <meta property="og:url" content="<?php echo get_permalink($post->ID); ?>"></meta>

    <?php if(empty($feed_image_url) == false) { ?>
        <meta property="og:image" content="<?php echo ikit_three_image_resize($feed_image_url, IKIT_THREE_IMAGE_RESIZE_SMALL);?>"></meta>
    <?php } ?>

    <?php

}
// Otherwise sitewide meta
else {

    ?>
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $site_description; ?>"/>
    <?php
}

?>

<!-- Support for canonical for SEO -->
<?php if(is_home() || is_front_page()) { ?>
  <link rel="canonical" href="<?php echo get_site_url(); ?>"/>
<?php } else if (is_singular()) { ?>
  <link rel="canonical" href="<?php echo get_permalink($post->ID); ?>"/>
<?php } ?>

<?php
$fav_icon_url = null;
if(array_key_exists(IKIT_THREE_THEME_OPTION_FAV_ICON, $g_theme_options)) {
    $fav_icon_url = $g_theme_options[IKIT_THREE_THEME_OPTION_FAV_ICON]['url'];
}
?>
<link rel="shortcut icon" href="<?php if(empty($fav_icon_url)) { echo bloginfo('template_url') . '/images/default_favicon.png'; } else { echo $fav_icon_url; }; ?>">

<!-- iOS devices should not auto-scale the website, as resolutions are perfectly matched -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0;">

<!-- Add theme stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style.css"/>

<!-- Add child theme stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<?php

wp_enqueue_script('jquery');
wp_enqueue_script('js_jquery_init', get_bloginfo('template_url') . '/js/jquery.init.js');
wp_enqueue_script('js_isotope', get_bloginfo('template_url') . '/js/jquery.isotope.js');
wp_enqueue_script('js_humanize', get_bloginfo('template_url') . '/js/humanize.js');
wp_enqueue_script('js_selectbox_input', get_bloginfo('template_url') . '/js/selectbox_input.js');

wp_enqueue_script('js_bowser', get_bloginfo('template_url') . '/js/bowser.min.js');
wp_enqueue_script('js_cat', get_bloginfo('template_url') . '/js/cat.js');
wp_enqueue_script('js_fluid_grid', get_bloginfo('template_url') . '/js/fluid_grid.js');
wp_enqueue_script('js_plugins', get_bloginfo('template_url') . '/js/plugins.js');
wp_enqueue_script('js_ikit_three', get_bloginfo('template_url') . '/js/ikit_three.js');

ikit_style_editor_enqueue_style('background_images');
ikit_style_editor_enqueue_style('sass');
ikit_style_editor_enqueue_style('sass_templates');

wp_enqueue_style('css_plugins', get_bloginfo('template_url') . '/css/plugins.css');
wp_enqueue_style('css_editor', get_bloginfo('template_url') . '/css/editor.css');

wp_head();

ikit_head();

?>

<!-- Add IE stylesheet -->
<?php if(preg_match('/msie/i',$_SERVER['HTTP_USER_AGENT'])) { ?>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie.css"/>
<?php } ?>

<!-- Add to calendar -->
<link href="https://addtocalendar.com/atc/1.5/atc-base.css " rel="stylesheet" type="text/css">
<script src="https://addtocalendar.com/atc/1.5/atc.min.js"></script>

<?php

$custom_font_embed_code = null;
if(array_key_exists(IKIT_THREE_THEME_OPTION_CUSTOM_FONT_EMBED_CODE, $g_theme_options) == true) {
    $custom_font_embed_code = $g_theme_options[IKIT_THREE_THEME_OPTION_CUSTOM_FONT_EMBED_CODE];
}

if(empty($custom_font_embed_code) == false) {
    echo $custom_font_embed_code;
}
else {
    ?>

    <script src="https://use.typekit.net/uwa3uik.js"></script>
    <script type="text/javascript">
    try{

        // Typekit Loaded fonts need to run the onloaded function
        Typekit.load({
            active: jQuery.ikit_three.fonts.onLoaded,
            inactive: jQuery.ikit_three.fonts.onLoaded
        });
    }
    catch(e) {}
    </script>
    <?php
}
?>

<!-- Global Javascript variables -->
<script type="text/javascript">
    g_templateUrl = "<?php echo get_bloginfo('template_url'); ?>";
</script>

<?php echo $g_options[IKIT_PLUGIN_OPTION_EMBED_CODES]; ?>
<?php echo $g_options[IKIT_PLUGIN_OPTION_HEADER_SCRIPTS]; ?>

</head>


<?php
$detect = new Mobile_Detect;
$browser_mobile_class_name = $detect->isMobile() ? 'browser-mobile' : '';
?>
<body <?php body_class('ikit-three ikit-body ikit post-name-' . $page_slug . ' ' . $browser_mobile_class_name); ?>>

<?php
// Alt image is for collapsed header state

$aiga_header_logo_image_url = null;
$aiga_header_logo_alt_image_url = null;
if(array_key_exists(IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_IMAGE, $g_theme_options)) {
    $aiga_header_logo_image_url = $g_theme_options[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_IMAGE]['url'];
}
if(array_key_exists(IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_ALT_IMAGE, $g_theme_options)) {
    $aiga_header_logo_alt_image_url = $g_theme_options[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_ALT_IMAGE]['url'];
}

?>

<div class="root" <?php if($g_theme_options[IKIT_THREE_THEME_OPTION_HEADER_LOCK_COLLAPSED_ENABLED] == true) { ?>data-theme-option-header-lock-collapsed="true"<?php } ?>>

<!-- If admin has decided to always show collapsed header, add an attribute the JS will key off of to disable, and set the data collapsed to true permanently for styling -->
<div class="header">

    <!-- Compact nav menu -->
    <div class="header-compact">
        <div class="header-compact-search"> <!-- This element sits above the other header elements, hidden by default -->
            <?php get_search_form(); ?>
        </div>

        <div class="header-compact-layout">
            <div class="header-compact-layout-left">
                <div class="header-compact-menu-button-open">
                    <a class="header-compact-menu-button-open-link" href="javascript:void(0)">
                        <div class="header-compact-menu-button-open-image"></div>
                    </a>
                </div>

                <div class="header-logo">
                    <a href="<?php echo home_url(); ?>">
                        <img class="header-logo-image" alt="Go to homepage" src="<?php if(empty($aiga_header_logo_image_url)) { echo get_bloginfo('template_url') . '/images/default_aiga_header_logo.svg'; } else { echo $aiga_header_logo_image_url; } ?>" />
                    </a>
                </div>
            </div>

            <div class="header-compact-layout-right">
                <a class="header-compact-button-search" href="javascript:void(0);">
                    <div class="header-compact-button-search-open-image"></div>
                    <div class="header-compact-button-search-close-image"></div>
                </a>
            </div>

        </div>
    </div>

    <!-- Desktop/Full size nav menu -->
    <div class="header-layout-container">
        <?php ikit_three_render_header_layout($aiga_header_logo_image_url, $aiga_header_logo_alt_image_url) ?>
    </div>

    <div class="header-layout-container-collapsed">
        <?php ikit_three_render_header_layout($aiga_header_logo_image_url, $aiga_header_logo_alt_image_url) ?>
    </div>

</div>

<!-- Functions independent from header as it is position absolute on scroll etc. -->
<div class="header-compact-menu">

    <div class="header-compact-menu-inner">

        <div class="header-compact-menu-button-close">
            <div class="header-compact-menu-button-close-image"></div>
        </div>

        <?php foreach($g_main_nav_menu_items as $main_nav_menu_item) { ?>

        <div class="header-compact-menu-item" id="header-compact-menu-item-<?php echo $main_nav_menu_item->ID; ?>">

            <?php if(count($g_main_nav_menu_items_by_parent_id[$main_nav_menu_item->ID]) == 0) { ?>
            <a class="header-compact-menu-item-link" href="<?php echo $main_nav_menu_item->url;?>">
                <?php ikit_three_render_sso_lock(array("post_id" => $main_nav_menu_item->object_id, "style" => "light")); ?>
                <?php echo $main_nav_menu_item->title;?>
            </a>
            <?php } else { ?>
            <a class='header-compact-menu-item-link-expand' href="javascript:void(0)" data-url="<?php echo $main_nav_menu_item->url?>">
                <div class="header-compact-menu-item-link-expand-title">
                    <?php ikit_three_render_sso_lock(array("post_id" => $main_nav_menu_item->object_id, "style" => "light")); ?>
                    <?php echo $main_nav_menu_item->title; ?>
                </div>
                <div class="header-compact-menu-item-link-expand-icon">
                    <div class="header-compact-menu-item-link-expand-icon-image"></div>
                </div>
            </a>
            <?php } ?>

            <div class="header-compact-menu-item-children">
                <?php foreach($g_main_nav_menu_items_by_parent_id[$main_nav_menu_item->ID] as $category_subitem) { ?>
                <div class="header-compact-menu-item-children-item">
                    <a class="header-compact-menu-item-children-item-link" target="<?php echo $category_subitem->target; ?>" href="<?php echo $category_subitem->url; ?>">
                        <?php ikit_three_render_sso_lock(array("post_id" => $category_subitem->object_id, "style" => "light")); ?>
                        <?php if($category_subitem->target == '_blank') { ?> \ <?php } ?>
                        <?php echo $category_subitem->title;?>
                    </a>
                </div>
                <?php } ?>
            </div>

        </div>

        <?php } ?>

    </div>

</div>

<!-- If always showing the collapsed header, need to set attribute on layout to allow for correct padding on page -->
<div class="layout">

<?php
$background_image = get_background_image();
$background_color = get_background_color();
$has_background = false;
if(empty($background_image) == false || empty($background_color) == false) {
    $has_background = true;
}
?>

<!-- Empty grid just used for calculating the width so they match a 4 column grid -->
<div class="sizing-grid-container">
    <div class="sizing-grid">
        <div class="cat-plugin-fluid-grid grid"
            cat_plugin_fluid_grid_breakpoint_body_size_num_cols="<?php echo IKIT_THREE_LAYOUT_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS; ?>"
            cat_plugin_fluid_grid_breakpoint_body_size_classes="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES; ?>"
            cat_plugin_fluid_grid_breakpoint_body_class="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS; ?>"
        >
            <div class="cat-plugin-fluid-grid-item grid-item"></div>
        </div>
    </div>
</div>


<div class="layout-content" style="<?php if($has_background) { echo 'background-color:transparent;'; } ?>">
