<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsStatuses extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_statuses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        // Order statuses
        DB::statement("
            INSERT INTO `olabs_oims_statuses` (`id`, `name`, `slug`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
                (1, 'New', 'new', 1, NULL, NULL, '2017-03-12 02:50:20', '2017-03-12 02:50:20', NULL),
                (2, 'Submitted', 'submitted', 1, NULL, NULL, '2017-03-12 02:55:34', '2017-03-12 02:55:34', NULL),
                (3, 'Approved', 'approved', 1, NULL, NULL, '2017-03-12 02:56:05', '2017-03-12 02:56:05', NULL),
                (4, 'Rejected', 'rejected', 1, NULL, NULL, '2017-03-12 02:58:37', '2017-03-12 02:58:37', NULL);"
                );
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_statuses');
    }
}
