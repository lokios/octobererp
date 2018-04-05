<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsEmployeeTypes extends Migration
{
    public function up()
    {
        Schema::rename('olabs_oims_employee_type', 'olabs_oims_employee_types');
    }
    
    public function down()
    {
        Schema::rename('olabs_oims_employee_types', 'olabs_oims_employee_type');
    }
}
