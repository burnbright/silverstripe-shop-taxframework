<?php
class TaxRate extends RegionRestriction{
	
	static $db = array(
		'Rate' => 'Percentage',
		'Priority' => 'Int',
		'Name' => 'Varchar', //eg: 'gst'
		'Compounding' => 'Boolean'
	);
	
	static $has_one = array(
		'TaxClass' => 'TaxClass'
	);
	
	static $defaults = array(
		'Name' => 'TAX'	
	);
	
	/**
	 * Prevent empty defaults
	 */
	function onBeforeWrite(){
		foreach(self::$defaults as $field => $value){
			if(empty($this->$field)){
				$this->$field = $value;
			}
		}
		parent::onBeforeWrite();
	}
	
}