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
			//add tax to shipping via shipping framework modifier
			if(ClassInfo::exists("ShippingFrameworkModifier") && $shippingmod = $order->getModifier('ShippingFrameworkModifier')){
				$shippingclass = DataObject::get_one("TaxClass","LOWER(TRIM(\"Name\")) = 'shipping'");
				$taxclass = ($shippingclass) ? $shippingclass : $defaultclass;
				$value += $taxclass->getRate($address) * $shippingmod->Amount;
			}
		}
		return $value;
	}
	
}