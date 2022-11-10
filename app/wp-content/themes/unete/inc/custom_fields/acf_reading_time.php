<?php
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_60de52163e294',
        'title' => 'Tiempo de lectura',
        'fields' => array(
            array(
                'key' => 'field_60de5226da63e',
                'label' => 'Tiempo de lectura',
                'name' => 'reading_time',
                'type' => 'time_picker',
                'instructions' => 'Tiempo en minutos',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'i',
                'return_format' => 'i',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;