<?php namespace F2re\Pagecsv\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateF2rePagecsvPages extends Migration
{
    public function up()
    {
        Schema::create('f2re_pagecsv_pages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('slug');
            $table->text('title')->nullable();
            $table->text('metadescr')->nullable();
            $table->string('h1')->nullable();
            $table->text('content')->nullable();
            $table->string('category')->nullable();
            $table->string('option')->nullable();
            $table->text('customcontent')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('f2re_pagecsv_pages');
    }
}
