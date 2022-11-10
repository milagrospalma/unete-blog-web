<?php
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_60de27de483e8',
        'title' => 'Configuraciones',
        'fields' => array(
            array(
                'key' => 'field_60de27ed0f7f3',
                'label' => 'Home',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_60e5bb710000',
                'label' => 'Título',
                'name' => 'home_title',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_60e5bb710001',
                'label' => 'Sub Título',
                'name' => 'home_subtitle',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_60de28080f7f4',
                'label' => 'Lo más reciente',
                'name' => 'the_most_recent',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'post',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                ),
                'elements' => '',
                'min' => 1,
                'max' => 1,
                'return_format' => 'object',
            ),
            array(
                'key' => 'field_60d37797f0599',
                'label' => 'Authors',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_60d372155aa99',
                'label' => 'Authors',
                'name' => 'authors',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => '',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Agregar author',
                'sub_fields' => array(
                    array(
                        'key' => 'field_60d372505aa98',
                        'label' => 'Código',
                        'name' => 'a_code',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '30',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_60d374fe5aa97',
                        'label' => 'Author',
                        'name' => 'a_author',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '70',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                    ),
                ),
            ),
            array(
                'key' => 'field_60d37797f0399',
                'label' => 'MTO',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_60d372155293a',
                'label' => 'Links MTO',
                'name' => 'mto_links',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => '',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Agregar link mto',
                'sub_fields' => array(
                    array(
                        'key' => 'field_60d372505293b',
                        'label' => 'Pais',
                        'name' => 'mto_country',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '30',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'CL' => 'Chile',
                            'CO' => 'Colombia',
                            'MX' => 'México',
                            'PE' => 'Perú',
                            'BO' => 'Bolivia',
                            'CR' => 'Costa Rica',
                            'EC' => 'Ecuador',
                            'SV' => 'El Salvador',
                            'GT' => 'Guatemala',
                            'PA' => 'Panamá',
                            'DO' => 'Dominicana',
                            'PR' => 'Puerto Rico'
                        ),
                        'default_value' => 'PE',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'return_format' => 'value',
                        'ajax' => 0,
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_60d374fe5293c',
                        'label' => 'Link',
                        'name' => 'mto_url',
                        'type' => 'url',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '70',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                    ),
                ),
            ),
            array(
                'key' => 'field_60d3779010421',
                'label' => 'Phones',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_60d3721020421',
                'label' => 'Phones country',
                'name' => 'countries_phones',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => '',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Agregar',
                'sub_fields' => array(
                    array(
                        'key' => 'field_60d3725030421',
                        'label' => 'Pais',
                        'name' => 'cp_country',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '30',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'CL' => 'Chile',
                            'CO' => 'Colombia',
                            'MX' => 'México',
                            'PE' => 'Perú',
                            'BO' => 'Bolivia',
                            'CR' => 'Costa Rica',
                            'EC' => 'Ecuador',
                            'SV' => 'El Salvador',
                            'GT' => 'Guatemala',
                            'PA' => 'Panamá',
                            'DO' => 'Dominicana',
                            'PR' => 'Puerto Rico'
                        ),
                        'default_value' => 'PE',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'return_format' => 'value',
                        'ajax' => 0,
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_60d3721040421',
                        'label' => 'Phones',
                        'name' => 'cp_phones',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '70',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => 1,
                        'max' => 0,
                        'layout' => 'block',
                        'button_label' => 'Agregar',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_60d3725050421',
                                'label' => 'Phone',
                                'name' => 'cp_phone',
                                'type' => 'text',
                                'instructions' => 'Lima: (01) 211-3614',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '100',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'blog-footer-settings',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;