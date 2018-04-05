
Intro:
=======
The tasks is October plugin to simplify tasks scheduling. 
Some of the usecases could be:
- Send daily mails for reportings
- Send newsletters
- Schedule based cleanups/ reports generations

Tasks:
=============
Cuurent supported tasks type are Email tasks
All tasks with status Live are peridically scheduled and there logs are maintained in TasksLogs table/admin

TODO:
add other types of tasks as per customer feature requests


Setups:
Install plugin
php artisan plugin:refresh olabs.tasks

Add the scheduler to /etc/crontab & restart cron

* * * * *  root  php <project_root>/artisan schedule:run >> /dev/null 2>&1

Tasks:
=====
Add the tasks via Backend tasks scheduling:
http://<xyz>/backend/olabs/tasks/tasklogs


Tasks Logs:
===========
Logs of tasks run states shall be displayed via Tasks Logs interface

http://<xyz>/backend/olabs/tasks/tasklogs








