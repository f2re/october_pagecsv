<?php namespace F2re\Pagecsv\Controllers;

use Illuminate\Routing\Controller;

use F2re\Pagecsv\Models\Pages;

class CSVproc extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Page CSV controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the sitemap.xml
    |
    */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }
    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function sitemap()
    {
    	$pages = Pages::all();
        return view( 'f2re.pagecsv::sitemap', [ 'pages'=>$pages ] );
    }
    
    	
    
}