<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTenantContentCategories extends Migration
{
    public function up()
    {
        Schema::table('olabs_tenant_content_categories', function($table)
        {
            $table->increments('id')->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_tenant_content_categories', function($table)
        {
            $table->integer('id')->change();
        });
    }
}
