<?php

add_action('ikit_action_widgets_render', 'ikit_three_action_widgets_render', 10, 4);

function ikit_three_action_widgets_render($class, $args, $instance, $context) {

    $theme_options = get_option(IKIT_THREE_THEME_OPTION_GROUP_GENERAL);

    /**
     * Eye on Design Widget
     */
    if($class == 'Ikit_WidgetEyeOnDesign') {

        extract($args);

        echo $before_title;
        ikit_three_render_widget_header('Eye on Design', 'http://eyeondesign.aiga.org', '_blank');
        echo $after_title;

        ?>

        <?php foreach ($context['eyeondesign_items'] as $eyeondesign_item) {

            $image_url = null;

            // Assumes structure is <item><image><url>...</url></image></item>
            $image_tag = $eyeondesign_item->get_item_tags('', 'image');
            $image_tag = $image_tag[0]['child'];
            foreach($image_tag as $child) {
                $image_url = $child['url'][0]['data'];
            }

            ?>

            <a class="link-block" target="_blank" href="<?php echo $eyeondesign_item->get_link(); ?>">

                <?php if($image_url != null) { ?>
                    <div class="link-block-image eyeondesign-item-image cat-plugin-anystretch-image"
                        cat_plugin_anystretch_image_alt="Eye on Design image"
                        cat_plugin_anystretch_image_url="<?php echo $image_url; ?>">
                        <div class="link-block-image-overlay"></div>
                    </div>
                <?php } ?>

                <div class="eyeondesign-item-title"><?php echo $eyeondesign_item->get_title(); ?></div>

            </a>

            <?php
            break;
        }

    }

    /**
     * Sponsors Widget
     */

    if($class == 'Ikit_WidgetSponsors') {

        extract($args);

        echo $before_title;
        $title = $instance['title'];
        if(empty($title)) {
            $title = 'Official Sponsor';
        }
        ikit_three_render_widget_header($title);
        echo $after_title;

        ?>
        <div class="sponsor-items">
        <?php

        foreach($context['national_sponsors'] as $sponsor) {

        ?>

            <?php
            $attachment_image_src = wp_get_attachment_image_src(get_post_meta($sponsor->ID, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_PRIMARY_IMAGE, true), 'full');
            $sponsor_permalink = ikit_three_sponsor_get_permalink($sponsor->ID);
            $sponsor_permalink_target = ikit_three_sponsor_get_permalink_target($sponsor->ID);
            ?>

            <div class="sponsor-item">
                <a target="<?php $sponsor_permalink_target; ?>" href="<?php echo $sponsor_permalink; ?>">
                    <div class="sponsor-item-image">
                        <img alt="Official sponsor image" width="<?php echo round($attachment_image_src[1]/2); ?>px" src="<?php echo $attachment_image_src[0]; ?>"/>
                    </div>
                </a>
            </div>

        <?php
        }

        ?>
        </div>
        <?php

    }

    /**
     * Local Sponsors Widget
     */
    if($class == 'Ikit_WidgetLocalSponsors') {

        extract($args);

        echo $before_title;
        $title = $instance['title'];
        if(empty($title)) {
            $title = 'Chapter Sponsors';
        }
        ikit_three_render_widget_header($title);
        echo $after_title;

        ?>
        <div class="sponsor-items">
        <?php

        foreach($context['local_sponsors_short'] as $sponsor) {
        ?>

            <?php
            $attachment_image_src = wp_get_attachment_image_src(get_post_meta($sponsor->ID, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_PRIMARY_IMAGE, true), 'full');

            $sponsor_url = get_post_meta($sponsor->ID, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_URL, true);
            $sponsor_url_target = "_blank";

            if(get_option(IKIT_THREE_THEME_OPTION_GROUP_GENERAL)[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR] == true) {
                $sponsor_url = get_permalink($sponsor->ID);
                $sponsor_url_target = "_self";
            }

            ?>
            <div class="sponsor-item">
                <a target="<?php echo $sponsor_url_target; ?>" href="<?php echo $sponsor_url; ?>">
                    <div class="sponsor-item-image">
                        <img alt="Local sponsor image" width="<?php echo round($attachment_image_src[1]/2); ?>px" src="<?php echo $attachment_image_src[0]; ?>"/>
                    </div>
                </a>
            </div>
        <?php
        }

        ?>
        </div>
        <?php

    }


    /**
     * Sign Up Widget
     */
    if($class == 'Ikit_WidgetMailingList') {

        extract($args);

        $mailchimp_signup_form_url = $context['mailchimp_signup_form_url'];

        $custom_title = $instance['title'];
        if(empty($custom_title)) {
            $custom_title = 'Sign up for our Newsletter';
        }

        if(empty($mailchimp_signup_form_url) == false) {

            $title = $custom_title;

            if(!empty($title)) {
                echo $before_title;
                ikit_three_render_widget_header($title);
                echo $after_title;
            }

            ?>

                <form class="mailing-list-form" target="_blank" action="<?php echo $mailchimp_signup_form_url; ?>" method="post">
                    <div class="mailing-list-description">Stay connected and learn about the latest news and events in our community!</div>
                    <input class="mailing-list-input box-input" type="text" value="" placeholder="enter your email address" name="EMAIL" class="required email" id="mce-EMAIL">
                </form>

            <?php
        }
    }

    /**
     * Featured Job Widget
     */
    if($class == 'Ikit_WidgetFeaturedJob') {

        extract($args);

        $num_results = count($context['featured_jobs']);

        $title = 'Latest Job Posting';
        if($num_results > 1) {
            $title = $title . 's';
        }

        echo $before_title;
        ikit_three_render_widget_header($title);
        echo $after_title;

        $post_count = 0;

        ?>
        <div class="job-items">
        <?php

        foreach($context['featured_jobs'] as $featured_job) {
            $ikit_job_meta = ikit_job_get_meta($featured_job->ID);
            ?>
            <div class="job-item">
                <a class="link-block" href="<?php echo get_permalink($featured_job->ID); ?>">
                    <div class="job-item-title"><?php echo $featured_job->post_title; ?></div>
                    <div class="job-item-company"><?php echo $ikit_job_meta->company_name; ?></div>
                    <?php ikit_three_render_sso_lock(array()); ?>
                </a>
            </div>
            <?php
            $post_count++;
        }

        ?>
        </div>
        <?php

    }

    /**
     * Featured Portfolio Widget
     */
    if($class == 'Ikit_WidgetFeaturedPortfolio') {

        extract($args);

        $num_results = count($context['featured_portfolios']);

        $title = 'Featured Portfolio';
        if($num_results > 1) {
            $title = $title . 's';
        }

        echo $before_title;
        ikit_three_render_widget_header($title);
        echo $after_title;

        ?>

        <div class="portfolio-items">

        <?php foreach ($context['featured_portfolios'] as $featured_portfolio) {

            $ikit_portfolio_meta = ikit_portfolio_get_meta($featured_portfolio->ID);
            $project = $ikit_portfolio_meta[array_rand($ikit_portfolio_meta, 1)]; // Get a random project for this portfolio
            $project_image = $project->cover_image_url;

            ?>

            <div class="portfolio-item">
                <a class="link-block" target="_blank" href="<?php echo $project->url; ?>">
                    <div class="link-block-image portfolio-item-image"><img alt="Portfolio project image" src="<?php echo $project_image; ?>"/></div>
                    <div class="portfolio-item-author"><?php echo $project->owner_name; ?></div>
                    <div class="portfolio-item-project"><?php echo $project->title; ?></div>
                </a>
            </div>

            <?php

        }

        ?>
        </div>
        <?php

    }


    /**
     * New Members
     */
    if($class == 'Ikit_WidgetNewMembers') {

        extract($args);

        echo $before_title;
        ikit_three_render_widget_header('New Members');
        echo $after_title;

        ?>

        <div class="member-items">
            <?php foreach($context['members'] as $idx=>$member) { ?>

                <div class="member-item">
                    <span>
                        <div class="member-item-name"><?php echo $member->full_name; ?></div>
                        <div class="member-item-details">
                            <div class="member-item-type"><?php echo ikit_member_type_display_name($member->member_type); ?></div>
                            <div class="member-item-date"><?php echo date("F j, Y", strtotime($member->join_date)); ?></div>
                        </div>
                    </span>
                </div>

            <?php } ?>
        </div>

        <?php


    }

    /**
     * I am AIGA Widget
     */
    if($class == 'Ikit_WidgetIAmAIGA') {

        extract($args);

        echo $before_title;
        ikit_three_render_widget_header('I am AIGA');
        echo $after_title;

        if(empty($context) == false) {

            $member_year = ikit_member_join_year($context['member']);

            ?>

            <span>

                <div class="link-block-image member-item-image cat-plugin-anystretch-image"
                    cat_plugin_anystretch_image_alt="Member photo"
                    cat_plugin_anystretch_image_url="<?php echo ikit_member_avatar_url($context['member']); ?>">
                    <div class="link-block-image-overlay"></div>
                </div>

                <div class="member-item-details">
                    <div class="member-item-name"><?php echo $context['member']->full_name; ?></div>
                </div>

            </span>

            <?php

        }
    }

    /**
     * Join AIGA Widget
     */
    if($class == 'Ikit_WidgetJoinAIGA') {

        extract($args);

        ?>
        <a target="_blank" href="http://www.aiga.org/belong/">
            <img alt="Join AIGA promotional image" src="<?php echo $context['selected_promo_image_url']; ?>"/>
        </a>
        <?php

    }

    /**
     * Page Widget
     */
    if($class == 'Ikit_WidgetPage') {

        extract($args);

        if(array_key_exists('page', $context)) {

            echo $before_title;
            $title = $instance['title'];
            if(empty($title) == false) {
                ikit_three_render_widget_header($instance['title']);
            }
            echo $after_title;
            ?>
            <div class="page-content">
            <?php
                echo apply_filters ('the_content', $context['page']->post_content);
            ?>
            </div>
            <?php

        }

    }

    /**
     * Twitter Widget
     */
    if($class == 'Ikit_Twitter_Widget'){

        extract($args);

        if(count($context['twitter_messages']) > 0) {

            echo $before_title;
            ikit_three_render_widget_header('Twitter', $context['twitter_url'], '_blank');
            echo $after_title;

            ?>

            <div class="twitter-items">

            <?php

                for($i=0;$i<count($context['twitter_messages']);$i++) {
                    $twitter_message = $context['twitter_messages'][$i];
                    if($i < $context['num_twitter_messages']) {
                    ?>
                    <div class="twitter-item">
                        <div class="twitter-item-text">
                              <?php echo ikit_social_twitter_url_converter(str_replace($context['twitter_username'] . ': ', '', html_entity_decode($twitter_message->text))); ?>
                        </div>
                        <div class="twitter-item-timestamp">
                            <script>
                                var timeEl = $('.twitter-item-timestamp');
                                var humanizedTime = jQuery.humanize.naturalTime(new Date("<?php echo $twitter_message->created_at; ?>"));
                                document.write(humanizedTime);
                            </script>
                        </div>
                    </div>
                    <?php
                    }
                }

                ?>

            </div>

            <?php

        }

    }

    /**
     * Facebook Widget
     */
    if($class == 'Ikit_Facebook_Widget') {

        extract($args);

        if(count($context['facebook_status_messages']) > 0) { ?>

            <?php
            echo $before_title;
            ikit_three_render_widget_header('Facebook', $context['facebook_url'], '_blank');
            echo $after_title;
            ?>

            <div class="facebook-item">
            <?php foreach ($context['facebook_status_messages'] as $facebook_status_message) {?>

                <?php if(empty($facebook_status_message->message) == false) { ?>
                    <div class="facebook-item-message"><?php echo ikit_social_url_converter(html_entity_decode(ikit_truncate($facebook_status_message->message, 256))); ?></div>
                <?php } elseif(empty($facebook_status_message->name) == false) { ?>
                    <div class="facebook-item-name"><?php echo $facebook_status_message->name; ?></div>
                <?php } else { ?>
                  <?php continue; ?>
                <?php } ?>

                <?php if(empty($facebook_status_message->link) == false) { ?>
                    <a class="box-button facebook-item-read-more" target="_blank" href="<?php echo $facebook_status_message->link; ?>">Read more</a>
                <?php } ?>

            <?php break; } ?>
            </div>

        <?php }

    }


    /**
     * Vimeo Widget
     */
    if($class == 'Ikit_Vimeo_Widget'){

        extract($args);

        if(count($context['vimeo_videos']) > 0) {

            $vimeo_video = $context['vimeo_videos'][0];
            if($context['randomize_vimeo']) {
                $vimeo_video = $context['vimeo_videos'][array_rand($context['vimeo_videos'], 1)];
            }
            // Extract the video url
            $vimeo_enclosure = $vimeo_video->get_item_tags('', 'enclosure');
            $vimeo_video_url = $vimeo_enclosure[0]['attribs']['']['url'];
            // Extract the video thumbnail image
            $vimeo_media_content = $vimeo_video->get_item_tags('http://search.yahoo.com/mrss/', 'content');
            $vimeo_video_thumbnail_url = ($vimeo_media_content[0]['child']['http://search.yahoo.com/mrss/']['thumbnail'][0]['attribs']['']['url']);

            // Replace thethumbnail url with the hi-res version
            $vimeo_video_thumbnail_url = ikit_social_vimeo_thumbnail_image_resize($vimeo_video_thumbnail_url);

            echo $before_title;
            ikit_three_render_widget_header('Vimeo', $context['vimeo_url'], '_blank');
            echo $after_title;

            ?>

            <div class="vimeo-item">
                <a class="link-block" target="_blank" href="<?php echo $vimeo_video->get_link(); ?>">
                    <div class="vimeo-item-thumbnail">
                        <img alt="Vimeo video thumbnail image" src="<?php echo $vimeo_video_thumbnail_url; ?>"/>
                    </div>
                    <div class="vimeo-item-overlay"></div>
                </a>
            </div>


        <?php }
    }



    /**
     * YouTube Widget
     */
    if($class == 'Ikit_YouTube_Widget'){

        extract($args);

        if(count($context['youtube_videos']) > 0) { ?>

            <?php

            $youtube_video = $context['youtube_videos'][0];
            if($context['randomize_youtube']) {
                $youtube_video = $context['youtube_videos'][array_rand($context['youtube_videos'], 1)];
            }

            // Extract the video url
            $video_url = $youtube_video->get_link();
            $video_id = explode('=', $video_url);
            $video_id = explode("&", $video_id[1]);
            $thumbnail_url = ikit_social_vimeo_thumbnail_image_resize("http://img.youtube.com/vi/".$video_id[0]."/0.jpg");

            echo $before_title;
            ikit_three_render_widget_header('YouTube', $context['youtube_url'], '_blank');
            echo $after_title;

            ?>

            <div class="youtube-item">
                <a class="link-block" target="_blank" href="<?php echo $youtube_video->get_link(); ?>">
                    <div class="youtube-item-thumbnail">
                        <img alt="YouTube video thumbnail image" src="<?php echo $thumbnail_url; ?>"/>
                    </div>
                    <div class="youtube-item-overlay"></div>
                </a>
            </div>

        <?php }
    }


    /**
     * Flickr Widget
     */
    if($class == 'Ikit_Flickr_Widget'){

        extract($args);

        if(count($context['flickr_images']) > 0) { ?>

            <?php

            $flickr_image = $context['flickr_images'][0];
            if($context['randomize_flickr']) {
                $flickr_image = $context['flickr_images'][array_rand($context['flickr_images'], 1)];
            }
            $flickr_image_url = ikit_social_flickr_image_from_description($flickr_image->get_description());

            echo $before_title;
            ikit_three_render_widget_header('Flickr', $context['flickr_url'], '_blank');
            echo $after_title;

            ?>

            <a class="link-block" target="_blank" href="<?php echo $flickr_image->get_link(); ?>">
                <div class="link-block-image flickr-item-image"><img alt="Flickr photo" src="<?php echo ikit_social_flickr_image_resize($flickr_image_url, 4);?>"/></div>
            </a>

        <?php }
    }

    /**
     * Instagram Widget
     */
    if($class == 'Ikit_Instagram_Widget'){

        extract($args);

        if(count($context['instagram_photos']) > 0) {

            $instagram_photo = $context['instagram_photos'][0];
            if($context['randomize_instagram']) {
                $instagram_photo = $context['instagram_photos'][array_rand($context['instagram_photos'], 1)];
            }

            echo $before_title;
            ikit_three_render_widget_header('Instagram', $context['instagram_url'], '_blank');
            echo $after_title;

            if($instagram_photo->media_type == 'IMAGE') {

                ?>
                <a class="link-block" target="_blank" href="<?php echo $instagram_photo->permalink; ?>">
                    <div class="link-block-image"><img alt="Instagram photo" src="<?php echo $instagram_photo->media_url;?>"/></div>
                </a>
                <?php

            }
            else if($instagram_photo->media_type == 'VIDEO') {

                ?>
                <a class="link-block" target="_blank" href="<?php echo $instagram_photo->permalink; ?>">
                    <div class="link-block-image instagram-item-video">
                      <img alt="Instagram photo" src="<?php echo $instagram_photo->thumbnail_url;?>"/>
                      <div class="instagram-item-video-overlay"></div>
                    </div>
                </a>
                <?php

            }
            else if($instagram_photo->media_type == 'CAROUSEL_ALBUM') {

                $instagram_carousel_photos = [$instagram_photo];
                foreach($instagram_photo->children->data as $child) {
                  array_push($instagram_carousel_photos, $child);
                }
                ?>
                <div class="cycle2-slideshow"
                    data-cycle-swipe="true"
                    data-cycle-slides=".instagram-item-slide"
                    data-cycle-pager=".instagram-item-slides-pager"
                    data-cycle-pager-template="&lt;span&gt;&lt;/span&gt;"
                    data-cycle-paused="true"
                >
                    <?php
                    foreach($instagram_carousel_photos as $instagram_carousel_photo) {
                        ?>
                        <div class="instagram-item-slide">
                            <a class="link-block" target="_blank" href="<?php echo $instagram_carousel_photo->permalink; ?>">
                                <div class="link-block-image"><img alt="Instagram photo" src="<?php echo $instagram_carousel_photo->media_url;?>"/></div>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <?php if(count($instagram_carousel_photos) > 1) { ?>
                    <div class="instagram-item-slides-pager cycle-pager"></div>
                <?php } ?>

                <?php

            }
        }

    }

    /**
     * Featured Video Widget
     */
    if($class == 'Ikit_Featured_Video_Widget') {

        extract($args);

        if($context['video_id'] != null) {

            $video_image_url = $context['video_image_url'];

            if($context['custom_video_image_url'] != null) {
                $video_image_url = $context['custom_video_image_url'];
            }

            $video_id = $context['video_id'];
            $video_player_url = ikit_social_service_video_get_player_url($context['video_type'], $context['video_id']) . '?autoplay=1&rel=0&wmode=opaque';

            echo $before_title;
            ikit_three_render_widget_header('Featured Video');
            echo $after_title;

            ?>

            <div class="video-item">
                <div class="video-item-image video-item-image-<?php echo $context['video_id'] ?> cat-plugin-anystretch-image cat-plugin-video-swap"
                    cat_plugin_anystretch_image_alt="Featured video image"
                    cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($video_image_url, IKIT_THREE_IMAGE_RESIZE_LARGE); ?>"
                    cat_plugin_video_swap_button_selector=".video-item-image-<?php echo $context['video_id'] ?>"
                    cat_plugin_video_swap_video_player_url="<?php echo $video_player_url; ?>"
                >
                    <div class="video-item-overlay"></div>
                </div>
                <div class="video-item-title"><?php echo $context['video_title']; ?></div>

            </div>

            <?php

        }

    }

    /**
     * News Widget
     */
    if($class == 'Ikit_News_Widget') {

        extract($args);

        echo $before_title;
        $title = $instance['title'];
        if(empty($title)) {
            $title = 'News';
        }
        ikit_three_render_widget_header($title);
        echo $after_title;

        ?>
        <div class="news-items">
        <?php

        $post_count = 0;
        foreach($context['posts'] as $post) {

            $news_image = ikit_post_get_image_url($post->ID, 'full', null);
            $news_url_target = '_self';
            $news_url = get_permalink($post->ID);

            $external = false;
            if($post->post_type == IKIT_POST_TYPE_IKIT_POST_EXTERNAL) {
                $external = true;
                $news_url = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_POST_EXTERNAL_LINK_URL, true);
                $news_url_target = '_blank';
            }

            $news_preview_description = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_POST_PREVIEW_DESCRIPTION, true);
            $news_author = ikit_post_get_author($post->ID, get_the_author_meta('display_name', $post->post_author));

            ?>

            <div class="news-item">

                <a class="link-block" target="<?php echo $news_url_target; ?>" href="<?php echo $news_url; ?>">

                    <?php if($news_image) { ?>
                        <div class="link-block-image news-item-image"><img alt="News image" src="<?php echo ikit_three_image_resize($news_image, IKIT_THREE_IMAGE_RESIZE_LARGE); ?>"></img></div>
                    <?php } ?>

                    <div class="news-item-title"><?php echo $post->post_title; ?></div>

                    <?php ikit_three_render_news_item_attributes($post, $external); ?>

                    <?php if(empty($news_preview_description) == false) { ?>
                        <div class="news-item-description"><?php echo $news_preview_description; ?></div>
                    <?php } ?>

                    <?php ikit_three_render_sso_lock(array("post_id" => $post->ID)); ?>

                </a>

            </div>

            <?php

            $post_count++;

        }

        ?>
        </div>
        <?php

    }

    /**
     * Events Internal Widget
     */
    if($class == 'Ikit_Events_Internal_Widget') {

        extract($args);

        echo $before_title;
        $title = $instance['title'];
        if(empty($title)) {
            $title = 'Upcoming Community Events';
        }
        ikit_three_render_widget_header($title);
        echo $after_title;

        ?>
        <div class="event-items">
        <?php

        $post_count = 0;
        foreach($context['posts'] as $post) {

            $ikit_event_meta = ikit_event_get_meta($post->ID);
            $event = ikit_event_get_meta_normalized($post->ID, $ikit_event_meta, null);
            $event_image = $event['image'];
            $event_start_date = $event['start_date'];
            $event_end_date = $event['end_date'];
            $event_preview_description = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_EVENT_PREVIEW_DESCRIPTION, true);
            $event_url = $event['permalink'];
            $event_url_target = $event['permalink_target'];
            $event_location_city = $event['location_city'];
            $event_start_time = $event['start_time'];
            $event_end_time = $event['end_time'];
            $event_start_time_raw = $event['start_time_raw'];
            $event_end_time_raw = $event['end_time_raw'];
            $event_timezone_abbreviation = $event['timezone_abbreviation'];

            ?>

            <div class="event-item">

                <a class="link-block" target="<?php echo $event_url_target; ?>" href="<?php echo $event_url; ?>">

                    <?php if($event_image) { ?>
                        <div class="link-block-image event-item-image"><img alt="Event image" src="<?php echo $event_image; ?>"></img></div>
                    <?php } ?>

                    <div class="event-item-title">
                        <?php echo $post->post_title; ?>
                    </div>

                    <?php ikit_three_render_event_item_attributes($post, false, true, $event_start_date, $event_end_date, $event_location_city, $event_start_time, $event_end_time, $event_start_time_raw, $event_end_time_raw, $event_timezone_abbreviation); ?>

                    <?php if(empty($event_preview_description) == false) { ?>
                        <div class="event-item-description"><?php echo $event_preview_description; ?></div>
                    <?php } ?>

                </a>

            </div>

            <?php

            $post_count++;

        }
        ?>
        </div>
        <?php

    }

    /**
     * Featured Events and News Billboard Widget
     */
    if($class == 'Ikit_Three_Featured_Events_News_Billboard_Widget') {

        extract($args);

        if(count($context['posts']) > 0) {

            $paused = false;
            if($context['disable_auto_slide'] == 1) {
                $paused = true;
            }

            ?>
            <div class="items">

                <div class="item-slides-container">

                    <!-- Calc means set height of slideshow to height of longest slide, we need this to center vertically -->
                    <div class="item-slides cycle2-slideshow"
                        data-cycle-pager-template="&lt;span&gt;&lt;/span&gt;"
                        data-cycle-manual-speed="200"
                        data-cycle-timeout="5000"
                        data-cycle-swipe="true"
                        data-cycle-pause-on-hover="true"
                        data-cycle-paused="<?php echo $paused ? 'true' : 'false'; ?>"
                        data-cycle-log="false"
                        data-cycle-slides=".item-slide"
                        data-cycle-auto-height="calc"
                        data-cycle-pager=".item-slides-pager"
                        data-disable-fullscreen="<?php echo $context['disable_fullscreen']; ?>"
                    >
                        <?php

                        $post_count = 0;
                        foreach($context['posts'] as $post) {

                            $item_image = null;
                            $item_preview_description = null;
                            $item_url = null;
                            $item_url_target = null;
                            $item_attributes = null;
                            $item_link_title = null;

                            if($post->post_type == IKIT_POST_TYPE_IKIT_EVENT || $post->post_type == IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL || $post->post_type == IKIT_POST_TYPE_IKIT_EVENT_INTERNAL) {

                                $ikit_event_meta = ikit_event_get_meta($post->ID);
                                $event = ikit_event_get_meta_normalized($post->ID, $ikit_event_meta, null);
                                $item_image = $event['image'];
                                $item_url = $event['permalink'];
                                $item_url_target = $event['permalink_target'];
                                $item_preview_description = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_EVENT_PREVIEW_DESCRIPTION, true);
                                $item_link_title = "Learn More";

                                $event_start_date = $event['start_date'];
                                $event_end_date = $event['end_date'];

                                // Don't need to display external, internal, sso lock indicator
                                $item_attributes =  $event_start_date;
                                if($event_end_date != $event_start_date) {
                                    $item_attributes = $item_attributes . ' - ' . $event_end_date;
                                }

                            }
                            else if($post->post_type == 'post' || $post->post_type == IKIT_POST_TYPE_IKIT_POST_EXTERNAL) {

                                $item_preview_description = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_EVENT_PREVIEW_DESCRIPTION, true);
                                $item_image = ikit_post_get_image_url($post->ID, 'full', null);
                                $item_url_target = '_self';
                                $item_url = get_permalink($post->ID);
                                $item_link_title = "Read More";

                                // Don't need to display external indicator
                                if($post->post_type == IKIT_POST_TYPE_IKIT_POST_EXTERNAL) {
                                    $item_url = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_POST_EXTERNAL_LINK_URL, true);
                                    $item_url_target = '_blank';
                                }
                            }

                            ?>
                            <div class="item-slide">

                                <a class="link-block" target="<?php echo $item_url_target; ?>" href="<?php echo $item_url; ?>">

                                    <table>
                                    <tr>

                                    <td class="item-info-col">
                                        <div class="item-info-col-inner">
                                            <span class="item-title">
                                                <?php echo $post->post_title; ?>
                                            </span>

                                            <span class="item-attributes">
                                                <?php echo $item_attributes; ?>
                                            </span>

                                            <?php if(empty($item_preview_description) == false) { ?>
                                            <div class="item-description">
                                                <?php echo $item_preview_description; ?>
                                            </div>
                                            <?php } ?>

                                            <div class="item-read-more-container">
                                                <div class="item-read-more box-button">
                                                    <?php echo $item_link_title; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="item-image-col">
                                        <!-- If does not have an image, just don't make it a link block image so hover state doesn't appear -->
                                        <div class="<?php if($item_image) { ?>link-block-image<?php } ?> item-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Item image" cat_plugin_anystretch_image_url="<?php if($item_image) { echo ikit_three_image_resize($item_image, IKIT_THREE_IMAGE_RESIZE_LARGE); } else { echo ''; } ?>"></div>
                                    </td>

                                    </tr>
                                    </table>

                                </a>
                            </div>
                            <?php

                            $post_count++;

                        }

                        ?>

                    </div>


                </div>

            </div>

            <?php if($post_count > 1) { ?>
                <div class="item-slides-pager cycle-pager"></div>
            <?php } ?>

            <?php

        }

    }

    /**
     * Latest Events and News Billboard Widget
     */
    if($class == 'Ikit_Three_Latest_Events_News_Billboard_Widget') {

        extract($args);

        if(count($context['posts']) > 0) {

            ?>
            <div class="items">
            <div class="items-layout">
            <?php

            $post_count = 0;
            foreach($context['posts'] as $post) {

                // Only display 3 items at most.
                if($post_count >= 3) {
                    break;
                }

                $item_image = null;
                $item_preview_description = null;
                $item_url = null;
                $item_url_target = null;
                $item_attributes = null;
                $item_link_title = null;

                if($post->post_type == IKIT_POST_TYPE_IKIT_EVENT || $post->post_type == IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL || $post->post_type == IKIT_POST_TYPE_IKIT_EVENT_INTERNAL) {

                    $ikit_event_meta = ikit_event_get_meta($post->ID);
                    $event = ikit_event_get_meta_normalized($post->ID, $ikit_event_meta, null);
                    $item_image = $event['image'];
                    $item_url = $event['permalink'];
                    $item_url_target = $event['permalink_target'];
                    $item_link_title = 'Learn More';
                    $item_preview_description = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_EVENT_PREVIEW_DESCRIPTION, true);

                    $event_start_date = $event['start_date'];
                    $event_end_date = $event['end_date'];

                    // Don't need to display external, internal, sso lock indicator
                    $item_attributes =  $event_start_date;
                    if($event_end_date != $event_start_date) {
                        $item_attributes = $item_attributes . ' - ' . $event_end_date;
                    }

                }
                else if($post->post_type == 'post' || $post->post_type == IKIT_POST_TYPE_IKIT_POST_EXTERNAL) {

                    $item_preview_description = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_EVENT_PREVIEW_DESCRIPTION, true);
                    $item_image = ikit_post_get_image_url($post->ID, 'full', null);
                    $item_url_target = '_self';
                    $item_link_title = 'Read More';
                    $item_url = get_permalink($post->ID);

                    // Don't need to display external indicator
                    if($post->post_type == IKIT_POST_TYPE_IKIT_POST_EXTERNAL) {
                        $item_url = get_post_meta($post->ID, IKIT_CUSTOM_FIELD_IKIT_POST_EXTERNAL_LINK_URL, true);
                        $item_url_target = '_blank';
                    }
                }

                ?>

                <div class="item">
                    <div class="item-inner">

                        <a class="link-block" target="<?php echo $item_url_target; ?>" href="<?php echo $item_url; ?>">

                            <?php if($item_image) { ?>
                                <div class="link-block-image item-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Item image" cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($item_image, IKIT_THREE_IMAGE_RESIZE_LARGE); ?>"></div>
                            <?php } ?>

                            <div class="item-title">
                                <?php echo $post->post_title; ?>
                            </div>

                            <div class="item-attributes">
                                <?php echo $item_attributes; ?>
                            </div>

                            <?php if(empty($item_preview_description) == false) { ?>
                            <div class="item-description">
                                <?php echo $item_preview_description; ?>
                            </div>
                            <?php } ?>

                            <div class="item-read-more-container">
                                <div class="item-read-more box-button">
                                    <?php echo $item_link_title; ?>
                                </div>
                            </div>

                        </a>

                    </div>
                </div>

                <?php

                $post_count++;

            }
            ?>
            </div>
            </div>
            <?php

        }

    }

    /**
     * Events Widget
     */
    if($class == 'Ikit_Events_Widget') {

        extract($args);

        echo $before_title;
        $title = $instance['title'];
        if(empty($title)) {
            $title = 'Upcoming Events';
        }
        ikit_three_render_widget_header($title);
        echo $after_title;

        ?>
        <div class="event-items">
        <?php

        $post_count = 0;
        foreach($context['posts'] as $post) {

            $ikit_event_meta = ikit_event_get_meta($post->ID);
            $event = ikit_event_get_meta_normalized($post->ID, $ikit_event_meta, null);
            $event_image = $event['image'];
            $event_location_city = $event['location_city'];
            $event_start_date = $event['start_date'];
            $event_end_date = $event['end_date'];
            $event_url = $event['permalink'];
            $event_url_target = $event['permalink_target'];
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

                <a class="link-block" target="<?php echo $event_url_target; ?>" href="<?php echo $event_url; ?>">

                    <?php if($event_image) { ?>
                        <div class="link-block-image event-item-image"><img alt="Event image" src="<?php echo ikit_three_image_resize($event_image, IKIT_THREE_IMAGE_RESIZE_LARGE); ?>"></img></div>
                    <?php } ?>

                    <div class="event-item-title">
                        <?php echo $post->post_title; ?>
                    </div>

                    <?php ikit_three_render_event_item_attributes($post, $external, $internal, $event_start_date, $event_end_date, $event_location_city, $event_start_time, $event_end_time, $event_start_time_raw, $event_end_time_raw, $event_timezone_abbreviation); ?>

                    <?php if(empty($event_preview_description) == false) { ?>
                        <div class="event-item-description"><?php echo $event_preview_description; ?></div>
                    <?php } ?>

                    <?php ikit_three_render_sso_lock(array("post_id" => $post->ID)); ?>

                </a>

            </div>

            <?php

            $post_count++;

        }

        ?>
        </div>
        <?php

    }

    /**
     * Quote Widget
     */
    if($class == 'Ikit_Quote_Widget') {

        extract($args);

        // Get a random quote from the list
        if(count($context['quotes']) > 0) {

            $quote = $context['quotes'][array_rand($context['quotes'], 1)];

            ?>

            <div class="quote-item">

                <div class="quote-item-text">
                    &ldquo;<?php echo $quote['quote_text']; ?>&rdquo;
                </div>

                <?php if(empty($quote['attribution']) == false) { ?>

                    <div class="quote-item-attribution">
                        <?php if(empty($quote['attribution_link_url']) == false) { ?>
                            <a target="_blank" href="<?php echo $quote['attribution_link_url']; ?>">&ndash;<?php echo $quote['attribution']; ?></a>
                        <?php } else { ?>
                            &ndash;<?php echo $quote['attribution']; ?>
                        <?php } ?>
                    </div>

                <?php } ?>

            </div>

            <?php

        }

    }

    /**
     * Promo Widget
     */
    if($class == 'Ikit_WidgetPromo') {

        extract($args);

        $style_id = (isset($context['style_id']) ? $context['style_id'] : 0);
        $link_url = (isset($context['link_url']) ? $context['link_url'] : null);
        $link_url_title = (isset($context['link_url_title']) ? $context['link_url_title'] : null);
        $link_url_target = (isset($context['link_url_target']) ? $context['link_url_target'] : null);
        $text = $context['text'];

        // Join
        if($context['preset_id'] == "2") {
            $text = "Make a donation to help support AIGA initiatives!";
            $link_url_target = "_blank";
            $link_url_title = "Donate";
            $link_url = "http://www.aiga.org/contribute-campaigns";
            $style_id = "1";
        }
        // Donate
        else if($context['preset_id'] == "1") {
            $text = "Become an AIGA member today and unlock the benefits!";
            $link_url_target = "_blank";
            $link_url_title = "Join Today";
            $link_url = "http://www.aiga.org/join";
            $style_id = "0";
        }
        else {
            if(empty($link_url_target) == true) {
                $link_url_target = "_blank";
            }
        }

        $style_id = intval($instance['promo_style_id']);
        if(!$style_id) {
            $style_id = 0;
        }

        ?>
        <div class="promo-item promo-item-style-<?php echo $style_id; ?>">
            <div class="promo-item-text"><?php echo $text; ?></div>
            <?php if(empty($link_url_title) == false && empty($link_url) == false) { ?>
                <a class="box-button promo-item-link" target="<?php echo $link_url_target;?>" href="<?php echo $link_url; ?>"><?php echo $link_url_title; ?></a>
            <?php } ?>
        </div>
        <?php

    }



}

add_action('ikit_action_widgets_render_before_widget', 'ikit_three_action_widgets_render_before_widget', 10, 5);

function ikit_three_action_widgets_render_before_widget($class, $args, $instance, $context, $before_widget) {
    echo $before_widget;
}

add_action('ikit_action_widgets_render_after_widget', 'ikit_three_action_widgets_render_after_widget', 10, 5);

function ikit_three_action_widgets_render_after_widget($class, $args, $instance, $context, $after_widget) {
    echo $after_widget;
}

add_filter('ikit_filter_widgets_should_render', 'ikit_three_filter_widgets_should_render', 10, 5);

function ikit_three_filter_widgets_should_render($val, $class, $args, $instance, $context) {

    if($class == 'Ikit_Events_Internal_Widget') {
        if(count($context['posts']) <= 0) {
            return false;
        }
    }

    if($class == 'Ikit_News_Widget') {
        if(count($context['posts']) <= 0) {
            return false;
        }
    }

    if($class == 'Ikit_Events_Widget') {
        if(count($context['posts']) <= 0) {
            return false;
        }
    }

    if($class == 'Ikit_WidgetFeaturedJob') {
        if(count($context['featured_jobs']) <= 0) {
            return false;
        }
    }

    // Disabled as no avatars with impexium yet
    if($class == 'Ikit_WidgetIAmAIGA') {
        return false;
    }

    return true;
}

add_action('ikit_action_widgets_form_update', 'ikit_three_action_widgets_form_update', 10, 5);

function ikit_three_action_widgets_form_update($class, $class_instance, $instance, $new_instance, $old_instance) {

}

add_action('ikit_action_widgets_render_form', 'ikit_three_action_widgets_render_form', 10, 4);

function ikit_three_action_widgets_render_form($class, $class_instance, $instance) {

    if($class == 'Ikit_WidgetPromo') {

        $instance = wp_parse_args((array)$instance, array('promo_style_id' => ''));

        $promo_styles = array(
            "0" => "Light",
            "1" => "Dark",
        );

        $selected_promo_style_id = esc_attr( $instance['promo_style_id'] );

        ?>
        <p>
        <label for="<?php echo $class_instance->get_field_id('promo_style_id'); ?>">Select style:</label>
        <select id="<?php echo $class_instance->get_field_id('promo_style_id'); ?>" name="<?php echo $class_instance->get_field_name('promo_style_id'); ?>" class="widefat">
        <?php foreach($promo_styles as $promo_style_id => &$promo_style_name) { ?>
            <option <?php if($promo_style_id == $selected_promo_style_id) {?>selected<?php } ?> value="<?php echo $promo_style_id; ?>"><?php echo $promo_style_name; ?></option>
        <?php } ?>
        </select>
        </p>
        <?php

    }

}

/**
 Featured Events News Billboard Widget
 Similar to existing billboards but supports both Events and News posts.
 Very specific to this theme so is not made a common widget...
 */
class Ikit_Three_Featured_Events_News_Billboard_Widget extends Ikit_Widget {
    public function __construct() {
        parent::__construct(
            'ikit_three_featured_events_news_billboard_widget',
            'iKit Featured Events and News Billboard Widget',
            array('classname' => 'ikit-three-widget-featured-events-news-billboard', 'description' => 'Displays events and news posts assigned to the "Featured" category in a billboard format. If no items are featured, will instead display latest. Alternates between events and news items (event, news, event, ...).'));
    }

    function form_update($new_instance, $old_instance) {

        $instance = $old_instance;
        $instance['num_results'] = intval($new_instance['num_results']);
        $instance['disable_auto_slide'] = ($new_instance['disable_auto_slide'] == 1 ? 1 : 0);
        $instance['disable_fullscreen'] = ($new_instance['disable_fullscreen'] == 1 ? 1 : 0);
        $instance['selected_post_types'] = $new_instance['selected_post_types'];
        return $instance;
    }

    function render_form($instance) {
        $instance = wp_parse_args( (array) $instance, array( 'num_results'=>'5'));
        $num_results = esc_attr( $instance['num_results'] );

        $post_types = array(
            IKIT_POST_TYPE_IKIT_EVENT => "Events",
            'post' => "Posts",
            IKIT_POST_TYPE_IKIT_EVENT_INTERNAL => "Community Events",
            IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL => "External Events",
            IKIT_POST_TYPE_IKIT_POST_EXTERNAL => "External Posts"
        );

        ?>

        <p>You MUST place this above the "iKit Latest Events and News Billboard Widget" widget or it will not render properly. If you do want to place it below, make sure to check "Disable fullscreen" below.</p>

        <p>
        <label for="<?php echo $this->get_field_id('num_results'); ?>">Number of items to display (max 5):</label>
        <input class="widefat" id="<?php echo $this->get_field_id('num_results'); ?>" name="<?php echo $this->get_field_name('num_results'); ?>" type="text" value="<?php echo esc_attr($num_results); ?>"/>
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'disable_auto_slide' ); ?>"><?php _e('Disable auto-slide:'); ?></label>
        <input class="checkbox" type="checkbox" <?php checked('1', (array_key_exists('disable_auto_slide', $instance) ? $instance['disable_auto_slide'] : 0)); ?> value="1" id="<?php echo $this->get_field_id( 'disable_auto_slide' ); ?>" name="<?php echo $this->get_field_name( 'disable_auto_slide' ); ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'disable_fullscreen' ); ?>"><?php _e('Disable fullscreen:'); ?></label>
        <input class="checkbox" type="checkbox" <?php checked('1', (array_key_exists('disable_fullscreen', $instance) ? $instance['disable_fullscreen'] : 0)); ?> value="1" id="<?php echo $this->get_field_id( 'disable_fullscreen' ); ?>" name="<?php echo $this->get_field_name( 'disable_fullscreen' ); ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('selected_post_types'); ?>">Select the types to display (selecting nothing defaults to all):</label>
        <select multiple id="<?php echo $this->get_field_id('selected_post_types'); ?>" name="<?php echo $this->get_field_name('selected_post_types'); ?>[]" class="widefat">
            <?php foreach($post_types as $post_type => &$post_type_name) { ?>
                <option <?php if(in_array($post_type, (isset($instance['selected_post_types']) ? $instance['selected_post_types'] : array()))) { ?>selected<?php } ?> value="<?php echo $post_type; ?>"><?php echo $post_type_name; ?></option>
            <?php } ?>
        </select>
        </p>

        <?php
    }

    public function render_context($args, $instance, &$context) {

        // We fetch multiple post types and return the union of the two so we do not limit the post count here
        $num_posts = 5;

        $events_post_types = array(IKIT_POST_TYPE_IKIT_EVENT, IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL, IKIT_POST_TYPE_IKIT_EVENT_INTERNAL);
        $news_post_types = array('post', IKIT_POST_TYPE_IKIT_POST_EXTERNAL);

        // Get the events posts
        $selected_events_post_types = $events_post_types;
        if(isset($instance['selected_post_types'])) {
            $selected_events_post_types = $instance['selected_post_types'];
            $selected_events_post_types = array_diff($selected_events_post_types, $news_post_types);
        }
        $posts_events = array();

        if(sizeof($selected_events_post_types) > 0) {
            $query_events = array();
            $query_events['posts_per_page'] = $num_posts;
            $query_events['category_name'] = IKIT_SLUG_CATEGORY_FEATURED;
            $query_events['post_type'] = $selected_events_post_types;
            $query_events['order'] = 'ASC';
            $query_events['post_status'] = 'publish';
            $query_events['orderby'] = 'meta_value_num';
            $query_events['meta_key'] = IKIT_CUSTOM_FIELD_GENERIC_ORDERING_DISPLAY_PRIORITY;

            $query_events['meta_query'] = array(

                array('key' => IKIT_CUSTOM_FIELD_IKIT_EVENT_END_DATE,
                    'value' => date_i18n("Y-m-d"), 'compare' => '>=',
                    'type' => 'DATE'),

                array('key' => IKIT_CUSTOM_FIELD_IKIT_EVENT_STATUS, 'value' => 'Closed',
                    'compare' => '!=',
                    'type' => 'CHAR')

            );

            $posts_events = get_posts($query_events);
        }

        // Get news posts
        $selected_news_post_types = $news_post_types;
        if(isset($instance['selected_post_types'])) {
            $selected_news_post_types = $instance['selected_post_types'];
            $selected_news_post_types = array_diff($selected_news_post_types, $events_post_types);
        }
        $posts_news = array();

        if(sizeof($selected_news_post_types) > 0) {
            $query_news = array();
            $query_news['posts_per_page'] = $num_posts;
            $query_news['category_name'] = IKIT_SLUG_CATEGORY_FEATURED;
            $query_news['order'] = 'DESC';
            $query_news['post_status'] = 'publish';
            $query_news['post_type'] = $selected_news_post_types;
            $query_news['orderby'] = 'meta_value_num';
            $query_news['meta_key'] = IKIT_CUSTOM_FIELD_GENERIC_ORDERING_DISPLAY_PRIORITY;

            $posts_news = get_posts($query_news);
        }

        // If nothing featured at all, show latest news and events instead...
        if(count($posts_events) <= 0 && count($posts_news) <= 0) {

            if(sizeof($selected_events_post_types) > 0) {
                $query_events['category_name'] = null;
                $posts_events = get_posts($query_events);
            }

            if(sizeof($selected_news_post_types) > 0) {
                $query_news['category_name'] = null;
                $posts_news = get_posts($query_news);
            }

        }

        // Alternate event then news and so on, we cannot directly
        // compare because events take higher precedence the earlier they are
        // and news take higher precdence the later they are.
        $posts = array();
        for($i=0;$i<$num_posts;$i++) {
            if(sizeof($posts_events) > $i) {
                array_push($posts, $posts_events[$i]);
            }
            if(sizeof($posts_news) > $i) {
                array_push($posts, $posts_news[$i]);
            }
        }

        // Just return the first five or fewer if a number was specified
        $num_results = $instance['num_results'];
        if($num_results <= 0 || $num_results > $num_posts) {
            $num_results = $num_posts;
        }

        $posts = array_slice($posts, 0, $num_results);

        $context['disable_auto_slide'] = $instance['disable_auto_slide'];
        $context['disable_fullscreen'] = $instance['disable_fullscreen'];
        $context['posts'] = $posts;

    }

}

function ikit_three_widgets_featured_events_news_billboard_init() {
    return register_widget("Ikit_Three_Featured_Events_News_Billboard_Widget");
}

add_action( 'widgets_init', 'ikit_three_widgets_featured_events_news_billboard_init');


/**
 Latest Events News Billboard Widget
 Similar to existing billboards but supports both Events and News posts and shows only chronological order
 ignoring those that are featured.
 */
class Ikit_Three_Latest_Events_News_Billboard_Widget extends Ikit_Widget {
    public function __construct() {
        parent::__construct(
            'ikit_three_latest_events_news_billboard_widget',
            'iKit Latest Events and News Billboard Widget',
            array('classname' => 'ikit-three-widget-latest-events-news-billboard', 'description' => 'Displays latest events and news posts in a billboard format. Alternates between events and news items (event, news, event, ...).'));
    }

    function form_update($new_instance, $old_instance) {

        $instance = $old_instance;
        $instance['selected_post_types'] = $new_instance['selected_post_types'];
        return $instance;
    }

    function render_form($instance) {
        $instance = wp_parse_args( (array) $instance, array());

        $post_types = array(
            IKIT_POST_TYPE_IKIT_EVENT => "Events",
            'post' => "Posts",
            IKIT_POST_TYPE_IKIT_EVENT_INTERNAL => "Community Events",
            IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL => "External Events",
            IKIT_POST_TYPE_IKIT_POST_EXTERNAL => "External Posts"
        );

        ?>

            <p>
            <label for="<?php echo $this->get_field_id('selected_post_types'); ?>">Select the types to display (selecting nothing defaults to all):</label>
            <select multiple id="<?php echo $this->get_field_id('selected_post_types'); ?>" name="<?php echo $this->get_field_name('selected_post_types'); ?>[]" class="widefat">
                <?php foreach($post_types as $post_type => &$post_type_name) { ?>
                    <option <?php if(in_array($post_type, (isset($instance['selected_post_types']) ? $instance['selected_post_types'] : array()))) { ?>selected<?php } ?> value="<?php echo $post_type; ?>"><?php echo $post_type_name; ?></option>
                <?php } ?>
            </select>
            </p>

            <?php
        }

    public function render_context($args, $instance, &$context) {

        $num_posts = 5;

        $events_post_types = array(IKIT_POST_TYPE_IKIT_EVENT, IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL, IKIT_POST_TYPE_IKIT_EVENT_INTERNAL);
        $news_post_types = array('post', IKIT_POST_TYPE_IKIT_POST_EXTERNAL);

        // Get the events posts
        $selected_events_post_types = $events_post_types;
        if(isset($instance['selected_post_types'])) {
            $selected_events_post_types = $instance['selected_post_types'];
            $selected_events_post_types = array_diff($selected_events_post_types, $news_post_types);
        }
        $posts_events = array();

        if(sizeof($selected_events_post_types) > 0) {
            $query_events = array();
            $query_events['posts_per_page'] = $num_posts;
            $query_events['post_type'] = $selected_events_post_types;
            $query_events['order'] = 'ASC';
            $query_events['post_status'] = 'publish';
            $query_events['orderby'] = 'meta_value_num';
            $query_events['meta_key'] = IKIT_CUSTOM_FIELD_GENERIC_ORDERING_DISPLAY_PRIORITY;

            $query_events['meta_query'] = array(

                array('key' => IKIT_CUSTOM_FIELD_IKIT_EVENT_END_DATE,
                'value' => date_i18n("Y-m-d"), 'compare' => '>=',
                'type' => 'DATE'),

                array('key' => IKIT_CUSTOM_FIELD_IKIT_EVENT_STATUS, 'value' => 'Closed',
                'compare' => '!=',
                'type' => 'CHAR')

            );

            $posts_events = get_posts($query_events);
        }

        // Get news posts
        $selected_news_post_types = $news_post_types;
        if(isset($instance['selected_post_types'])) {
            $selected_news_post_types = $instance['selected_post_types'];
            $selected_news_post_types = array_diff($selected_news_post_types, $events_post_types);
        }
        $posts_news = array();

        if(sizeof($selected_news_post_types) > 0) {
            $query_news = array();
            $query_news['posts_per_page'] = $num_posts;
            $query_news['order'] = 'DESC';
            $query_news['post_status'] = 'publish';
            $query_news['post_type'] = array('post', IKIT_POST_TYPE_IKIT_POST_EXTERNAL);
            $query_news['orderby'] = 'meta_value_num';
            $query_news['meta_key'] = IKIT_CUSTOM_FIELD_GENERIC_ORDERING_DISPLAY_PRIORITY;

            $posts_news = get_posts($query_news);
        }

        // Alternate event then news and so on, we cannot directly
        // compare because events take higher precedence the earlier they are
        // and news take higher precdence the later they are.
        $posts = array();
        for($i=0;$i<$num_posts;$i++) {
            if(sizeof($posts_events) > $i) {
                array_push($posts, $posts_events[$i]);
            }
            if(sizeof($posts_news) > $i) {
                array_push($posts, $posts_news[$i]);
            }
        }

        // Just return the first five
        $posts = array_slice($posts, 0, $num_posts);

        $context['posts'] = $posts;

    }

}

function ikit_three_widgets_latest_events_news_billboard_init() {
    return register_widget("Ikit_Three_Latest_Events_News_Billboard_Widget");
}

add_action( 'widgets_init', 'ikit_three_widgets_latest_events_news_billboard_init');


?>
