<?php
/**
 * Taxonomy for studios
 *
 * @since 1.0.0
 */
function xa10up_register_taxonomy_studio() {
	$labels = array(
		'name'          => _x( 'Studios', 'taxonomy general name' ),
		'singular_name' => _x( 'Studio', 'taxonomy singular name' ),
		'search_items'  => __( 'Search Studios' ),
		'all_items'     => __( 'All Studios' ),
		'edit_item'     => __( 'Edit Studio' ),
		'update_item'   => __( 'Update Studio' ),
		'add_new_item'  => __( 'Add New Studio' ),
		'new_item_name' => __( 'New Studio Name' ),
		'menu_name'     => __( 'Studio' ),
	);
	$args   = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'studio' ),
	);
	register_taxonomy( 'studio', array( 'review', 'page' ), $args );
}
