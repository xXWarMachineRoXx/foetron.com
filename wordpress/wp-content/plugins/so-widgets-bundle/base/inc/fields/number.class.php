<?php

/**
 * Class SiteOrigin_Widget_Field_Number
 */
class SiteOrigin_Widget_Field_Number extends SiteOrigin_Widget_Field_Text_Input_Base {

	/**
	 * The minimum value of the allowed range.
	 *
	 * @access protected
	 * @var float
	 */
	protected $step;

	 /**
	 * Whether to apply abs() when saving to ensure only positive numbers are possible.
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $abs;

	protected function get_default_options() {
		return array(
			'input_type' => 'number',
		);
	}

	protected function get_input_attributes() {
		if ( empty( $this->step ) ) {
			return array();
		}
	
		return array(
			'step' => $this->step,
		);
	}

	protected function get_input_classes() {
		$input_classes = parent::get_input_classes();
		$input_classes[] = 'siteorigin-widget-input-number';
		return $input_classes;
	}

	protected function sanitize_field_input( $value, $instance ) {
		if ( ! empty( $value ) ) {
			return ( float ) ( ! empty( $this->abs ) ? abs( $value ) : $value );
		} else {
			return false;
		}
	}
}
