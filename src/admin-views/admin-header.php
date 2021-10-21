<?php
/**
 *
 */

$admin_notifications = tribe( 'admin.notifications' );
/*
$admin_notifications->mark_as_read( 'read' );

$admin_notifications->add_notification(
	[
		'id'    => 'read',
		'title' => 'I have been read!',
		'content' => 'As much as you want to see me unread, I have been marked as read'
	]
);

$admin_notifications->add_notification(
	[
		'id'    => 'aaaaa',
		'title' => 'AAAAAA',
	]
);

$admin_notifications->add_notification(
	[
		'id'    => 'zzzzzz',
		'title' => 'ZZZZZZ',
	]
);

*/


?>
<div class="tribe-admin__layout">
	<div class="tribe-admin__header">

		<div class="tribe-admin__header-content">
			<h3 style="padding-left: 22px;" class="tooltip tribe-tooltipster tooltipster" title="This is my div's tooltip message!">Event Tickets</h3>

			<div style="position: fixed; right: 0; padding-right: 20px;">
				<!-- Upgrade to Event Tickets Plus | Rating -->
				<button onclick="document.getElementsByClassName('tribe-admin__header-sidebar')[0].classList.toggle('tribe-admin__header-sidebar--open')">
					<span class="dashicons dashicons-bell"></span>
					<span style="background: tomato; width: 9px; height: 9px; border-radius: 50%; position: fixed; right: 22px;"></span>
				</button>
			</div>
		</div>
	</div>

	<div class="tribe-admin__header-sidebar">
		<?php $notifications = $admin_notifications->get_notifications(); ?>
		<?php if ( empty( $notifications ) ) : ?>
			<h4><?php esc_html_e( 'All caught up for now!', 'tribe-common' ); ?></h4>
		<?php endif; ?>
		<?php

		// Apply some chronological order to the notifications.
		usort( $notifications, function( $a, $b ) {
			return ( $a['date'] > $b['date'] ) ? -1 : 1;
		} );


		foreach ( $notifications as $n ) :
			$classes = [
				'tribe-admin__header-sidebar-notification',
				// Iterate over categories to add classes.
				'tribe-admin__header-sidebar-notification--unread' => empty( $n['read'] ),
			];

		?>
			<div <?php tribe_classes( $classes ); ?>>
				<h4><?php echo $n['title']; ?></h4>
				<?php echo wpautop( $n['content'] ); ?>

				<?php
					printf(
						_x( '%1$s ago', '%2$s = human-readable time difference', 'tribe-common' ),
						human_time_diff( $n['date'], time() ) // current_time( 'timestamp' )
					);
				?>
				<p
					class="tooltip"
					title="<?php echo empty( $n['read'] ) ? 'unread' : 'read'; ?>"
				><?php echo empty( $n['read'] ) ? 'unread' : 'read'; ?></p>

			</div>
			<hr />

		<?php endforeach; ?>


		<!-- <h4>🤑 Get up to 40% off</h4>
		<p>We're having this huge sale coming for you. Learn more.</p>

		<hr />

		<h4>📰 Be up to date</h4>
		<p>Sign up to our newsletter!</p> -->
	</div>
</div>

