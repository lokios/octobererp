<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProductsUsersPrice extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_products_users_price', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            $table->integer('product_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->unique(['product_id', 'user_id']);
            
            $table->double('price')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_products_users_price');
    }

}