<?php namespace F2re\Pagecsv;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return [
	        'F2re\Pagecsv\Components\SearchPage'  => 'SearchPageCSV',
          'F2re\Pagecsv\Components\GeoCode'  => 'GeoCodeCSV',
	    ];
    }

    public function registerSettings()
    {
    }
}
