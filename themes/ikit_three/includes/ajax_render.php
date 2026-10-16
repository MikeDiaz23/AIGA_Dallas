<?php


function ikit_three_ajax_render($action, $data = array()) {
    return ikit_ajax_render($action, $data, IKIT_THREE_THEME_NAME);
}

function ikit_three_ajax_render_portfolios() {

    $args = array();
    $args['posts_per_page'] = IKIT_THREE_PORTFOLIOS_POSTS_PER_PAGE;
    $args['render'] = function($context) {

        $post = $context['post'];

        $ikit_portfolio_meta = ikit_portfolio_get_meta($post->ID);

        $project = $ikit_portfolio_meta[array_rand($ikit_portfolio_meta, 1)]; // Get a random project for this portfolio

        $project_image = $project->cover_image_url;

        ?>

        <div class="cat-plugin-fluid-grid-item grid-item portfolio-item">
            <div class="grid-item-inner">
                <a class="link-block" target="_blank" href="<?php echo $project->url; ?>">
                    <?php if($project_image != null) { ?>
                        <div class="link-block-image portfolio-item-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Portfolio project image" cat_plugin_anystretch_image_url="<?php echo $project_image; ?>"></div>
                    <?php } ?>
                    <div class="portfolio-item-author"><?php the_title(); ?></div>
                    <div class="portfolio-item-project"><?php echo $project->title; ?></div>
                </a>
            </div>
        </div>

        <?php

    };

    ikit_ajax_render_portfolios($args);

}

function ikit_three_ajax_render_jobs() {

    $args = array();
    $args['posts_per_page'] = IKIT_THREE_JOBS_POSTS_PER_PAGE;
    $args['render'] = function($context) {

        $post = $context['post'];

        $ikit_job_meta = ikit_job_get_meta($post->ID);
        ?>

        <div class="cat-plugin-fluid-grid-item grid-item job-item">
            <div class="grid-item-inner">
                <a class="link-block" href="<?php echo get_permalink(); ?>">
                    <div class="box-item">
                        <div class="job-item-title"><?php the_title(); ?></div>
                        <div class="job-item-company-name"><?php echo $ikit_job_meta->company_name; ?></div>
                        <div class="job-item-attributes">
                            <span class="job-item-date"><?php echo mysql2date('F j, Y', get_gmt_from_date($ikit_job_meta->date_approved), false);?> \ </span>
                            <span class="job-item-location"><?php echo $ikit_job_meta->city; ?>, <?php echo $ikit_job_meta->state; ?></span>
                            <?php ikit_three_render_sso_lock(array()); ?>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <?php
    };

    ikit_ajax_render_jobs($args);

}

function ikit_three_ajax_render_events() {

    $args = array();
    $args['posts_per_page'] = IKIT_THREE_EVENTS_POSTS_PER_PAGE;
    $args['render'] = function($context) {

        $post = $context['post'];

        $ikit_event_meta = ikit_event_get_meta($post->ID);
        $event = ikit_event_get_meta_normalized($post->ID, $ikit_event_meta, null);
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
        $event_preview_description = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_EVENT_PREVIEW_DESCRIPTION, true);

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

                <table class="event-item-layout">
                <tr>
                <td class="event-item-info-col">

                    <div class="event-item-title">
                        <?php the_title(); ?>
                    </div>

                    <?php ikit_three_render_event_item_attributes($post, $external, $internal, $event_start_date, $event_end_date, $event_location_city, $event_start_time, $event_end_time, $event_start_time_raw, $event_end_time_raw, $event_timezone_abbreviation); ?>

                    <?php if(empty($event_preview_description) == false) { ?>
                        <div class="event-item-description"><?php echo $event_preview_description;?></div>
                    <?php } ?>

                    <?php ikit_three_render_sso_lock(array("post_id" => $post->ID)); ?>

                    <div class="box-button event-item-link">Learn More</div>



                </td>
                <?php if($event_image) { ?>
                <td class="event-item-image-col">
                    <div class="link-block-image event-item-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Event image" cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($event_image, IKIT_THREE_IMAGE_RESIZE_MEDIUM); ?>"></div>
                </td>
                <?php } ?>
                </tr>
                </table>

            </a>

        </div>

        <?php

    };

    $args['update_query'] = function(&$query) {

        $type = $_POST['type'];

        if($type == IKIT_THREE_EVENTS_TYPE_AIGA) {
            $query['post_type'] = array(IKIT_POST_TYPE_IKIT_EVENT, IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL);
        }
        else if($type == IKIT_THREE_EVENTS_TYPE_COMMUNITY) {
            $query['post_type'] = array(IKIT_POST_TYPE_IKIT_EVENT_INTERNAL);
        }

    };

    ikit_ajax_render_events($args);

}

function ikit_three_ajax_render_news() {

    $args = array();
    $args['posts_per_page'] = IKIT_THREE_NEWS_POSTS_PER_PAGE;
    $args['render'] = function($context) {

        $post = $context['post'];
        $query = $context['query'];

        $news_image = ikit_post_get_image_url($post->ID, 'full', null);
        $news_url = get_permalink($post->ID);
        $news_url_target = '_self';

        $external = false;
        if($post->post_type == IKIT_POST_TYPE_IKIT_POST_EXTERNAL) {
            $external = true;
            $news_url = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_POST_EXTERNAL_LINK_URL, true);
            $news_url_target = '_blank';
        }

        $news_preview_description = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_POST_PREVIEW_DESCRIPTION, true);

        // Viewing from the categories page
        $category_view = $_POST['category_view'];
        ?>

        <?php if($category_view == true) { ?>
        <div class="cat-plugin-fluid-grid-item grid-item news-item">
            <div class="grid-item-inner">
        <?php } else { ?>
        <div class="news-item">
        <?php } ?>

            <?php if($category_view != true) {
                $category_ids = wp_get_post_categories($post->ID);
                if(sizeof($category_ids) > 0) { ?>
                    <div class="news-item-categories">
                    <?php for($j=0;$j<sizeof($category_ids);$j++) {
                        $category = get_category($category_ids[$j]); ?>
                        <a class="news-item-category box-button" href="<?php echo get_category_link($category->cat_ID); ?>"><?php echo $category->name; ?></a>
                    <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <a class="link-block" target="<?php echo $news_url_target; ?>" href="<?php echo $news_url; ?>">

                <div class="news-item-title"><?php the_title(); ?></div>

                <?php ikit_three_render_news_item_attributes($post, $external); ?>

                <?php if($news_image) { ?>
                    <div class="link-block-image news-item-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="News image" cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($news_image, IKIT_THREE_IMAGE_RESIZE_MEDIUM); ?>"></div>
                <?php } ?>

                <?php if(empty($news_preview_description) == false) { ?>
                    <div class="news-item-description"><?php echo $news_preview_description; ?></div>
                <?php } ?>

                <?php ikit_three_render_sso_lock(array("post_id" => $post->ID)); ?>

                <?php if($category_view != true) { ?>
                    <div class="box-button news-item-link">Read More</div>
                <?php } ?>

            </a>

        <?php if($category_view == true) { ?>
            </div>
        </div>
        <?php } else { ?>
        </div>
        <?php } ?>

        <?php

    };

    ikit_ajax_render_news($args);

}

function ikit_three_ajax_render_member_directory() {

    $args = array();
    $args['posts_per_page'] = IKIT_THREE_MEMBER_DIRECTORY_POSTS_PER_PAGE;
    $args['render'] = function($context) {

        $member = $context['member'];

        ?>
        <div class="cat-plugin-fluid-grid-item grid-item member-item">

            <div class="grid-item-inner">

                <span>

                    <?php
                    if(empty($member->avatar) == false) {
                        ?>
                        <div class="link-block-image member-item-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Member photo" cat_plugin_anystretch_image_url="<?php echo ikit_member_avatar_url($member); ?>"></div>
                        <?php
                    }
                     ?>
                    <div class="member-item-name"><?php echo $member->full_name; ?></div>
                    <?php
                    if(isset($member->company)) {
                        ?>
                        <div class="member-item-company"><?php echo strip_tags($member->company); ?></div>
                        <?php
                    }
                    ?>
                    <div class="member-item-attributes">

                        <?php
                        $member_type_display_name = null;
                        $member_type = $member->member_type;
                        $member_type_display_name = ikit_member_type_display_name($member_type);
                        if($member_type_display_name != null && $member_type != IKIT_MEMBER_TYPE_DEPRECATED_CONTRIBUTOR && $member_type != IKIT_MEMBER_TYPE_DEPRECATED_DESIGN_SUPPORTER && $member_type != IKIT_MEMBER_TYPE_DEPRECATED_GROUP_MEMBER) {
                            ?>
                            <span class="member-item-type"><?php echo $member_type_display_name; ?><span> \ </span></span>
                            <?php
                        }

                        ?>

                        <span class="member-item-year"><?php echo ikit_member_join_year($member); ?></span>

                    </div>
                </span>
            </div>
        </div>

        <?php

    };

    ikit_ajax_render_member_directory($args);

}

function ikit_three_ajax_render_events_calendar_compact() {

    $args = array();
    $args['render_day'] = function($context) {

        if(array_key_exists('day', $context)) {
            $check_date = $context['year'] . '-' . $context['month'] . '-' . $context['day'];
            $current_date = date('Y-n-j');
            ikit_three_render_events_calendar_day_compact($context['day'], $context['events_by_date'], $current_date, $check_date);
        }
        else {
            ikit_three_render_events_calendar_day_compact();
        }

    };

    $args['update_query'] = function(&$query) {

        $type = $_POST['type'];

        if($type == IKIT_THREE_EVENTS_TYPE_AIGA) {
            $query['post_type'] = array(IKIT_POST_TYPE_IKIT_EVENT, IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL);
        }
        else if($type == IKIT_THREE_EVENTS_TYPE_COMMUNITY) {
            $query['post_type'] = array(IKIT_POST_TYPE_IKIT_EVENT_INTERNAL);
        }

    };

    ikit_ajax_render_events_calendar($args);

}

function ikit_three_ajax_render_events_calendar() {

    $args = array();
    $args['render_day'] = function($context) {

        if(array_key_exists('day', $context)) {
            $check_date = $context['year'] . '-' . $context['month'] . '-' . $context['day'];
            $current_date = date('Y-n-j');
            ikit_three_render_events_calendar_day($context['day'], $context['events_by_date'], $current_date, $check_date);
        }
        else {
            ikit_three_render_events_calendar_day();
        }

    };

    $args['update_query'] = function(&$query) {

        $type = $_POST['type'];

        if($type == IKIT_THREE_EVENTS_TYPE_AIGA) {
            $query['post_type'] = array(IKIT_POST_TYPE_IKIT_EVENT, IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL);
        }
        else if($type == IKIT_THREE_EVENTS_TYPE_COMMUNITY) {
            $query['post_type'] = array(IKIT_POST_TYPE_IKIT_EVENT_INTERNAL);
        }

    };

    ikit_ajax_render_events_calendar($args);

}

function ikit_three_ajax_render_events_past() {

    $args = array();
    $args['posts_per_page'] = IKIT_THREE_EVENTS_PAST_POSTS_PER_PAGE;
    $args['render'] = function($context) {

        $post = $context['post'];

        $ikit_event_meta = ikit_event_get_meta($post->ID);
        $event = ikit_event_get_meta_normalized($post->ID, $ikit_event_meta, null);
        $event_location_city = $event['location_city'];
        $event_start_date = $event['start_date'];
        $event_end_date = $event['end_date'];
        $event_image = $event['image'];
        $event_permalink = $event['permalink'];
        $event_permalink_target = $event['permalink_target'];
        $event_url = $event['url'];
        $event_url_target = $event['event_url_target'];
        $external = false;
        $internal = false;
        $event_preview_description = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_EVENT_PREVIEW_DESCRIPTION, true);
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

        <div class="cat-plugin-fluid-grid-item grid-item event-item">
            <div class="grid-item-inner">

                <a class="link-block" target="<?php echo $event_permalink_target; ?>" href="<?php echo $event_permalink; ?>">

                    <?php if($event_image != null) { ?>
                        <div class="link-block-image event-item-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Event image" cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($event_image, IKIT_THREE_IMAGE_RESIZE_MEDIUM); ?>"></div>
                    <?php } ?>

                    <div class="event-item-title"><?php the_title(); ?></div>

                    <?php ikit_three_render_event_item_attributes($post, $external, $internal, $event_start_date, $event_end_date, $event_location_city, $event_start_time, $event_end_time, $event_start_time_raw, $event_end_time_raw, $event_timezone_abbreviation); ?>

                    <?php if(empty($event_preview_description) == false) { ?>
                        <div class="event-item-description"><?php echo $event_preview_description; ?></div>
                    <?php } ?>

                    <?php ikit_three_render_sso_lock(array("post_id" => $post->ID)); ?>

                </a>

            </div>
        </div>

        <?php

    };
    $args['update_query'] = function(&$query) {

        $type = $_POST['type'];

        if($type == IKIT_THREE_EVENTS_TYPE_AIGA) {
            $query['post_type'] = array(IKIT_POST_TYPE_IKIT_EVENT, IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL);
        }
        else if($type == IKIT_THREE_EVENTS_TYPE_COMMUNITY) {
            $query['post_type'] = array(IKIT_POST_TYPE_IKIT_EVENT_INTERNAL);
        }

    };

    ikit_ajax_render_events_past($args);

}

function ikit_three_ajax_get_event_attendees() {

    $event_id = $_POST['event_id'];
    $event_service = $_POST['event_service'];

    $attendees = ikit_event_get_attendees($event_id, $event_service);

    if(is_null($attendees)) {
        ikit_render_500_error();
    }
    else {
        print json_encode($attendees);
    }

    die();
}

// API Methods



add_action('wp_ajax_ikit_three_ajax_render_portfolios', 'ikit_three_ajax_render_portfolios' );
add_action('wp_ajax_nopriv_ikit_three_ajax_render_portfolios', 'ikit_three_ajax_render_portfolios' );

add_action('wp_ajax_ikit_three_ajax_render_events_past', 'ikit_three_ajax_render_events_past' );
add_action('wp_ajax_nopriv_ikit_three_ajax_render_events_past', 'ikit_three_ajax_render_events_past' );

add_action('wp_ajax_ikit_three_ajax_get_event_attendees', 'ikit_three_ajax_get_event_attendees' );
add_action('wp_ajax_nopriv_ikit_three_ajax_get_event_attendees', 'ikit_three_ajax_get_event_attendees' );

add_action( 'wp_ajax_ikit_three_ajax_render_news', 'ikit_three_ajax_render_news' );
add_action( 'wp_ajax_nopriv_ikit_three_ajax_render_news', 'ikit_three_ajax_render_news' );

add_action( 'wp_ajax_ikit_three_ajax_render_events', 'ikit_three_ajax_render_events' );
add_action( 'wp_ajax_nopriv_ikit_three_ajax_render_events', 'ikit_three_ajax_render_events' );

add_action( 'wp_ajax_ikit_three_ajax_render_events_calendar', 'ikit_three_ajax_render_events_calendar' );
add_action( 'wp_ajax_nopriv_ikit_three_ajax_render_events_calendar', 'ikit_three_ajax_render_events_calendar' );

add_action( 'wp_ajax_ikit_three_ajax_render_events_calendar_compact', 'ikit_three_ajax_render_events_calendar_compact' );
add_action( 'wp_ajax_nopriv_ikit_three_ajax_render_events_calendar_compact', 'ikit_three_ajax_render_events_calendar_compact' );

add_action( 'wp_ajax_ikit_three_ajax_render_jobs', 'ikit_three_ajax_render_jobs' );
add_action( 'wp_ajax_nopriv_ikit_three_ajax_render_jobs', 'ikit_three_ajax_render_jobs' );

add_action( 'wp_ajax_ikit_three_ajax_render_member_directory', 'ikit_three_ajax_render_member_directory' );
add_action( 'wp_ajax_nopriv_ikit_three_ajax_render_member_directory', 'ikit_three_ajax_render_member_directory' );




?>
