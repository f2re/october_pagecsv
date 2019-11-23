<?php namespace F2re\Pagecsv\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateF2rePagecsvPages2 extends Migration
{
    public function up()
    {
        Schema::table('f2re_pagecsv_pages', function($table)
        {
            $table->dropColumn('deleted_at');
        });
    }
    
    public function down()
    {
        Schema::table('f2re_pagecsv_pages', function($table)
        {
            $table->timestamp('deleted_at')->nullable();
        });
    }
}
