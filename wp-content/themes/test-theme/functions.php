<?php

// we're firing all out initial functions at the start
add_action('after_setup_theme','bones_ahoy', 15);

function bones_ahoy() {
    // launching this stuff after theme setup
    add_action('after_setup_theme','bones_theme_support');

} /* end bones ahoy */

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function bones_theme_support() {

	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'bonestheme' )   // main nav in header
		)
	);
} /* end bones theme support */


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
		'walker'          => new Vart_Walker_Nav_Menu(),							// Custom walker object to use (Note: You must pass an actual object to use, not a string)
		'fallback_cb'     => 'vart_main_nav_fallback'		// If the menu doesn't exist, the fallback function to use. Set to false for no fallback
	);
	
	wp_nav_menu( $defaults );	
}

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


 /**
 * class Bootstrap_Walker_Nav_Menu()
 *
 * Extending Walker_Nav_Menu to modify class assigned to submenu ul element
 *
 * @author Rachel Baker
 **/
class Vart_Walker_Nav_Menu extends Walker_Nav_Menu {

	function __construct() {

	}
	
	function start_lvl(&$output, $depth) {
	    $indent = str_repeat("\t", $depth);
	    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

}

