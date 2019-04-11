<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsReferenceNumber extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_reference_number', function($table)
        {
            $table->renameColumn('reference_date', 'context_date');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_reference_number', function($table)
        {
            $table->renameColumn('context_date', 'reference_date');
        });
    }
}
