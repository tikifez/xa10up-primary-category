<?php

/**
 * Custom post type for reviews
 *
 * The review custom post type is for writing reviews of film and television.
 *
 * @since 1.0.0
 */

function xa10up_post_type_review() {
	$labels = array(
		'name'                  => _x( 'Reviews', 'Post type general name', 'review' ),
		'singular_name'         => _x( 'Review', 'Post type singular name', 'review' ),
		'menu_name'             => _x( 'Reviews', 'Admin Menu text', 'review' ),
		'name_admin_bar'        => _x( 'Review', 'Add New on Toolbar', 'review' ),
		'add_new'               => __( 'Add New', 'review' ),
		'add_new_item'          => __( 'Add New review', 'review' ),
		'new_item'              => __( 'New review', 'review' ),
		'edit_item'             => __( 'Edit review', 'review' ),
		'view_item'             => __( 'View review', 'review' ),
		'all_items'             => __( 'All reviews', 'review' ),
		'search_items'          => __( 'Search reviews', 'review' ),
		'parent_item_colon'     => __( 'Parent reviews:', 'review' ),
		'not_found'             => __( 'No reviews found.', 'review' ),
		'not_found_in_trash'    => __( 'No reviews found in Trash.', 'review' ),
		'featured_image'        => _x( 'Review Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'review' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'review' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'review' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'review' ),
		'archives'              => _x( 'Review archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'review' ),
		'insert_into_item'      => _x( 'Insert into review', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'review' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this review', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'review' ),
		'filter_items_list'     => _x( 'Filter reviews list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'review' ),
		'items_list_navigation' => _x( 'Reviews list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'review' ),
		'items_list'            => _x( 'Reviews list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'review' ),
	);
	$args   = array(
		'labels'             => $labels,
		'description'        => 'Film reviews',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'review' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
		'taxonomies'         => array( 'category', 'post_tag' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'review', $args );
}

/**
 * Register xa10up_post_type_review to the admin_init action hook.
 */
add_action( 'init', 'xa10up_post_type_review' );
