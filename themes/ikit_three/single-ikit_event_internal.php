<?php
/**
 * Template Name: Single Event Internal
 */
?>
<?php get_header();?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post();

    global $id;

    $ikit_event_meta = ikit_event_get_meta($id);
    $event = ikit_event_get_meta_normalized($id, $ikit_event_meta, null);
    $event_link_title = $ikit_event_meta->url_name;

    if(empty($event_link_title)) {
        $event_link_title = 'More Information';
    }

    $start_date_abbr = mysql2date('D, M j, Y', get_gmt_from_date($event['start_date_raw']), false);
    $end_date_abbr = mysql2date('D, M j, Y', get_gmt_from_date($event['end_date_raw']), false);

    ?>

    <div class="page-header-4">
         <?php if(empty($event['image']) == false && $g_theme_options[IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == false) { ?>
            <div class="page-header-4-title-container">
                <div class="page-header-4-title">
                    <?php the_title(); ?>
                </div>
            </div>
            <div class="page-header-4-image-container">
                <div class="page-header-4-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Event image" cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($event['image'], IKIT_THREE_IMAGE_RESIZE_LARGE); ?>"></div>
            </div>
        <?php } else { ?>
            <div class="page-header-5-title-container">
                <div class="page-header-5-title">
                    <?php the_title(); ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <table class="page-layout-4">
    <tr>

        <td class="page-layout-4-tools">
            <div class="page-layout-4-tool">
                <?php ikit_three_render_social_share([array('name' => 'addtocal', 'render' => function($render_context) { ikit_three_render_event_add_to_calendar($render_context); }, 'render_context' => ikit_three_render_event_add_to_calendar_context($event))]); ?>
            </div>
        </td>

        <td class="page-layout-4-content">

            <table>
            <tr>
            <td class="page-layout-4-body">
                <?php if(empty($event['image']) == false && $g_theme_options[IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == true) { ?>
                <div class="page-layout-4-body-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Event image" cat_plugin_anystretch_image_url="<?php echo $event['image']; ?>"></div>
                <?php } ?>
                <div class="page-layout-4-body-paragraph-text wp-editor">
                    <?php the_content(); ?>
                </div>
            </td>
            <td class="page-layout-4-attributes">
                <div class="page-layout-4-attributes-inner">

                    <div class="page-layout-4-attribute">
                        <div class="page-layout-4-attribute-header">When & Where</div>
                        <div class="page-layout-4-attribute-text">

                            <span class="event-date"><?php echo $start_date_abbr;?> <?php if($event['end_date'] != $event['start_date']) { echo ' - ' . $end_date_abbr; } ?></span>
                            <?php if(ikit_event_has_time($event['start_time_raw'])) { ?>
                                <span class="event-time"><?php echo date('g:i A', $event['start_time']); ?> - <?php echo date('g:i A', $event['end_time']); ?></span>
                            <?php } ?>

                            <?php if(empty($event['location_name']) == false || empty($event['location_city']) == false || empty($event['location_address1']) == false || empty($event['location_address2']) == false) { ?>
                            <div class="event-location">
                                <div class="event-location-inner">
                                    <div class="event-location-name"><?php echo $event['location_name']; ?></div>
                                    <div class="event-location-address1"><?php echo $event['location_address1']; ?></div>
                                    <div class="event-location-address2"><?php echo $event['location_address2']; ?></div>
                                    <div class="event-location-city-state-zip"><?php echo $event['location_city']; ?><?php if(empty($event['location_city']) == false && empty($event['location_state']) == false) { echo ', '; } ?> <?php echo $event['location_state']; ?> <?php if($event['location_postal_code'] != '0') { echo $event['location_postal_code']; } ?></div>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                    </div>

                    <?php if(!empty($event['location_address1']) && !empty($event['location_city'])) { ?>
                    <div class="page-layout-4-attribute">
                        <iframe
                            class="event-location-map"
                            frameborder="0" style="border:0"
                            src="https://www.google.com/maps/embed/v1/place?key=<?php echo IKIT_API_KEY_GOOGLE_MAPS; ?>&q=<?php echo $event['location_address1'] . ' ' . $event['location_address2'] . ' ' . $event['location_city'] . ' ' . $event['location_state']. ' ' . $event['location_postal_code']; ?>">
                        </iframe>
                    </div>
                    <?php } ?>

                    <?php if(empty($event['url']) == false) { ?>

                    <div class="page-layout-4-attribute">
                        <div class="page-layout-4-attribute-actions">
                            <a class="box-button event-link" target="<?php echo $event['url_target'];?>" href="<?php echo $event['url']; ?>"><?php echo $event_link_title; ?></a>
                        </div>
                    </div>

                    <?php } ?>

                </div>

            </td>
            </tr>
            </table>

        </td>

    </tr>
    </table>

    <?php ikit_three_render_related_items($post->ID); ?>

    <?php if($g_theme_options[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_IKIT_EVENT]) { ?>
        <?php if(comments_open($post->ID)) { ?>
            <?php ikit_three_render_comments(); ?>
        <?php } ?>
    <?php } ?>

    <?php
endwhile;?>

<?php get_footer();?>
