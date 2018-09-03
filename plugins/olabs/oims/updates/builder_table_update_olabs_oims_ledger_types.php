<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsLedgerTypes extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_ledger_types', function($table)
        {
            $table->string('type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_ledger_types', function($table)
        {
            $table->dropColumn('type');
        });
    }
}
