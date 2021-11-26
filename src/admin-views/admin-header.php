<?php
/**
 *
 *
 * @var array $notifications
 */
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
			<!-- @TODO: This should be hooked via action -->
			<h3
				style="padding-left: 22px;"
				class="tooltip tribe-tooltipster tooltipster"
				title="This is my div's tooltip message!"
			>
				<?php esc_html_e( 'Event Tickets', 'tribe-common' ); ?>
			</h3>

			<div style="position: fixed; right: 0; padding-right: 20px;">
				<!-- @TODO: This should be hooked via action -->
				<!-- Upgrade to Event Tickets Plus | Rating -->
				<button onclick="document.getElementsByClassName('tribe-admin__header-sidebar')[0].classList.toggle('tribe-admin__header-sidebar--open')">
					<span class="dashicons dashicons-bell"></span>
					<span style="background: tomato; width: 9px; height: 9px; border-radius: 50%; position: fixed; right: 22px;"></span>
				</button>
			</div>

		</div>
	</div>


	<?php $this->template( 'admin-header/sidebar' ); ?>

</div>

