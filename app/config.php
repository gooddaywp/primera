<?php
// Theme setup actions & filters.


// TODO:
// https://laternastudio.com/blog/automatically-sending-nonces-with-wordpress-ajax-requests/


namespace App;

// NOTE: Example code to load setups only for specific templates.
// use Brain\Hierarchy\Hierarchy;
// global $wp_query;
// $hierarchy = new Hierarchy;
// $templates = $hierarchy->getTemplates( $wp_query );
// if ( ! in_array( 'index', $templates ) ) {
//     return;
// }

if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

// Actions
add_action( 'after_setup_theme'  , __NAMESPACE__ . '\\_loadThemeTextdomain' );
add_action( 'wp_head'            , __NAMESPACE__ . '\\_addHeadMeta' );
add_action( 'after_setup_theme'  , __NAMESPACE__ . '\\_addThemeSupport' );
add_action( 'after_setup_theme'  , __NAMESPACE__ . '\\_defineImageSizes' );
add_action( 'after_setup_theme'  , __NAMESPACE__ . '\\_addGutenbergSupport' );
add_action( 'after_setup_theme'  , __NAMESPACE__ . '\\_registerNavMenus' );
add_action( 'widgets_init'       , __NAMESPACE__ . '\\_registerSidebars' );
add_action( 'wp_enqueue_scripts' , __NAMESPACE__ . '\\_registerScripts' );
add_action( 'wp_enqueue_scripts' , __NAMESPACE__ . '\\_enqueueFrontendScripts' );

// Filters
add_filter( 'body_class'                , __NAMESPACE__ . '\\_filterBodyClasses' );
add_filter( 'widget_tag_cloud_args'     , __NAMESPACE__ . '\\_filterTagCloudArgs' );
add_filter( 'nav_menu_css_class'        , __NAMESPACE__ . '\\_filterNavMenuListItemClasses', 10, 4 );
add_filter( 'nav_menu_link_attributes'  , __NAMESPACE__ . '\\_filterNavMenuLinkAtts', 10, 4 );
add_filter( 'login_headerurl'           , __NAMESPACE__ . '\\_filterLoginUrl' );
add_filter( 'login_headertext'          , __NAMESPACE__ . '\\_filterLoginHeaderText' );
add_filter( 'script_loader_tag'         , __NAMESPACE__ . '\\_filterScriptLoaderTag', 10, 2 );
add_filter( 'use_default_gallery_style' , '__return_false' );

/**
* Load text domain.
* Text domain should match theme folder name.
* @since 1.0
*/
function _loadThemeTextdomain()
{
    load_theme_textdomain( 'primeraTextDomain', get_theme_file_path('languages') );
}

/**
* Add head data.
* @since 1.0
*/
function _addHeadMeta()
{
    $meta = array(
        'viewport' => '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">',
    );

    if ( $GLOBALS['is_IE'] ) {
        $meta['ie_edge'] = '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    }

    // Add a pingback url auto-discovery header for singularly identifiable articles.
    if ( is_singular() && pings_open() ) {
        $meta = '<link rel="pingback" href="' . esc_url( get_bloginfo('pingback_url') ) . '">';
    }

    $meta = apply_filters( 'primera/head/meta', $meta );

    foreach ( $meta as $m ) {
        echo $m;
    }
}

/**
* Add theme support.
* @since  1.0
*/
function _addThemeSupport()
{
    # WordPress
    add_theme_support( 'html5', array('search-form','comment-form','comment-list','gallery','caption') );
    add_theme_support( 'automatic-feed-links' ); // adds posts and comments RSS feed links
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'customize-selective-refresh-widgets' );

    # Gutenberg feature. Replaces Fitvids?
    # wordpress.org/gutenberg/handbook/extensibility/theme-support/#responsive-embedded-content
    add_theme_support( 'responsive-embeds' );

    # Add logo support. Usage: the_custom_logo();
    // add_theme_support( 'custom-logo' );

    # Add WooCommerce support.
    // add_theme_support( 'woocommerce' );
}

/**
* Add Gutenberg support.
*
* @link  wordpress.org/gutenberg/handbook/extensibility/theme-support/
* @since  1.0
*/
function _addGutenbergSupport()
{
    // Wide aligned images.
    // add_theme_support( 'align-wide' );

    // Add editor styles.
    // add_theme_support( 'wp-block-styles' );

    // Disable custom color picker.
    // add_theme_support( 'disable-custom-colors' );

    // Color palette.
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => __( 'Dusty orange', 'primeraTextDomain' ),
            'slug'  => 'dusty-orange',
            'color' => '#ed8f5b',
        ),
        array(
            'name'  => __( 'Dusty red', 'primeraTextDomain' ),
            'slug'  => 'dusty-red',
            'color' => '#e36d60',
        ),
        array(
            'name'  => __( 'Dusty wine', 'primeraTextDomain' ),
            'slug'  => 'dusty-wine',
            'color' => '#9c4368',
        ),
        array(
            'name'  => __( 'Dark sunset', 'primeraTextDomain' ),
            'slug'  => 'dark-sunset',
            'color' => '#33223b',
        ),
        array(
            'name'  => __( 'Almost black', 'primeraTextDomain' ),
            'slug'  => 'almost-black',
            'color' => '#0a1c28',
        ),
        array(
            'name'  => __( 'Dusty water', 'primeraTextDomain' ),
            'slug'  => 'dusty-water',
            'color' => '#41848f',
        ),
        array(
            'name'  => __( 'Dusty sky', 'primeraTextDomain' ),
            'slug'  => 'dusty-sky',
            'color' => '#72a7a3',
        ),
        array(
            'name'  => __( 'Dusty daylight', 'primeraTextDomain' ),
            'slug'  => 'dusty-daylight',
            'color' => '#97c0b7',
        ),
        array(
            'name'  => __( 'Dusty sun', 'primeraTextDomain' ),
            'slug'  => 'dusty-sun',
            'color' => '#eee9d1',
        ),
    ) );

    // Font sizes.
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => __( 'small', 'primeraTextDomain' ),
            'shortName' => __( 'S', 'primeraTextDomain' ),
            'size' => 12,
            'slug' => 'small'
        ),
        array(
            'name' => __( 'regular', 'primeraTextDomain' ),
            'shortName' => __( 'M', 'primeraTextDomain' ),
            'size' => 16,
            'slug' => 'regular'
        ),
        array(
            'name' => __( 'large', 'primeraTextDomain' ),
            'shortName' => __( 'L', 'primeraTextDomain' ),
            'size' => 36,
            'slug' => 'large'
        ),
    ) );
}

/**
* Define thumbnail image size and register custom image sizes.
* @since 1.0
*/
function _defineImageSizes()
{
    // Override "post-thumbnail" default size (150x150).
    set_post_thumbnail_size( 300, 300, true );

    // Uncomment to register custom image sizes.
    // $imageSizes = [
    //     '100vw' => [2000],
    //     '16:9'  => [1600, (1600/16*9), true],
    // ];
    // foreach ( $imageSizes as $name => $size ) {
    //     add_image_size( $name, $size[0], $size[1] ?? 9999, $size[2] ?? false );
    // }
}

/**
* Register nav menus.
* @since 1.0
*/
function _registerNavMenus()
{
    register_nav_menus( array(
        'primary' => esc_html__('Primary Menu','primeraTextDomain'),
    ) );
}

/**
* Register Sidebars
*/
function _registerSidebars()
{
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => apply_filters( 'primeraFunctionPrefix/before_widget_title', '<h4 class="widgettitle">' ),
        'after_title'   => apply_filters( 'primeraFunctionPrefix/after_widget_title', '</h4>' ),
    ];
    register_sidebar([
        'id'          => 'primary',
        'name'        => __('Primary', 'primeraTextdomain'),
        'description' => '',
    ] + $config);
}

/**
* Register scripts for later use.
*
* @since 1.0
*/
function _registerScripts()
{
    $vendorScripts = [

        // fitvidsjs.com/
        'primeraFunctionPrefix-fitvids' => [
            'cdnUrl'   => 'https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.2.0/jquery.fitvids.min.js',
            'localUrl' => get_parent_theme_file_uri( 'public/js/vendor/fitvids.js' ),
            'deps'     => ['jquery'],
            'attr'     => 'defer',
        ],

        // fontawesome.com/
        'primeraFunctionPrefix-fontawesome' => [
            'cdnUrl'   => 'https://use.fontawesome.com/releases/v5.0.13/js/all.js',
            'localUrl' => get_parent_theme_file_uri( 'public/js/vendor/fontawesome.js' ),
            'attr'     => 'defer',
        ],

        // kenwheeler.github.io/slick/
        'primeraFunctionPrefix-slickslider' => [
            'cdnUrl'   => 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
            'localUrl' => get_parent_theme_file_uri( 'public/js/vendor/slickslider.js' ),
            'deps'     => ['jquery'],
            'attr'     => 'defer',
        ],

        // fancyapps.com/fancybox/3/
        'primeraFunctionPrefix-fancybox' => [
            'cdnUrl'   => 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.js',
            'localUrl' => get_parent_theme_file_uri( 'public/js/vendor/fancybox.js' ),
            'deps'     => ['jquery'],
            'attr'     => 'defer',
        ],

        // formvalidator.net/
        'primeraFunctionPrefix-formvalidator' => [
            'cdnUrl'   => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js',
            'localUrl' => get_parent_theme_file_uri( 'public/js/vendor/formvalidator.js' ),
            'deps'     => ['jquery'],
            'attr'     => 'defer',
        ],

        // github.com/WickyNilliams/enquire.js
        'primeraFunctionPrefix-enquire' => [
            'cdnUrl'   => 'https://cdn.jsdelivr.net/npm/enquire.js@2.1.6/dist/enquire.min.js',
            'localUrl' => get_parent_theme_file_uri( 'public/js/vendor/enquire.js' ),
            'deps'     => ['jquery'],
            'attr'     => 'defer',
        ],
    ];

    foreach ( $vendorScripts as $handle => $script ) {

        $url  = 'local' == envName() ? ($script['localUrl'] ?? $script['cdnUrl']) : ($script['cdnUrl'] ?? $script['localUrl']);
        $deps = $script['deps'] ?? [];

        wp_register_script( $handle, $url, $deps, null, false );
        ($script['attr'] ?? false) && wp_script_add_data( $handle, $script['attr'], true );
    }
}

/**
* Enqueue frontend scripts.
* @since 1.0
*/
function _enqueueFrontendScripts()
{
    // WP Comments
    if ( is_singular() && comments_open() && get_option('thread_comments') ) {
        wp_enqueue_script( 'comment-reply', '', '', '',  true );
    }

    // App CSS
    wp_enqueue_style(
        'primeraFunctionPrefix',
        get_parent_theme_file_uri( 'public/css/app.css' ), // alt: get_stylesheet_uri(),
        [],
        filemtime( get_parent_theme_file_path('public/css/app.css') )
    );

    // App JS
    wp_enqueue_script(
        'primeraFunctionPrefix',
        get_parent_theme_file_uri( 'public/js/app.js' ),
        [
            'wp-util' ,        // loads jQuery, UndescoreJS, wp.ajax & wp.template
            // 'hoverIntent',  // briancherne.github.io/jquery-hoverIntent/
            // 'imagesloaded', // imagesloaded.desandro.com/
            // 'jquery-form',  // malsup.com/jquery/form/
            // 'jquery-ui-selectmenu',
            // 'jquery-hotkeys',
            // 'backbone',
            // 'jquery',
        ],
        filemtime( get_parent_theme_file_path('public/js/app.js') )
    );
    wp_script_add_data( 'primeraFunctionPrefix', 'defer', true );

    // Localized App JS
    wp_localize_script(
        'primeraFunctionPrefix',
        'primeraFunctionPrefixLocalizedData', // js handle
        [
            'imgUrl'    => esc_url( get_theme_file_uri('public/img/') ),
            'ajaxUrl'   => esc_url_raw( admin_url('admin-ajax.php') ),
            'restUrl'   => esc_url_raw( rest_url('/primeraTextDomain/v1/') ),
            'ajaxNonce' => wp_create_nonce( 'wp_ajax' ),
            'restNonce' => wp_create_nonce( 'wp_rest' ), // must be named: wp_rest
        ]
    );

    // View Styles & Scripts
    $viewName = str_replace(['.blade','.php'], '', basename($GLOBALS['template']));
    if ( file_exists($path = get_theme_file_path("public/css/{$viewName}.css")) ) {
        wp_enqueue_style(
            $viewName,
            get_theme_file_uri("public/css/{$viewName}.css"),
            ['primeraFunctionPrefix'],
            filemtime($path)
        );
    }
    if ( file_exists($path = get_theme_file_path("public/js/{$viewName}.js")) ) {
        wp_enqueue_script(
            $viewName,
            get_theme_file_uri("public/js/{$viewName}.js"),
            ['primeraFunctionPrefix'],
            filemtime($path)
        );
        wp_script_add_data( $viewName, 'defer', true );
    }
}

/**
* Modify <body> class list.
*
* @link  https://codex.wordpress.org/Global_Variables#Browser_Detection_Booleans
* @link  https://wptavern.com/wordpress-4-8-will-end-support-for-internet-explorer-versions-8-9-and-10
* @since  1.0
*/
function _filterBodyClasses( $classes )
{
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( wp_is_mobile() ) {
        $classes[] = 'is-mobile-device';
    }

    // In order of market share.
    if ( $GLOBALS['is_chrome'] ) {
        $classes[] = 'is-chrome';
    } elseif ( $GLOBALS['is_safari'] ) {
        $classes[] = 'is-safari';
    } elseif ( $GLOBALS['is_gecko'] ) {
        $classes[] = 'is-gecko';
        $classes[] = 'is-firefox';
    } elseif ( $GLOBALS['is_edge'] ) {
        $classes[] = 'is-ms-edge';
    } elseif ( $GLOBALS['is_IE'] ) {
        $classes[] = 'is-ms-ie';
    }

    return array_unique( $classes );
}

/**
* Modify Tag Cloud widget arguments.
*
* @since  1.0
*/
function _filterTagCloudArgs( $args )
{
    $args['number']    = 18;
    $args['smallest']  = 1;
    $args['largest']   = 1;
    $args['unit']      = 'rem';
    $args['format']    = 'flat'; // list or flat (custom classes only work with flat)
    $args['separator'] = "\n";
    $args['orderby']   = 'count'; // name (alphabetical) or count (popularity)
    $args['order']     = 'ASC';

    return $args;
}

/**
* Filter nav menu list item classes.
*
* This filter can be found in wp-includes/class-walker-nav-menu.php
*
* @since  1.0
* @return  array  Numeric array of list item classes.
*/
function _filterNavMenuListItemClasses( $classes, $item, $args, $depth )
{
    if ( 'primary' == $args->theme_location ) {
        array_push( $classes, 'menu-item--primary' );
    }

    return $classes;
}

/**
* Filter nav menu link attributes.
*
* This filter can be found in wp-includes/class-walker-nav-menu.php
*
* @since  1.0
* @return  array  Asccociative array of anchor attributes.
*/
function _filterNavMenuLinkAtts( $atts, $item, $args, $depth )
{
    $atts['class'] = 'menu-link';

    if ( 'primary' == $args->theme_location ) {
        $atts['class'] .= ' menu-link--primary';

        // if ( 'category' === $item->object ) {
        //     $atts['data-category-id'] = absint( $item->object_id );
        // }
    }

    if ( $item->current ) {
        $atts['class'] .= ' menu-link--active';
    }
    elseif ( $item->current_item_parent ) {
        $atts['class'] .= ' menu-link--active-parent';
        $atts['class'] .= ' menu-link--parent';
    }
    elseif ( $item->current_item_ancestor ) {
        $atts['class'] .= ' menu-link--active-ancestor';
        $atts['class'] .= ' menu-link--ancestor';
    }

    // First, check if "current" is set, which means the item is a nav menu item.
    if ( isset( $item->current ) ) {
        if ( $item->current ) {
            $atts['aria-current'] = 'page';
        }
    }
    // Otherwise, it's a post item, so check if the item is the current post.
    elseif ( ! empty( $item->ID ) ) {
        global $post;
        if ( ! empty( $post->ID ) && $post->ID == $item->ID ) {
            $atts['aria-current'] = 'page';
        }
    }

    return $atts;
}

/**
* Changing the logo link from wordpress.org to home_url.
*
* @since  1.0
*/
function _filterLoginUrl()
{
    return esc_url( home_url('/') );
}

/**
* Changing the alt text on the logo to show your site name.
*
* @since  1.0
*/
function _filterLoginHeaderText()
{
    return esc_attr( get_bloginfo('name') );
}

/**
* Adds async/defer attributes to enqueued / registered scripts.
*
* If #12009 lands in WordPress, this function can no-op since it would be handled in core.
*
* Source: https://github.com/wprig/wprig/blob/master/dev/inc/template-functions.php#L41
*
* @since 1.0
* @link https://core.trac.wordpress.org/ticket/12009
* @param string $tag The script tag.
* @param string $handle The script handle.
* @return array
*/
function _filterScriptLoaderTag( $tag, $handle )
{
    foreach ( array( 'async', 'defer' ) as $attr ) {

        if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
            continue;
        }

        // Prevent adding attribute when already added in #12009.
        if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
            $tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
        }

        // Only allow async or defer, not both.
        break;
    }

    return $tag;
}
