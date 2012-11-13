<?php
class TaxClassTest extends SapphireTest{
	
	static $fixture_file = array(
		'shop/tests/fixtures/dummyproducts.yml',
		'shop/tests/fixtures/Addresses.yml',
		'shop_taxframework/tests/fixtures/TaxClasses.yml'
	);
	
	function testTaxRates(){
		$producttaxclass = $this->objFromFixture("TaxClass", "products");
		$groceriestaxclass = $this->objFromFixture("TaxClass", "groceries");
		
		$us_arizona = $this->objFromFixture("Address", "aus85728");
		$this->assertEquals($producttaxclass->getRate($us_arizona),0.066); //6.6%
		
		//test other classes
		$this->assertEquals($groceriestaxclass->getRate($us_arizona),0); //not charged tax
		
		//test specificity
		$anz1010 = $this->objFromFixture("Address", "anz1010");
		$this->assertEquals($producttaxclass->getRate($anz1010),0.15); //15%
		
		$wnz6012 = $this->objFromFixture("Address", "wnz6012");
		$this->assertEquals($producttaxclass->getRate($wnz6012),0.50); //50%
		
	}
	
	/*function testTaxFrameworkModifier(){
		
	}*/
	
}