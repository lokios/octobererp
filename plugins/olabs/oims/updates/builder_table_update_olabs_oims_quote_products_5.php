<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuoteProducts5 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quote_products', function($table)
        {
            $table->text('description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quote_products', function($table)
        {
            $table->dropColumn('description');
        });
    }
}
