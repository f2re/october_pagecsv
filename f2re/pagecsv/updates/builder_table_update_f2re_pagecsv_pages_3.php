<?php namespace F2re\Pagecsv\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

use Illuminate\Support\Facades\DB;

class BuilderTableUpdateF2rePagecsvPages3 extends Migration
{
    public function up()
    {
        // Full Text Index
    	DB::statement('ALTER TABLE f2re_pagecsv_pages ADD FULLTEXT fulltexttitle_index (title)');
    }
    
    public function down()
    {
        
    }
}
