<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssetPurchases extends Migration
{
    public function up()
    {
        Schema::rename('olabs_oims_project_assets', 'olabs_oims_project_asset_purchases');
    }
    
    public function down()
    {
        Schema::rename('olabs_oims_project_asset_purchases', 'olabs_oims_project_assets');
    }
}
