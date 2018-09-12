<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPaymentReceivables5 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_payment_receivables', function($table)
        {
            $table->integer('to_user_id')->default(0)->change();
            $table->integer('from_project_id')->default(0)->change();
            $table->integer('from_user_id')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_payment_receivables', function($table)
        {
            $table->integer('to_user_id')->default(null)->change();
            $table->integer('from_project_id')->default(null)->change();
            $table->integer('from_user_id')->default(null)->change();
        });
    }
}
