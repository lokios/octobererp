<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBackendUsers extends Migration  
{
    public function up()
    {
//        if (Schema::hasColumns('backend_users', [
//            "address",
//            "address_2",
//            "postcode",
//            "city",
//            "country",
//            // Contact
//            "contact_email",
//            "contact_phone",
//            ])) 
//        {
//            return;
//        }
        Schema::table('backend_users', function($table)
        {
            // Delivery address
            $table->string("address")->nullable();
            $table->string("address_2")->nullable();
            $table->string("postcode")->nullable();
            $table->string("city")->nullable();
            $table->string("country")->nullable();
            
            // Contact
            $table->string("contact_email")->nullable();
            $table->string("contact_phone")->nullable();   
        });
    }
    
    public function down()
    {
    }
    

}