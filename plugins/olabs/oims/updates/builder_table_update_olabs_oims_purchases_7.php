<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPurchases7 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->integer('project_book_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->dropColumn('project_book_id');
        });
    }
}
