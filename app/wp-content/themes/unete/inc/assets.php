<?php
// ==== ASSETS ==== //

// Now that you have efficiently generated scripts and stylesheets for your theme, how should they be integrated?
// This file walks you through the approach I use but you are free to do this any way you like

// Enqueue front-end scripts and styles
function theme_enqueue_scripts()
{

    // Empty by default, may be populated by conditionals below; this is used to generate the script filename
    $script_name = '';

    // An empty array that can be filled with variables to send to front-end scripts
    $script_vars = array();
    // A generic script handle used internally by WordPress
    $script_handle = 'unete';
    // Namespace for scripts; this should match what is specified in your `gulpconfig.js` (and it's safe to leave alone)
    $ns = 'unete';

    // Figure out which script bundle to load based on various options set in `src/functions-config-defaults.php`
    // Note: bundles require fewer HTTP requests at the expense of addition caching hits when different scripts are requested on different pages of your site
    // You could also load one main bundle on every page with supplementary scripts as needed (e.g. for commenting or a contact page); it's up to you!

    // Plugins bundle
    $script_name = '-plugins';
    $handle_plugin = $script_handle . $script_name;
    $file_name_out_ext = "{$ns}{$script_name}";
    $file_name = "{$file_name_out_ext}.js";
    $plugins_hash_md5 =  file_exists( get_stylesheet_directory() . "/js/{$file_name}" ) === true ? substr(md5_file(get_stylesheet_directory() . "/js/{$file_name}"), 0, 10) : $file_name;
    $script_file_name = WP_ENV == 'dev' ? "{$file_name}" : "{$file_name_out_ext}_{$plugins_hash_md5}.js";

    // add if file exist
    if ( file_exists( get_stylesheet_directory() . "/js/{$script_file_name}" ) === true ) {
        $theme_file_handler = get_stylesheet_directory_uri() . "/js/{$script_file_name}";
        wp_enqueue_script($handle_plugin, $theme_file_handler, array('jquery'), false, true);
        wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js?render='.RECAPTCHA_SITEKEY, array('jquery'), false, true);
    }

    // Load theme-specific JavaScript bundles with versioning based on last modified time; http://www.ericmmartin.com/5-tips-for-using-jquery-with-wordpress/
    // The handle is the same for each bundle since we're only loading one script; if you load others be sure to provide a new handle
    $script_name = '-core';
    $file_name_out_ext = "{$ns}{$script_name}";
    $file_name = "{$file_name_out_ext}.js";
    $script_hash_md5 = substr(md5_file(get_stylesheet_directory() . "/js/{$file_name}"), 0, 10);
    $script_file_name = WP_ENV == 'dev' ? "{$file_name}" : "{$file_name_out_ext}_{$script_hash_md5}.js";

    // add if file exist
    if ( file_exists( get_stylesheet_directory() . "/js/{$script_file_name}" ) === true ) {
        $theme_file_handler = get_stylesheet_directory_uri() . "/js/{$script_file_name}";
        $dependence = file_exists( get_stylesheet_directory() . "/js/{$handle_plugin}") ? $handle_plugin : 'jquery';
        wp_enqueue_script( $script_handle . $script_name, $theme_file_handler, array($dependence), false, true);
    }

    // Pass variables to JavaScript at runtime; see: http://codex.wordpress.org/Function_Reference/wp_localize_script
    $script_vars = apply_filters('theme_script_vars', $script_vars);
    if (!empty($script_vars)) {
        $dependence = file_exists( get_stylesheet_directory() . "/js/{$handle_plugin}") ? $handle_plugin : $file_name_out_ext;
        wp_localize_script($dependence, 'jsVars', $script_vars);
    }

    // Register and enqueue our main stylesheet with versioning based on last modified time
    $style_hash_md5 = substr(md5_file(get_stylesheet_directory() . '/style.css'), 0, 10);
    $style_file_name = WP_ENV == 'dev' ? "style.css" : "style_{$style_hash_md5}.css";

    // add if file exist
    if ( file_exists( get_stylesheet_directory() . "/$style_file_name" ) === true ) {
        $theme_style_file_handler = get_stylesheet_directory_uri() . "/{$style_file_name}";
        wp_register_style('theme-style', $theme_style_file_handler, $dependencies = array(), false);
        wp_enqueue_style('theme-style');
    }

}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


// Provision the front-end with the appropriate script variables
function theme_update_script_vars($script_vars = array())
{
    global $blogCountries;

    // Non-destructively merge script variables if a particular condition is met (e.g. `is_archive()` or whatever); useful for managing many different kinds of script variables
    return array_merge($script_vars, array(
        'baseUrl' => get_bloginfo('url'),
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'security' => base64_encode(wp_create_nonce( 'uneteabelcorp-security-nonce' )),
        'countries' => $blogCountries ? $blogCountries : (Object) [],
        'buttonStart' => get_blog_button_start(),
        'mtoLinks' => get_blog_mto_links(),
        'recaptchaSiteKey' => RECAPTCHA_SITEKEY,
        'phones' => get_blog_phones_countries(),
    ));
}

add_filter('theme_script_vars', 'theme_update_script_vars');

/**
 * Dynamically populate a select field’s choices
 *
 * @link https://www.advancedcustomfields.com/resources/dynamically-populate-a-select-fields-choices/
 *
 * @param array $field
 * @return array
 */
function acf_blog_list_authors( $field ){
    $field['choices'] = array();
    if(function_exists('get_field')) {
        $authors = get_field('authors', 'options');
        if (!empty($authors) && !is_wp_error($authors)){
            foreach ($authors as $author){
                $field['choices'][$author['a_code']] = $author['a_author'];
            }
        }
    }

    return $field;
}
add_filter( 'acf/load_field/key=field_60d372505a872', 'acf_blog_list_authors');

/**
 * Clear key redis change status comment
 */
function blog_clear_redis_comments_by_post( $comment_ID , $comment )
{
    if( !empty($comment) && !empty($comment->comment_post_ID) ){
        wp_cache_delete('blog_unete_comments_'.$comment->comment_post_ID, 'blog_unete');
    }
    return $comment;
}
add_filter( 'comment_approved_comment' , 'blog_clear_redis_comments_by_post' , '99', 2 );
add_filter( 'comment_unapproved_comment' , 'blog_clear_redis_comments_by_post' , '99', 2 );

function blog_clear_redis_acf_options($post_id) {
    if($post_id === 'options'){
        wp_cache_flush();
    }
}
add_action('acf/save_post', 'blog_clear_redis_acf_options', 20);

function blog_clear_redis_save_post( $post_id, $post ) {
    if (isset($post->post_status) && 'publish' == $post->post_status) {
        wp_cache_flush();
    }
}
add_action( 'save_post', 'blog_clear_redis_save_post', 1, 2);

function blog_admin_custom_style_tags_category() {
    echo '<script>
        jQuery(window).load(function() {
            jQuery("#category-all #categorychecklist input").attr("type", "radio");
        });
    </script>';
    echo '<style>
        body.taxonomy-post_tag .term-parent-wrap, 
        body.taxonomy-post_tag .term-description-wrap,
        body.taxonomy-post_tag .term-slug-wrap,
        body.taxonomy-category .term-parent-wrap,
        #taxonomy-post_tag #post_tag-adder {display:none;}
    </style>';
}
add_action('admin_head', 'blog_admin_custom_style_tags_category');

function blog_admin_hierarchical_tags_register() {

    global $wp_rewrite;

    $rewrite =  array(
        'hierarchical'              => false,
        'slug'                      => get_option('tag_base') ? get_option('tag_base') : 'tag',
        'with_front'                => ! get_option('tag_base') || $wp_rewrite->using_index_permalinks(),
        'ep_mask'                   => EP_TAGS,
    );

    $labels = array(
        'name'                       => _x( 'Tags', 'Taxonomy General Name', 'hierarchical_tags' ),
        'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'hierarchical_tags' ),
        'menu_name'                  => __( 'Taxonomy', 'hierarchical_tags' ),
        'all_items'                  => __( 'All Tags', 'hierarchical_tags' ),
        'parent_item'                => __( 'Parent Tag', 'hierarchical_tags' ),
        'parent_item_colon'          => __( 'Parent Tag:', 'hierarchical_tags' ),
        'new_item_name'              => __( 'New Tag Name', 'hierarchical_tags' ),
        'add_new_item'               => __( 'Add New Tag', 'hierarchical_tags' ),
        'edit_item'                  => __( 'Edit Tag', 'hierarchical_tags' ),
        'update_item'                => __( 'Update Tag', 'hierarchical_tags' ),
        'view_item'                  => __( 'View Tag', 'hierarchical_tags' ),
        'separate_items_with_commas' => __( 'Separate tags with commas', 'hierarchical_tags' ),
        'add_or_remove_items'        => __( 'Add or remove tags', 'hierarchical_tags' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'hierarchical_tags' ),
        'popular_items'              => __( 'Popular Tags', 'hierarchical_tags' ),
        'search_items'               => __( 'Search Tags', 'hierarchical_tags' ),
        'not_found'                  => __( 'Not Found', 'hierarchical_tags' ),
    );

    register_taxonomy( 'post_tag', 'post', array(
        'hierarchical'              => true, // Was false, now set to true
        'query_var'                 => 'tag',
        'labels'                    => $labels,
        'rewrite'                   => $rewrite,
        'public'                    => false,
        'show_ui'                   => true,
        'show_admin_column'         => true,
        '_builtin'                  => true,
    ) );

}
add_action('admin_init', 'blog_admin_hierarchical_tags_register');
