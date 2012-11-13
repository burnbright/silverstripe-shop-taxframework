<?php

class TaxClass extends DataObject{
	
	static $db = array(
		'Name' => 'Varchar',
		'Default' => 'Boolean'
	);
	
	static $has_many = array(
		'TaxRates' => 'TaxRate'
	);
	
	static $summary_fields = array(
		'Name',
		'Default'
	);
	
	function getCMSFields(){
		$fields = parent::getCMSFields();
		$fieldList = array_merge(RegionRestriction::$field_labels,array(
			'Rate' => 'Rate',
			'Name' => 'Name',
			//'Priority' => 'Priority',
			//'Compounding' => 'Compounding'
		));
		$fieldTypes = array_merge(RegionRestriction::get_table_field_types(),array(
			'Rate' => 'TextField',
			'Name' => 'TextField',
			//'Priority' => 'TextField',
			//'Compounding' => 'CheckboxField'
		));
		$fields->fieldByName("Root")->removeByName('TaxRates'); //remove tax rates tab
		if($this->isInDB()){
			$tablefield = new TableField("TaxRates", "TaxRate", $fieldList, $fieldTypes);
			$tablefield->setCustomSourceItems($this->TaxRates());
			$fields->addFieldsToTab("Root.Main", array(
				new LabelField("TaxRatesHelp", "Enter tax class rates for specific regions. Rates should be entered in decimal form, for example 0.05 = 5%."),
				$tablefield
			));
		}
		return $fields;
	}
	
	static function get_by_address(Address $address){
		$where = RegionRestriction::address_filter($address);
		$join = "INNER JOIN \"TaxRate\" ON \"TaxClass\".\"ID\" = \"TaxRate\".\"TaxClassID\" ";
		return DataObject::get("TaxClass",$where, $sort = "", $join);		
	}
	
	function getRate($address = null){
		if(!$address){
			$address = singleton('Address');
		}
		$where = array(
			"\"TaxRate\".\"TaxClassID\" = {$this->ID}",
			RegionRestriction::address_filter($address)
		);
		$sort = implode(', ',array(
			RegionRestriction::wildcard_sort("PostalCode"),
			RegionRestriction::wildcard_sort("City"),
			RegionRestriction::wildcard_sort("State"),
			RegionRestriction::wildcard_sort("Country"),
			"\"Rate\" ASC"
		));
		if($rate = DataObject::get_one("TaxRate","(".implode(") AND (",$where).")",true,$sort)){
			return $rate->Rate;
		}
		return 0;
	}
	
	function getTax($value){
		return $value * $this->getRate();
	}
	
	function onBeforeWrite(){
		parent::onBeforeWrite();
		if($this->Default){
			DB::query("UPDATE \"TaxClass\" SET \"Default\" = 0"); //clear any other default
		}
	}
	
}