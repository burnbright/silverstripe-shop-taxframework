<?php

class TaxFrameworkModifier extends OrderModifier{
	
	public static $singular_name = "Tax";
	function i18n_singular_name() {
		return _t("TaxModifier.SINGULAR", self::$singular_name);
	}
	public static $plural_name = "Taxes";
	function i18n_plural_name() {
		return _t("TaxModifier.PLURAL", self::$plural_name);
	}
	
	/**
	 * TODO: reduce the number of database calls
	 */
	function value($incoming){
		$order = $this->Order();
		$value = 0;
		if($order && $address = $order->ShippingAddress()){
			$defaultclass = DataObject::get_one("TaxClass","\"Default\" = 1"); //get default rate
			//sum taxe rates
			foreach($order->Items() as $item){
				$taxclass = ($item->Product()->TaxClass()->exists()) ? $item->Product()->TaxClass() : $defaultclass;
				if($taxclass && $rate = $taxclass->getRate($address)){
					$value += $item->Total() * $rate; //tax is total x rate
				}
			}
		}
		return $value;
	}
	
}