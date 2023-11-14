<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetTaskRemainder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:taskreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a task reminder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = \App\Models\Task::where('remainder', 0)->where('remainder_date', '=', date('Y-m-d'))->get();
        $controller = new \App\Http\Controllers\Controller();
        if (count($tasks)) {
            foreach ($tasks as $task) {
                $message = 'Hello ' . $task->user->name . '.'
                        . chr(10) . 'This is the remainder of : ' . strip_tags($task->activity) . '.'
                        . chr(10) . 'Type: ' . $task->taskType->name . '.'
                        . chr(10) . 'From ' . $task->client->name . ''
                        . chr(10) . 'You created at : ' . date('d-m-Y', strtotime($task->created_at))
                        . chr(10) . 'Thanks.';
                $controller->send_whatsapp_sms($task->user->phone, $message);
                $controller->send_sms($task->user->phone, $message, 1, null, 'admin');

                if ($task->taskUsers()->count() > 0) {
                    foreach ($task->taskUsers()->get() as $task_user) {
                        if ($task_user->user_id != $task->user->id) {
                            $user = \App\Models\User::find($task_user->user_id);
                            $msg = 'Hello ' . $user->firstname . ' ' . $user->lastname . '.'
                                    . chr(10) . 'This is the remainder of a task allocated to you'
                                    . chr(10) . 'Task: ' . strip_tags($task->activity) . '.'
                                    . chr(10) . 'Type: ' . $task->taskType->name . '.'
                                    . chr(10) . 'From ' . $task->client->name . ''
                                    . chr(10) . 'Deadline: ' . date('d-m-Y', strtotime($task->start_date)) . '.'
                                    . chr(10) . 'By: ' . $task->user->name . '.'
                                    . chr(10) . 'Thanks.';
                            $controller->send_whatsapp_sms($user->phone, $msg);
                            $controller->send_sms($user->phone, $msg,1, null, 'admin');
                        }
                    }
                }
                \App\Models\Task::where('id', $task->id)->update(['remainder' => 1]);
            }
        }
      //  DB::select('refresh  materialized view  admin.all_sms ');
        return 0;
    }
}
