<?php

/**
 * Method add like in post - blog
 */

add_action('wp_ajax_postBlogLike', 'postBlogLike');
add_action('wp_ajax_nopriv_postBlogLike', 'postBlogLike');

function postBlogLike()
{
    $token = $_POST['token'];
    $option = $_POST['option'];
    $slug = $_POST['slug'];
    $token_decode = base64_decode($token);
    $_REQUEST['security'] = $token_decode;

    if($token !== base64_encode($token_decode) || !check_ajax_referer('uneteabelcorp-security-nonce', 'security', false)) {
        wp_send_json_error('Invalid security token sent.');
        wp_die();
    }

    $idPost = addslashes($_POST['id']);
    $likes = 1;
    if (empty($idPost) || empty($slug)) {
        wp_send_json_error('Invalid value sent.');
        wp_die();
    }

    $recaptcha = $_POST['recaptcha'];
    if (empty($recaptcha)) {
        wp_send_json_error('Invalid recaptcha sent.');
        wp_die();
    }

    $response = get_blog_validate_recaptcha($recaptcha);

    if (empty($response) || $response['success'] !== true || $response['score'] < 0.5) {
        wp_send_json_error($response);
        wp_die();
    }

    $key = 'count_post_like';
    $count = get_post_meta($idPost, $key, true);
    if (empty($count)) {
        delete_post_meta($idPost, $key);
        add_post_meta($idPost, $key, 1);
    } else {
        $likes = ($option === 'remove')? --$count : ++$count;
        update_post_meta($idPost, $key, $likes);
    }

    wp_cache_delete('blog_unete_post_'.$slug, 'blog_unete');

    wp_send_json_success([
        'id' => $idPost,
        'likes' => (int) $likes
    ]);
    wp_die();
}