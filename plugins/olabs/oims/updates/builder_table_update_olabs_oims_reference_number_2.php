<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsReferenceNumber2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_reference_number', function($table)
        {
            $table->renameColumn('type', 'reference_type');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_reference_number', function($table)
        {
            $table->renameColumn('reference_type', 'type');
        });
    }
}
