<?php

/**
 * undocumented class
 *
 * @package default
 * @author
 **/
class Test_Widget_2 {

	public function __construct() {
		add_action( 'init', array( $this, 'test_widget' ) );
	}

	/**
	 * This is what would be in the theme files
	 * Current limitation: we MUST use a group to avoid saving the entire $_POST object
	 */
	public function test_widget() {

		$name = 'meta_fields_3'; // uber important, used for the name of the group and the key for saving in wp_options

		$fm = new Fieldmanager_Group( array(
			'name'  => $name,
			'label' => 'Test widget 2 label',
			'children' => array(
				'text'         => new Fieldmanager_Textfield( 'Text Field', array() ),
				'autocomplete' => new Fieldmanager_Autocomplete( 'Autocomplete', array(
					'datasource' => new Fieldmanager_Datasource_Post(),
				) ),
				'media'        => new Fieldmanager_Media( 'Media File', array() ),
				'checkbox'     => new Fieldmanager_Checkbox( 'Checkbox', array() ),
				'radios'       => new Fieldmanager_Radios( 'Radio Buttons', array() ),
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

new Test_Widget_2();
