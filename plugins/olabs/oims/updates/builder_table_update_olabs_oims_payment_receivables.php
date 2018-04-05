<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPaymentReceivables extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_payment_receivables', function($table)
        {
            $table->string('received_from')->nullable();
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_payment_receivables', function($table)
        {
            $table->dropColumn('received_from');
            $table->increments('id')->unsigned()->change();
        });
    }
}
