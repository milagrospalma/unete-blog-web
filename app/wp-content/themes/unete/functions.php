<?php
// ==== FUNCTIONS ==== //

// Load the configuration file for this installation; all options are set here
if (is_readable(trailingslashit(get_stylesheet_directory()) . 'functions-config.php')) {
    require_once trailingslashit(get_stylesheet_directory()) . 'functions-config.php';
}

// Load configuration defaults for this theme; anything not set in the custom configuration (above) will be set here
require_once trailingslashit(get_stylesheet_directory()) . 'functions-config-defaults.php';

// An example of how to manage loading front-end assets (scripts, styles, and fonts)
require_once trailingslashit(get_stylesheet_directory()) . 'inc/assets.php';

// Required class Custom Posts
//require_once trailingslashit(get_stylesheet_directory()) . 'inc/custom_posts/MyCustomPost.php';

//Required Geo IP
//require_once trailingslashit(get_stylesheet_directory()) . 'inc/geoip/GeoIP.php';

// Required class Actions
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/postBlogLike.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/postBlogShare.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/emailRegisterSubscription.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/postDiscoverMore.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/postDiscoverMoreByCategory.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/postDiscoverMorePosts.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/postCommentsInsert.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/classes/blogExportReport.php';

// Required class Widgets
//require_once trailingslashit(get_stylesheet_directory()) . 'inc/widgets/MyWidget.php';

// Required class Template
require_once trailingslashit(get_stylesheet_directory()) . 'inc/Unete.php';

// Only the bare minimum to get the theme up and running
function theme_setup()
{
    // Language loading
    load_theme_textdomain('unete-theme', trailingslashit(get_template_directory()) . 'languages');

    // HTML5 support; mainly here to get rid of some nasty default styling that WordPress used to inject
    add_theme_support('html5', ['search-form', 'gallery']);

    //This feature enables Post Thumbnails support for a theme.
    add_theme_support( 'post-thumbnails' );

    // $content_width limits the size of the largest image size available via the media uploader
    // It should be set once and left alone apart from that; don't do anything fancy with it; it is part of WordPress core
    global $content_width;
    if (!isset($content_width) || !is_int($content_width)) {
        $content_width = (int)960;
    }
}

add_action('after_setup_theme', 'theme_setup', 11);

/**
 * Functions theme
 */

function get_blog_categories() {
    $categories = [];
    $key = 'blog_unete_all_categories';
    $data = wp_cache_get($key, 'blog_unete');
    if(!empty($data)){
        return $data;
    }

    $args = ['taxonomy'	=> "category", 'hide_empty' => 1];
    $categoriesDefault = get_categories($args);
    if(!empty($categoriesDefault)) {
        foreach ($categoriesDefault as $cat ){
            $categories[] = [
                'id'	=> $cat->term_id,
                'slug'	=> $cat->slug,
                'title'	=> $cat->name,
                'url'   => get_term_link($cat),
                'description'	=> $cat->description ? $cat->description : ''
            ];
        }
        wp_cache_set($key, $categories, 'blog_unete', 250000);
    }

    return $categories;
}

function the_get_blog_categories($active = 'inicio', $custom = 'nav-options') {
    $categories = get_blog_categories();
    $html  = '';
    if (!empty($categories)) {
        $html .= '<ul class="'.$custom.'">';
        $class = $active === 'inicio' ? 'selected' : '';
        $html .= '    <li><a class="nav-option '.$class.'" href="'.get_site_url().'">Inicio</a></li>';
        foreach ( $categories as $category ) {
            $class = $category['slug'] === $active ? 'selected' : '';
            $html .= '<li><a class="nav-option '.$class.'" href="'.$category['url'].'">'.$category['title'].'</a></li>';
        }
        $html .= '</ul>';
    }
    echo $html;
}

function get_blog_button_start() {
    $key = 'blog_unete_button_start';
    $data = wp_cache_get($key, 'blog_unete');
    if( !empty( $data ) ) {
        return $data;
    }

    $data = [];
    if( function_exists('get_field') ){
        $countries = get_field( 'button_start', 'options' );
        if(!empty($countries)){
            foreach ($countries as $country){
                $data[$country['bs_country']] = [
                    'iso' => !empty($country['bs_country']) ? $country['bs_country'] : null ,
                    'link'  => !empty($country['bs_url']) ? $country['bs_url'] : null,
                ];
            }
            wp_cache_set($key, $data, 'blog_unete', 250000);
        }
    }
    return $data;
}

function get_blog_mto_links() {
    $key = 'blog_unete_mto_links';
    $data = wp_cache_get($key, 'blog_unete');
    if( !empty( $data ) ) {
        return $data;
    }

    $data = [];
    if( function_exists('get_field') ){
        $countries = get_field( 'mto_links', 'options' );
        if(!empty($countries)){
            foreach ($countries as $country){
                $data[$country['mto_country']] = [
                    'iso' => !empty($country['mto_country']) ? $country['mto_country'] : null ,
                    'link'  => !empty($country['mto_url']) ? $country['mto_url'] : null,
                ];
            }
            wp_cache_set($key, $data, 'blog_unete', 250000);
        }
    }
    return $data;
}

function get_the_name_author($idPost){
    $auth = '';
    if(function_exists('get_field') && $idPost) {
        $code = get_field('author_select', $idPost);
        $authors = get_field('authors', 'options');
        if (!empty($authors) && !is_wp_error($authors) && !empty($code)){
            foreach ($authors as $author){
                if($code === $author['a_code']) {
                    $auth = $author['a_author'];
                }
            }
        }
    }

    return $auth;
}

function get_the_category_reducer($id) {
    $data = [
        'term_id' => null,
        'title' => '',
        'slug' => '',
        'background' => '#ffffff'
    ];
    if(function_exists('get_field') && $id) {
        $category = get_the_category($id);
        if(!empty($category)) {
            $background = get_field('background', $category[0]);
            $data['term_id'] = $category[0]->term_id;
            $data['title'] = $category[0]->name;
            $data['slug'] = $category[0]->slug;
            $data['background'] = !empty($background) ? $background : '#ffffff';
        }
    }
    return (object) $data;
}

function get_blog_most_recent($id = 0, $page = 1) {

    $key = 'blog_most_recent_'.$page;
    $data = wp_cache_get($key, 'blog_unete');
    if( !empty( $data ) ) {
        return $data;
    }

    $idPostMostRecent = $id;
    $mostRecent = null;
    $postMostRecent = null;
    $homeTitle = '';
    $homeSubTitle = '';
    if( $id === 0 && function_exists('get_field') ) {
        $mostRecent = get_field('the_most_recent', 'options');
        if(!empty($mostRecent)){
            $mostRecent = $mostRecent[0];
            $idPostMostRecent = $mostRecent->ID;
        }
        $homeTitle = get_field('home_title', 'options');
        $homeSubTitle = get_field('home_subtitle', 'options');
    }

    /**
     * add ('no_found_rows'  => true) if not necessary pagination.
     */
    $args = [
        'posts_per_page' =>  6,
        'post_type'      => 'post',
        'order'          => 'DESC',
        'paged'          => $page,
        'post__not_in'   => !empty($idPostMostRecent) ? [$idPostMostRecent] : []
    ];

    if(!empty($mostRecent)) {
        $postMostRecent = [
            'id' => $mostRecent->ID,
            'title' => $mostRecent->post_title,
            'description' => get_the_excerpt($mostRecent->ID),
            'category' => get_the_category_reducer($mostRecent->ID),
            'link' => get_the_permalink($mostRecent->ID),
            'date' => get_the_date('M d Y', $mostRecent),
            'time' => function_exists('get_field') ? get_field('reading_time', $mostRecent->ID) : '',
            'author' => get_the_name_author( $mostRecent->ID ),
            'image' => get_the_post_thumbnail($mostRecent, 'thumbnail_678_328')
        ];
    }

    $wp_query = new WP_Query($args);
    $data = [];
    if( !empty( $wp_query->posts )){
        foreach ( $wp_query->posts as $gpost ){
            $data[] = [
                'id' => $gpost->ID,
                'title' => $gpost->post_title,
                'category' => get_the_category_reducer($gpost->ID),
                'link' => get_the_permalink($gpost->ID),
                'date' => get_the_date('M d Y', $gpost),
                'time' => function_exists('get_field') ? get_field('reading_time', $gpost->ID) : '',
                'author' => get_the_name_author( $gpost->ID ),
                'image' => get_the_post_thumbnail($gpost, 'thumbnail_330_330')
            ];
        }
    }

    $info = [
        'header' => [
            'title' => $homeTitle,
            'sub_title' => $homeSubTitle
        ],
        'post_most_recent' => $postMostRecent,
        'posts' => [
            'paged' => (int) $page,
            'max_num_pages' => $wp_query->max_num_pages,
            'data' => $data
        ]
    ];
    wp_cache_set($key, $info, 'blog_unete', 250000);

    wp_reset_postdata();
    wp_reset_query();
    return $info;
}

function get_blog_menu_primary() {

    $key = 'blog_unete_menu_primary';
    $data = wp_cache_get($key, 'blog_unete');
    if(!empty($data)){
        return $data;
    }
    $pages = [];
    $locations = get_nav_menu_locations();
    $menuPrimary = isset($locations['menu-primary']) ? wp_get_nav_menu_items($locations['menu-primary']) : null;

    if (!empty($menuPrimary)) {
        foreach ( $menuPrimary as $primary ) {
            if($primary->post_status === 'publish' ) {
                $pages[] = [
                    'title' => $primary->title,
                    'url' => $primary->url,
                    'target' => $primary->target,
                    'classes' => implode(' ', $primary->classes)
                ];
            }
        }
        wp_cache_set($key, $pages, 'blog_unete', 250000);
    }

    return $pages;
}

function set_blog_menu_primary($custom = 'menu-options') {
    $pages = get_blog_menu_primary();
    $html  = '';
    if (!empty($pages)) {
        $html .= '<ul class="'.$custom.'">';
        foreach ( $pages as $page ) {
            $html .= '<li><a class="option '.$page['classes'].'" href="'.$page['url'].'" target="'.$page['target'].'">'.$page['title'].'</a></li>';
        }
        $html .= '</ul>';
    }
    echo $html;
}

function the_add_partial_blog($file_name, $origin = '') {
    if ( !empty($file_name) && file_exists( get_stylesheet_directory() . "/partials/{$file_name}.php" ) === true ) {
        include get_stylesheet_directory() . "/partials/{$file_name}.php";
    }
}

function get_blog_validate_format($value, $type)
{
    //name
    if ($type == 'name' && strlen($value) > 2) {
        return true;
    } elseif ($type == 'email') {
        if (preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/", $value)) {
            return true;
        } else {
            return false;
        }
    } elseif ($type == 'id' && is_numeric($value) && mb_strlen($value) >= '1') {
        return true;
    } elseif ($type == 'phone' && is_numeric($value) && mb_strlen($value) >= '5') {
        return true;
    } else {
        return false;
    }
}

function get_blog_post_by_category($nameCategory = '',  $page = 1, $pagedPerPage = 8, $idPosts = false, $idCategory = 0, $isPost = false, $inCache = true, $excludePost = '') {

    $key = 'blog_unete_category_'.$nameCategory.'_'.$page;
    $data = wp_cache_get($key, 'blog_unete');
    if(!empty($data) && !empty($inCache)){
        return $data;
    }
    $data = (int) $idCategory;
    $homeTitle = '';
    $homeSubTitle = '';

    if(empty($data)){
        global $wp_query;
        $data =  $wp_query->get_queried_object();
        $homeTitle = get_field('home_title', 'options');
        $homeSubTitle = get_field('home_subtitle', 'options');
    }

    $info = [];
    $dataCategory = [];
    $cat = $idCategory;
    $slug = $nameCategory;
    if(!empty($data)) {

        if(empty($idCategory)) {
            $dataCategory = [
                'id' => $data->term_id,
                'title' => $data->name,
                'sub_title' => function_exists('get_field') ? get_field('sub_title', $data) : '',
                'background' => function_exists('get_field') ? get_field('background', $data) : '',
                'description' => !is_null($data->description) ? $data->description : '',
                'slug' => $data->slug,
            ];
            $cat = $data->term_id;
            $slug = $data->slug;
        }

        /**
         * add ('no_found_rows'  => true) if not necessary pagination.
         */
        $excludeAllPost = !empty($idPosts) ? explode(',', $idPosts) : [];
        if(!empty($excludePost)) {
            $excludeAllPost = array_merge($excludeAllPost, explode(',', $excludePost));
        }
        $args = [
            'posts_per_page' =>  $pagedPerPage,
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'orderby'        => 'publish_date',
            'order'          => 'DESC',
            'paged'          => $page,
            'cat'            => $cat,
            'post__not_in'   => $excludeAllPost
        ];

        $wp_query = new WP_Query($args);
        $data = [];
        $articles = [];
        $discoverMore = [];
        $idArticles =[];
        if( !empty( $wp_query->posts )){
            foreach ( $wp_query->posts as $gpost ){
                $data[] = [
                    'id' => $gpost->ID,
                    'title' => $gpost->post_title,
                    'link' => get_the_permalink($gpost->ID),
                    'description' => get_the_excerpt($gpost->ID),
                    'category' => get_the_category_reducer($gpost->ID),
                    'date' => get_the_date('M d Y', $gpost),
                    'time' => function_exists('get_field') ? get_field('reading_time', $gpost->ID) : '',
                    'author' => get_the_name_author( $gpost->ID ),
                    'thumbnail' => get_the_post_thumbnail($gpost, 'thumbnail'),
                    'image' => get_the_post_thumbnail($gpost, 'thumbnail_330_330')
                ];
            }
            $discoverMore = $data;

            if($page === 1 && ! $isPost ) {
                $articles = array_slice($data, 0, 2);
                $discoverMore = array_slice($data, 2, 8);
            }
            if(!empty($articles)) {
                foreach ( $articles as $article ) {
                    $idArticles[] = $article['id'];
                }
            }
        }

        $info = [
            'header' => [
                'title' => $homeTitle,
                'sub_title' => $homeSubTitle
            ],
            'configuration' => [
                'paged' => (int) $page,
                'category_id' => $cat,
                'id_posts' => !empty($idPosts) ? $idPosts : implode(",", $idArticles),
                'max_num_pages' => $wp_query->max_num_pages,
                'slug' => $slug
            ],
            'category' => $dataCategory,
            'articles' => $articles,
            'discover_more' => $discoverMore
        ];
        if(!empty($inCache)){
            wp_cache_set($key, $info, 'blog_unete', 250000);
        }
    }
    wp_reset_postdata();
    wp_reset_query();
    return $info;
}

function get_blog_post_by_tag($nameTag, $page, $pagedPerPage, $idPosts, $idsTag, $excludePost) {

    $key = 'blog_unete_tag_'.$nameTag.'_'.$page;
    $data = wp_cache_get($key, 'blog_unete');
    if(!empty($data)){
        return $data;
    }

    $info = [];
    $slug = $nameTag;
    if(!empty($idsTag)) {

        /**
         * add ('no_found_rows'  => true) if not necessary pagination.
         */
        $excludeAllPost = !empty($idPosts) ? explode(',', $idPosts) : [];
        if(!empty($excludePost)) {
            $excludeAllPost = array_merge($excludeAllPost, explode(',', $excludePost));
        }

        $args = [
            'posts_per_page' => $pagedPerPage,
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'orderby'        => 'publish_date',
            'order'          => 'DESC',
            'paged'          => $page,
            'tag__in'        => $idsTag,
            'post__not_in'   => $excludeAllPost
        ];

        $wp_query = new WP_Query($args);
        $data = [];
        $discoverMore = [];
        if( !empty( $wp_query->posts )){
            foreach ( $wp_query->posts as $gpost ){
                $data[] = [
                    'id' => $gpost->ID,
                    'title' => $gpost->post_title,
                    'link' => get_the_permalink($gpost->ID),
                    'description' => get_the_excerpt($gpost->ID),
                    'category' => get_the_category_reducer($gpost->ID),
                    'date' => get_the_date('M d Y', $gpost),
                    'time' => function_exists('get_field') ? get_field('reading_time', $gpost->ID) : '',
                    'author' => get_the_name_author( $gpost->ID ),
                    'thumbnail' => get_the_post_thumbnail($gpost, 'thumbnail'),
                    'image' => get_the_post_thumbnail($gpost, 'thumbnail_330_330')
                ];
            }
            $discoverMore = $data;
        }
        $maxNumPages = $wp_query->max_num_pages;
        wp_reset_postdata();
        wp_reset_query();

        $info = [
            'configuration' => [
                'paged' => (int) $page,
                'category_id' => implode(',', $idsTag),
                'id_posts' => $idPosts,
                'max_num_pages' => $maxNumPages,
                'slug' => $slug
            ],
            'discover_more' => $discoverMore
        ];

        wp_cache_set($key, $info, 'blog_unete', 250000);
    }

    return $info;
}

function get_blog_post_by_tag_or_category($idsTags, $idCategory, $postName, $postId, $type = 'tags', $page = 1, $excludePost = '') {
    $post_like = null;
    $filter_post = 'tag';
    $searchInCategory = false;
    $perPage = 3;
    if(!empty($idsTags) && $type !== 'category'){
        $idsTags = is_string($idsTags) ? explode(',', $idsTags) : $idsTags;

        $post_like = get_blog_post_by_tag($postName, $page, $perPage, $postId, $idsTags, $excludePost);

        $countPost = count($post_like['discover_more']);
        $customPerPage = 1;

        if((int)$countPost !== (int)$perPage){
            $customPerPage = (int) $perPage - (int) $countPost;
            $searchInCategory = true;
        }

        if((int)$post_like['configuration']['max_num_pages'] === (int)$page && (int)$countPost === (int)$perPage) {
            $customPerPage = 3;
            $searchInCategory = true;
        }


        if(!empty($searchInCategory)){
            $postCategoryValidate = get_blog_post_by_category($postName, $page, $customPerPage, $postId, $idCategory, true, false, $excludePost);
            if(!empty($postCategoryValidate) && !empty($postCategoryValidate['discover_more']) && (int)$countPost !== (int)$perPage){
               $post_like['discover_more'] = array_merge($post_like['discover_more'], $postCategoryValidate['discover_more']);
            }
        }
    }

    if(empty($post_like['discover_more']) || $type === 'category') {
        $post_like = get_blog_post_by_category($postName, $page, $perPage, $postId, $idCategory, true, true, $excludePost);
        $filter_post = 'category';
    }

    return [
        'filter' => $filter_post,
        'posts' => $post_like,
        'change' => $searchInCategory
    ];
}

function get_the_content_reducer($idPost){
    $content = [];
    if(function_exists('get_field') && $idPost) {
        $sections = get_field('secciones', $idPost);
        if (!empty($sections) && !is_wp_error($sections) ){
            $id = 0;
            foreach ($sections as $section){
                $content[] = [
                    'id' => $idPost.'_'.$id,
                    'title' => $section['sec_text_title'],
                    'content' => $section['sec_text_text']
                ];
                $id++;
            }
        }
    }

    return $content;
}

function get_blog_post_detail($slug = '') {
    $key = 'blog_unete_post_'.$slug;
    $data = wp_cache_get($key, 'blog_unete');
    if(!empty($data)){
        return $data;
    }

    $info = [];
    $post = get_post();
    if(!empty($post)){
        $likes = get_post_meta($post->ID, 'count_post_like', true);
        $category = get_the_category_reducer($post->ID);
        $tags = get_the_terms( $post->ID, 'post_tag' );
        $tagsIds = [];

        if(!empty($tags)){
            foreach ($tags as $tag ){
                    $tagsIds[] = $tag->term_id;
            }
        }

        $_post_detail = [
            'id' => $post->ID,
            'title' => $post->post_title,
            'slug' => $post->post_name,
            'url' =>  get_the_permalink( $post->ID ),
            'category' => $category,
            'date' => get_the_date('M d Y', $post),
            'time' => function_exists('get_field') ? get_field('reading_time', $post->ID) : '',
            'author' => get_the_name_author( $post->ID ),
            'summary' => get_the_excerpt( $post->ID ),
            'content' => get_the_content_reducer($post->ID),
            'likes_count' => !empty($likes) ? (int) $likes : 0,
            'comment_count' => (int) $post->comment_count,
            'tag_id' => $tagsIds
        ];

        wp_reset_postdata();
        $idCategory = $category->term_id;

        $postsLike = get_blog_post_by_tag_or_category($tagsIds, $idCategory, $post->post_name, $post->ID);

        $info = [
            'post' =>  $_post_detail,
            'category' => $category,
            'filter'  => $postsLike['filter'],
            'change' => $postsLike['change'],
            'post_like' => $postsLike['posts']
        ];
        wp_cache_set($key, $info, 'blog_unete', 250000);
    }
    wp_reset_postdata();
    return $info;
};

function get_blog_post_share($id){
    $key = 'blog_unete_share_'.$id;
    $data = wp_cache_get($key, 'blog_unete');
    if(!empty($data)){
        return $data;
    }

    $shareFc = get_post_meta($id, 'count_share_fc', true);
    $shareIns = get_post_meta($id, 'count_share_ins', true);
    $shareWhat = get_post_meta($id, 'count_share_what', true);

    $shareAll = (int) $shareFc + (int)$shareIns + (int)$shareWhat;

    wp_cache_set($key, $shareAll, 'blog_unete', 250000);
    return $shareAll;
}

/**
 * Comments
 */

function get_blog_post_comment_insert($data){
    $result = [];
    if(!empty($data)){
        $commentData = [
            'comment_author' => $data['author'],
            'comment_author_email' => $data['email'],
            'comment_date' =>  date('Y-m-d H:i:s'),
            'comment_post_ID' => $data['id'],
            'comment_content' => $data['comment'],
            'comment_approved' => 0,
            'comment_meta' => [
                'country' => $data['country']
            ]
        ];
        $result = wp_insert_comment($commentData);
    }

    return $result;
}

function get_blog_post_approved_comments($id){
    $comments = [];
    if(!empty($id)) {
        $key = 'blog_unete_comments_'.$id;
        $data = wp_cache_get($key, 'blog_unete');
        if(!empty($data)){
            return $data;
        }

        $results = get_approved_comments($id, ['order'   => 'DESC']);
        if(!empty($results)){
            foreach ($results as $item) {
                $comments[] = [
                    'id' => $item->comment_ID,
                    'author' => $item->comment_author,
                    'email' => $item->comment_author_email,
                    'date' => get_comment_date('M d Y', $item->comment_ID),
                    'content' => $item->comment_content
                ];
            }
        }

        wp_cache_set($key, $comments, 'blog_unete', 250000);

        wp_reset_postdata();
        wp_reset_query();
    }
    return $comments;
}

function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function get_blog_post_comment_date_reducer($date){
    $result = '';
    if(!empty($date)) {
        $counter = date_diff(date_create($date), date_create(date('Y-m-d')));
        $days = $counter->format('%a');
        $data = $days === 0 || $days === 1  ? '1 dia' :  $days.' días';
        $result = 'Hace '.$data;
    }
    return $result;

}

function get_blog_phones_countries() {
    $key = 'blog_unete_phones_countries';
    $data = wp_cache_get($key, 'blog_unete');
    if( !empty( $data ) ) {
        return $data;
    }

    $data = [];
    if( function_exists('get_field') ){
        $countries = get_field( 'countries_phones', 'options' );
        if(!empty($countries)){
            foreach ($countries as $country){
                $phones = (array)[];
                foreach ($country['cp_phones'] as $phone){
                    $phones[] = $phone['cp_phone'];
                }

                $data[$country['cp_country']] = [
                    'iso' => !empty($country['cp_country']) ? $country['cp_country'] : null ,
                    'phones'  => $phones,
                ];
            }
            wp_cache_set($key, $data, 'blog_unete', 250000);
        }
    }
    return $data;
}


function get_blog_validate_recaptcha($token = '') {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_SECRETKEY, 'response' => $token)));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$Unete = new Unete();
