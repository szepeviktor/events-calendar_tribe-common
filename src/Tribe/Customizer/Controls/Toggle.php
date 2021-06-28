<?php
/**
 * Models a Customizer toggle switch.
 *
 * @since TBD
 *
 * @package Tribe\Customizer\Controls
 */

namespace Tribe\Customizer\Controls;

use Tribe\Customizer\Control;

/**
 * Class Toggle
 *
 * @since TBD
 *
 * @package Tribe\Customizer\Controls
 */
class Toggle extends Control {

	/**
	 * Control's Type.
	 *
	 * @since TBD
	 *
	 * @var string
	 */
	public $type = 'toggle';

	/**
	 * Anyone able to set theme options will be able to see the slider.
	 *
	 * @since TBD
	 *
	 * @var string
	 */
	public $capability = 'edit_theme_options';

	/**
	 * Render the control's content
	 *
	 * @since TBD
	 */
	public function render_content() {
		$input_id         = '_customize-input-' . $this->id;
		$description_id   = '_customize-description-' . $this->id;
		$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
		$name             = '_customize-toggle-' . $this->id;

		?>
		<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $this->description ) ) : ?>
			<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php endif; ?>

		<span class="customize-inside-control-row">
			<label class="tec-switch-label">
					<?php if ( ! empty( $this->choices['on'] ) ) : ?>
						<span class="toggle-label-on">
							<?php echo wp_kses_post( $this->choices['on'] ); ?>
						</span>
					<?php endif; ?>
					<input
						id="<?php echo esc_attr( $input_id . '-toggle' ); ?>"
						type="checkbox"
						class="tec-switch-input"
						<?php echo $describedby_attr; ?>
						name="<?php echo esc_attr( '_customize-toggle-' . $this->id ); ?>"
						<?php $this->input_attrs(); ?>
						<?php $this->link(); ?>
					/>
				<span class="tec-switch-toggle"></span>
				<span class="toggle-label-off">
					<?php
					if ( ! empty( $this->choices['off'] ) ) {
						echo wp_kses_post( $this->choices['off'] );
					} else {
						echo wp_kses_post( $this->label );
					}
					?>
				</span>
			</label>
		</span>
		<?php
	}
}
