<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProductsTable extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('ean_13')->nullable();
            $table->string('barcode')->nullable();
            $table->boolean('active')->nullable();
            $table->boolean('on_sale')->nullable();

            $table->boolean('visibility')->nullable();
            $table->boolean('available_for_order')->nullable();
            $table->boolean('show_price')->nullable();
            $table->integer('condition')->nullable();
            
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            
            $table->integer('brand_id')->nullable();
            
            
            $table->double('pre_tax_wholesale_price')->nullable();
            $table->double('pre_tax_retail_price')->nullable();
            $table->integer('tax_id')->nullable();
            $table->double('retail_price_with_tax')->nullable();
            
            

            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();            
            
            // relation - categories
            $table->integer('default_category_id')->nullable();
            
            // Shipping
            $table->double('package_width')->nullable();
            $table->double('package_height')->nullable();
            $table->double('package_depth')->nullable();
            $table->double('package_weight')->nullable();
            $table->double('additional_shipping_fees')->nullable();
            // relation -  Forbidden carriers
            
            // Quantities
            $table->integer('quantity')->unsigned();
            $table->integer('when_out_of_stock')->nullable();
            $table->integer('minimum_quantity')->unsigned();
            $table->timestamp('availability_date')->nullable();
            
            $table->text('customization')->nullable();
            
            // Accessories - products
            // Featured - products
            // Images
            // Attachement
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_products');
    }

}
