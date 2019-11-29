<?php namespace F2re\PageCSV\Components;

use Cms\Classes\ComponentBase;

use F2re\Pagecsv\Models\Pages;
use Input;

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
        return [
        	'pagination' => [
	             'title'             => 'Per page',
	             'description'       => 'items per page',
	             'default'           => 10,
	             'type'              => 'string',
	             'validationPattern' => '^[0-9]+$',
	             'validationMessage' => 'The Max Items property can contain only numeric symbols',
	        ],
        ];
    }
    
    public function search(){
    	$query = input('queryCsv');
    	
    	$data = Pages::where('title', 'like', "%{$query}%")->queryPaginate([
            'page'    => $this->property('pageNumber'),
            'perPage' => $this->property('pagination'),
        ]);
        return $data;
    }
    
	public function onSearch()
    {

    	$this->page['searchresult'] = $this->search();
    	
    	if (1 < $this->page['searchresult']->lastPage()) {
            $more_link = $this->renderPartial('@_morelink.htm', ['pageNumber' => 1]);
        } else {
            $more_link = ''; // если мы достигли последней страницы, кнопка больше не нужна
        }
    	return [
	        '#request' => $this->renderPartial('@_list.htm'),
	        '#load-more-button' => $more_link,
	    ];
    }
    
    /**
     * Request while typing search
     **/
    public function onType()
    {
    	$this->page['searchresult'] = $this->search();
    	
    	return [
	        '#request' => $this->renderPartial('@_list.htm'),
	    ];
    }
    
    /*
     * Данная функция вызывается по клику на кнопку "Загрузить ещё"
     */
    public function onLoadMore()
    {
        // получаем номер страницы
        $pageNumber = Input::get('page') + 1;

        // выставляем номер страницы и готовим данные
        $this->setProperty('pageNumber', $pageNumber);
        
        $this->page['searchresult'] = $this->search();

        // if ($pageNumber < 10) {
        if ($pageNumber < $this->page['searchresult']->lastPage()) {
            $more_link = $this->renderPartial('@_morelink.htm', ['pageNumber' => $pageNumber]);
        } else {
            $more_link = ''; // если мы достигли последней страницы, кнопка больше не нужна
        }

        return [
            // если перед селектором стоит @, новое содержимое будет добавляться
            // в конец, а не заменять старое
            '@#result'            => $this->renderPartial('@_list.htm'),
            '#load-more-button' => $more_link,
        ];
    }
}
