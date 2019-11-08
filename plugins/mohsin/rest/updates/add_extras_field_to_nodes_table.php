<?php namespace Mohsin\Rest\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddExtrasFieldToNodesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('mohsin_rest_nodes')) {
            Schema::table('mohsin_rest_nodes', function (Blueprint $table) {
                $table->string('extras')->after('is_disabled')->default('{}');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('mohsin_rest_nodes')) {
            Schema::table('mohsin_rest_nodes', function (Blueprint $table) {
                $table->dropColumn('extras');
            });
        }
    }
}
