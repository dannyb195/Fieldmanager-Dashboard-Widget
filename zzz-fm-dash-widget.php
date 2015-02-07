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

	/**
	 * Extending Fieldmanager to allow for using in dashboard widgets
	 * Stores data in wp_options->FM Group->name ( must use a group )
	 * Usage example can be found in test-widet.php
	 */
	class FM_Dash_Widget extends Fieldmanager_Context_Storable {

		public $fm;

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
		public function __construct( $field ) {

			$this->fm = $field; // for $this->render_field which checks $this->fm
			$this->widget_id = $field->name;
			$this->label = $field->label;
			if ( ! empty( $this->widget_id ) ) {
				add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
			}
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
			echo 'get option<pre>';
			print_r( get_option( $this->widget_id ) );
			echo '</pre>';

		}

		/**
		 * The config screen for the widget
		 * @return [type] [description]
		 */
		public function configure_dashboard_widget() {
			// outputting our field group
			$values = get_option( $this->widget_id );
			$this->render_field( array( 'data' => $values ) );

			// checking to make sure we are saving our widget
			echo '<input type="hidden" name="' . $this->widget_id . '_fm_save_check" value="true" />';
			echo '<br /><hr />';

			// Using the $field->name to distinguish what should be saved
			// Looping over $_POST to remove empty repeater fields as they something save empty ones
			if ( isset( $_POST[ $this->widget_id . '_fm_save_check' ] ) ) {
				$empty_check = $_POST[ $this->widget_id ];
				$save_array = array();
				foreach ($empty_check as $parent_key => $parent_value) {
					$save_array[ $parent_key ] = $parent_value;
					if ( is_array( $parent_value ) ) {
						$save_array[ $parent_key ] = array();
						foreach ( $parent_value as $child_key => $child_value) {
							if ( ! empty( $child_value ) ) {
								$save_array[ $parent_key ][ $child_key ] = $child_value;
							}
						}
					}
				}
				// saving our FM group data in wp_options
				update_option( $this->widget_id, $save_array );
			}
		} // end configure_dashboard_widget

		/**
		 * Get option.
		 *
		 * @see get_option().
		 */
		protected function get_data( $data_id, $option_name, $single = false ) {
			return get_option( $option_name, null );
		}

		/**
		 * Add option.
		 *
		 * @see add_option().
		 */
		protected function add_data( $data_id, $option_name, $option_value, $unique = false ) {
			return add_option( $option_name, $option_value, '', $this->wp_option_autoload ? 'yes' : 'no' );
		}

		/**
		 * Update option.
		 *
		 * @see update_option().
		 */
		protected function update_data( $data_id, $option_name, $option_value, $option_prev_value = '' ) {
			return update_option( $option_name, $option_value );
		}

		/**
		 * Delete option.
		 *
		 * @see delete_option().
		 */
		protected function delete_data( $data_id, $option_name, $option_value = '' ) {
			return delete_option( $option_name, $option_value );
		}

	} // end class

	// including the files that represents theme level code, i.e. what we just build all ^ that for
	include( 'test-widget.php' );
	include( 'test-widget-2.php' );

} // end FM check
