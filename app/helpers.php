<?php

if ( ! function_exists('strtobool') ) :
/**
* Function for turning string booleans values into real booleans.
*
* @since  1.0
* @param  mixed  $value  String to convert to a boolean.
* @return  bool|string
*/
function strtobool($value): bool
{
    $value = strtolower( strval($value) );

    if ( $value === 'true' || $value === '1' ) {
        return true;
    }
    elseif ( $value === 'false' || $value === '0' ) {
        return false;
    }

    return boolval($value);
}
endif;

if ( ! function_exists('add_ajax_action') ) :
/**
* Add AJAX actions helper.
* @param  $cb  callable|array  If array uses "priv" and "nopriv" keys the callbacks are split up (use false to disable either), else use callable for both.
*/
function add_ajax_action(string $action, $cb): void
{
    if (is_array($cb) && !wp_is_numeric_array($cb)) {

        $nopriv = ($cb['nopriv'] ?? false) ? $cb['nopriv'] : false;
        $priv = ($cb['priv'] ?? false) ? $cb['priv'] : $nopriv;
    }
    else {
        $nopriv = $priv = $cb;
    }

    ($nopriv && is_callable($nopriv)) && add_action("wp_ajax_nopriv_{$action}", $nopriv);
    ($priv && is_callable($priv)) && add_action("wp_ajax_{$action}", $priv);
}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
// Backward compatibility.
function wp_body_open()
{
    do_action( 'wp_body_open' );
}
endif;

if ( ! function_exists( 'html_class' ) ) :
function html_class( $class='' )
{
	// Separates class names with a single space, collates class names for body element
	echo 'class="' . join( ' ', get_html_class( $class ) ) . '"';
}
endif;

if ( ! function_exists( 'get_html_class' ) ) :
function get_html_class( $class='' )
{
    $classes = [];

    if ( ! $GLOBALS['is_IE'] ) {
        $classes[] = 'css-vars';
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

    if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	$classes = array_map( 'esc_attr', $classes );

	/**
	 * Filters the list of CSS html class names.
	 *
	 * @param string[] $classes An array of body class names.
	 * @param string[] $class   An array of additional class names added to the html element.
	 */
	$classes = apply_filters( 'html_class', $classes, $class );

	return array_unique( $classes );
}
endif;

if ( ! function_exists( 'asset' ) ) :
// Get URL of an asset from within the public folder.
function asset( string $filePath ): string
{
    return get_theme_file_uri( "public/{$filePath}" );
}
endif;

// Check if SSL is enabled.
if (! function_exists('isSsl')) :
function isSsl()
{
    if ( is_ssl() ) {
        return true;
    }
    else if ( 0 === stripos( get_option('siteurl'), 'https://' ) ) {
        return true;
    }
    else if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
        return true;
    }

    return false;
}
endif;

if ( ! function_exists( 'envName' ) ) :
/**
* Get current environment.
* @since 1.0
* @return string
*/
function envName( $allowServerName=false )
{
    static $env = '';

    if ( '' != $env ) {
        return $env;
    }

    $server = [
        $_SERVER['HTTP_HOST']
    ];

    if ( $allowServerName ) {
        $server[] = $_SERVER['SERVER_NAME'];
    }

    if ( in_array( '%production-url%', $server ) ) {
        return $env = 'production';
    }
    else if ( in_array( '%staging-url%', $server ) ) {
        return $env = 'staging';
    }
    else if ( in_array( '%development-url%', $server ) ) {
        return $env = 'development';
    }
    else if ( in_array( $_SERVER['REMOTE_ADDR'], ['::1', '127.0.0.1'] ) ) {
        return $env = 'local';
    }

    return 'production';
}
endif;

/**
* Get related posts by category example.
*/
function getRelatedPostsExample( $amount=4 )
{
    global $post;

    if ( ! $post ) {
        the_post();
    }

    if ( ! $cats = wp_get_post_categories( $post->ID ) ) {
        return [];
    }

    $catIds = '';
    foreach ( $cats as $cat ) {
        $catIds .= "$cat,";
    }

    return get_posts([
        'cat'          => $catIds,
        'numberposts'  => $amount,
        'post__not_in' => [$post->ID],
    ]);
}

/**
* Get yoast primary (or 1st found) category.
*/
function getYoastPrimaryCategory( $postId=0 )
{
    // If no category is set, return fasle.
	if ( ! $category = get_the_category( $postId ?: get_the_ID() ) ) {
        return false;
    }

    // Get first category.
    $firstCategory = [
        'title' => $category[0]->name,
        'slug' => $category[0]->slug,
        'url' => get_category_link( $category[0]->term_id ),
    ];

    // If Yoast primary term does not exist, return the first category.
    if ( ! class_exists('WPSEO_Primary_Term') ) {
        return $firstCategory;
    }

    $wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id($postId) );

    // If method does not exsits, return the first category.
    if ( ! method_exists($wpseo_primary_term,'get_primary_term') ) {
        return $firstCategory;
    }

    $term = get_term( $wpseo_primary_term->get_primary_term() );

    // If post doesn't have a primary term set, return first category.
    if ( is_wp_error($term) ) {
        return $firstCategory;
    }

    // Yoast primary category is available.
    return [
        'title' => $term->name,
        'slug' => $term->slug,
        'url' => get_category_link( $term->term_id ),
    ];
}
