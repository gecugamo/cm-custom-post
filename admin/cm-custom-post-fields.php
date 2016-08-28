<?php

// Register meta boxes.
function cm_custom_post_meta_register() {
	add_meta_box(
		'cm_plugin_name_meta',
		esc_html__ ( 'Custom Post', 'text-domain' ),
		'cm_custom_post_meta_display',
		'custom_post',
		'normal'
	);
}
add_action( 'add_meta_boxes', 'cm_custom_post_meta_register' );

// Display meta boxes.
function cm_custom_post_meta_display( $post ) {
	?>

	<?php wp_nonce_field( basename( __FILE__ ), 'cm_custom_post_nonce' ); ?>

	<p>
		<label for="cm_custom_post_text"><?php _e( 'Custom Post Text', 'text-domain' ); ?></label>
		<input type="text" name="cm_custom_post_text" value="<?php esc_attr_e( get_post_meta( $post->ID, 'cm_custom_post_text', true ) ); ?>" class="widefat" />
	</p>

	<?php
	$content = get_post_meta( $post->ID, 'cm_custom_post_wysiwyg', true );
	$editor_id = 'cm_custom_post_wysiwyg';
	wp_editor( $content, $editor_id );
}

// Save meta box values.
function cm_custom_post_meta_save( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'cm_custom_post_nonce' ] ) && wp_verify_nonce( $_POST[ 'cm_custom_post_nonce' ], basename( __FILE__ ) ) );
	$has_permission = current_user_can( 'edit_others_posts' );

    if ( $is_autosave || $is_revision || ! $is_valid_nonce || ! $has_permission ) {
		return;
	}

	if ( isset( $_POST[ 'cm_custom_post_text' ] ) ) {
		$cm_custom_post_text = sanitize_text_field( $_POST[ 'cm_custom_post_text' ] );
		update_post_meta( $post_id, 'cm_custom_post_text', $cm_custom_post_text );
	}

	if ( isset( $_POST[ 'cm_custom_post_wysiwyg' ] ) ) {
		$cm_custom_post_wysiwyg = wp_kses_post( $_POST[ 'cm_custom_post_wysiwyg' ] );
		update_post_meta( $post_id, 'cm_custom_post_wysiwyg', $cm_custom_post_wysiwyg );
	}
}
add_action( 'save_post', 'cm_custom_post_meta_save' );
