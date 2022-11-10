<?php

/**
 * Method load post discover more category - blog
 */

add_action('wp_ajax_postDiscoverMoreByCategory', 'postDiscoverMoreByCategory');
add_action('wp_ajax_nopriv_postDiscoverMoreByCategory', 'postDiscoverMoreByCategory');

function postDiscoverMoreByCategory()
{
    $token = $_POST['token'];
    $paged =  addslashes($_POST['paged']);
    $category =  addslashes($_POST['category']);
    $ids =  addslashes($_POST['ids']);
    $filter = addslashes($_POST['filter']);
    $categoryName =  addslashes($_POST['name']);
    $isPost = addslashes($_POST['isPost']);
    $idCategory = addslashes($_POST['idCategory']);

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

    $count = 6;
    if(!empty($isPost) && $isPost === 'true'){
        $count = 3;
    }

    $posts = [];
    $merge = false;
    $morePage = false;
    if( !empty($filter) && $filter === 'tag' ) {
        $posts = get_blog_post_by_tag($categoryName, $paged, $count, $ids, explode(",", $category));
        if((int) $posts['configuration']['max_num_pages'] === (int) $paged ) {
            $countPost = count($posts['discover_more']);
            $completePost = [];
            if($countPost !== $count){
                $completePost = get_blog_post_by_category($categoryName, 1, ($count - $countPost), $ids, $idCategory, $isPost, false);
                $posts['discover_more'] = array_merge($posts['discover_more'], $completePost['discover_more']);
            }
            if(!empty($completePost) && $completePost['configuration']['max_num_pages'] > 1 ) {
                $morePage = true;
            }
            $merge = true;
        }
    }

    if( !empty($filter) && $filter !== 'tag' ) {
        $posts = get_blog_post_by_category($categoryName, $paged, $count, $ids, $category, $isPost);
    }
    $posts['configuration']['merge'] = $merge;
    $posts['configuration']['more_page'] = $morePage;

    if(empty($posts) && empty($posts['discover_more'])){
        wp_send_json_error('Invalid post request.');
        wp_die();
    }

    wp_send_json_success($posts);
    wp_die();
}