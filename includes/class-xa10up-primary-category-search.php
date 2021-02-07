<?php


class XA10up_Primary_Category_Search {

	/**
	 * Filters for primary taxonomy fields
	 *
	 * @return boolean
	 * @since 1.0.0
	 * @static
	 */
	public static function filter_taxonomy_fields( $val ): bool {
		$primary_field_pattern = '/xa10up_field_([a-z0-9_]+)_primary/';
		$match                 = preg_match( $primary_field_pattern, $val );

		return boolval( $match );
	}

	/**
	 * Adds an updated "join" to the search query
	 *
	 * @param string $join Join string in search query.
	 *
	 * @return mixed|string
	 *
	 * @access public
	 * @static
	 * @since  1.0.0
	 */
	public static function update_join( $join ) {
		global $wpdb;

		if ( is_search() ) {
			$join .= "
        INNER JOIN
          {$wpdb->term_relationships} ON {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id
        INNER JOIN
          {$wpdb->term_taxonomy} ON {$wpdb->term_taxonomy}.term_taxonomy_id = {$wpdb->term_relationships}.term_taxonomy_id
        INNER JOIN
          {$wpdb->terms} ON {$wpdb->terms}.term_id = {$wpdb->term_taxonomy}.term_id
      ";
		}

		return $join;
	}

	/**
	 * Updates the "groupby" in the search query
	 *
	 * @param $groupby
	 *
	 * @return mixed|string
	 * @access public
	 * @static
	 * @since  1.0.0
	 */
	public static function update_groupby( $groupby ) {
		global $wpdb;

		if ( is_search() ) {
			$groupby = "{$wpdb->posts}.ID";
		}

		return $groupby;
	}

	/**
	 * Adds primary taxonomies to search results
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function add_taxonomies() {
		$options = get_option( 'xa10up_options' );

		if ( ! empty( $options ) ) {
			$post_taxonomy_fields = array_filter(
				$options,
				array(
					'XA10up_Primary_Category_Search',
					'filter_taxonomy_fields',
				),
				ARRAY_FILTER_USE_KEY
			);

			// validate taxonomy values.
			foreach ( $post_taxonomy_fields as $field => $taxonomy ) {
				// If the taxonomy value exists, add it to the search.
				if ( taxonomy_exists( $taxonomy ) ) {
					$post_type = preg_replace( '/xa10up_field_([a-z0-9_]+)_primary/', '$1', $field );

					// Register query hooks for primary post taxonomies.
					add_filter(
						'posts_join',
						array(
							'XA10up_Primary_Category_Search',
							'update_join',
						)
					);
					add_filter(
						'posts_where',
						function ( $where ) use ( $taxonomy, $post_type ) {
							return $this->update_where( $where, $taxonomy, $post_type );
						}
					);
					add_filter(
						'posts_groupby',
						array(
							'XA10up_Primary_Category_Search',
							'update_groupby',
						)
					);
				}
			}
		}
	}

	/**
	 * * Adds an updated "update" to the search query
	 *
	 * @param string $where     Where string in the search query.
	 * @param string $taxonomy  Taxonomy the where applies to.
	 * @param string $post_type Post type the where applies to.
	 *
	 * @return mixed|string
	 *
	 * @access public
	 * @static
	 * @since  1.0.0
	 */
	public static function update_where( $where, $taxonomy, $post_type ) {
		global $wpdb;

		// Match both the post type and the taxonomy. It's conceivable that
		// multiple post types could share taxonomies but you only want the
		// results to show each post type for its primary taxonomy, not others.
		if ( is_search() ) {
			$where .= $wpdb->prepare(
				" OR
    (
      {$wpdb->posts}.post_status LIKE %s
      AND
      {$wpdb->posts}.post_type LIKE %s
      AND
      {$wpdb->term_taxonomy}.taxonomy LIKE %s
      AND
      {$wpdb->terms}.name LIKE (%s)
    ) ",
				array(
					'publish',
					$post_type,
					$taxonomy,
					'%' . get_query_var( 's' ) . '%',
				)
			);
		}

		return $where;
	}


}