<?php

class PopulateTaxClassesTask extends BuildTask{
	
	protected $title = "Populate Tax Classes";
	protected $description = "Creates tax classes";
	
	function run($request = null){
		if(!DataObject::get_one('TaxClass')){
			$fixture = new YamlFixture('shop_taxframework/tests/fixtures/TaxClasses.yml');
			$fixture->saveIntoDatabase();
			DB::alteration_message('Created tax classes', 'created');
		}else{
			DB::alteration_message('Some tax classes already exist. None were created.');
		}
	}
	
}

class PopulateShopTaxClassesTask extends Extension{
	
	function beforePopulate(){
		$task = new PopulateTaxClassesTask();
		$task->run();
	}
	
}