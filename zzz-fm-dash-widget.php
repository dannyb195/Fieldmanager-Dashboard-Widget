<?php
/**
 * Fieldmanager extenstion to allow for dashboard widget support.
 *
 * @package Fieldmanager
 * @version 1.0.0-beta.2
 */

/*
Plugin Name: Fieldmanager Dash Widget Support
Plugin URI:
Description: Allows for dashboard widget support, a possible alternative to using a theme option page
Author: Dan Beil
Version: 0.1
Author URI: http://addactiondan.me
*/

if ( defined( 'FM_VERSION' ) && ! class_exists( 'FM_Dash_Widget' ) ) {



	class FM_Dash_Widget extends Fieldmanager_Context {

		public $widget_id;

		public $label;



		public function __construct( $widget_id, $label ) {

			echo 'get_option array<pre>';
			print_r( $_GET );
			echo '</pre>';

			$this->widget_id = $widget_id;
			$this->label = $label;
			if ( ! empty( $this->widget_id ) ) {
				add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
			}




		}

		public function return_html( $type, $name, $class = null ) {
			$widget = get_option( $this->widget_id );
			echo sprintf( '<input type="%s" name="%s[%s]" value="%s" />', esc_attr( $type ), esc_attr( $this->widget_id ), esc_attr( $name ), esc_attr( $widget[ $name ] ) );
		}



		public function add_dashboard_widget() {
			wp_add_dashboard_widget(
				$this->widget_id,
				$this->label,
				array( $this, 'render_dashboard_widget' ),
				array( $this, 'configure_dashboard_widget' )
			);
		}

		public function render_dashboard_widget() {
			// displaying the get_options for this widget
			// In a production envrio this would display options in a pretty way
			echo '<pre>';
			print_r( get_option( $this->widget_id ) );
			echo '</pre>';
		}

		public function configure_dashboard_widget() {

			$fm = new Fieldmanager_Textfield( 'test fm', array(
				'name' => 'test_fm_save',
			) );
			$this->return_html( $fm->field_class, $fm->name ); // this needs to use FM core rather than this function

			echo '<input type="hidden" name="' . $this->widget_id . '_fm_save_check" value="true" />';
			echo '<br /><hr />';

			// Creating array for saving so we dont save all $_POST data here
			if ( isset( $_POST[ $this->widget_id . '_fm_save_check' ] ) ) {
				update_option( $this->widget_id, $_POST[ $this->widget_id ] );
			}

		} // end configure_dashboard_widget

	} // end class

} // end FM check


new FM_Dash_Widget( 'test_id_etjdkf', 'Label' );

new FM_Dash_Widget( 'test_widget_2', 'second label' );