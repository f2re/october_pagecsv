<?php namespace F2re\Pagecsv\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateF2rePagecsvPages extends Migration
{
    public function up()
    {
        Schema::table('f2re_pagecsv_pages', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('f2re_pagecsv_pages', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
    }
}
