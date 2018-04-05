<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssets3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_assets', function($table)
        {
            $table->renameColumn('condition', 'product_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_assets', function($table)
        {
            $table->renameColumn('product_id', 'condition');
        });
    }
}
