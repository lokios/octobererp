<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsBankAccounts extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_bank_accounts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('account_number');
            $table->string('bank_name');
            $table->string('status')->nullable();
            $table->string('address')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('bank_code')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_person')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_bank_accounts');
    }
}
