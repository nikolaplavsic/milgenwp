<?php
/* Welcome to Bones :)
This is the core Bones file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

/*********************
LAUNCH BONES
Let's fire off all the functions
and tools. I put it up here so it's
right up top and clean.
*********************/

define('BONES_LIBRARY_DIR', get_stylesheet_directory_uri() . '/library/');
define('BONES_ASSETS_DIR', BONES_LIBRARY_DIR . 'assets/');

// we're firing all out initial functions at the start
add_action('after_setup_theme','bones_ahoy', 15);

function bones_ahoy() {

    // launching operation cleanup
    add_action('init', 'bones_head_cleanup');
    // remove WP version from RSS
    add_filter('the_generator', 'bones_rss_version');
    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'bones_remove_recent_comments_style', 1);
    // clean up gallery output in wp
    add_filter('gallery_style', 'bones_gallery_style');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'bones_scripts_and_styles', 999);
    // ie conditional wrapper
    add_filter( 'style_loader_tag', 'bones_ie_conditional', 10, 2 );

    // launching this stuff after theme setup
    add_action('after_setup_theme','bones_theme_support');
    // adding sidebars to Wordpress (these are created in functions.php)
    add_action( 'widgets_init', 'bones_register_sidebars' );
    // adding the bones search form (created in functions.php)
    add_filter( 'get_search_form', 'bones_wpsearch' );

    // cleaning up random code around images
    add_filter('the_content', 'bones_filter_ptags_on_images');
    // cleaning up excerpt
    add_filter('excerpt_more', 'bones_excerpt_more');

} /* end bones ahoy */

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function bones_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'bones_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'bones_remove_wp_ver_css_js', 9999 );

} /* end bones head cleanup */

// remove WP version from RSS
function bones_rss_version() { return ''; }

// remove WP version from scripts
function bones_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove injected CSS for recent comments widget
function bones_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function bones_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function bones_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function bones_scripts_and_styles() {
  if (!is_admin()) {

    // modernizr (without media query polyfill)
    wp_register_script( 'bones-modernizr', BONES_ASSETS_DIR . 'js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

    // register main stylesheet (twitter bootstrap)
    wp_register_style( 'bt-stylesheet', BONES_ASSETS_DIR . 'css/bootstrapwp.css', false, '0.92', 'all');

    // ie-only style sheet
    wp_register_style( 'bt-ie-only', BONES_ASSETS_DIR . 'css/ie.css', array(), '' );

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

	// adding bootstrap.js file in the footer
	wp_enqueue_script('bootstrap-js', BONES_ASSETS_DIR . 'js/bootstrap.min.js', array('jquery'), '0.92', true);
	
    //adding scripts file in the footer
    wp_register_script( 'bones-js', BONES_ASSETS_DIR . 'js/scripts.js', array( 'jquery' ), '', true );

    // enqueue styles and scripts
    wp_enqueue_script( 'bones-modernizr' );
    wp_enqueue_style( 'bt-stylesheet' );
    wp_enqueue_style( 'bt-ie-only');
    /*
    I recommend using a plugin to call jQuery
    using the google cdn. That way it stays cached
    and your site will load faster.
    */
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap-js' );
    wp_enqueue_script( 'bones-js' );

  }
}

// adding the conditional wrapper around ie stylesheet
// source: http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
function bones_ie_conditional( $tag, $handle ) {
	if ( 'bt-ie-only' == $handle )
		$tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
	return $tag;
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function bones_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');

	// default thumb size
	set_post_thumbnail_size(125, 125, true);

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
	    array(
	    'default-image' => '',  // background image default
	    'default-color' => '', // background color default (dont add the #)
	    'wp-head-callback' => '_custom_background_cb',
	    'admin-head-callback' => '',
	    'admin-preview-callback' => ''
	    )
	);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
		)
	);

	// wp menus
	add_theme_support( 'menus' );

	// load custom walker menu class file
    require 'includes/class-bootstrap_walker_nav_menu.php';
	
	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'bonestheme' ),   // main nav in header
			'footer-links' => __( 'Footer Links', 'bonestheme' ) // secondary nav in footer
		)
	);
	
	
	
} /* end bones theme support */


/*********************
MENUS & NAVIGATION
*********************/

// the main menu
function vart_main_nav() {
	
	$defaults = array(
		'theme_location'  => 'main-nav',					// The location in the theme to be used--must be registered with register_nav_menu()
		'menu'            => '',							// The menu that is desired; accepts (matching in order) id, slug, name
		'container'       => 'nav',							// Whether to wrap the ul, and what to wrap it with. Allowed tags are div and nav. Use false for no container
		'container_class' => 'nav-collapse collapse',		// The class that is applied to the container
		'container_id'    => '',							// The ID that is applied to the container
		'menu_class'      => 'nav',							// The class that is applied to the ul element which encloses the menu items. Multiple classes can be separated with spaces
		'menu_id'         => '',							// The ID that is applied to the ul element which encloses the menu items
		'echo'            => true,							// Whether to echo the menu or return it. For returning menu use '0'
		'before'          => '',							// Output text before the <a> of the link
		'after'           => '',							// Output text after the </a> of the link
		'link_before'     => '',							// Output text before the link text
		'link_after'      => '',							// Output text after the link text
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',		// Evaluated as the format string argument of a sprintf() expression
		'depth'           => 2,								// How many levels of the hierarchy are to be included where 0 means all
		'walker'          => new Bootstrap_Walker_Nav_Menu(),				// Custom walker object to use (Note: You must pass an actual object to use, not a string)
		'fallback_cb'     => 'vart_main_nav_fallback'		// If the menu doesn't exist, the fallback function to use. Set to false for no fallback
	);
	
	wp_nav_menu( $defaults );	
}
// the main menu fallback
function vart_main_nav_fallback() {
	wp_page_menu( array(
		'sort_column'	=> 'menu_order, post_title',		// The default setting is sort by menu order and alphabetically by page title. Options: post_title, menu_order, post_date, post_modified, ID, post_author, post_name
		'show_home'		=> true,							// Add "Home" as the first item in the list of "Pages". Options: true, false, :string (Use this text as the link in place of "Home")
    	'menu_class'	=> 'nav-collapse collapse',			// The div class the list is displayed in. Defaults to menu.
		'include'		=> '',
		'exclude'		=> '',
		'echo'			=> true,							// Whether to echo the menu or return it. For returning menu use '0'
        'link_before'	=> '',								// before each link
        'link_after'	=> ''								// after each link
	) );
}

// the footer menu (should you choose to use one)
function vart_footer_links() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => false,                           // remove nav container
    	'menu' => __( 'Footer Links', 'bonestheme' ),   // nav name
    	'menu_class' => 'footer-nav',					// adding custom nav class
    	'theme_location' => 'footer-links',             // where it's located in the theme
    	'depth' => 1,                                   // limit the depth of the nav
    	'fallback_cb' => 'vart_footer_links_fallback'	// fallback function
	));
} /* end bones footer link */

// this is the fallback for footer menu
function vart_footer_links_fallback() {
	echo '<ul class="footer-nav">';
	$args = array(
		'depth'        => 1,
		'title_li'     => '',
	    'post_status'  => 'publish' 
	);
	wp_list_pages( $args );
	echo '</ul>';
}

/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using bones_related_posts(); )
function bones_related_posts() {
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if($tags) {
		foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }
        $args = array(
        	'tag' => $tag_arr,
        	'numberposts' => 5, /* you can change this to show more */
        	'post__not_in' => array($post->ID)
     	);
        $related_posts = get_posts($args);
        if($related_posts) {
        	foreach ($related_posts as $post) : setup_postdata($post); ?>
	           	<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
	        <?php endforeach; }
	    else { ?>
            <?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'bonestheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
} /* end bones related posts function */

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function bones_page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation"><ol class="bones_page_navi clearfix">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __( "First", 'bonestheme' );
		echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link('<<');
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="bpn-current">'.$i.'</li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link('>>');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = __( "Last", 'bonestheme' );
		echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ol></nav>'.$after."";
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function bones_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a href="'. get_permalink($post->ID) . '" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function bones_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}

add_action("wp_enqueue_scripts", "vart_jquery_enqueue", 11);
function vart_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}

?>
