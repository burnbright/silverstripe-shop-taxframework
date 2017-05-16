<?php
class TaxedProductDecorator extends DataExtension{
	static $has_one = array(
		'TaxClass' => 'TaxClass',
	);

	function updateCMSFields(FieldList $fields){
		if($taxclasses = DataObject::get("TaxClass","","\"Name\" ASC")){
			$fields->addFieldsToTab("Root.Pricing", array(
				new DropdownField("TaxClassID","Tax Class",$taxclasses->map('ID','Name'))
			));
		}
	}

	/*
	 //this is done using the modifier
	function updateSellingPrice(&$price){
		if($taxclass = $this->owner->TaxClass()){
			$price += $taxclass->getTax($price); //TODO: specify address
		}
	}
	*/

}
