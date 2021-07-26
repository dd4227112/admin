<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ImportExpense;
use Illuminate\Validation\Rule;
use DB;
use Auth;

/**
 * Description of Project
 * 
 * This file will be used to link projects.shulesoft.com with admin.shulesoft.com
 * 
 * only key variables will be included
 * 
 * we aim to have a proper reporting 
 *
 * @author swilla
 */
class Project extends Controller {

    //put your code here

    private $project_id;
    public $project_name;
    public $user_email;
    public $updated_by;
    public $type_id;
    public $priority;
    public $title;
    public $message;
    public $assign_to;
    public $due_date;
    public $istype;
    public $status;
    public $legend;
    public $isactive;
    public $dt_created;
    public $actual_dt_created;
    public $reply_type;
    private $connection = 'project';

    public function getProjectId() {
        $project = DB::connection($this->connection)->table('projects')->where('name', 'ilike', strtolower($this->project_name))->first();
        return count($project) == 1 ? $project->id : die('project with a name ' . $this->project_name . ' does not exists in projects.shulesoft.com');
    }

    public function setUserId($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $user = DB::connection($this->connection)->table('users')->where('email', strtolower($email));
            if (count($user->first()) == 1) {
                $user_info = DB::table('users')->where('email', strtolower($email))->first();
                count($user_info) == 1 ?
                                DB::connection($this->connection)->table('users')->where('email', strtolower($email))->update(['id' => $user_id]) :
                                die('Email ' . $email . ' does not exists in admin.shulesoft.com');
            } else {
                die('Email ' . $email . ' does not exists in projects.shulesoft.com');
            }
        }
    }

    public function getUserId() {
        $user = DB::connection($this->connection)->table('users')->where('email', 'ilike', strtolower($this->user_email))->first();
        return count($user) == 1 ? $user->id : die('users with a email ' . $this->user_email . ' does not exists in projects.shulesoft.com');
    }

    public function getTypeId() {
        $project = DB::connection($this->connection)->table('types')->where('name', 'ilike', strtolower($this->project_type))->first();
        return count($project) == 1 ? $project->id : die('project type with a name ' . $this->project_type . ' does not exists in projects.shulesoft.com');
    }

    public function saveTask() {
        $vars = get_class_vars(get_called_class());
        foreach ($vars as $key => $val) {
            if ($this->$key == NULL && !in_array($key,['project_id'])) {
                die($key . ' cannot be empty');
            }
        }      
        return DB::connection($this->connection)->table('easycases')->insert([
                    'project_id' => $this->getProjectId(),
                    'user_id' => $this->getUserId(),
                    'type_id' => $this->getTypeId(),
                    'priority' => $this->priority,
                    'title' => $this->title, 'message', 'estimated_hours', 'hours', 'completed_task', 'assign_to', 'due_date', 'istype', 'format', 'status', 'legend', 'isactive', 'dt_created', 'actual_dt_created', 'reply_type', 'is_chrome_extension', 'from_email'
        ]);
    }

    public function updateTaskStatus() {
        
    }

}
