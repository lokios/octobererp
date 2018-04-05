<?php

namespace Olabs\Tasks;

use System\Classes\PluginBase;

//use Olabs\Tasks\Models\TaskLogs;
//use Olabs\Tasks\Models\Tasks;

class Plugin extends PluginBase {

    public function registerComponents() {
        
    }

    public function registerSettings() {
        
    }

    public function registerSchedule($schedule) {
        try {
            $tasks = \Olabs\Tasks\Models\Tasks::where(['status' => 'L'])->get();
            foreach ($tasks as $key => $task) {
                $schedule->call(function ()use($task) {

                    $task->run();
                })->{$task->schedule}(); //->everyMinute();
            }

            $schedule->call(function () {

                $t = new \Olabs\Tasks\Models\TaskLogs();
                $t->name = 'daily task';
                $t->save();
            })->daily();

            $schedule->call(function () {

                $t = new \Olabs\Tasks\Models\TaskLogs();
                $t->name = 'everyFiveMinutes task';
                $t->save();
            })->everyFiveMinutes();

            $schedule->call(function () {

                $t = new \Olabs\Tasks\Models\TaskLogs();
                $t->name = 'everyThirtyMinutes task';
                $t->save();

                Mail::send([
                    'text' => 'This is plain text',
                    'html' => '<strong>This is HTML</strong>',
                    'raw' => true
                        ], function($message) {

                    $message->from('us@example.com', 'October');
                    $message->to('foo@example.com')->cc('bar@example.com');
                });
            })->everyThirtyMinutes();
        } catch (\Exception $e) {
            
        }
    }

    public function registerPermissions() {
        return [
            'olabs.tasks.manage' => ['tab' => 'Tasks', 'label' => 'Manage tasks and schedules'],
        ];
    }

    public function registerNavigation() {
        return [
            'reports' => [
                'label' => 'Tasks',
                'url' => \Backend::url('olabs/tasks/tasks'),
                'icon' => 'icon-file',
                'permissions' => ['olabs.tasks.manage'],
                'order' => 500,
            ]
        ];
    }

}
