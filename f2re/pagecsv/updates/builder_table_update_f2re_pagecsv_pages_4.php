<?php namespace F2re\Pagecsv\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateF2rePagecsvPages4 extends Migration
{
    public function up()
    {
        Schema::table('f2re_pagecsv_pages', function($table)
        {
            $table->double('lat', 10, 0)->nullable();
            $table->double('lon', 10, 0)->nullable();
            $table->index(['lat','lon']);
        });
    }
    
    public function down()
    {
        Schema::table('f2re_pagecsv_pages', function($table)
        {
            $table->dropIndex(['lat','lon']);
            $table->dropColumn('lat');
            $table->dropColumn('lon');
        });
    }
}
