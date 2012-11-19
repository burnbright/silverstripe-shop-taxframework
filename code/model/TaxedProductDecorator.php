<?php

class TaxedProductDecorator extends DataObjectDecorator{
	
	function extraStatics(){
		return array(
			'has_one' => array(
				'TaxClass' => 'TaxClass'
			)
		);
	}
	
	function updateCMSFields($fields){
		if($taxclasses = DataObject::get("TaxClass","","\"Name\" ASC")){
			$fields->addFieldsToTab("Root.Content.Pricing", array(
				new DropdownField("TaxClass","Tax Class",$taxclasses->map('ID','Name'))	
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