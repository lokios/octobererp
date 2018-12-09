<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuotes17 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->string('tax_method')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->dropColumn('tax_method');
        });
    }
}
