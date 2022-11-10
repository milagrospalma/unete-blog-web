<?php

class Unete
{

	private $blogExportReportPost;

    public function __construct()
    {
        $this->init();
        $this->classes();
        $this->postTypes();
        $this->actions();
        $this->hideAdminBar();
        $this->addImagesSizes();
        $this->includeCustomFields();
    }

    public function init()
    {
        add_action('init', [$this, 'themeRegisterMenus']);
        add_action('widgets_init', [$this, 'themeLoadSidebars']);
        add_action('widgets_init', [$this, 'themeLoadWidgets']);
        add_filter('upload_mimes', [$this, 'setMimeTypes']);
    }

    /**
     * Create Custom Posts
     */
    public function postTypes()
    {
//        $this->custom_post_type = new MyCustomPost();
    }

    /**
     * Create actions
     */
    public function actions()
    {
//        $this->navHeadAction = new NavHeadAction();
    }

    /**
     * Create classes
     */
    public function classes()
    {
        $this->blogExportReportPost = new blogExportReport();
    }

    /**
     * Register Menus
     */
    public function themeRegisterMenus()
    {
        register_nav_menus(
            array(
                'menu-primary' => __('Menú Principal', 'unete-theme'),
                'menu-footer'  => __('Menú Footer', 'unete-theme')
            )
        );
    }

    /**
     * Hide admin bar in front
     */
    public function hideAdminBar() {
        show_admin_bar(false);
    }

    public function addImagesSizes() {

        add_image_size( 'thumbnail_330_330', 330, 330, true );
        add_image_size( 'thumbnail_678_328', 678, 328, true );

    }

    /**
     * Register Widgets
     */
    public function themeLoadSidebars()
    {
//        register_sidebar(array(
//            'name'          => __('Catálogos de Marcas', 'blog'),
//            'id'            => 'blog-unete',
//            'description'   => __('', 'blog'),
//            'before_widget' => '',
//            'after_widget'  => '',
//            'before_title'  => '<h3 class="promoapp-title upper">',
//            'after_title'   => '</h3>',
//        ));
    }

    public function themeLoadWidgets() {
//        register_widget( 'blogBrandsCatalogWidget' );
    }

    /**
     * Add support format svg upload image
     * @param $mimes
     * @return Array
     */
    public function setMimeTypes($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

	/**
	 * @return mixed
	 */
	public function getMenuTypeMetaBox()
	{
//		return $this->navHeadAction;
	}

    /**
     * @return mixed
     */
    public function getMyCustomPosts()
    {
//        return $this->custom_post_type;
    }

    public function includeCustomFields(){
        include_once 'custom_fields/acf_settings.php';
        include_once 'custom_fields/acf_header_start.php';
        include_once 'custom_fields/acf_reading_time.php';
        include_once 'custom_fields/acf_configuration_home.php';
        include_once 'custom_fields/acf_category.php';
        include_once 'custom_fields/acf_select_author.php';
        include_once 'custom_fields/acf_sections_post.php';
    }
}