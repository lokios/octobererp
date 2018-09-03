<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsVoucherProducts extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_voucher_products', function($table)
        {
            $table->integer('supplier_id')->nullable();
            $table->increments('id')->unsigned(false)->change();
            $table->renameColumn('user_id', 'employee_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_voucher_products', function($table)
        {
            $table->dropColumn('supplier_id');
            $table->increments('id')->unsigned()->change();
            $table->renameColumn('employee_id', 'user_id');
        });
    }
}
