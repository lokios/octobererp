<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsUnits2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_units', function($table)
        {
            $table->integer('updated_by')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_units', function($table)
        {
            $table->integer('updated_by')->nullable(false)->change();
        });
    }
}
