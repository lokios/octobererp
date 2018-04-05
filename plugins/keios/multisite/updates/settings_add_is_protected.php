<?php namespace RainLab\User\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class SettingsAddIsProtected extends Migration
{
    public function up()
    {
        Schema::table('keios_multisite_settings', function ($table) {
            $table->boolean('is_protected')->default(false);
        });
    }

    public function down()
    {
        Schema::table('keios_multisite_settings', function ($table) {
            $table->dropColumn('is_protected');
        });
    }

}
