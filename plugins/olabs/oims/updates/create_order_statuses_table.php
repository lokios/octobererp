<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateOrderStatusesTable extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_order_statuses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            $table->string('title')->nullable();
            $table->string('color')->nullable();
            $table->boolean('active')->nullable();
            
            $table->boolean('send_email_to_customer')->nullable();
            $table->boolean('attach_invoice_pdf_to_email')->nullable();
            
            $table->string('mail_template_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_order_statuses');
    }

}
