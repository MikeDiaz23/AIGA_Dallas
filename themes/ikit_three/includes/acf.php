<?php

/**
 * Load the Advanced Custom Fields configuration for the ikit two theme specifically.
 * These are ACF fields that are not generic to any theme and should only appear
 * on theme 2.
 */
function ikit_three_load_acf() {

if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => '593edc637cd3e',
        'title' => 'iKit Internal Event (Theme)',
        'fields' =>
        array (
            0 =>
            array (
                'key' => 'field_709',
                'label' => 'Disable Detail',
                'name' => 'disable_detail',
                'type' => 'true_false',
                'order_no' => 0,
                'instructions' => 'Enabling this option will disable the detail page for this community event.  Any links to this event will forward the user directly to the external site. If there is no URL defined for this event, it will still go to the detail page.',
                'required' => 0,
                'conditional_logic' =>
                array (
                    'status' => 0,
                    'rules' =>
                    array (
                        0 =>
                        array (
                            'field' => 'null',
                            'operator' => '==',
                            'value' => '',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
            ),
        ),
        'location' =>
        array (
            'rules' =>
            array (
                0 =>
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'ikit_event_internal',
                    'order_no' => 0,
                ),
            ),
            'allorany' => 'all',
        ),
        'options' =>
        array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' =>
            array (
            ),
        ),
        'menu_order' => 0,
    ));

    register_field_group(array (
        'id' => '593ee8a35a083',
        'title' => 'Post (Theme)',
        'fields' =>
        array (
            0 =>
            array (
                'key' => 'field_758',
                'label' => 'Hide Published Date',
                'name' => 'hide_published_date',
                'type' => 'true_false',
                'order_no' => 0,
                'instructions' => '',
                'required' => 0,
                'conditional_logic' =>
                array (
                    'status' => 0,
                    'rules' =>
                    array (
                        0 =>
                        array (
                            'field' => 'field_758',
                            'operator' => '==',
                            'value' => 1,
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
            ),
        ),
        'location' =>
        array (
            'rules' =>
            array (
                0 =>
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                    'order_no' => 0,
                ),
            ),
            'allorany' => 'all',
        ),
        'options' =>
        array (
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' =>
            array (
            ),
        ),
        'menu_order' => 0,
    ));

    register_field_group(array (
    		'id' => '569910bfccf74',
    		'title' => 'Section Table of Contents Alt 1 (Theme)',
    		'fields' => array (
    			array (
    				'key' => 'field_5ee1006d8cc1b',
    				'label' => 'Content Items',
    				'name' => 'page_template_section_toc_alt_1_content_items',
    				'type' => 'repeater',
    				'sub_fields' => array (
    					array (
    						'key' => 'field_5ee100858cc1c',
    						'label' => 'Title',
    						'name' => 'title',
    						'type' => 'text',
    						'required' => 1,
    						'column_width' => '',
    						'default_value' => '',
    						'placeholder' => '',
    						'prepend' => '',
    						'append' => '',
    						'formatting' => 'html',
    						'maxlength' => '',
    					),
    					array (
    						'key' => 'field_5ee1008c8cc1d',
    						'label' => 'Description',
    						'name' => 'description',
    						'type' => 'wysiwyg',
    						'column_width' => '',
    						'default_value' => '',
    						'toolbar' => 'full',
    						'media_upload' => 'yes',
    					),
    					array (
    						'key' => 'field_5ee1009b8cc1e',
    						'label' => 'Link URL',
    						'name' => 'link_url',
    						'type' => 'text',
    						'column_width' => '',
    						'default_value' => '',
    						'placeholder' => '',
    						'prepend' => '',
    						'append' => '',
    						'formatting' => 'html',
    						'maxlength' => '',
    					),
    					array (
    						'key' => 'field_5ee10197a8392',
    						'label' => 'Link Target',
    						'name' => 'link_target',
    						'type' => 'select',
                'choices' => array (
        					'_self' => 'Standard',
        					'_blank' => 'New Window',
                  '' => '',
        				),
        				'default_value' => '',
        				'allow_null' => 0,
        				'multiple' => 0,
    					),
    				),
    				'row_min' => '',
    				'row_limit' => '',
    				'layout' => 'row',
    				'button_label' => 'Add Row',
    			),
    		),
    		'location' => array (
    			array (
    				array (
    					'param' => 'page_template',
    					'operator' => '==',
    					'value' => 'section_toc_alt_1.php',
    					'order_no' => 0,
    					'group_no' => 0,
    				),
    			),
    		),
    		'options' => array (
    			'position' => 'normal',
    			'layout' => 'no_box',
    			'hide_on_screen' => array (
    			),
    		),
    		'menu_order' => 0,
  	));

}

}

add_action('wp_loaded', 'ikit_three_load_acf');


?>
