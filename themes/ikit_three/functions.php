<?php

/**
 * Theme constants
 */

define("IKIT_THREE_THEME_NAME", 'ikit_three');
define("IKIT_THREE_JOBS_POSTS_PER_PAGE", 15);
define("IKIT_THREE_PORTFOLIOS_POSTS_PER_PAGE", 15);
define("IKIT_THREE_EVENTS_PAST_POSTS_PER_PAGE", 15);
define("IKIT_THREE_NEWS_POSTS_PER_PAGE", 12);
define("IKIT_THREE_EVENTS_POSTS_PER_PAGE", 9);
define("IKIT_THREE_MEMBER_DIRECTORY_POSTS_PER_PAGE", 20);
define("IKIT_THREE_MAX_SEARCH_RESULTS", 25);

define("IKIT_THREE_PAGE_DESCRIPTION_MAX_LENGTH", 300);

define("IKIT_THREE_THEME_OPTION_GROUP_GENERAL", "ikit_three_general");
define("IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_IKIT_EVENT", "comments_enabled_ikit_event");
define("IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_POST", "comments_enabled_post");
define("IKIT_THREE_THEME_OPTION_EVENT_ATTENDEE_LIST_ENABLED", "event_attendee_list_enabled");
define("IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_IMAGE", "aiga_header_logo_image");
define("IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_ALT_IMAGE", "aiga_header_logo_alt_image");
define("IKIT_THREE_THEME_OPTION_FAV_ICON", "fav_icon");
define("IKIT_THREE_THEME_OPTION_CUSTOM_FONT_EMBED_CODE", "custom_font_embed_code");
define("IKIT_THREE_THEME_OPTION_DEFAULT_CALENDAR_VIEW_EVENTS", "default_calendar_view_events");
define("IKIT_THREE_THEME_OPTION_IKIT_EVENTS_INTERNAL_SEPARATE_PAGE", "ikit_events_internal_separate_page");
define("IKIT_THREE_THEME_OPTION_EVENTS_HIDE_FEED", "events_hide_feed");
define("IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_PERSON", "single_enabled_ikit_person");
define("IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR", "single_enabled_ikit_sponsor");
define("IKIT_THREE_THEME_OPTION_FOOTER_HIDE_LOCAL_SPONSORS", "footer_hide_local_sponsors");
define("IKIT_THREE_THEME_OPTION_PERSONS_SINGLE_SMALL_HERO_IMAGE_ENABLED", "persons_single_small_hero_image_enabled");
define("IKIT_THREE_THEME_OPTION_NEWS_SINGLE_SMALL_HERO_IMAGE_ENABLED", "news_single_small_hero_image_enabled");
define("IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED", "events_single_small_hero_image_enabled");
define("IKIT_THREE_THEME_OPTION_HEADER_LOCK_COLLAPSED_ENABLED", "header_lock_collapsed_enabled");

define("IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES", "breakpoint-body-size-2xl,breakpoint-body-size-xl,breakpoint-body-size-l,breakpoint-body-size-m,breakpoint-body-size-s");
define("IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS", "breakpoint-body");

define("IKIT_THREE_LAYOUT_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS", "4,4,3,2,1");
define("IKIT_THREE_PAGE_LAYOUT_5_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS", "3,3,3,2,1");
define("IKIT_THREE_PAGE_LAYOUT_4_TOOLS_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS", "1,1,1,3,1");
define("IKIT_THREE_PAGE_LAYOUT_4_BODY_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS", "4,4,3,2,1");
define("IKIT_THREE_PAGE_LAYOUT_4_BODY_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS_SIDEBAR", "3,3,3,2,1");
define("IKIT_THREE_PAGE_LAYOUT_4_BODY_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS_TOC", "3,3,2,2,1");
define("IKIT_THREE_PAGE_LAYOUT_4_BODY_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS_SIDEBAR_TOC", "2,2,2,2,1");
define("IKIT_THREE_PAGE_LAYOUT_4_BODY_FULL_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS", "4,4,3,2,1");

define("IKIT_THREE_EVENTS_TYPE_AIGA", "aiga");
define("IKIT_THREE_EVENTS_TYPE_COMMUNITY", "community");

define("IKIT_THREE_CUSTOM_FIELD_IKIT_EVENT_INTERNAL_DISABLE_DETAIL", "disable_detail");
define("IKIT_THREE_CUSTOM_FIELD_POST_HIDE_PUBLISHED_DATE", "hide_published_date");
define("IKIT_THREE_CUSTOM_FIELD_PAGE_TEMPLATE_SECTION_TOC_ALT_1_CONTENT_ITEMS", "page_template_section_toc_alt_1_content_items");

define("IKIT_THREE_IMAGE_RESIZE_SMALL", "small");
define("IKIT_THREE_IMAGE_RESIZE_MEDIUM", "medium");
define("IKIT_THREE_IMAGE_RESIZE_LARGE", "large");

/**
 * Theme setup
 */
add_action('after_setup_theme', 'ikit_three_setup');

function ikit_three_setup() {

  // Custom header support
  add_theme_support('custom-header', array(
      'wp-head-callback' => 'ikit_three_header_style',
      'admin-head-callback' => 'ikit_three_admin_header_style'
      )
  );

  define('HEADER_TEXTCOLOR', 'FFFFFF');

  // Custom background support
  add_theme_support('custom-background');

  // Includes
  require(get_template_directory() . '/includes/theme_options.php');
  require(get_template_directory() . '/includes/widgets.php');
  require(get_template_directory() . '/includes/shortcodes.php');
  require(get_template_directory() . '/includes/ajax_render.php');
  require(get_template_directory() . '/includes/updates.php');
  require(get_template_directory() . '/includes/acf.php');

  // Set defaults for theme options
  $theme_options = get_option(IKIT_THREE_THEME_OPTION_GROUP_GENERAL);
  $theme_options_updated = false;

  if(isset($theme_options[IKIT_THREE_THEME_OPTION_EVENT_ATTENDEE_LIST_ENABLED]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_EVENT_ATTENDEE_LIST_ENABLED] = 1;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_IKIT_EVENT]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_IKIT_EVENT] = 0;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_POST]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_POST] = 1;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_DEFAULT_CALENDAR_VIEW_EVENTS]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_DEFAULT_CALENDAR_VIEW_EVENTS] = 0;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_PERSON]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_PERSON] = 0;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_IKIT_EVENTS_INTERNAL_SEPARATE_PAGE]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_IKIT_EVENTS_INTERNAL_SEPARATE_PAGE] = 0;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_PERSONS_SINGLE_SMALL_HERO_IMAGE_ENABLED]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_PERSONS_SINGLE_SMALL_HERO_IMAGE_ENABLED] = 0;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR] = 0;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_FOOTER_HIDE_LOCAL_SPONSORS]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_FOOTER_HIDE_LOCAL_SPONSORS] = 0;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_EVENTS_HIDE_FEED]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_EVENTS_HIDE_FEED] = 0;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_NEWS_SINGLE_SMALL_HERO_IMAGE_ENABLED]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_NEWS_SINGLE_SMALL_HERO_IMAGE_ENABLED] = 0;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED] = 0;
      $theme_options_updated = true;
  }
  if(isset($theme_options[IKIT_THREE_THEME_OPTION_HEADER_LOCK_COLLAPSED_ENABLED]) == false) {
      $theme_options[IKIT_THREE_THEME_OPTION_HEADER_LOCK_COLLAPSED_ENABLED] = 0;
      $theme_options_updated = true;
  }
  if($theme_options_updated) {
      update_option(IKIT_THREE_THEME_OPTION_GROUP_GENERAL, $theme_options);
  }

}

function ikit_three_header_style() {

}

function ikit_three_admin_header_style() {

}

/**
 * Theme options
 */
function ikit_three_options_setup() {
  add_theme_page('Theme Options', 'Theme Options', 'manage_options', 'ikit-three-theme-options', 'ikit_three_theme_options_page_render');
}

add_action('admin_menu', 'ikit_three_options_setup');


/**
 * Theme support for widgets
 */
add_action('widgets_init', 'ikit_three_widgets_setup');

function ikit_three_widgets_setup() {

  $before_widget = '<div id="%1$s" class="widget ikit-widget %2$s"><div class="widget-content"><div class="widget-content-inner">';
  $after_widget = '</div></div></div>';

  register_sidebar( array(
  'name' => __('Index Billboard'),
  'id' => 'index-billboard-sidebar',
  'before_widget' => $before_widget,
  'after_widget' => $after_widget
  ));

  register_sidebar( array(
  'name' => __('Index'),
  'id' => 'index-sidebar',
  'before_widget' => $before_widget,
  'after_widget' => $after_widget
  ));

  register_sidebar( array(
  'name' => __('Page'),
  'id' => 'page-sidebar',
  'before_widget' => $before_widget,
  'after_widget' => $after_widget
  ));

  register_sidebar( array(
  'name' => __('News'),
  'id' => 'news-sidebar',
  'before_widget' => $before_widget,
  'after_widget' => $after_widget
  ));

  register_sidebar( array(
  'name' => __('Events'),
  'id' => 'events-sidebar',
  'before_widget' => $before_widget,
  'after_widget' => $after_widget
  ));

  register_sidebar( array(
  'name' => __('Jobs'),
  'id' => 'jobs-sidebar',
  'before_widget' => $before_widget,
  'after_widget' => $after_widget
  ));

  register_sidebar( array(
  'name' => __('Membership Directory'),
  'id' => 'member-directory-sidebar',
  'before_widget' => $before_widget,
  'after_widget' => $after_widget
  ));

  register_sidebar( array(
  'name' => __('Portfolios'),
  'id' => 'portfolios-sidebar',
  'before_widget' => $before_widget,
  'after_widget' => $after_widget
  ));

  register_sidebar( array(
  'name' => __('Section Table of Contents'),
  'id' => 'section-toc-sidebar',
  'before_widget' => $before_widget,
  'after_widget' => $after_widget
  ));

  // Remove default widgets
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Search');
  unregister_widget('WP_Widget_Pages');
  unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_Categories');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Tag_Cloud');
  unregister_widget('WP_Nav_Menu_Widget');
  unregister_widget('Ikit_WidgetSocial');
  unregister_widget('Ikit_WidgetEventCalendar');
  unregister_widget('Ikit_Events_Billboard_Widget');
  unregister_widget('Ikit_News_Billboard_Widget');
  unregister_widget('Ikit_Video_Billboard_Widget');
  unregister_widget('GFWidget');

}

/**
 * Theme support for navigation menus
 */
function ikit_three_nav_menus_setup() {

  // XXX Nasty hack, for some reason whenever we register custom nav menus in the wp 4.3.x it breaks the customizer
  // so we basically just don't register the custom menu when using the customizer, likely the issue is it can't find
  // custom menus so fails with a js error. Hopefully fixed in later versions of WP.
  if(strpos(ikit_get_request_url(false), 'customize.php') !== false) {

  }
  else {
      register_nav_menus(
      array('nav-menu-main' => __('Main Menu'))
      );
  }

}

add_action( 'admin_init', 'ikit_three_nav_menus_setup' );

/**
 * Enable shortcode media button (classic editor only, see https://wordpress.org/plugins/classic-editor/)
 * otherwise is supported by the block editor.
 */
add_action('media_buttons', 'ikit_shortcodes_media_button_setup', 1);

/**
 * Enable custom gutenberg blocks
 */
add_action('enqueue_block_editor_assets', 'ikit_blocks_enqueue_assets');

/**
 * Enable style editor
 */
add_action('admin_menu', 'ikit_menu_style_editor_menu_add', 9);

/**
 * Custom editor styles
 */
add_editor_style('css/editor.css'); // Adds support for editor-style.css so you can see the style in editor

function ikit_three_render_comments() {
    ?>
    <div class="page-layout-5 comments">
    <div class="page-layout-5-inner">

    <table>
    <tr>
        <td class="page-layout-5-spacer"/>
        <td class="page-layout-5-body">

        <div class="page-layout-5-body-title">Comments</div>

            <div class="page-layout-5-body-grid">
                <div class="page-layout-5-body-grid-item-single">
                    <div class="page-layout-5-body-grid-item-single-inner">
                    <?php include(TEMPLATEPATH . '/post_comments.php'); ?>
                    </div>
                </div>
            </div>

        </td>
        <td class="page-layout-5-sidebar"/>
    </tr>
    </table>

    </div>
    </div>

    <?php
}

function ikit_three_render_events_calendar_day_compact($day = null, $events_by_date = null, $current_date = null, $check_date  = null) {

    // Check if no events the entire month and if so show no results
    if($check_date != null && $day == 1) {

        $month_has_events = false;
        $year = (int)explode('-', $check_date)[0];
        $month = (int)explode('-', $check_date)[1];
        $date = mktime(12, 0, 0, $month, 1, $year);
        $days_in_month = date("t", $date);
        for($test_day = 1; $test_day <= $days_in_month; $test_day++) {
            if(array_key_exists($year . '-' . $month . '-' . $test_day, $events_by_date)) {
                $month_has_events = true;
            }
        }

        if($month_has_events == false) {
            ?>
            <div class="events-calendar-day-compact">
                <div class="events-calendar-day-compact-date">
                  <div class="no-results">No results found.</div>
                </div>
            </div>
            <?php
        }

    }

    // Display each day and the events it contains
    if(!empty($events_by_date) && array_key_exists($check_date, $events_by_date)) {

        ?>
        <div class="events-calendar-day-compact">
        <div class="events-calendar-day-compact-date"><?php echo date('F j', strtotime($check_date)); ?></div>
        <?php

        $events_for_date = $events_by_date[$check_date];
        foreach($events_for_date as $key=>$event_for_date) {
            $post = $event_for_date[0];
            $ikit_event_meta = $event_for_date[1];
            $event = ikit_event_get_meta_normalized($post->ID, $ikit_event_meta, null);
            $event_location_city = $event['location_city'];
            $event_start_date = $event['start_date'];
            $event_end_date = $event['end_date'];
            $event_permalink = $event['permalink'];
            $event_permalink_target = $event['permalink_target'];
            $event_url = $event['url'];
            $event_url_target = $event['url_target'];
            $external = false;
            $internal = false;
            $event_start_time = $event['start_time'];
            $event_end_time = $event['end_time'];
            $event_start_time_raw = $event['start_time_raw'];
            $event_end_time_raw = $event['end_time_raw'];
            $event_timezone_abbreviation = $event['timezone_abbreviation'];

            if($ikit_event_meta->service == IKIT_EVENT_SERVICE_EXTERNAL) {
                $external = true;
            }
            else if($ikit_event_meta->service == IKIT_EVENT_SERVICE_INTERNAL) {
                $internal = true;
            }

            ?>
            <a class="link-block events-calendar-day-compact-event-link" target="<?php echo $event_permalink_target; ?>" href="<?php echo $event_permalink; ?>">

                <div class="events-calendar-day-compact-event-info">
                    <div class="events-calendar-day-compact-event-title">
                        <?php echo $post->post_title;?>
                    </div>
                    <div class="events-calendar-day-compact-event-attributes">
                        <?php
                        ikit_three_render_event_item_attributes($post, $external, $internal, $event_start_date, $event_end_date, $event_location_city, $event_start_time, $event_end_time, $event_start_time_raw, $event_end_time_raw, $event_timezone_abbreviation);
                        ?>
                    </div>
                    <?php ikit_three_render_sso_lock(array("post_id" => $post->ID)); ?>
                </div>

            </a>
            <?php
        }

        ?>
        </div>
        <?php
    }

}

/**
 * Render a single event calendar day, should only be used by the ajax function, ikit_three_ajax_render_events_calendar
 */
function ikit_three_render_events_calendar_day($day = null, $events_by_date = null, $current_date = null, $check_date  = null) {

    ?>

    <td class="events-calendar-day <?php if($day == null) { echo 'events-calendar-day-not-in-month'; } ?> <?php if($current_date == $check_date) { echo 'events-calendar-day-current'; } ?>">
        <div class="events-calendar-day-content">
            <table>
                <tr>
                <td>

                <div class="events-calendar-day-events">
                <?php
                if(!empty($events_by_date) && array_key_exists($check_date, $events_by_date)) {

                    $events_for_date = $events_by_date[$check_date];
                    foreach($events_for_date as $key=>$event_for_date) {
                        $post = $event_for_date[0];
                        $ikit_event_meta = $event_for_date[1];

                        $event = ikit_event_get_meta_normalized($post->ID, $ikit_event_meta, null);
                        $event_location_city = $event['location_city'];
                        $event_start_date = $event['start_date'];
                        $event_end_date = $event['end_date'];
                        $event_permalink = $event['permalink'];
                        $event_permalink_target = $event['permalink_target'];
                        $event_url = $event['url'];
                        $event_url_target = $event['url_target'];
                        $external = false;
                        $internal = false;
                        $event_start_time = $event['start_time'];
                        $event_end_time = $event['end_time'];
                        $event_start_time_raw = $event['start_time_raw'];
                        $event_end_time_raw = $event['end_time_raw'];
                        $event_image = ikit_event_get_image_url($post->ID, $ikit_event_meta, null, 'full');
                        $event_timezone_abbreviation = $event['timezone_abbreviation'];

                        if($ikit_event_meta->service == IKIT_EVENT_SERVICE_EXTERNAL) {
                            $external = true;
                        }
                        else if($ikit_event_meta->service == IKIT_EVENT_SERVICE_INTERNAL) {
                            $internal = true;
                        }

                        ?>
                        <div class="events-calendar-day-event">

                            <a class="events-calendar-day-event-image-link" target="<?php echo $event_permalink_target; ?>" href="<?php echo $event_permalink; ?>">
                                <div class="events-calendar-day-event-image cat-plugin-anystretch-image"
                                    cat_plugin_anystretch_image_alt="Event image"
                                    cat_plugin_anystretch_image_url="<?php if($event_image) { echo ikit_three_image_resize($event_image, IKIT_THREE_IMAGE_RESIZE_SMALL); } ?>"
                                >
                                </div>
                            </a>

                            <a class="events-calendar-day-event-info-link" target="<?php echo $event_permalink_target; ?>" href="<?php echo $event_permalink; ?>">

                                <div class="events-calendar-day-event-info">
                                    <div class="events-calendar-day-event-info-title">
                                        <?php echo $post->post_title;?>
                                    </div>
                                    <div class="events-calendar-day-event-info-attributes">
                                        <?php
                                        ikit_three_render_event_item_attributes($post, $external, $internal, $event_start_date, $event_end_date, $event_location_city, $event_start_time, $event_end_time, $event_start_time_raw, $event_end_time_raw, $event_timezone_abbreviation);
                                        ?>
                                    </div>
                                    <?php ikit_three_render_sso_lock(array("post_id" => $post->ID, "style" => "light")); ?>
                                </div>

                            </a>

                        </div>
                        <?php
                    }

                }
                else {
                    ?>
                    <div class="events-calendar-day-event events-calendar-day-event-0">
                        <div class="events-calendar-day-event-empty">
                            <table>
                            <tr>
                            <td>
                            <?php if($day != null) { echo $day; } ?>
                            </td>
                            </tr>
                            </table>
                        </div>
                    </div>
                    <?php
                }

                ?>
                </div>
                </td>
                </tr>
            </table>
        </div>
    </td>
    <?php
}

/**
 * Render titles styles for widgets, wordpress will automatically add <h2 class="widgettitle"></h2>
 * placing the title rendered her inbetween, styles can then be added to widgettitle, this ensures
 * that non-ikit widgets still render their titles appropriately.
 */
function ikit_three_render_widget_header($title = null, $link_url = null, $link_target = null) {
    ?>
    <div class="<?php if(empty($link_url) == false) { ?>cat-plugin-click-redirect<?php } ?>"
        cat_plugin_click_redirect_url="<?php echo $link_url; ?>"
        cat_plugin_click_redirect_target="<?php echo $link_target; ?>"
    >
        <?php echo $title ?>
    </div>
    <?php
}

function ikit_three_has_toc($post) {

    global $g_main_nav_menu_items_by_parent_id;

    $parent_main_nav_menu_item_id = ikit_get_parent_nav_menu_item_id($post);

    if($parent_main_nav_menu_item_id == null || $parent_main_nav_menu_item_id == 0) {
        return false;
    }

    return true;

}

/**
 * Render table of contents for the post, this finds the nav menu item parent
 * and lists all the sub nav menu items as links, you can specify a class name
 * prefix to be prefixed to the rendered elements.
 */
function ikit_three_render_toc($post) {

    global $g_main_nav_menu_items_by_parent_id;

    $parent_main_nav_menu_item_id = ikit_get_parent_nav_menu_item_id($post);

    if($parent_main_nav_menu_item_id != null) {
        $main_nav_menu_items_for_parent_id = $g_main_nav_menu_items_by_parent_id[$parent_main_nav_menu_item_id];

        ?>
        <div class="toc-links">
        <?php

        foreach($main_nav_menu_items_for_parent_id as $main_nav_menu_item_for_parent_id) {

            $active = false;
            if($main_nav_menu_item_for_parent_id->object_id == $post->ID) {
                $active = true;
            }

            ?>
            <div class="toc-link-container">
                <a class="toc-link <?php if($active) { echo 'active'; } ?>" target="<?php echo $main_nav_menu_item_for_parent_id->target; ?>" href="<?php echo $main_nav_menu_item_for_parent_id->url; ?>">
                    <?php ikit_three_render_sso_lock(array("post_id" => $main_nav_menu_item_for_parent_id->object_id)); ?>
                    <?php if($main_nav_menu_item_for_parent_id->target == '_blank') { ?> \ <?php } ?>
                    <?php echo $main_nav_menu_item_for_parent_id->title; ?>
                </a>
           </div>
            <?php
        }

        ?>
        </div>
        <?php

    }

}


/**
 * Get the sponsor permalink. By default there is no permalink, clicking on the sponsor
 * will go to the sponsor's URL. However, if single is enabled, the permalink will
 * be the link to the detail page.
 */
function ikit_three_sponsor_get_permalink($ikit_sponsor_id) {

    $sponsor_url = get_post_meta($ikit_sponsor_id, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_URL, true);

    if(get_option(IKIT_THREE_THEME_OPTION_GROUP_GENERAL)[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR] == true) {
        $sponsor_url = get_permalink($ikit_sponsor_id);
    }

    return $sponsor_url;

}

/**
 * Get the sponsor permalink target, depending on if single is enabled.
 */
function ikit_three_sponsor_get_permalink_target($ikit_sponsor_id) {

    $sponsor_url_target = "_blank";

    if(get_option(IKIT_THREE_THEME_OPTION_GROUP_GENERAL)[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR] == true) {
        $sponsor_url_target = "_self";
    }

    return $sponsor_url_target;

}

/**
 * Get the date of the news post, it can be disabled via theme options
 */
function ikit_three_get_post_date($post) {

    if(get_post_meta($post->ID, IKIT_THREE_CUSTOM_FIELD_POST_HIDE_PUBLISHED_DATE, true) == true) {
        return null;
    }

    return $post->post_date;


}

/**
 * Render the SSO lock icon. You can pass 'style' => 'light' to render the light
 * version of the icon for dark backgrounds.
 */
function ikit_three_render_sso_lock($args) {

    $has_lock = true;
    if(array_key_exists('post_id', $args)) {
        $has_lock = ikit_sso_has_lock($args['post_id']);
    }
    if($has_lock) {
    ?>
    <div class="sso-lock sso-lock-<?php echo $args['style']; ?>">
        <div class="sso-lock-icon"></div>
        <div class="sso-lock-label">Members only</div>
    </div>
    <?php
    }
}

/**
 * Because there are actually two headers, one that stays positioned relative with a large logo
 * and the other shrunken with the alt logo, but they share the exact same code, so we use this
 * functio to render each version.
 */
function ikit_three_render_header_layout($aiga_header_logo_image_url, $aiga_header_logo_alt_image_url) {

    global $g_main_nav_menu_items;
    global $g_main_nav_menu_items_by_parent_id;

    ?>

    <div class="header-layout">

        <div class="header-layout-left">

            <div class="header-logo">
                <a href="<?php echo home_url(); ?>">
                    <img class="header-logo-image" alt="Go to homepage" src="<?php if(empty($aiga_header_logo_image_url)) { echo get_bloginfo('template_url') . '/images/default_aiga_header_logo.svg'; } else { echo $aiga_header_logo_image_url; } ?>" />
                    <img class="header-logo-image-alt" alt="Go to homepage" src="<?php if(empty($aiga_header_logo_alt_image_url)) { echo get_bloginfo('template_url') . '/images/default_aiga_header_logo_alt.svg'; } else { echo $aiga_header_logo_alt_image_url; } ?>" />
                </a>
            </div>

        </div>

        <div class="header-layout-right">

            <div class="header-menu">
                <?php foreach($g_main_nav_menu_items as $item) { ?>

                    <?php

                    // If we are on the menu item page or any of its children menu
                    // items we consider the item active.
                    $item_active = false;
                    if($item->post_name == 'home' && (is_home() || is_front_page())) { $item_active = true; }
                    if($item->object == 'page' && is_page($item->object_id)) { $item_active = true; }
                    foreach($g_main_nav_menu_items_by_parent_id[$item->ID] as $child_item) {
                        if($child_item->object == 'page' && is_page($child_item->object_id)) { $item_active = true; }
                    }
                    ?>

                    <span class="header-menu-item" id="header-menu-item-<?php echo $item->ID; ?>">

                        <a class="header-menu-item-link <?php if($item_active) { echo 'active'; } ?>" href="<?php echo $item->url;?>">
                            <?php ikit_three_render_sso_lock(array("post_id" => $item->object_id)); ?>
                            <?php ikit_three_render_sso_lock(array("post_id" => $item->object_id, "style" => "light")); ?>
                            <?php echo $item->title; ?>
                        </a>

                        <?php if(count($g_main_nav_menu_items_by_parent_id[$item->ID]) > 0) { ?>
                        <div class="header-menu-item-children-container">
                            <ul class="header-menu-item-children">
                                <?php foreach($g_main_nav_menu_items_by_parent_id[$item->ID] as $child_item) { ?>
                                 <li class='header-menu-item-children-item'>
                                    <a class="header-menu-item-children-item-link" target="<?php echo $child_item->target; ?>" href="<?php echo $child_item->url; ?>">
                                        <?php ikit_three_render_sso_lock(array("post_id" => $child_item->object_id)); ?>
                                        <?php ikit_three_render_sso_lock(array("post_id" => $child_item->object_id, "style" => "light")); ?>
                                        <?php if($child_item->target == '_blank') { ?> \ <?php } ?>
                                        <?php echo $child_item->title;?>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>

                    </span>

                <?php } ?>
            </div>

            <div class="header-search">
                <div class="header-search-bar">
                    <?php get_search_form(); ?>
                    <div class="header-search-button-close-container">
                        <a class="header-search-button header-search-button-close" href="javascript:void(0);">
                            <div class="header-search-button-close-image"></div>
                        </a>
                    </div>
                </div>
                <div class="header-search-collapse-panel"></div>
                <div class="header-search-button-container">
                    <a class="header-search-button header-search-button-open" href="javascript:void(0);">
                        <div class="header-search-button-open-image"></div>
                        <div class="header-search-button-open-image-alt"></div>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <?php

}

/**
 * Render related news and event posts
 */
function ikit_three_render_related_items($post_id) {

    $related_item_ids = get_post_meta($post_id, IKIT_CUSTOM_FIELD_GENERIC_RELATED_ITEMS, true);
    if(is_array($related_item_ids)) {

        if(sizeof($related_item_ids) > 0) {

            $related_item_ids = array_slice($related_item_ids, 0, 5);

            ?>
            <div class="page-layout-5 related-items">
            <div class="page-layout-5-inner">
            <table>
            <tr>
                <td class="page-layout-5-spacer"/>
                <td class="page-layout-5-body">
                    <div class="page-layout-5-body-title">Related</div>
                    <ul class="light-slider">
            <?php
        }

        foreach($related_item_ids as $related_item_id) {
            $related_item = get_post($related_item_id);

            ?>
            <li>
            <?php

            // Handle events
            if(in_array($related_item->post_type, array(IKIT_POST_TYPE_IKIT_EVENT, IKIT_POST_TYPE_IKIT_EVENT_INTERNAL, IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL))) {

                $ikit_event_meta = ikit_event_get_meta($related_item->ID);
                $event = ikit_event_get_meta_normalized($related_item->ID, $ikit_event_meta, null);
                $event_location_city = $event['location_city'];
                $event_start_date = $event['start_date'];
                $event_end_date = $event['end_date'];
                $event_image = $event['image'];

                $event_permalink = $event['permalink'];
                $event_permalink_target = $event['permalink_target'];

                $event_url = $event['url'];
                $event_url_target = $event['url_target'];

                $external = false;
                $internal = false;
                $event_preview_description = get_post_meta($related_item->ID, IKIT_CUSTOM_FIELD_IKIT_EVENT_PREVIEW_DESCRIPTION, true);

                $event_start_time = $event['start_time'];
                $event_end_time = $event['end_time'];
                $event_start_time_raw = $event['start_time_raw'];
                $event_end_time_raw = $event['end_time_raw'];
                $event_timezone_abbreviation = $event['timezone_abbreviation'];

                if($ikit_event_meta->service == IKIT_EVENT_SERVICE_EXTERNAL) {
                    $external = true;
                }
                else if($ikit_event_meta->service == IKIT_EVENT_SERVICE_INTERNAL) {
                    $internal = true;
                }

                ?>

                <div class="event-item">

                    <a class="link-block" target="<?php echo $event_permalink_target; ?>" href="<?php echo $event_permalink; ?>">

                        <?php if($event_image) { ?>
                            <div class="link-block-image event-item-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Event image" cat_plugin_anystretch_image_url="<?php echo $event_image; ?>"></div>
                        <?php } ?>

                        <div class="event-item-title">
                            <?php echo get_the_title($related_item); ?>
                        </div>

                        <?php ikit_three_render_event_item_attributes($related_item, $external, $internal, $event_start_date, $event_end_date, $event_location_city, $event_start_time, $event_end_time, $event_start_time_raw, $event_end_time_raw, $event_timezone_abbreviation); ?>

                        <?php if(empty($event_preview_description) == false) { ?>
                            <div class="event-item-description"><?php echo $event_preview_description;?></div>
                        <?php } ?>

                        <?php ikit_three_render_sso_lock(array("post_id" => $related_item->ID)); ?>

                    </a>

                </div>

                <?php

            }
            // Handle news
            else if(in_array($related_item->post_type, array('post', IKIT_POST_TYPE_IKIT_POST_EXTERNAL))) {

                $news_image = ikit_post_get_image_url($related_item->ID, 'full', null);
                $news_url = get_permalink($related_item->ID);
                $news_url_target = '_self';

                $external = false;
                if($related_item->post_type == IKIT_POST_TYPE_IKIT_POST_EXTERNAL) {
                    $external = true;
                    $news_url = get_post_meta($related_item->ID, IKIT_CUSTOM_FIELD_IKIT_POST_EXTERNAL_LINK_URL, true);
                    $news_url_target = '_blank';
                }

                $news_preview_description = get_post_meta($related_item->ID, IKIT_CUSTOM_FIELD_POST_PREVIEW_DESCRIPTION, true);

                ?>

                <a class="link-block" target="<?php echo $news_url_target; ?>" href="<?php echo $news_url; ?>">

                <?php if($news_image) { ?>
                    <div class="link-block-image news-item-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="News image" cat_plugin_anystretch_image_url="<?php echo $news_image; ?>"></div>
                <?php } ?>

                <div class="news-item-title"><?php echo get_the_title($related_item); ?></div>

                    <?php ikit_three_render_news_item_attributes($related_item, $external); ?>

                    <?php if(empty($news_preview_description) == false) { ?>
                        <div class="news-item-description"><?php echo $news_preview_description; ?></div>
                    <?php } ?>

                    <?php ikit_three_render_sso_lock(array("post_id" => $related_item->ID)); ?>

                </a>

                <?php

            }

            ?>
            </li>
            <?php
        }

        if(sizeof($related_item_ids) > 0) {
            ?>
                    </ul>
                </td>
                <td class="page-layout-5-sidebar"/>
            </tr>
            </table>
            </div>
            </div>
            <?php
        }

    }

}

/**
 * Render the table of contents title, this is basically the parent nav menu items name
 */
function ikit_three_render_toc_title($post) {

    global $g_main_nav_menu_items;

    $found = false;
    $parent_main_nav_menu_item_id = ikit_get_parent_nav_menu_item_id($post);

    // Find the parent nav menu item and add a link to it
    if($parent_main_nav_menu_item_id != null) {

        foreach($g_main_nav_menu_items as $main_nav_menu_item) {
            if($main_nav_menu_item->ID == $parent_main_nav_menu_item_id) {
                $found = true;
                ?>
                <a href="<?php echo $main_nav_menu_item->url; ?>"><?php echo $main_nav_menu_item->title; ?></a>
                <?php
            }
        }

        // If there is no parent, show the post title itself
        if($found == false) {
            ?>
            <a href="<?php echo get_post_permalink($post); ?>"><?php echo get_the_title($post); ?></a>
            <?php
        }
    }

}

/**
 * Renders ancilliary attributes for an event, such as if its from the community, external, its location and datetime.
 * If external shows Presented by... if community will show Community Event...
 */
function ikit_three_render_event_item_attributes($post, $external, $internal, $event_start_date, $event_end_date, $event_location_city, $event_start_time, $event_end_time, $event_start_time_raw, $event_end_time_raw, $event_timezone_abbreviation) {
    ?>

    <div class="event-item-attributes">

        <div class="event-item-date">
            <?php echo $event_start_date;?> <?php if($event_end_date != $event_start_date) { echo ' - ' . $event_end_date; } ?>
        </div>

        <?php if(ikit_event_has_time($event_start_time_raw)) { ?>
        <div class="event-item-time">
            <?php echo date('g:i A', $event_start_time); ?> - <?php echo date('g:i A', $event_end_time); ?>
            <?php if($event_timezone_abbreviation != null) { ?>
              <span><?php echo $event_timezone_abbreviation; ?></span>
            <?php } ?>
        </div>
        <?php } ?>

        <?php $include_separator = false; ?>

        <?php if(!empty($event_location_city)) {  ?>
            <span class="event-item-location">
                <?php echo $event_location_city; ?>
            </span>
            <?php $include_separator = true; ?>
        <?php } ?>

        <?php if($external) { ?>
            <span class="event-item-external-source"><?php if($include_separator) {?> \ <?php } ?>Presented by <?php echo get_post_meta($post->ID, IKIT_CUSTOM_FIELD_GENERIC_EXTERNAL_SOURCE_DISPLAY_NAME, true); ?></span>
            <?php $include_separator = true; ?>
        <?php } ?>

        <?php if($internal) { ?>
            <span class="event-item-internal-source"><?php if($include_separator) {?> \ <?php } ?>Community Event</span>
        <?php } ?>

    </div>

    <?php
}

/**
 * Render load more button.
 */
function ikit_three_render_infinity_fetcher_fetch_button() {
    ?>
    <div class="infinity-fetcher-fetch-button-container">
        <a href="javascript:void(0);" class="box-button infinity-fetcher-fetch-button">
            <span>Load More</span>
            <div class="infinity-fetcher-fetch-button-loader">
                <div class="infinity-fetcher-fetch-button-loader-inner">

                    <!-- http://cssload.net/en/horizontal-bars/7 -->
                    <div id="cssload-wrapper">
                        <div id="cssload-border">
                            <div id="cssload-whitespace">
                                <div id="cssload-line">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </a>
    </div>
    <?php
}

/**
 * Render news item attributes, these are ancilliary attributes such as date, author, and external source,
 * if is external, shows presented by... if its not external shows the author.
 */
function ikit_three_render_news_item_attributes($post, $external) {

    ?>
    <div class="news-item-attributes">

        <?php if($external) { ?>
        <span class="news-item-external-source">
            Presented by <?php echo get_post_meta($post->ID, IKIT_CUSTOM_FIELD_GENERIC_EXTERNAL_SOURCE_DISPLAY_NAME, true); ?>
        </span>
        <?php } else { ?>
        <span class="news-item-author">
            by <?php echo ikit_post_get_author($post->ID, get_userdata($post->post_author)->display_name); ?>
        </span>
        <?php } ?>

        <?php if(ikit_three_get_post_date($post) != null) { ?>
            <span class="news-item-date"> \ <?php echo mysql2date('F j, Y', get_gmt_from_date($post->post_date), false);?></span>
        <?php } ?>

    </div>
    <?php
}

/**
 * Get the context to pass to the render method.
 * Returns null if invalid.
 */
function ikit_three_render_event_add_to_calendar_context($event) {

    $context = null;

    // Required to have a timezone otherwise we don't actually know the time of the event
    // important on a calendar because each person may be in a different timezone.
    if(empty($event['timezone']) == false) {
        $context = array(
            'start_date_iso' => mysql2date('Y-m-d', get_gmt_from_date($event['start_date_raw']), false) . ' ' . date('H:i:s', $event['start_time']),
            'end_date_iso' => mysql2date('Y-m-d', get_gmt_from_date($event['end_date_raw']), false) . ' ' . date('H:i:s', $event['end_time']),
            'title' => get_the_title(),
            'timezone' => $event['timezone'],
            'description' => get_post_meta($event['post_id'], IKIT_CUSTOM_FIELD_IKIT_EVENT_PREVIEW_DESCRIPTION, true),
            'location' => empty($event['location_name']) ? $event['location_city'] : $event['location_name'],
            'organizer' => ikit_get_blog_title(),
            'organizer_email' => get_the_author_meta( 'user_email' ),
        );
    }

    return $context;

}

/**
 * Render add to calendar for event.
 */
function ikit_three_render_event_add_to_calendar($context) {

    ?>
    <span class="addtocalendar" data-calendars="iCalendar, Outlook, Google Calendar">
        <var class="atc_event">
            <var class="atc_date_start"><?php echo $context['start_date_iso']; ?></var>
            <var class="atc_date_end"><?php echo $context['end_date_iso']; ?></var>
            <var class="atc_timezone"><?php echo $context['timezone']; ?></var>
            <var class="atc_title"><?php echo $context['title']; ?></var>
            <var class="atc_description"><?php echo $context['description']; ?></var>
            <!-- XXX Need to set a location or won't be able to add, so if empty just leave ellipses -->
            <var class="atc_location"><?php echo empty($context['location']) ? '...' : $context['location']; ?></var>
            <var class="atc_organizer"><?php echo $context['organizer']; ?></var>
            <var class="atc_organizer_email"><?php echo $context['organizer_email']; ?></var>
        </var>
    </span>
    <?php

}

/**
 * Render social links.
 *
 * You may pass in additional custom social items beyond the generic.
 * They should be an associative array with a render, and render_context key,
 * the render should be a render method to call to render the item, and the
 * render context should be an associative array of the args to be made available
 * in the render function.
 */
function ikit_three_render_social_share($custom_social_items = null) {

    $social_items = array('twitter', 'facebook', 'linked_in', 'email');

    $social_url_formats = array(
        'twitter' => 'https://twitter.com/intent/tweet?url=%s',
        'facebook' => 'https://www.facebook.com/sharer.php?s=100&p[url]=%s',
        'linked_in' => 'https://www.linkedin.com/shareArticle?url=%s',
        'email' => 'mailto:?body=%s'
    );

    ?>

    <div class="social-share-container">
        <div class="social-share">
            <?php foreach($social_items as $social_item) { ?>

                <div class="social-share-item social-share-item-<?php echo $social_item; ?>">
                    <a class="social-share-item-link" href="<?php echo sprintf($social_url_formats[$social_item], get_permalink()); ?>">
                    </a>
                </div>

            <?php } ?>

            <!-- Page specific social items below -->
            <?php if($custom_social_items != null) {?>
                <?php foreach($custom_social_items as $custom_social_item) { ?>
                    <?php if($custom_social_item['render_context'] != null) { ?>
                        <div class="social-share-item social-share-item-<?php echo $custom_social_item['name']; ?>">
                            <?php echo $custom_social_item['render']($custom_social_item['render_context']); ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

        </div>
    </div>

    <?php
}

/**
 * Image resizing for faster load times.
 */
function ikit_three_image_resize($url, $size) {

    // To allow for animated gifs, we do not resize gifs
    if(ikit_string_ends_with($url, '.gif')) {
      return $url;
    }

    if($size == IKIT_THREE_IMAGE_RESIZE_SMALL) {
        return ikit_image_resize($url, 800, null);
    }
    else if($size == IKIT_THREE_IMAGE_RESIZE_MEDIUM) {
        return ikit_image_resize($url, 1200, null);
    }
    else if($size == IKIT_THREE_IMAGE_RESIZE_LARGE) {
        return ikit_image_resize($url, 1600, null);
    }

}

/**
 * Custom editor styles
 */
add_filter('tiny_mce_before_init', 'ikit_three_editor_custom_styles');
function ikit_three_editor_custom_styles($settings) {

    // Show style select dropdown
    $settings["theme_advanced_buttons2"] = "styleselect," . (array_key_exists("theme_advanced_buttons2", $settings) ? $settings["theme_advanced_buttons2"] : "");

    // Remove preformatted
    $settings['block_formats'] = 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;';

    // Set default colors
    $default_colours = '"000000", "Black",
                      "a5a5a5", "Grey",
                      "1E7B76", "Teal",
                      "41C8B9", "Aqua",
                      "EC008C", "Pink",
                      "782887", "Purple",
                      "A5D21E", "Lime",
                      "FFA300", "Orange",
                      "ED1C24", "Red",
                      "0000D2", "Blue",
                      "39B54A", "Green",
                      "00AEEF", "Cyan",';

    $settings['textcolor_map'] = '['.$default_colours.']';

    return $settings;
}

function ikit_three_editor_add_buttons($buttons) {
    // WordPress 3.9 introduced TinyMCE 4.0, which requires specifically adding the styleselect as below
    $wp_version = get_bloginfo('version');
    if($wp_version >= 3.9) {
        array_unshift($buttons, 'styleselect');
    }
    return $buttons;
}
add_filter('mce_buttons_2', 'ikit_three_editor_add_buttons');

/**
 * Various theme setup
 */
function ikit_three_setup_theme() {
    update_option('image_default_link_type' , 'none');
}
add_action('after_setup_theme', 'ikit_three_setup_theme');

/**
 * Add helpful admin notices for specific pages
 */
function ikit_three_admin_notices(){
    global $pagenow;
    $post_type = get_current_screen()->post_type;
    $base = get_current_screen()->base;

    if(($post_type == 'post' || $post_type == 'page') && $base == 'post') {
        ?>
        <div class="updated">
            <p>Please refer to the theme 3 documentation for tips on <a target="_blank" href="https://aiga-workroom1.pbworks.com/w/page/118517721/00%20-%20What's%20New%20in%20Version%203#GeneralUpdatestoEditingPostsNewsEventsetc">formatting posts</a>.</p>
        </div>
        <?php
    }

}
add_action('admin_notices', 'ikit_three_admin_notices');

/**
 * Function for getting the column counts on grids.
 * In theme three grid layouts are structured in such a way that every page has exactly four columns
 * including the sidebar content.  So we determine whether or not the page has a table of contents
 * and active widgets and return the appropriate number of columns.
 */
function ikit_three_get_page_layout_4_body_grid_num_cols($post, $sidebar_name) {
    if(ikit_three_has_toc($post) && is_active_sidebar($sidebar_name)) {
        return IKIT_THREE_PAGE_LAYOUT_4_BODY_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS_SIDEBAR_TOC;
    }
    else if(ikit_three_has_toc($post)) {
        return IKIT_THREE_PAGE_LAYOUT_4_BODY_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS_TOC;
    }
    else if(is_active_sidebar($sidebar_name)) {
        return IKIT_THREE_PAGE_LAYOUT_4_BODY_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS_SIDEBAR;
    }
    else {
        return IKIT_THREE_PAGE_LAYOUT_4_BODY_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS;
    }
}

?>
