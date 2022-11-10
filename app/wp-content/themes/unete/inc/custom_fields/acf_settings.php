<?php
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' => 'Blog Settings',
        'menu_title' => 'Blog Settings',
        'menu_slug' => 'blog-settings',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-admin-home',
        'position' => 600,
        'redirect' => true
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Blog Header',
        'menu_title'	=> 'Header',
        'menu_slug' 	=> 'blog-header-settings',
        'parent_slug'	=> 'blog-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' => 'Blog Settings',
        'menu_title' => 'Blog',
        'menu_slug' => 'blog-footer-settings',
        'parent_slug' => 'blog-settings',
    ));
}