<?php
if ( empty( $notification ) ) {
	return;
}

	$classes = [
		'tribe-admin__header-sidebar-notification',
		// Iterate over categories to add classes.
		'tribe-admin__header-sidebar-notification--unread' => empty( $notification['read'] ),
		'tribe-common__admin-container',
	];

?>
<div <?php tribe_classes( $classes ); ?>>
	<h4><?php echo $notification['title']; ?></h4>
	<?php echo wpautop( $notification['content'] ); ?>

	<?php
		printf(
			// Translators: %1$s human-readable time difference
			__( '%1$s ago', 'tribe-common' ),
			human_time_diff( $notification['date'], time() ) // current_time( 'timestamp' )
		);
	?>
	<p
		class="tooltip"
		title="<?php echo empty( $notification['read'] ) ? 'unread' : 'read'; ?>"
	><?php echo empty( $notification['read'] ) ? 'unread' : 'read'; ?></p>

	<?php if ( empty( $notification['read'] ) ) : ?>
		<button
			class="tribe-admin__header-sidebar-notification-mark-as-read"
			data-notification-id="<?php echo esc_attr( $notification['id'] ); ?>"
		>
			<?php esc_html_e( 'Mark as read', 'tribe-common' ); ?>
		</button>
	<?php endif; ?>
</div>
<hr />
