<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuotes19 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->text('operational_terms')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->dropColumn('operational_terms');
        });
    }
}
