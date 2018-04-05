<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectWorkProducts extends Migration
{
    public function up()
    {
        Schema::rename('olabs_oims_project_work_materials', 'olabs_oims_project_work_products');
    }
    
    public function down()
    {
        Schema::rename('olabs_oims_project_work_products', 'olabs_oims_project_work_materials');
    }
}
