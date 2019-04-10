<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProducts4 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_products', function($table)
        {
            $table->string('tax_code')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_products', function($table)
        {
            $table->dropColumn('tax_code');
        });
    }
}
