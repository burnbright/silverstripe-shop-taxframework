<?php

class TaxAdmin extends ModelAdmin{
	
	static $url_segment = "tax";
	static $menu_title = "Tax";

	static $managed_models = array(
		"TaxClass"
	);
	
}