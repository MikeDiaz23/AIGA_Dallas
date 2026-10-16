<?php
/**
 * Template Name: Membership Rates
 */
?>
<?php get_header();?>

<div class="page-header-3">
    <div class="page-header-3-title">
        <?php ikit_three_render_toc_title($post); ?>
    </div>
</div>

<table class="page-layout-4">
<tr>

    <td class="page-layout-4-tools">

        <?php if(ikit_three_has_toc($post)) {?>
        <div class="page-layout-4-tool">
            <?php ikit_three_render_toc($post); ?>
        </div>
        <?php } ?>

    </td>

    <td class="page-layout-4-content">

        <table>
        <tr>
        <td class="page-layout-4-body">

            <div class="page-layout-4-body-paragraph-text wp-editor">

                <div class="rate-header">A Dynamic Community</div>

                <p>
                As an AIGA member, you will receive access to benefits including professional development, continuing education on a local and national level, discounted rates to exclusive programs and events, access to virtual webinars, leadership opportunities, special <a target="_blank" href="https://www.aiga.org/membership-community/member-special-offers">members-only</a> savings  — and unique connection opportunities with a network of mentors, influential designers, design educators, and industry leaders.
                </p>

                <a target="_blank" href="https://my.aiga.org/become-a-member">
                  <div class="rate-boxes">

                    <div class="rate-box">
                      <img src="<?php bloginfo('template_url'); ?>/images/membership_emerging.png"/>
                      <img src="<?php bloginfo('template_url'); ?>/images/membership_professional.png"/>
                      <img src="<?php bloginfo('template_url'); ?>/images/membership_leader.png"/>
                    </div>
                    <div class="rate-box">
                      <img src="<?php bloginfo('template_url'); ?>/images/membership_educator.png"/>
                      <img src="<?php bloginfo('template_url'); ?>/images/membership_student.png"/>
                    </div>

                  </div>
                </a>

                <div class="rate-header">Group memberships</div>

                <p>Save by establishing a group membership for your organization, <a target="_blank" href="https://www.aiga.org/membership-community/group-membership">learn more</a> about how to enroll or renew.</p>

                <div class="rate-header">Questions</div>

                <p>See the <a target="_blank" href="http://www.aiga.org/membership-faqs">Membership FAQs</a> for more information about setting up your account. Still have questions about membership? Call 212 807 1990 or <a target="_blank" href="http://www.aiga.org/contact.aspx?sel=membership/log-inissues">send us an email</a>.</p>

            </div>

        </td>
         <td class="page-layout-4-sidebar"/>

        </tr>
        </table>

    </td>

</tr>
</table>




<?php get_footer();?>
