<?php

add_action('ikit_action_shortcodes_render', 'ikit_three_action_shortcodes_render', 10, 4);

function ikit_three_action_shortcodes_render($tag, $context) {

    $unique_id = uniqid();

    if($tag == 'ikit_page_content') {
        echo $context['page_content'];
    }

    if($tag == 'ikit_post_content') {
        echo $context['post_content'];
    }

    if($tag == 'ikit_service_video') {
        if($context['video_id'] != null && $context['video_type'] != null) {
        ?>
            <div class="editor-shortcode-service-video">
                <div class="editor-shortcode-service-video-embed">
                    <iframe width="<?php echo $context['video_width']; ?>" height="<?php echo $context['video_height']; ?>" src="<?php echo ikit_social_service_video_get_player_url($context['video_type'], $context['video_id']) . '?autoplay=0&rel=0&wmode=opaque'; ?>" frameborder="0"></iframe>
                </div>
                <?php if($context['caption'] != null) { ?>
                  <div class="editor-shortcode-service-video-caption"><?php echo $context['caption']; ?></div>
                <?php } ?>
            </div>
        <?php
        }
    }

    if($tag == 'ikit_pull_quote') {

        if($context['text'] != null) {
            ?>
            <div class="editor-shortcode-pull-quote">
                <div class="editor-shortcode-pull-quote-text"><?php echo $context['text']; ?></div>
            </div>
            <?php
        }

    }

    if($tag == 'ikit_image') {

        if($context['image_url']) {

            ?>
            <div class="editor-shortcode-image">
                <img class="editor-shortcode-image-image" src="<?php echo $context['image_url'];?>"/>
                <?php if($context['caption'] != null) { ?>
                  <div class="editor-shortcode-image-caption"><?php echo $context['caption']; ?></div>
                <?php } ?>
            </div>
            <?php

        }

    }

    if($tag == 'ikit_image_gallery') {

        if(sizeof($context['images']) > 0) {

            $has_captions = false;
            foreach($context['images'] as $image) {
                if($image['caption'] != null) {
                    $has_captions = true;
                }
            }

            ?>
            <div class="editor-shortcode-image-gallery">
                <div class="editor-shortcode-image-gallery-slideshow cycle2-slideshow"
                    data-cycle-pager-template="&lt;span&gt;&lt;/span&gt;"
                    data-cycle-manual-speed="200"
                    data-cycle-timeout="5000"
                    data-cycle-swipe="true"
                    data-cycle-paused="true"
                    data-cycle-log="false"
                    data-cycle-slides=".editor-shortcode-image-gallery-slide"
                    data-cycle-auto-height="container"
                    data-cycle-loader="wait"
                    data-cycle-pager=".cycle-pager-<?php echo $unique_id; ?>"
                    data-cycle-caption=".cycle-caption-<?php echo $unique_id; ?>"
                    data-cycle-caption-template="{{cycleCaption}}"
                >
                    <?php foreach($context['images'] as $image) { ?>
                    <div class="editor-shortcode-image-gallery-slide cycle-next" data-cycle-caption="<?php if($image['caption'] != null) { echo $image['caption']; } else { echo ''; };?>">
                        <div class="editor-shortcode-image-gallery-slide-image">
                            <img class="editor-shortcode-image-gallery-slide-image-image" src="<?php echo $image['image_url'];?>"/>
                        </div>
                    </div>
                    <?php } ?>

                </div>

                <?php if(sizeof($context['images']) > 1) { ?>
                    <div class="editor-shortcode-image-gallery-slideshow-pager cycle-pager cycle-pager-<?php echo $unique_id; ?>"></div>
                <?php } ?>

                <?php if($has_captions == true) { ?>
                    <div class="editor-shortcode-image-gallery-slideshow-caption cycle-caption cycle-caption-<?php echo $unique_id; ?>"></div>
                <?php } ?>

            </div>
            <?php

        }

    }

}

?>