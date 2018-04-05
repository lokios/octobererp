<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRainlabExtendUsers extends Migration
{
    public function up()
    {
        if (Schema::hasColumns('users', [
            "oims_ds_first_name",
            "oims_ds_last_name",
            "oims_ds_address",
            "oims_ds_address_2",
            "oims_ds_postcode",
            "oims_ds_city",
            "oims_ds_country",
            "oims_ds_county",
            // Invoice address
            "oims_is_first_name",
            "oims_is_last_name",
            "oims_is_address",
            "oims_is_address_2",
            "oims_is_postcode",
            "oims_is_city",
            "oims_is_country",
            "oims_is_county",            
            
            // Contact
            "oims_contact_email",
            "oims_contact_phone",
            ])) 
        {
            return;
        }
        Schema::table('users', function($table)
        {
            // Delivery address
            $table->string("oims_ds_first_name")->nullable();
            $table->string("oims_ds_last_name")->nullable();
            $table->string("oims_ds_address")->nullable();
            $table->string("oims_ds_address_2")->nullable();
            $table->string("oims_ds_postcode")->nullable();
            $table->string("oims_ds_city")->nullable();
            $table->string("oims_ds_country")->nullable();
            $table->string("oims_ds_county")->nullable();
            // Invoice address
            $table->string("oims_is_first_name")->nullable();
            $table->string("oims_is_last_name")->nullable();
            $table->string("oims_is_address")->nullable();
            $table->string("oims_is_address_2")->nullable();
            $table->string("oims_is_postcode")->nullable();
            $table->string("oims_is_city")->nullable();
            $table->string("oims_is_country")->nullable();
            $table->string("oims_is_county")->nullable();            
            
            // Contact
            $table->string("oims_contact_email")->nullable();
            $table->string("oims_contact_phone")->nullable();   
        });
    }
    
    public function down()
    {
    }
    

}