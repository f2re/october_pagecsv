<?php namespace F2re\PageCSV\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Http\Response;
use F2re\Pagecsv\Models\Pages;
use Input;

class GeoCode extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'GeoCode Component ',
            'description' => 'Search similar posts by geocode radius.'
        ];
    }

    public function defineProperties()
    {
        return [
        	'radius' => [
	             'title'             => 'Geocode search radius in km',
	             'description'       => 'Geocode search radius in km',
	             'default'           => 50,
	             'type'              => 'string',
	             'validationPattern' => '^[0-9]+$',
	             'validationMessage' => 'The Geocode search radius property can contain only numeric symbols',
	        ],
          'limit' => [
               'title'             => 'Records per query',
               'description'       => 'Records per query',
               'default'           => 5,
               'type'              => 'string',
               'validationPattern' => '^[0-9]+$',
               'validationMessage' => 'The Limit property can contain only numeric symbols',
          ],
          'category' => [
               'title'             => 'Category search',
               'description'       => 'Category search',
               'default'           => 'hotel',
               'type'              => 'string',
          ],
        ];
    }
    
    public function search(){
    	$_r   = (int)$this->property('radius');
    	$_id  = (int)$this->property('id');
      $_cat = $this->property('category');
    	$data = Pages::searchGeo( $_id, $_r, $this->property('limit'), $_cat);
      return $data;
    }

  public function onRender()
  {
    $this->page['geocoderesult'] = $this->search();
  }
    
	public function onRun()
  {
    $content= $this->renderPartial('@default.htm');
  }
    
}
