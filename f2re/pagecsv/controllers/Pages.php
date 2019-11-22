<?php namespace F2re\Pagecsv\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

use Input;
use Flash;

use F2re\Pagecsv\Models\CSVProcess;

class Pages extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController',        'Backend\Behaviors\ReorderController'    ];
    // public $implement = [
    //     'Backend.Behaviors.ImportExportController',
    // ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
	// public $importExportConfig = 'config_import_export.yaml';
	
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('F2re.Pagecsv', 'main-menu-pages');
    }
    
    
    public function onUploadForm() //pop up
	{
	    $this->asExtension('FormController')->create();
	
	    return $this->makePartial('upload_form');
	}
	
	public function onUpload()
	{
		$result = CSVProcess::process( Input::file('uploadcsv')->getPathName() );
		
		
		Flash::success(
			"File uploaded! ".
			( $result['added']>0?"Added {$result['added']} pages ":'' ).
			( $result['updated']>0?"Updated {$result['updated']} pages ":'' ).
			( $result['deleted']>0?"Deleted {$result['deleted']} pages ":'' ) 
			) ;
		// return Redirect::back();
		return true;
	    // return $this->asExtension('FormController')->create_onSave();
	}
	
}
