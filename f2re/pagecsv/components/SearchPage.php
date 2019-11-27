<?php namespace F2re\PageCSV\Components;

use Cms\Classes\ComponentBase;

use F2re\Pagecsv\Models\Pages;

class SearchPage extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'SearchPage Component ',
            'description' => 'Include search engine in page. Find pages loaded over plugin.'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    
    
	public function onSearch()
    {
    	$query = input('queryCsv');
    	$data['searchresult'] = Pages::where('title', 'like', "%{$query}%")->get();
    	$this->page['searchresult'] = $data['searchresult'];
    	// return [
	    //     '#request' => $this->renderPartial('searchresult',$data)
	    // ];
    }
}
