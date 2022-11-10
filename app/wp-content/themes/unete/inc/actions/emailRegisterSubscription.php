<?php

/**
 * Method register email to subscription - blog
 */

add_action('wp_ajax_emailRegisterSubscription', 'emailRegisterSubscription');
add_action('wp_ajax_nopriv_emailRegisterSubscription', 'emailRegisterSubscription');

function emailRegisterSubscription()
{
    $token = $_POST['token'];
    $token_decode = base64_decode($token);
    $_REQUEST['security'] = $token_decode;

    if($token !== base64_encode($token_decode) || !check_ajax_referer('uneteabelcorp-security-nonce', 'security', false)) {
        wp_send_json_error('Invalid security token sent.');
        wp_die();
    }

    $email = strip_tags($_POST['email']);

    if (empty($email) || empty(get_blog_validate_format($email, 'email'))) {
        wp_send_json_error('Invalid email sent.');
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
    if (class_exists('blogSubscriptionModel')) {
        $_POST['email'] = $email;
        $_POST['data'] = $email;
        $result = blogSubscriptionModel::insertSubscription($_POST);
    }

    wp_send_json_success($result);
    wp_die();
}