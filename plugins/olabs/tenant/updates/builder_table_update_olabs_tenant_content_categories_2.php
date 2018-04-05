<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTenantContentCategories2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_tenant_content_categories', function($table)
        {
            $table->text('app')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_tenant_content_categories', function($table)
        {
            $table->dropColumn('app');
        });
    }
}
