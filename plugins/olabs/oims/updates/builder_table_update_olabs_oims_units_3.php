<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsUnits3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_units', function($table)
        {
            $table->text('conversion_meta')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_units', function($table)
        {
            $table->dropColumn('conversion_meta');
        });
    }
}
