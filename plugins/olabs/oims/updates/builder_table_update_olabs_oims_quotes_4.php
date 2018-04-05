<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuotes4 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->string('status', 255)->nullable();
            $table->dropColumn('quotestatus_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->dropColumn('status');
            $table->integer('quotestatus_id')->nullable()->unsigned();
        });
    }
}
