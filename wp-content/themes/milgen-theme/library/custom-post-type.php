<?php

function vart_custom_post_partner(){

	$labels = array(
		'name'					=> _x( 'Partners', 'post type general name' ),	/* general name for the post type, usually plural. The same as, and overridden by $post_type_object->label*/
		'singular_name'			=> _x( 'Partner', 'post type singular name' ),	/* name for one object of this post type. Defaults to value of name*/
		'menu_name'				=> 'Partners',									/* the menu name text. This string is the name to give menu items. Defaults to value of name*/
		'all_items'				=> __('All Partners'), 							/* the all items text used in the menu. Default is the Name label */
		'add_new'				=> _x( 'Add New', 'partner' ),					/* the add new text. The default is Add New for both hierarchical and non-hierarchical types. When internationalizing this string, please use a gettext context matching your post type. Example: _x('Add New', 'product'); */
		'add_new_item'			=> __( 'Add New Partner' ),						/* the add new item text. Default is Add New Post/Add New Page */
		'edit_item'				=> __( 'Edit Partner' ),						/* the edit item text. Default is Edit Post/Edit Page */
		'new_item'				=> __( 'New Partner' ),							/* the new item text. Default is New Post/New Page */
		'view_item'				=> __( 'View Partner' ),						/* the view item text. Default is View Post/View Page */
		'items_archive'			=> __( 'Partner Archive' ),						/* the items archive text. Default is Page Archive */
		'search_items'			=> __( 'Search Partners' ),						/* the search items text. Default is Search Posts/Search Pages */
		'not_found'				=> __( 'No partners found' ),					/* the not found text. Default is No posts found/No pages found */
		'not_found_in_trash'	=> __( 'No partners found in the Trash' ),		/* the not found in trash text. Default is No posts found in Trash/No pages found in Trash */
		'parent_item_colon'		=> '',											/* the parent text. This string isn't used on non-hierarchical types. In hierarchical ones the default is Parent */
		
	);
	$args = array(
		'labels'        		=> $labels,														/* An array of labels for this post type. Default: if empty, name is set to label value, and singular_name is set to name value */
		'description'   		=> 'Holds our partners and partner specific data',				/* A short descriptive summary of what the post type is. */
		'public'        		=> true,														/* Whether a post type is intended to be used publicly either via the admin interface or by front-end users. Default: false */
		'exclude_from_search'	=> false,														/* Whether to exclude posts with this post type from front end search results. Default: value of the opposite of the public argument */
		'publicly_queryable'	=> true,														/* Whether queries can be performed on the front end as part of parse_request(). Default: value of public argument */
		'show_ui'				=> true,														/* Whether to generate a default UI for managing this post type in the admin. Default: value of public argument */
		'show_in_nav_menus'		=> true,														/* Whether post_type is available for selection in navigation menus. Default: value of public argument */
		'show_in_menu'			=> true,														/* Where to show the post type in the admin menu. show_ui must be true. Default: value of show_ui argument */
		'show_in_admin_bar'		=> true,														/* Whether to make this post type available in the WordPress admin bar. Default: value of the show_in_menu argument */
		'menu_position'			=> 5,															/* The position in the menu order the post type should appear. show_in_menu must be true. Default: null - defaults to below Comments */
		'menu_icon'				=> null, 														/* the url to the icon to be used for this menu. Default: null - defaults to the posts icon */
		'capability_type'		=> 'post', 														/* The string to use to build the read, edit, and delete capabilities. Default: "post" */
		'hierarchical'			=> false,														/* Whether the post type is hierarchical (e.g. page). Allows Parent to be specified. Default: false */
		'supports'				=> array( 'title', 'editor', 'thumbnail' ),						/* An alias for calling add_post_type_support() directly. Default: title and editor */
		'has_archive'			=> true,														/* Enables post type archives. Will use $post_type as archive slug by default. Default: false */
		'rewrite' 				=> array('slug' => 'partners', 'with_front' => false)
	);
	register_post_type( 'partner', $args );	
}

add_action( 'init', 'vart_custom_post_partner' );

//add filter to ensure the partner, is displayed when user updates a partner 

function vart_partner_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['partner'] = array(
    0 =>	'', 																		// Unused. Messages start at index 1.
    1 =>	sprintf(
    			__( 'Partner updated. <a href="%s">View partner</a>' ), 
    			esc_url( get_permalink($post_ID) ) 
			),
    2 => 	__( 'Partner updated.' ),
    3 => 	__( 'Partner deleted.' ),
    4 =>	__( 'Partner updated.' ),
    
    /* translators: %s: date and time of the revision */
    5 => 	isset($_GET['revision']) ? 
    			sprintf( 
    				__( 'Partner restored to revision from %s' ), 
    				wp_post_revision_title( (int) $_GET['revision'], false ) ) 
			: 
				false,
				
    6 => 	sprintf( 
    			__( 'Partner published. <a href="%s">View partner</a>' ), 
    			esc_url( get_permalink($post_ID) ) 
			),
			
    7 => 	__( 'Partner saved.' ),
    8 => 	sprintf( 
    			__( 'Partner submitted. <a target="_blank" href="%s">Preview partner</a>' ), 
    			esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) 
			),
			
    9 => 	sprintf( 
    			__( 'Partner scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview partner</a>' ),
      			// translators: Publish box date format, see http://php.net/date
      			date_i18n( __( 'M j, Y @ G:i' ), 
      			strtotime( $post->post_date ) ), 
      			esc_url( get_permalink($post_ID) ) 
			),
			
    10 => 	sprintf( 
    			__( 'Partner draft updated. <a target="_blank" href="%s">Preview partner</a>' ), 
    			esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) 
			),
	
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'vart_partner_updated_messages' );

//display contextual help for Partners
function vart_partner_add_help_text( $contextual_help, $screen_id, $screen ) {
 // $contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
  if ( 'partner' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a book:', 'your_text_domain') . '</p>';
  } elseif ( 'edit-partner' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of books blah blah blah.', 'your_text_domain') . '</p>' ;
  }
  return $contextual_help;
}
//add_action( 'contextual_help', 'vart_partner_add_help_text', 10, 3 );
	
	
/* ---------------------------------------------------------- */
/* META BOXES
/* ---------------------------------------------------------- */

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'vart_partner_info_meta_box_setup' );
add_action( 'load-post-new.php', 'vart_partner_info_meta_box_setup' );

/* Meta box setup function. */
function vart_partner_info_meta_box_setup() {
	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'vart_add_partner_info_meta_box' );
	
	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'vart_save_partner_info_meta_box', 10, 2 );
	
	add_action( 'admin_enqueue_scripts', 'vart_partner_enqueue_scripts', 10, 2 );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function vart_add_partner_info_meta_box() {
    add_meta_box( 
        'partner_info_meta_box',
        __( 'Partner Info' ),
        'vart_partner_info_meta_box',
        'partner',
        'normal',
        'high'
    );
}

/* Display the post meta box. */
function vart_partner_info_meta_box( $object, $box ) {
	wp_nonce_field( basename( __FILE__ ), 'partner_info_meta_box_nonce' );
	
	// partner_url
	printf('<p><label for="%1$s">%2$s</label><input id="%1$s" name="%1$s" class="" value="%3$s"/></p>',
		'partner_url', // id / name 
		__( "Partner website url:", 'example' ),
		esc_attr( get_post_meta( $object->ID, 'partner_url', true ) )
	);
	
	// partner_email
	printf('<p><label for="%1$s">%2$s</label><input id="%1$s" name="%1$s" class="" value="%3$s"/></p>',
		'partner_email', // id / name 
		__( "Partner email:", 'example' ),
		esc_attr( get_post_meta( $object->ID, 'partner_email', true ) )
	);
	
	// partner_address
	printf('<p><label for="%1$s">%2$s</label><input id="%1$s" name="%1$s" class="" value="%3$s"/></p>',
		'partner_address', // id / name 
		__( "Partner address:", 'example' ),
		esc_attr( get_post_meta( $object->ID, 'partner_address', true ) )
	);
	
	// partner_phone
	printf('<p><label for="%1$s">%2$s</label><input id="%1$s" name="%1$s" class="" value="%3$s"/></p>',
		'partner_phone', // id / name 
		__( "Partner phone:", 'example' ),
		esc_attr( get_post_meta( $object->ID, 'partner_phone', true ) )
	);
}

/* Save the meta box's post metadata. */
function vart_save_partner_info_meta_box( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['partner_info_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['partner_info_meta_box_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$partner_url = ( isset( $_POST['partner_url'] ) ? esc_url($_POST['partner_url']) : '' );
	$partner_email = ( isset( $_POST['partner_email'] ) ? sanitize_email($_POST['partner_email']) : '' );
	$partner_address = ( isset( $_POST['partner_address'] ) ? apply_filters('attribute_escape', $_POST['partner_address']) : '' );
	$partner_phone = ( isset( $_POST['partner_phone'] ) ? apply_filters('attribute_escape', $_POST['partner_phone']) : '' );
	
	
	$meta_keys = array(
		'partner_url' => $partner_url,
		'partner_email' => $partner_email,
		'partner_address' => $partner_address,
		'partner_phone' => $partner_phone
	);

	
	
	foreach ($meta_keys as $meta_key => $new_meta_value) {
		
		/* Get the meta value of the custom field key. */
		$old_meta_value = get_post_meta( $post_id, $meta_key, true );
		
		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $old_meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	
		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $old_meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );
	
		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $old_meta_value )
			delete_post_meta( $post_id, $meta_key, $old_meta_value );
	}
	

}

function vart_partner_enqueue_scripts(){
	wp_enqueue_script('validation', BONES_ASSETS_DIR . 'js/jquery.validate.js', array('jquery'), false, true);
}

add_filter( 'manage_edit-partner_columns', 'vart_partner_columns_filter', 10, 1 );
function vart_partner_columns_filter( $columns ) {	
	$columns = array(
		'featured_image' => 'Logo',
		'title' => __( 'Name' ),
		'email' => __( 'Email' ),
		'url' => __( 'Web' ),
		'date' => __( 'Date' )
	);
	return $columns;
}
add_action( 'manage_partner_posts_custom_column', 'vart_partner_columns_filter_action', 10, 1 );
function vart_partner_columns_filter_action( $column ) {
	global $post;
	switch ( $column ) {
		case 'featured_image':
			echo get_the_post_thumbnail( $post->ID );
			break;
		case 'email':
			echo get_post_meta( $post->ID, 'partner_email', true );
			break;
		case 'url':
			echo get_post_meta( $post->ID, 'partner_url', true );
			break;
	}
}

add_filter( 'enter_title_here', 'vart_change_partner_enter_title_text', 10, 2 );
function vart_change_partner_enter_title_text( $title, $post ) {
	$screen = get_current_screen();
	if ( 'partner' == $screen->post_type ){
        $title = 'Enter Partner Name';
    }
 
    return $title;
}

function vart_partner_remove_media_buttons() {
	$screen = get_current_screen();
	if ( 'partner' == $screen->post_type ){
        add_action( 'media_buttons_context' , create_function('', 'return;') );
    }
		
}
add_action('admin_head','vart_partner_remove_media_buttons');












/*-------------------------------------------------------------------------------------------------
 * REFERENCE
 * ------------------------------------------------------------------------------------------------*/








function vart_custom_post_reference(){

	$labels = array(
		'name'					=> _x( 'References', 'post type general name' ),	/* general name for the post type, usually plural. The same as, and overridden by $post_type_object->label*/
		'singular_name'			=> _x( 'Reference', 'post type singular name' ),	/* name for one object of this post type. Defaults to value of name*/
		'menu_name'				=> 'References',									/* the menu name text. This string is the name to give menu items. Defaults to value of name*/
		'all_items'				=> __('All References'), 							/* the all items text used in the menu. Default is the Name label */
		'add_new'				=> _x( 'Add New', 'Reference' ),					/* the add new text. The default is Add New for both hierarchical and non-hierarchical types. When internationalizing this string, please use a gettext context matching your post type. Example: _x('Add New', 'product'); */
		'add_new_item'			=> __( 'Add New Reference' ),						/* the add new item text. Default is Add New Post/Add New Page */
		'edit_item'				=> __( 'Edit Reference' ),						/* the edit item text. Default is Edit Post/Edit Page */
		'new_item'				=> __( 'New Reference' ),							/* the new item text. Default is New Post/New Page */
		'view_item'				=> __( 'View Reference' ),						/* the view item text. Default is View Post/View Page */
		'items_archive'			=> __( 'Reference Archive' ),						/* the items archive text. Default is Page Archive */
		'search_items'			=> __( 'Search References' ),						/* the search items text. Default is Search Posts/Search Pages */
		'not_found'				=> __( 'No references found' ),					/* the not found text. Default is No posts found/No pages found */
		'not_found_in_trash'	=> __( 'No references found in the Trash' ),		/* the not found in trash text. Default is No posts found in Trash/No pages found in Trash */
		'parent_item_colon'		=> '',											/* the parent text. This string isn't used on non-hierarchical types. In hierarchical ones the default is Parent */
		
	);
	$args = array(
		'labels'        		=> $labels,														/* An array of labels for this post type. Default: if empty, name is set to label value, and singular_name is set to name value */
		'description'   		=> 'Holds our references and reference specific data',				/* A short descriptive summary of what the post type is. */
		'public'        		=> true,														/* Whether a post type is intended to be used publicly either via the admin interface or by front-end users. Default: false */
		'exclude_from_search'	=> false,														/* Whether to exclude posts with this post type from front end search results. Default: value of the opposite of the public argument */
		'publicly_queryable'	=> true,														/* Whether queries can be performed on the front end as part of parse_request(). Default: value of public argument */
		'show_ui'				=> true,														/* Whether to generate a default UI for managing this post type in the admin. Default: value of public argument */
		'show_in_nav_menus'		=> true,														/* Whether post_type is available for selection in navigation menus. Default: value of public argument */
		'show_in_menu'			=> true,														/* Where to show the post type in the admin menu. show_ui must be true. Default: value of show_ui argument */
		'show_in_admin_bar'		=> true,														/* Whether to make this post type available in the WordPress admin bar. Default: value of the show_in_menu argument */
		'menu_position'			=> 5,															/* The position in the menu order the post type should appear. show_in_menu must be true. Default: null - defaults to below Comments */
		'menu_icon'				=> null, 														/* the url to the icon to be used for this menu. Default: null - defaults to the posts icon */
		'capability_type'		=> 'post', 														/* The string to use to build the read, edit, and delete capabilities. Default: "post" */
		'hierarchical'			=> false,														/* Whether the post type is hierarchical (e.g. page). Allows Parent to be specified. Default: false */
		'supports'				=> array( 'title', 'editor', 'thumbnail' ),						/* An alias for calling add_post_type_support() directly. Default: title and editor */
		'has_archive'			=> true,														/* Enables post type archives. Will use $post_type as archive slug by default. Default: false */
		'rewrite' 				=> array('slug' => 'references', 'with_front' => false)
	);
	register_post_type( 'reference', $args );	
}

add_action( 'init', 'vart_custom_post_reference' );

//add filter to ensure the partner, is displayed when user updates a partner 

function vart_reference_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['reference'] = array(
    0 =>	'', 																		// Unused. Messages start at index 1.
    1 =>	sprintf(
    			__( 'Reference updated. <a href="%s">View reference</a>' ), 
    			esc_url( get_permalink($post_ID) ) 
			),
    2 => 	__( 'Reference updated.' ),
    3 => 	__( 'Reference deleted.' ),
    4 =>	__( 'Reference updated.' ),
    
    /* translators: %s: date and time of the revision */
    5 => 	isset($_GET['revision']) ? 
    			sprintf( 
    				__( 'Reference restored to revision from %s' ), 
    				wp_post_revision_title( (int) $_GET['revision'], false ) ) 
			: 
				false,
				
    6 => 	sprintf( 
    			__( 'Reference published. <a href="%s">View reference</a>' ), 
    			esc_url( get_permalink($post_ID) ) 
			),
			
    7 => 	__( 'Reference saved.' ),
    8 => 	sprintf( 
    			__( 'Reference submitted. <a target="_blank" href="%s">Preview reference</a>' ), 
    			esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) 
			),
			
    9 => 	sprintf( 
    			__( 'Reference scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview reference</a>' ),
      			// translators: Publish box date format, see http://php.net/date
      			date_i18n( __( 'M j, Y @ G:i' ), 
      			strtotime( $post->post_date ) ), 
      			esc_url( get_permalink($post_ID) ) 
			),
			
    10 => 	sprintf( 
    			__( 'Reference draft updated. <a target="_blank" href="%s">Preview reference</a>' ), 
    			esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) 
			),
	
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'vart_reference_updated_messages' );

//display contextual help for Partners
function vart_reference_add_help_text( $contextual_help, $screen_id, $screen ) {
 // $contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
  if ( 'reference' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a book:', 'your_text_domain') . '</p>';
  } elseif ( 'edit-partner' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of books blah blah blah.', 'your_text_domain') . '</p>' ;
  }
  return $contextual_help;
}
//add_action( 'contextual_help', 'vart_reference_add_help_text', 10, 3 );


/*-------------------------------------------------------------------------------------------------
 * Gallery
 * ------------------------------------------------------------------------------------------------*/








function vart_custom_post_gallery(){

	$labels = array(
		'name'					=> _x( 'Galleries', 'post type general name' ),	/* general name for the post type, usually plural. The same as, and overridden by $post_type_object->label*/
		'singular_name'			=> _x( 'Gallery', 'post type singular name' ),	/* name for one object of this post type. Defaults to value of name*/
		'menu_name'				=> 'Galleries',									/* the menu name text. This string is the name to give menu items. Defaults to value of name*/
		'all_items'				=> __('All Galleries'), 							/* the all items text used in the menu. Default is the Name label */
		'add_new'				=> _x( 'Add New', 'Gallery' ),					/* the add new text. The default is Add New for both hierarchical and non-hierarchical types. When internationalizing this string, please use a gettext context matching your post type. Example: _x('Add New', 'product'); */
		'add_new_item'			=> __( 'Add New Gallery' ),						/* the add new item text. Default is Add New Post/Add New Page */
		'edit_item'				=> __( 'Edit Gallery' ),						/* the edit item text. Default is Edit Post/Edit Page */
		'new_item'				=> __( 'New Gallery' ),							/* the new item text. Default is New Post/New Page */
		'view_item'				=> __( 'View Gallery' ),						/* the view item text. Default is View Post/View Page */
		'items_archive'			=> __( 'Gallery Archive' ),						/* the items archive text. Default is Page Archive */
		'search_items'			=> __( 'Search Galleries' ),						/* the search items text. Default is Search Posts/Search Pages */
		'not_found'				=> __( 'No galleries found' ),					/* the not found text. Default is No posts found/No pages found */
		'not_found_in_trash'	=> __( 'No galleries found in the Trash' ),		/* the not found in trash text. Default is No posts found in Trash/No pages found in Trash */
		'parent_item_colon'		=> '',											/* the parent text. This string isn't used on non-hierarchical types. In hierarchical ones the default is Parent */
		
	);
	$args = array(
		'labels'        		=> $labels,														/* An array of labels for this post type. Default: if empty, name is set to label value, and singular_name is set to name value */
		'description'   		=> 'Holds our references and reference specific data',				/* A short descriptive summary of what the post type is. */
		'public'        		=> true,														/* Whether a post type is intended to be used publicly either via the admin interface or by front-end users. Default: false */
		'exclude_from_search'	=> false,														/* Whether to exclude posts with this post type from front end search results. Default: value of the opposite of the public argument */
		'publicly_queryable'	=> true,														/* Whether queries can be performed on the front end as part of parse_request(). Default: value of public argument */
		'show_ui'				=> true,														/* Whether to generate a default UI for managing this post type in the admin. Default: value of public argument */
		'show_in_nav_menus'		=> true,														/* Whether post_type is available for selection in navigation menus. Default: value of public argument */
		'show_in_menu'			=> true,														/* Where to show the post type in the admin menu. show_ui must be true. Default: value of show_ui argument */
		'show_in_admin_bar'		=> true,														/* Whether to make this post type available in the WordPress admin bar. Default: value of the show_in_menu argument */
		'menu_position'			=> 5,															/* The position in the menu order the post type should appear. show_in_menu must be true. Default: null - defaults to below Comments */
		'menu_icon'				=> null, 														/* the url to the icon to be used for this menu. Default: null - defaults to the posts icon */
		'capability_type'		=> 'post', 														/* The string to use to build the read, edit, and delete capabilities. Default: "post" */
		'hierarchical'			=> false,														/* Whether the post type is hierarchical (e.g. page). Allows Parent to be specified. Default: false */
		'supports'				=> array( 'title' ),						/* An alias for calling add_post_type_support() directly. Default: title and editor */
		'has_archive'			=> true,														/* Enables post type archives. Will use $post_type as archive slug by default. Default: false */
		'rewrite' 				=> array('slug' => 'galleries', 'with_front' => false)
	);
	register_post_type( 'gallery', $args );	
}

//add_action( 'init', 'vart_custom_post_gallery' );

//add filter to ensure the partner, is displayed when user updates a partner 

function vart_gallery_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['gallery'] = array(
    0 =>	'', 																		// Unused. Messages start at index 1.
    1 =>	sprintf(
    			__( 'Gallery updated. <a href="%s">View gallery</a>' ), 
    			esc_url( get_permalink($post_ID) ) 
			),
    2 => 	__( 'Gallery updated.' ),
    3 => 	__( 'Gallery deleted.' ),
    4 =>	__( 'Gallery updated.' ),
    
    /* translators: %s: date and time of the revision */
    5 => 	isset($_GET['revision']) ? 
    			sprintf( 
    				__( 'Gallery restored to revision from %s' ), 
    				wp_post_revision_title( (int) $_GET['revision'], false ) ) 
			: 
				false,
				
    6 => 	sprintf( 
    			__( 'Gallery published. <a href="%s">View gallery</a>' ), 
    			esc_url( get_permalink($post_ID) ) 
			),
			
    7 => 	__( 'Gallery saved.' ),
    8 => 	sprintf( 
    			__( 'Gallery submitted. <a target="_blank" href="%s">Preview gallery</a>' ), 
    			esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) 
			),
			
    9 => 	sprintf( 
    			__( 'Gallery scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview gallery</a>' ),
      			// translators: Publish box date format, see http://php.net/date
      			date_i18n( __( 'M j, Y @ G:i' ), 
      			strtotime( $post->post_date ) ), 
      			esc_url( get_permalink($post_ID) ) 
			),
			
    10 => 	sprintf( 
    			__( 'Gallery draft updated. <a target="_blank" href="%s">Preview gallery</a>' ), 
    			esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) 
			),
	
  );

  return $messages;
}
//add_filter( 'post_updated_messages', 'vart_gallery_updated_messages' );

//display contextual help for Partners
function vart_gallery_add_help_text( $contextual_help, $screen_id, $screen ) {
 // $contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
  if ( 'gallery' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a book:', 'your_text_domain') . '</p>';
  } elseif ( 'edit-partner' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of books blah blah blah.', 'your_text_domain') . '</p>' ;
  }
  return $contextual_help;
}
//add_action( 'contextual_help', 'vart_gallery_add_help_text', 10, 3 );


function my_connection_types() {
	p2p_register_connection_type( array(
		'name' => 'references_to_galleries',
		'from' => 'reference',
		'to' => 'gallery',
		'cardinality' => 'one-to-one',
	) );
}
add_action( 'p2p_init', 'my_connection_types' );


?>
