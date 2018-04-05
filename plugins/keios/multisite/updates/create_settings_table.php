<?php namespace Keios\Multisite\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateSettingsTable
 * @package Keios\Multisite\Updates
 */
class CreateSettingsTable extends Migration
{

    public function up()
    {
        Schema::create('keios_multisite_settings', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('domain');
            $table->text('theme');
            $table->boolean('is_protected')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keios_multisite_settings');
    }

}
