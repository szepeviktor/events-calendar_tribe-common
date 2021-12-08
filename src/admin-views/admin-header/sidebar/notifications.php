<?php
if ( empty( $notifications ) ) {
	return;
}
// @TODO: We may want to move this to its own template file, and hook via action.

foreach ( $notifications as $notification ) : ?>
	<?php $this->template( 'admin-header/sidebar/notifications/notification', [ 'notification' => $notification ] ); ?>
<?php endforeach; ?>