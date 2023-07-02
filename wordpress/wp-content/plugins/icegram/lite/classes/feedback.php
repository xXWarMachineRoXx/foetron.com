<?php

/**
 * Get additional system & plugin specific information for feedback

 */
if ( ! function_exists( 'ig_get_additional_info' ) ) {


	function ig_get_additional_info( $additional_info, $system_info = false ) {
		global $icegram, $ig_tracker;
		$additional_info['version'] = $icegram->version;
		if ( $system_info ) {

			$additional_info['active_plugins']   = implode( ', ', $ig_tracker::get_active_plugins() );
			$additional_info['inactive_plugins'] = implode( ', ', $ig_tracker::get_inactive_plugins() );
			$additional_info['current_theme']    = $ig_tracker::get_current_theme_info();
			$additional_info['wp_info']          = $ig_tracker::get_wp_info();
			$additional_info['server_info']      = $ig_tracker::get_server_info();

			// IG Specific information
			$additional_info['plugin_meta_info'] = Icegram::get_ig_meta_info();
		}

		return $additional_info;

	}

}

add_filter( 'ig_additional_feedback_meta_info', 'ig_get_additional_info', 10, 2 );

if ( ! function_exists( 'ig_review_message_data' ) ) {
	/**
	 * Filter 5 star review data
	 *
	 * @param $review_data
	 *
	 * @return mixed
	 *
	 * @since 1.10.36
	 */
	function ig_review_message_data( $review_data ) {

		$review_url = 'https://wordpress.org/support/plugin/icegram/reviews/';
		$icon_url   = IG_PLUGIN_URL . 'lite/assets/images/icon-64.png';

		$review_data['review_url'] = $review_url;
		$review_data['icon_url']   = $icon_url;

		return $review_data;
	}
}

add_filter( 'ig_review_message_data', 'ig_review_message_data', 10 );

if ( ! function_exists( 'ig_can_ask_user_for_review' ) ) {
	/**
	 * Can we ask user for 5 star review?
	 *
	 * @return bool
	 *
	 * @since 1.10.36
	 */
	function ig_can_ask_user_for_review( $enable, $review_data ) {

		if ( $enable ) {

			$screen = get_current_screen();
			if ( ! in_array( $screen->id, array( 'ig_campaign', 'ig_message', 'edit-ig_message', 'edit-ig_campaign' ), true ) ) {
				return false;
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				return false;
			}

			$total_campaigns         = wp_count_posts( 'ig_campaign' );
			$total_campaigns_publish = $total_campaigns->publish;

			if ( $total_campaigns_publish == 0 ) {
				return false;
			}
		}

		return $enable;
	}
}

add_filter( 'ig_can_ask_user_for_review', 'ig_can_ask_user_for_review', 50, 2 );

/**
 * Render Icegram-Email Subscribers merge feedback widget.
 *
 * @since 1.10.38
 */
function ig_render_iges_merge_feedback() {

	global $ig_feedback, $icegram;

	if ( is_admin() ) {

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! in_array( $screen->id, array( 'ig_campaign', 'ig_message', 'edit-ig_message', 'edit-ig_campaign' ), true ) ) {
			return false;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		$total_campaigns = wp_count_posts( 'ig_campaign' );

		$total_campaigns_publish = $total_campaigns->publish;

		if ( $total_campaigns_publish >= 1 ) {

			$event = 'poll.merge_iges';

			// If user has already given feedback on Email Subscribers page, don't ask them again
			$is_event_tracked = $ig_feedback->is_event_tracked( 'ig_es', $event );

			if ( $is_event_tracked ) {
				return;
			}

			$params = array(
				'type'              => 'poll',
				'title'             => __( 'Subscription forms and CTAs??', 'email-subscribers' ),
				'event'             => $event,
				'desc'              => '<div><p>You use <a href="https://wordpress.org/plugins/icegram" target="_blank"><b>Icegram</b></a> to show onsite campaigns like popups and action bars.</p> <p>Would you like us to include email campaigns in the plugin as well? This way you can <b>convert visitors to subscribers, drive traffic and run email marketing from a single plugin</b>.</p> <p>Why do we ask?</p> <p>Our <a href="https://wordpress.org/plugins/email-subscribers" target="_blank"><b>Email Subscribers</b></a> plugin already does email campaigns. We are thinking of merging Icegram & Email Subscribers into a single plugin.</p> <p><b>Will a comprehensive ConvertKit / MailChimp like email + onsite campaign plugin be useful to you?</b></p> </div>',
				'fields' => array(
					array(
						'type' => 'radio',
						'name' => 'poll_options',
						'label'	   => __( 'Yes', 'email-subscribers' ),
						'value'	=> 'yes',
						'required' => true,
					),
					array(
						'type' => 'radio',
						'name' => 'poll_options',
						'label'	   => __( 'No', 'email-subscribers' ),
						'value'	=> 'no',
					),
					array(
						'type' => 'textarea',
						'name' => 'details',
						'placeholder' => __( 'Additional feedback', 'email-subscribers' ),
						'value'  => '',
					),
				),
				'allow_multiple'    => false,
				'position'          => 'bottom-center',
				'width'             => 400,
				'delay'             => 2, // seconds
				'display_as'		=> 'popup',
				'confirmButtonText' => __( 'Send my feedback to <b>Icegram team</b>', 'email-subscribers' ),
				'show_once'         => true,
			);

			$icegram->render_feedback_widget( $params );
		}

	}
}

add_action( 'admin_footer', 'ig_render_iges_merge_feedback' );

/**
 * Can load sweetalert js file
 *
 * @param bool $load
 *
 * @return bool
 *
 * @since 1.10.38
 */
function ig_can_load_sweetalert_js( $load = false ) {

	$screen = get_current_screen();
	if ( in_array( $screen->id, array( 'ig_campaign', 'ig_message', 'edit-ig_message', 'edit-ig_campaign' ), true ) ) {
		return true;
	}

	return $load;
}

add_filter( 'ig_can_load_sweetalert_js', 'ig_can_load_sweetalert_js', 10, 1 );

if ( ! function_exists('ig_can_load_sweetalert_css') ) {
	/**
	 * Can load sweetalert css
	 *
	 * @param bool $load
	 *
	 * @return bool
	 *
	 * @since 
	 */
	function ig_can_load_sweetalert_css( $load = false ) {

		$screen = get_current_screen();
		if ( in_array( $screen->id, array( 'ig_campaign', 'ig_message', 'edit-ig_message', 'edit-ig_campaign' ), true ) ) {
			return true;
		}

		return $load;
	}
}

add_filter( 'ig_can_load_sweetalert_css', 'ig_can_load_sweetalert_css', 10, 1 );

if ( ! function_exists( 'ig_show_plugin_usage_tracking_notice' ) ) {

	/**
	 * Can we show tracking usage optin notice?
	 *
	 * @return bool
	 *
	 * 
	 */
	function ig_show_plugin_usage_tracking_notice( $enable ) {

		// Show notice only to IG dashboard page.
		
		$screen = get_current_screen() ;
		$screen_id = $screen -> id ;

		if( !empty( $screen_id ) && $screen_id === 'edit-ig_campaign') {
			$enable = true;
		}

		return $enable;
	}
}

add_filter( 'ig_show_plugin_usage_tracking_notice', 'ig_show_plugin_usage_tracking_notice' );

if ( ! function_exists( 'ig_add_escape_allowed_tags') ) {
	/**
	 * Add HTML tags to be excluded while escaping
	 *
	 * @return array $allowedtags
	 */
	function ig_add_escape_allowed_tags() {
		$context_allowed_tags = wp_kses_allowed_html( 'post' );
		$custom_allowed_tags  = array(
			'div'      => array(
				'x-data' => true,
				'x-show' => true,
			),
			'select'   => array(
				'class'    => true,
				'name'     => true,
				'id'       => true,
				'style'    => true,
				'title'    => true,
				'role'     => true,
				'data-*'   => true,
				'tab-*'    => true,
				'multiple' => true,
				'aria-*'   => true,
				'disabled' => true,
				'required' => 'required',
			),
			'optgroup' => array(
				'label' => true,
			),
			'option'   => array(
				'class'    => true,
				'value'    => true,
				'selected' => true,
				'name'     => true,
				'id'       => true,
				'style'    => true,
				'title'    => true,
				'data-*'   => true,
			),
			'input'    => array(
				'class'          => true,
				'name'           => true,
				'type'           => true,
				'value'          => true,
				'id'             => true,
				'checked'        => true,
				'disabled'       => true,
				'selected'       => true,
				'style'          => true,
				'required'       => 'required',
				'min'            => true,
				'max'            => true,
				'maxlength'      => true,
				'size'           => true,
				'placeholder'    => true,
				'autocomplete'   => true,
				'autocapitalize' => true,
				'autocorrect'    => true,
				'tabindex'       => true,
				'role'           => true,
				'aria-*'         => true,
				'data-*'         => true,
			),
			'label'    => array(
				'class' => true,
				'name'  => true,
				'type'  => true,
				'value' => true,
				'id'    => true,
				'for'   => true,
				'style' => true,
			),
			'form'     => array(
				'class'  => true,
				'name'   => true,
				'value'  => true,
				'id'     => true,
				'style'  => true,
				'action' => true,
				'method' => true,
				'data-*' => true,
			),
			'svg'      => array(
				'width'    => true,
				'height'   => true,
				'viewbox'  => true,
				'xmlns'    => true,
				'class'    => true,
				'stroke-*' => true,
				'fill'     => true,
				'stroke'   => true,
			),
			'path'     => array(
				'd'               => true,
				'fill'            => true,
				'class'           => true,
				'fill-*'          => true,
				'clip-*'          => true,
				'stroke-linecap'  => true,
				'stroke-linejoin' => true,
				'stroke-width'    => true,
				'fill-rule'       => true,
			),

			'main'     => array(
				'align'    => true,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => true,
				'aria-*'   => true,
				'class'    => true,
				'id'       => true,
				'style'    => true,
				'title'    => true,
				'role'     => true,
				'data-*'   => true,
			),
			'textarea' => array(
				'id' => true,
				'autocomplete' => true,
				'required'	   => 'required',
				'placeholder'  => true,
				'class'		   => true,
			),
			'style'    => array(),
			'link'     => array(
				'rel'   => true,
				'id'    => true,
				'href'  => true,
				'media' => true,
			),
			'a'        => array(
				'x-on:click' => true,
			),
			'polygon'  => array(
				'class'  => true,
				'points' => true,
			),
		);

		$allowedtags = array_merge_recursive( $context_allowed_tags, $custom_allowed_tags );

		return $allowedtags;
	}
}

add_filter( 'ig_escape_allowed_tags', 'ig_add_escape_allowed_tags' );

