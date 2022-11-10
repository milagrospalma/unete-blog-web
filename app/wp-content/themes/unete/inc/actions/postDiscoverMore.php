<?php

/**
 * Method load post discover more - blog
 */

add_action('wp_ajax_postDiscoverMore', 'postDiscoverMore');
add_action('wp_ajax_nopriv_postDiscoverMore', 'postDiscoverMore');

function postDiscoverMore()
{
    $token = $_POST['token'];
    $paged =  addslashes($_POST['paged']);
    $category =  addslashes($_POST['category']);
    $id =  addslashes($_POST['id']);

    $token_decode = base64_decode($token);
    $_REQUEST['security'] = $token_decode;

    if($token !== base64_encode($token_decode) || !check_ajax_referer('uneteabelcorp-security-nonce', 'security', false)) {
        wp_send_json_error('Invalid security token sent.');
        wp_die();
    }

    if (empty($paged)) {
        wp_send_json_error('Invalid value sent.');
        wp_die();
    }

    $posts = get_blog_most_recent($id, $paged);

    if(empty($posts) && empty($posts['posts'])){
        wp_send_json_error('Invalid post request.');
        wp_die();
    }

    wp_send_json_success($posts['posts']);
    wp_die();
}