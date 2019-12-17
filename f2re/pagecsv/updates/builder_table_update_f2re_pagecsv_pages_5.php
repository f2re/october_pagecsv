<?php namespace F2re\Pagecsv\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateF2rePagecsvPages4 extends Migration
{
    public function up()
    {
        Schema::table('f2re_pagecsv_pages', function($table)
        {
            $table->index('category');
        });
    }
    
    public function down()
    {
        Schema::table('f2re_pagecsv_pages', function($table)
        {
            $table->dropIndex('category');
        });
    }
}
