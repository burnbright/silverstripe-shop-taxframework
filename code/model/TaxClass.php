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
