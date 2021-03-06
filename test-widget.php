<?php

/**
 * undocumented class
 *
 * @package default
 * @author
 **/
class Test_Widget {

	public function __construct() {
		add_action( 'init', array( $this, 'test_widget' ) );
	}

	/**
	 * This is what would be in the theme files
	 * Current limitation: we MUST use a group to avoid saving the entire $_POST object
	 */
	public function test_widget() {

		$name = 'meta_fields'; // uber important, used for the name of the group and the key for saving in wp_options

		$months = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );

		$fm = new Fieldmanager_Group( array(
			'name'  => $name,
			'label' => 'Test widget label',
			'children' => array(
				'text'         => new Fieldmanager_Textfield( 'Text Field', array() ),
				'autocomplete' => new Fieldmanager_Autocomplete( 'Autocomplete', array(
					'datasource' => new Fieldmanager_Datasource_Post(),
				) ),
				'local_data'   => new Fieldmanager_Autocomplete( 'Autocomplete without ajax', array(
					'datasource' => new Fieldmanager_Datasource( array( 'options' => $months ) ),
				) ),
				'textarea'     => new Fieldmanager_TextArea( 'TextArea', array() ),
				'media'        => new Fieldmanager_Media( 'Media File', array() ),
				'checkbox'     => new Fieldmanager_Checkbox( 'Checkbox', array() ),
				'radios'       => new Fieldmanager_Radios( 'Radio Buttons', array(
					'options' => array( 'One', 'Two', 'Three' ),
				) ),
				'select'       => new Fieldmanager_Select( 'Select Dropdown', array(
					'options' => array( 'One', 'Two', 'Three' ),
				) ),
				'richtextarea' => new Fieldmanager_RichTextArea( 'Rich Text Area', array() ),
				'repeat_text' => new Fieldmanager_Textfield( 'Repeatable', array(
					'limit' => 0,
				) ),
			)
		) );

		new FM_Dash_Widget( $fm );

	} // end test_widget

} // END class

new Test_Widget();
