<?php
/**
 * Primary Category settings section header
 *
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    XA10up_Primary_Category
 * @subpackage XA10up_Primary_Category/admin/partials
 */
$options            = get_option( 'xa10up_options' );
$post_type          = $args['post_type'];
$taxonomies = array_filter(
	get_object_taxonomies( $post_type->name, 'object' ),
	array(
		'XA10up_Primary_Category_Settings',
		'filter_taxonomies',
	)
);
?>
<select
	id="<?php echo esc_attr( $args['label_for'] ); ?>"
	data-custom="<?php echo esc_attr( $args['xa10up_custom_data'] ); ?>"
	name="xa10up_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
	<option value="" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'none', false ) ) : ( '' ); ?>>
		<?php esc_html_e( 'None', 'xa10up' ); ?>
	</option>
	<?php foreach ( $taxonomies as $key => $value ) : ?>
		<option value="<?php echo $key; ?>" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], $key, false ) ) : ( '' ); ?>>
			<?php esc_html_e( $value->labels->singular_name, 'xa10up' ); ?>
		</option>
	<?php endforeach; ?>
</select>
