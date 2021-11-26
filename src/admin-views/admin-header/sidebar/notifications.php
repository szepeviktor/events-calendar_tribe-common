<?php
if ( empty( $notifications ) ) {
	return;
}
// @TODO: We may want to move this to its own template file, and hook via action.

foreach ( $notifications as $n ) :
	$classes = [
		'tribe-admin__header-sidebar-notification',
		// Iterate over categories to add classes.
		'tribe-admin__header-sidebar-notification--unread' => empty( $n['read'] ),
		'tribe-common__admin-container',
	];

?>
	<div <?php tribe_classes( $classes ); ?>>
		<h4><?php echo $n['title']; ?></h4>
		<?php echo wpautop( $n['content'] ); ?>

		<?php
			printf(
				// Translators: %1$s human-readable time difference
				__( '%1$s ago', 'tribe-common' ),
				human_time_diff( $n['date'], time() ) // current_time( 'timestamp' )
			);
		?>
		<p
			class="tooltip"
			title="<?php echo empty( $n['read'] ) ? 'unread' : 'read'; ?>"
		><?php echo empty( $n['read'] ) ? 'unread' : 'read'; ?></p>

		<?php if ( empty( $n['read'] ) ) : ?>
			<button
				class="tribe-admin__header-sidebar-notification-mark-as-read"
				data-notification-id="<?php echo esc_attr( $n['id'] ); ?>"
			>
				<?php esc_html_e( 'Mark as read', 'tribe-common' ); ?>
			</button>
		<?php endif; ?>
	</div>
	<hr />

<?php endforeach; ?>