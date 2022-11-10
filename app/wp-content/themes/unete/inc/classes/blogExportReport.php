<?php


class blogExportReport
{
    public function __construct()
    {
        if ( current_user_can( 'manage_options' )) {
            add_filter('manage_posts_columns', [$this, 'blog_manager_add_custom_columns']);
            add_action('manage_posts_custom_column', [$this, 'blog_manager_custom_columns_content'], 10, 2);
            add_filter('views_edit-post', [$this, 'blog_manager_button_export']);
            add_action('admin_init', [$this, 'blog_manager_export_report']);
        }
    }

    /**
     * Edit columns of custom post type = posts
     */
    public function blog_manager_add_custom_columns( $columns ) {
        $columns['likes'] = 'Likes';
        $columns['share'] = 'Share';
        return $columns;
    }

    public function blog_manager_custom_columns_content ( $column_id, $post_id ) {
        $shareFc = get_post_meta($post_id, 'count_share_fc', true);
        $shareIns = get_post_meta($post_id, 'count_share_ins', true);
        $shareWhat = get_post_meta($post_id, 'count_share_what', true);

        $shareAll = (int) $shareFc + (int)$shareIns + (int)$shareWhat;
        switch( $column_id ) {
            case 'likes':
                $likes = get_post_meta($post_id, 'count_post_like', true);
                echo !empty($likes) ? $likes : 0;
                break;
            case 'share':
                echo $shareAll;
                break;
        }
    }

    /**
     * Adds "Export" button on module list post
     */
    public function blog_manager_button_export($views){
        $style = 'border-color: #479C2E; background-color: #479C2E; color: #ffffff; margin-top: -7px;';
        $views['export'] = '<a href="/wp-admin/edit.php?export=post" class="primary button" style="'.$style.'">Exportar reporte</a>';
        return $views;
    }

    public function blog_manager_get_all_posts() {
        $allPosts = [];
        $args = [
            'posts_per_page' =>  -1,
            'post_type'      => 'post',
            'no_found_rows'  => true,
            'order'          => 'DESC'
        ];
        $wp_query = new WP_Query($args);
        if( !empty( $wp_query->posts ) ) {
            foreach ( $wp_query->posts as $item ){
                $likes = get_post_meta($item->ID, 'count_post_like', true);
                $shareFc = get_post_meta($item->ID, 'count_share_fc', true);
                $shareIns = get_post_meta($item->ID, 'count_share_ins', true);
                $shareWhat = get_post_meta($item->ID, 'count_share_what', true);
                $allPosts[] = [
                    'id' => $item->ID,
                    'title'     => str_replace(',', '', $item->post_title),
                    'likes'     => !empty($likes) ? $likes : 0,
                    'comments'  => (int) $item->comment_count,
                    'facebook'  => !empty($shareFc) ? $shareFc : 0,
                    'instagram'  => !empty($shareIns) ? $shareIns : 0,
                    'whatsapp'  => !empty($shareWhat) ? $shareWhat : 0
                ];
            }
        }
        wp_reset_postdata();
        wp_reset_query();
        return $allPosts;
    }

    public function blog_manager_format_report_to_string_csv( $data )
    {
        $csv_output = '';
        $result = [
            'Orden',
            'Título',
            'Likes',
            'Comentarios',
            'Compartidos por facebook',
            'Compartidos por instagram',
            'Compartidos por whatsapp',
            'Total de compartidos'
        ];

        for ($i = 0; $i < count($result); ++$i) {
            $csv_output = $csv_output.$result[$i].',';
        }

        $csv_output .= "\n";

        if (count($data) > 0) {
            $counter = 1;
            foreach ($data as $key => $value) {
                $shareAll = $value['facebook'] + $value['instagram'] + $value['whatsapp'];
                $csv_output .= $counter.',';
                $csv_output .= $value['title'].',';
                $csv_output .= $value['likes'].',';
                $csv_output .= $value['comments'].',';
                $csv_output .= $value['facebook'].',';
                $csv_output .= $value['instagram'].',';
                $csv_output .= $value['whatsapp'].',';
                $csv_output .= $shareAll.',';
                $csv_output .= "\n";
                $counter++;
            }
        }

        return mb_convert_encoding($csv_output, 'UTF-16LE', 'UTF-8');
    }

    public function blog_manager_export_csv( $csv_str, $filename = null )
    {
        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header("Content-Disposition: attachment; filename={$filename}");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $csv_str;
        exit;
    }

    public function blog_manager_export_report()
    {
        if ( current_user_can( 'manage_options' ) && ! empty( $_GET['export'] ) && $_GET['export'] === 'post' ) {

            $date = date('d-m-Y');
            $filename = "post-export-report-{$date}.csv";
            $items = $this->blog_manager_get_all_posts();

            if ( is_array( $items ) && ! empty( $items ) ) {
                $csv = $this->blog_manager_format_report_to_string_csv( $items );

                if ( is_string( $csv ) && ! empty( $csv ) ) {
                    $this->blog_manager_export_csv( $csv, $filename );
                }
            }
        }
    }

}