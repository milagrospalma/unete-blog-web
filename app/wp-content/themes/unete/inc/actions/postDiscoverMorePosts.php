<?php

/**
 * Method load post discover more category - blog
 */

add_action('wp_ajax_postDiscoverMorePosts', 'postDiscoverMorePosts');
add_action('wp_ajax_nopriv_postDiscoverMorePosts', 'postDiscoverMorePosts');

function postDiscoverMorePosts()
{
    $token = $_POST['token'];
    $idPost =  addslashes($_POST['idPost']);
    $idCategory =  addslashes($_POST['idCategory']);
    $idsTags =  addslashes($_POST['idsTags']);
    $postName =  addslashes($_POST['name']);
    $page =  addslashes($_POST['page']);
    $type = addslashes($_POST['type']);
    $excludePost = addslashes($_POST['exclude']);

    $token_decode = base64_decode($token);
    $_REQUEST['security'] = $token_decode;

    if($token !== base64_encode($token_decode) || !check_ajax_referer('uneteabelcorp-security-nonce', 'security', false)) {
        wp_send_json_error('Invalid security token sent.');
        wp_die();
    }

    if (empty($page)) {
        wp_send_json_error('Invalid value sent.');
        wp_die();
    }

    $posts = get_blog_post_by_tag_or_category($idsTags, $idCategory, $postName.'-ajax', $idPost, $type, $page, $excludePost);
    $posts = $posts['posts'];
    $posts['configuration']['merge'] = $posts['change'];
    $posts['configuration']['more_page'] = false;

    if(empty($posts) && empty($posts['discover_more'])){
        wp_send_json_error('Invalid post request.');
        wp_die();
    }

    wp_send_json_success($posts);
    wp_die();
}