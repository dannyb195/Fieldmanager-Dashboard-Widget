<?php
/**
 * Fieldmanager extenstion to allow for dashboard widget support.
 *
 * @package Fieldmanager
 * @version 0.1
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

		/**
		 * [$widget_id description]
		 * @var [type]
		 */
		public $widget_id;

		/**
		 * [$label description]
		 * @var [type]
		 */
		public $label;

		/**
		 * [__construct description]
		 * @param [type] $widget_id [description]
		 * @param [type] $label     [description]
		 */
		public function __construct( $widget_id, $label ) {
			$this->widget_id = $widget_id;
			$this->label = $label;
			if ( ! empty( $this->widget_id ) ) {
				add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
			}
		}

		/**
		 * [return_html description]
		 * @param  [type] $type  [description]
		 * @param  [type] $name  [description]
		 * @param  [type] $class [description]
		 * @return [type]        [description]
		 */
		public function return_html( $type, $name, $class = null ) {
			$widget = get_option( $this->widget_id );
			echo sprintf( '<input type="%s" name="%s[%s]" value="%s" />', esc_attr( $type ), esc_attr( $this->widget_id ), esc_attr( $name ), esc_attr( $widget[ $name ] ) );
		}

		/**
		 * [add_dashboard_widget description]
		 */
		public function add_dashboard_widget() {
			wp_add_dashboard_widget(
				$this->widget_id,
				$this->label,
				array( $this, 'render_dashboard_widget' ),
				array( $this, 'configure_dashboard_widget' )
			);
		}

		/**
		 * [render_dashboard_widget description]
		 * @return [type] [description]
		 */
		public function render_dashboard_widget() {
			// displaying the print_r of get_options for this widget
			// In a production envrio this would display options in a pretty way
			echo '<pre>';
			print_r( get_option( $this->widget_id ) );
			echo '</pre>';
		}

		/**
		 * [configure_dashboard_widget description]
		 * @return [type] [description]
		 */
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


new FM_Dash_Widget( 'test_id_1', __( 'Label', 'textdomain' ) );

new FM_Dash_Widget( 'test_widget_2', __( 'second label', 'textdomain' ) );
