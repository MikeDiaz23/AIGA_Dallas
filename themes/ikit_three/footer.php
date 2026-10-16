<?php
/**
 * The template for displaying the footer.
 */
?>

<?php

global $g_main_nav_menu_items;
global $g_national_sponsors;
global $g_local_sponsors_short;
global $g_options;
global $g_theme_options;

?>

<!-- End layout content -->
</div>

<div class="footer">

    <div class="footer-inner">

        <?php
        $mailchimp_signup_form_url = $g_options[IKIT_PLUGIN_OPTION_MAILCHIMP_SIGNUP_FORM_URL];

        if(empty($mailchimp_signup_form_url) == false) {
        ?>
        <div class="footer-section footer-mailing-list">

            <div class="footer-mailing-list-inner">

                <div class="footer-header">Newsletter</div>
                <div class="footer-mailing-list-help">Stay connected and learn about the latest news and events in our community!</div>

                <form action="<?php echo $mailchimp_signup_form_url; ?>" method="post" target="_blank">
                    <input class="footer-mailing-list-input box-input required email"  placeholder="enter your email address"  type="text" value="" name="EMAIL" id="mce-EMAIL">
                    <!-- For 508 compliance -->
                    <label style="display:none"for="mce-EMAIL">Email</label>
                </form>

            </div>

        </div>
        <?php } ?>          

        <?php
        if(ikit_has_social_links()) {
        ?>        
        <div class="footer-section footer-social">

            <div class="footer-social-inner">

                <div class="footer-header">Find us on</div>
                <div class="footer-social-links">
                    <?php ikit_render_social_links(); ?>
                </div>

            </div>

        </div>
        <?php } ?>        

        <?php
        $contact_info = $g_options[IKIT_PLUGIN_OPTION_CONTACT_INFO];        

        if(empty($contact_info) == false) {
        ?>
        <div class="footer-section footer-mailing-list">

            <div class="footer-mailing-list-inner">

                <div class="footer-header">Contact Us</div>
                <div class="footer-contact-info">
                    <?php echo $contact_info; ?>
                </div>

            </div>

        </div>
        <?php } ?>    

        <div class="footer-section footer-national-sponsors">

            <div class="footer-header">Official Sponsors</div>
            <div class="footer-national-sponsors-items">
            <?php
            $sponsor_count = 0;
            foreach($g_national_sponsors as $sponsor) { ?>

                <?php
                $sponsor_permalink = ikit_three_sponsor_get_permalink($sponsor->ID);
                $sponsor_permalink_target = ikit_three_sponsor_get_permalink_target($sponsor->ID);
                $attachment_image_src = wp_get_attachment_image_src(get_post_meta($sponsor->ID, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_PRIMARY_IMAGE, true), 'full')
                ?>
                <div>
                    <a target="<?php echo $sponsor_permalink_target; ?>" href="<?php echo $sponsor_permalink; ?>">
                        <img alt="Official sponsor image" width="<?php echo round($attachment_image_src[1]/2); ?>px" src="<?php echo $attachment_image_src[0]; ?>"/>
                    </a>
                </div>
            <?php
            $sponsor_count++;
            } ?>

            </div>

        </div>

        <?php
        if($g_theme_options[IKIT_THREE_THEME_OPTION_FOOTER_HIDE_LOCAL_SPONSORS] == false) {
        ?>

            <!-- Local sponsors -->
            <?php if(count($g_local_sponsors_short) > 0) { ?>
            <div class="footer-section footer-local-sponsors">
                <div class="footer-header">Chapter Sponsors</div>
                <div class="footer-local-sponsors-items">
                <?php
                $sponsor_count = 0;
                foreach($g_local_sponsors_short as $sponsor) { ?>

                    <?php
                    $sponsor_permalink = ikit_three_sponsor_get_permalink($sponsor->ID);
                    $sponsor_permalink_target = ikit_three_sponsor_get_permalink_target($sponsor->ID);
                    $attachment_image_src = wp_get_attachment_image_src(get_post_meta($sponsor->ID, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_PRIMARY_IMAGE, true), 'full')
                    ?>

                    <div>
                        <a target="<?php echo $sponsor_permalink_target; ?>" href="<?php echo $sponsor_permalink; ?>">
                            <img alt="Local sponsor image" width="<?php echo round($attachment_image_src[1]/2); ?>px" src="<?php echo $attachment_image_src[0]; ?>"/>
                        </a>
                    </div>

                <?php
                $sponsor_count++;
                } ?>
                </div>
            </div>
            <?php } ?>

        <?php } ?>

        <div class="footer-section footer-technology-sponsors">

            <div class="footer-header">Technology Sponsors</div>
            <div class="footer-technology-sponsors-items">
                <div>
                    <a class="footer-disqus" target="_blank" href="http://www.disqus.com">
                        <img alt="Disqus logo" src="<?php bloginfo('template_url'); ?>/images/sponsor_disqus@2x.png"/>
                    </a>
                </div>
                <div>
                    <a class="footer-mailchimp" target="_blank" href="http://www.mailchimp.com">
                        <img alt="Mailchimp logo" src="<?php bloginfo('template_url'); ?>/images/sponsor_mailchimp@2x.png"/>
                    </a>
                </div>
            </div>

        </div>

        <div class="footer-section footer-copyright">
            &copy;<?php echo date("Y"); ?>, All Rights Reserved. <a class="footer-aiga" target="_blank" href="http://aiga.org">AIGA | the professional association for design</a>
        </div>

    </div>

</div>

<!-- End layout -->
</div>

<!-- End root -->
</div>

<?php
wp_footer();
?>

<div class="page-loader-dialog">
    <div id="page-loader-indicator"></div>
</div>

<?php echo $g_options[IKIT_PLUGIN_OPTION_FOOTER_SCRIPTS]; ?>

</body>

</html>
