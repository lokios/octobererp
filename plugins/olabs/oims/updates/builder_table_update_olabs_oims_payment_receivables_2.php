<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPaymentReceivables2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_payment_receivables', function($table)
        {
            $table->decimal('amount', 12, 2)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_payment_receivables', function($table)
        {
            $table->decimal('amount', 10, 0)->change();
        });
    }
}
