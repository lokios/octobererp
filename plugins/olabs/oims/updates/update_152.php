<?php namespace Olabs\Oims\Updates;

use Schema;
use DB;
use October\Rain\Database\Updates\Migration;

class Update_152 extends Migration
{

    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // property options
        Schema::table('olabs_oims_property_options', function ($table) {
            $table->integer('property_id')->unsigned()->change();
            $table->foreign('property_id')->references('id')->on('olabs_oims_properties')->onDelete('cascade');
        });
        
        // products options
        Schema::table('olabs_oims_products_options', function ($table) {
            $table->foreign('product_id')->references('id')->on('olabs_oims_products')->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('olabs_oims_property_options')->onDelete('cascade');
        });
        
        // products properties
        Schema::table('olabs_oims_products_properties', function ($table) {
            $table->foreign('product_id')->references('id')->on('olabs_oims_products')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('olabs_oims_properties')->onDelete('cascade');
        });
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
    }

}
