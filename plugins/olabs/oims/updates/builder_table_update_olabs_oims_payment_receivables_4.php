<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPaymentReceivables4 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_payment_receivables', function($table)
        {
            $table->string('narration')->nullable();
            $table->renameColumn('note', 'description');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_payment_receivables', function($table)
        {
            $table->dropColumn('narration');
            $table->renameColumn('description', 'note');
        });
    }
}
