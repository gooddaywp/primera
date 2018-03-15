<?php

/**
* Theme init.
*
* @since  1.0
* @return  void
*/
function _primera_theme_init()
{
	require_once get_template_directory().'/includes/class.theme.php';

	add_action( 'after_setup_theme'      , 'Primera_Theme::set_global_content_width' );
	add_action( 'after_setup_theme'      , 'Primera_Theme::load_theme_textdomain' );
	add_action( 'wp_head'                , 'Primera_Theme::add_head_meta' );
	add_action( 'after_setup_theme'      , 'Primera_Theme::add_theme_support' );
	add_action( 'wp_enqueue_scripts'     , 'Primera_Theme::enqueue_frontend_scripts' );
	add_action( 'after_setup_theme'      , 'Primera_Theme::register_nav_menus' );
	add_action( 'widgets_init'           , 'Primera_Theme::register_sidebars' );

	add_filter( 'admin_post_thumbnail_html' , 'Primera_Theme::filter_admin_post_thumbnail_html', 10, 3 );
	add_filter( 'widget_tag_cloud_args'     , 'Primera_Theme::modify_tag_cloud_args' );
	add_filter( 'nav_menu_css_class'        , 'Primera_Theme::filter_nav_menu_list_item_classes', 10, 4 );
	add_filter( 'nav_menu_link_attributes'  , 'Primera_Theme::filter_nav_menu_link_atts', 10, 4 );
	add_filter( 'login_headerurl'           , 'Primera_Theme::modify_login_url' );
	add_filter( 'login_headertitle'         , 'Primera_Theme::modify_login_title' );
}
_primera_theme_init();


/**
* Load files.
*
* @since  1.0
* @return  void
*/
function _primera_load_files()
{
	$dir = get_template_directory();

	require_once $dir.'/includes/class.loader.php';

	if ( ! Primera_Loader::missing_dependencies() ) {

		require_once $dir.'/includes/pluggable.php';
		require_once $dir.'/includes/class.ajax.php';
		require_once $dir.'/includes/class.module.php';
	}
}
_primera_load_files();


/**
* Add AJAX actions.
*
* @since  1.0
* @return  void
*/
function _primera_add_ajax_actions()
{
	# Action: primeraRenderModule
	add_action( 'wp_ajax_primeraRenderModule'        , 'Primera_AJAX::primeraRenderModule' );
	add_action( 'wp_ajax_nopriv_primeraRenderModule' , 'Primera_AJAX::primeraRenderModule' );
}
_primera_add_ajax_actions();


/**
* Add REST routes.
*
* @since  1.0
* @return  void
*/
function _primera_add_rest_routes()
{
    # Get something.
    register_rest_route( 'primera/v1', '/get-somthing/', array(
        'methods'  => 'GET',
        'callback' => 'Primera_REST::get_something',
    ), true );

    # Post something.
    register_rest_route( 'primera/v1', '/post-somthing/', array(
        'methods'  => 'POST',
        'callback' => 'Primera_REST::post_something',
    ), true );
}
add_action( 'rest_api_init', '_primera_add_rest_routes' );
