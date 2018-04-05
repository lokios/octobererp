<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBackendUsers4 extends Migration  
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
            $table->string("gst_number")->nullable();
            
        });
    }
    
    public function down()
    {
    }
    

}