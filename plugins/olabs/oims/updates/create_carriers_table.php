<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCarriersTable extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_carriers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            $table->string('title')->nullable();
            $table->boolean('active')->nullable();
            
            $table->string('transit_time')->nullable();
            $table->integer('speed_grade')->nullable();
            $table->string('tracking_url')->nullable();

            $table->boolean('free_shipping')->nullable();
            $table->integer('tax_id')->nullable();
            
            $table->integer('billing')->nullable(); // 1-total price, 2-weight
            
            $table->text('billing_total_price')->nullable();
            $table->text('billing_weight')->nullable();
            
            $table->double('maximum_package_width')->nullable();
            $table->double('maximum_package_height')->nullable();
            $table->double('maximum_package_depth')->nullable();
            $table->double('maximum_package_weight')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_carriers');
    }

}
