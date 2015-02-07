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
	 * Current limitation: does not support repeating fields due to the fact that you cannot set default values ( I think )
	 */
	public function test_widget() {

		$name = 'meta_fields'; // uber important, used for the name of the group and the key for saving in wp_options

		$values = get_option( $name );

		$months = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );

		$fm = new Fieldmanager_Group( array(
			'name'  => $name,
			'label' => 'Test widget label',
			'children' => array(
				'text'         => new Fieldmanager_Textfield( 'Text Field', array(
					'default_value' => $values['text'],
				) ),
				'autocomplete' => new Fieldmanager_Autocomplete( 'Autocomplete', array(
					'datasource' => new Fieldmanager_Datasource_Post(),
					'default_value' => $values['autocomplete'],
				) ),
				'local_data'   => new Fieldmanager_Autocomplete( 'Autocomplete without ajax', array(
					'datasource' => new Fieldmanager_Datasource( array( 'options' => $months ) ),
					'default_value' => $values['local_data'],
				) ),
				'textarea'     => new Fieldmanager_TextArea( 'TextArea', array(
					'default_value' => $values['textarea'],
				) ),
				'media'        => new Fieldmanager_Media( 'Media File', array(
					'default_value' => $values['media'],
				) ),
				'checkbox'     => new Fieldmanager_Checkbox( 'Checkbox', array(
					'default_value' => $values['checkbox'],
				) ),
				'radios'       => new Fieldmanager_Radios( 'Radio Buttons', array(
					'options' => array( 'One', 'Two', 'Three' ),
					'default_value' => $values['radios'],
				) ),
				'select'       => new Fieldmanager_Select( 'Select Dropdown', array(
					'options' => array( 'One', 'Two', 'Three' ),
					'default_value' => $values['select'],
				) ),
				'richtextarea' => new Fieldmanager_RichTextArea( 'Rich Text Area', array(
					'default_value' => $values['richtextarea'],
				) ),
				'repeat_text' => new Fieldmanager_Textfield( 'Repeatable', array(
					'limit' => 0,
				) ),
			)
		) );

		new FM_Dash_Widget( $fm );

	} // end test_widget

} // END class

new Test_Widget();
