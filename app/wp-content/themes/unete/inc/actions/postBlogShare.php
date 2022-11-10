<?php

/**
 * Method add share in post - blog
 */

add_action('wp_ajax_postBlogShare', 'postBlogShare');
add_action('wp_ajax_nopriv_postBlogShare', 'postBlogShare');

function postBlogShare()
{
    $token = $_POST['token'];
    $share = $_POST['share'];
    $token_decode = base64_decode($token);
    $_REQUEST['security'] = $token_decode;

    if($token !== base64_encode($token_decode) || !check_ajax_referer('uneteabelcorp-security-nonce', 'security', false)) {
        wp_send_json_error('Invalid security token sent.');
        wp_die();
    }

    $idPost = addslashes($_POST['id']);
    $shareCount = 1;
    if (empty($idPost) || empty($share)) {
        wp_send_json_error('Invalid value sent.');
        wp_die();
    }

    $key = 'count_share_'.$share;
    $count = get_post_meta($idPost, $key, true);
    if (empty($count)) {
        delete_post_meta($idPost, $key);
        add_post_meta($idPost, $key, 1);
    } else {
        $shareCount = ++$count;
        update_post_meta($idPost, $key, $shareCount);
    }

    wp_cache_delete('blog_unete_share_'.$idPost, 'blog_unete');

    wp_send_json_success([
        'id' => $idPost,
        'code' => $share,
        'share' => (int) $shareCount
    ]);
    wp_die();
}