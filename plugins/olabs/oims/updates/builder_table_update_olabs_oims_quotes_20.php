<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuotes20 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->text('meta')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->dropColumn('meta');
        });
    }
}
