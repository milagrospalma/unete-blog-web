<?php

/**
 * Method register comments by post - blog
 */

add_action('wp_ajax_postCommentsInsert', 'postCommentsInsert');
add_action('wp_ajax_nopriv_postCommentsInsert', 'postCommentsInsert');

function postCommentsInsert()
{
    $token = $_POST['token'];
    $token_decode = base64_decode($token);
    $_REQUEST['security'] = $token_decode;

    if($token !== base64_encode($token_decode) || !check_ajax_referer('uneteabelcorp-security-nonce', 'security', false)) {
        wp_send_json_error('Invalid security token sent.');
        wp_die();
    }

    $email = strip_tags($_POST['email']);
    $name = strip_tags($_POST['name']);
    $comment = strip_tags($_POST['comment']);
    $country = strip_tags($_POST['country']);
    $id = strip_tags($_POST['id']);

    if (empty($email) ||
        empty($name) ||
        empty($comment) ||
        empty($id) ||
        empty($country) ||
        empty(get_blog_validate_format($email, 'email')) ) {
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

    $result = [];
    if (function_exists('get_blog_post_comment_insert')) {
        $data = [
            'author' => $name,
            'email' => $email,
            'id' => $id,
            'comment' => $comment,
            'country' => $country
        ];
       $result = get_blog_post_comment_insert($data);
    }

    wp_send_json_success($result);
    wp_die();
}