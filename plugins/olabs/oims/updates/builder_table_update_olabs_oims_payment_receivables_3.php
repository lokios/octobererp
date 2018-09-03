<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPaymentReceivables3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_payment_receivables', function($table)
        {
            $table->integer('to_project_id')->nullable();
            $table->integer('to_user_id')->nullable();
            $table->integer('from_project_id')->nullable();
            $table->integer('from_user_id')->nullable();
            $table->string('to_approval')->nullable();
            $table->string('from_approval')->nullable();
            $table->renameColumn('received_from', 'payment_type');
            $table->dropColumn('project_id');
            $table->dropColumn('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_payment_receivables', function($table)
        {
            $table->dropColumn('to_project_id');
            $table->dropColumn('to_user_id');
            $table->dropColumn('from_project_id');
            $table->dropColumn('from_user_id');
            $table->dropColumn('to_approval');
            $table->dropColumn('from_approval');
            $table->renameColumn('payment_type', 'received_from');
            $table->integer('project_id')->nullable();
            $table->integer('user_id')->nullable();
        });
    }
}
