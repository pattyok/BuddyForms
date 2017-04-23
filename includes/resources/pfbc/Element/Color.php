<?php

/**
 * Class Element_Color
 */
class Element_Color extends Element_Textbox {
	/**
	 * @var array
	 */
	protected $_attributes = array( "type" => "color" );

	public function render() {

		echo 'KONRAD';
		$this->_attributes["pattern"] = "#[a-g0-9]{6}";
		$this->_attributes["title"]   = "6-digit hexidecimal color (e.g. #000000)";
		$this->validation[]           = new Validation_RegExp( "/" . $this->_attributes["pattern"] . "/", "Error: The %element% field must contain a " . $this->_attributes["title"] );
		parent::render();
	}
}
