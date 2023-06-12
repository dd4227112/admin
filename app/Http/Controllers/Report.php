<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Department_task;
use Illuminate\Http\Request;
use DB;
use Excel;
use Auth;
// use App\Models\KeyPeformance;
class Report extends Controller {

  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public $mark_table = 'marks'; // this can be changed to all_mark_info view or a complex material view mark_combined_view

  public function __construct() {
    $id = request('token');
    if (strlen($id) < 2) {
      $this->middleware('auth');
    }
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index() {

    $schema = request()->segment(3);
    $time='1 day';
    $where = strlen($schema) > 3 ? ' where "schema_name"=\'' . $schema . '\'  and created_at > now() - interval  \''.$time.'\'  ': ' where created_at > now() - interval  \''.$time.'\' ';
    $this->data['error_logs'] = DB::select('select * from admin.error_logs ' . $where);
    $this->data['danger_schema'] = \collect(DB::select('select count(*), "schema_name" from admin.error_logs  group by "schema_name" order by count desc limit 1 '))->first();
    return view('report.report_search', $this->data);
    //  return view('software.logs', $this->data);
  }

  public function systemReport() {
    $id = request()->segment(3);
    $type = request()->segment(4);

    //  $reason = request('reason');
    //  $this->data['classlevels'] = \App\Model\ClassLevel::all();
    //  $this->data['classes'] = $this->student_m->get_classes();
    $date = date('Y-m-d');
    if($type == 'day'){
      $criteria = "DATE_PART('date', created_at) = date_part('date', CURRENT_DATE)";
    }
    if($type == 'week'){
      $criteria = "DATE_PART('week', created_at) = date_part('week', CURRENT_DATE)";
    }
    if($type == 'month'){
      $criteria = "DATE_PART('month', created_at) = date_part('month', CURRENT_DATE)";
    }
    if($type == 'year'){
      $criteria = "DATE_PART('year', created_at) = date_part('year', CURRENT_DATE)";
    }
    if((int)$id>0){

      $this->data['type'] = $type;
      if((int)$id == 1){
        $this->data["title"] = "Number of Login failed attempts";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');
        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_login_attempts group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_login_attempts),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_login_attempts i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_login_attempts where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 2){
        $this->data["title"] = "Number of Log activities (students, parents, teachers)";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');
        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_log group by created_at::date order by created_at desc limit 14');
        $this->data["users"] = DB::SELECT('SELECT count(id) as ynumber, "table",created_at::date from admin.all_log where created_at::date=CURRENT_DATE group by created_at::date,"table" order by created_at desc limit 14');
        $this->data["activities"] = DB::SELECT('SELECT count(id) as ynumber, controller,created_at::date from admin.all_log where created_at::date=CURRENT_DATE group by created_at::date, controller order by ynumber desc');
        //  $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_log),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_log i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = NULL;
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_log where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 3){
        $this->data["title"] = "Number of errors recorded";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');
        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.error_logs group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.error_logs),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.error_logs i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.error_logs where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 4){
        $this->data["title"] = "Number of new Users (students, parents, teachers)";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');

        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_users group by created_at::date order by created_at desc limit 14');
        $this->data["users"] = DB::SELECT('SELECT count(id) as ynumber,"table",created_at::date from admin.all_users where created_at::date=CURRENT_DATE group by created_at::date,"table" order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_users),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_users i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_users where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 5){
        $this->data["title"] = "Number of Assignment Published";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');

        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_assignments group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_assignments),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_assignments i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_assignments where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 6){
        $this->data["title"] = "Number of Assignment Submitted";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');

        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_assignments_submitted group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_assignments_submitted),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_assignments_submitted i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_assignments_submitted where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }

      if((int)$id == 19){
        $this->data["title"] = "Number of Assignment Viewers";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');
        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_assignment_viewers group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_assignment_viewers),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_assignment_viewers i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_assignment_viewers where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 7){
        $this->data["title"] = "Number of Forum Questions Asked";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');

        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_forum_questions group by created_at::date order by created_at desc limit 14');
        $this->data["users"] = DB::SELECT('SELECT count(id) as ynumber, created_by_table AS "table",created_at::date from admin.all_forum_questions where created_at::date=CURRENT_DATE group by created_at::date,"table" order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_forum_questions),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_forum_questions i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_forum_questions where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');

      }
      if((int)$id == 8){
        $this->data["title"] = "Number of Forum Questions Answered";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');

        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_forum_answers group by created_at::date order by created_at desc limit 14');
        $this->data["users"] = DB::SELECT('SELECT count(id) as ynumber, created_by_table AS "table",created_at::date from admin.all_forum_answers where created_at::date=CURRENT_DATE group by created_at::date,"table" order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_forum_answers),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_forum_answers i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_forum_answers where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 20){
        $this->data["title"] = "Number of Forum Questions Viewers";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');

        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_forum_question_viewers group by created_at::date order by created_at desc limit 14');
        $this->data["users"] = DB::SELECT('SELECT count(id) as ynumber, created_by_table AS "table",created_at::date from admin.all_forum_question_viewers where created_at::date=CURRENT_DATE group by created_at::date,"table" order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_forum_question_viewers),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_forum_question_viewers i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_forum_question_viewers where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 9){
        $this->data["title"] = "Number of Files uploaded";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');
        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_files group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_files),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_files i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_files where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 10){
        $this->data["title"] = "Number of Media Comments";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');
        $this->data["datas"] = DB::SELECT('SELECT count(created_at) as ynumber,created_at::date from admin.all_media_comments group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_media_comments),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_media_comments i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_media_comments where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 11){
        $this->data["title"] = "Number of Total Likes";
        $this->data["datas"] = DB::SELECT('SELECT count(created_at) as ynumber,created_at::date from admin.all_media_likes group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_media_likes),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_media_likes i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_media_likes where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 12){
        $this->data["title"] = "Number of Total Viewers";
        $this->data["datas"] = DB::SELECT('SELECT count(created_at) as ynumber,created_at::date from admin.all_media_viewers group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_media_viewers),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_media_viewers i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_media_viewers where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');

      }
      if((int)$id == 13){
        $this->data["title"] = "Number of Videos Uploaded";
        $this->data["datas"] = DB::SELECT('SELECT count(created_at) as ynumber,created_at::date from admin.all_medias group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_medias),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_medias i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_medias where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');

      }
      if((int)$id == 14){
        $this->data["title"] = "Sms sent Replies";
        $this->data["datas"] = DB::SELECT('SELECT count(created_at) as ynumber,created_at::date from admin.all_reply_sms group by created_at::date order by created_at desc limit 14');
        $this->data["users"] = DB::SELECT('SELECT count(created_at) as ynumber,"table",created_at::date from admin.all_reply_sms where created_at::date=CURRENT_DATE group by created_at::date,"table" order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_reply_sms),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_reply_sms i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_reply_sms where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');

      }
      if((int)$id == 15){
        $this->data["title"] = "Online exams Published";
        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.all_minor_exams group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_minor_exams),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_minor_exams i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
        $this->data["schools"] = DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_minor_exams where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');

      }
      if((int)$id == 16){
        $this->data["title"] = "Sms sent and email sent";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');
        $this->data["datas"] =[]; //DB::SELECT('SELECT count(sms_id) as ynumber,created_at::date from admin.all_sms group by created_at::date order by created_at desc limit 14');
        $this->data["users"] =[]; //DB::SELECT('SELECT count(sms_id) as ynumber,"table",created_at::date from admin.all_sms where created_at::date=CURRENT_DATE group by created_at::date,"table" order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.all_sms),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.all_sms i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = [];//DB::SELECT($sql);
        $this->data["schools"] =[]; // DB::SELECT('SELECT count(schema_name) as ynumber,schema_name from admin.all_sms where created_at::date=CURRENT_DATE group by schema_name order by count(schema_name) desc limit 20');
      }
      if((int)$id == 17){
        $this->data["title"] = "Customer Support & Sales";
        $this->data["days"] = array(1 => 'Day 1', 2 =>  'Day 2', 3 =>  'Day 3', 4 => 'Day 4', 5 =>  'Day 5', 6 =>  'Day 6', 7 => 'Day 7');
        $this->data["datas"] = DB::SELECT("SELECT count(a.id) as ynumber,task_type_id, b.name as created_at from admin.tasks a, admin.task_types b where a.task_type_id = b.id AND a.created_at::date < '2020-05-20' AND a.created_at::date > '2020-05-10'  group by a.task_type_id,b.name order by a.task_type_id desc");
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.tasks),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.tasks i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);
      }
      if((int)$id == 18){
        $this->data["title"] = "Website Demo Requests";
        $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber,created_at::date from admin.website_demo_requests group by created_at::date order by created_at desc limit 14');
        $sql = "with dates as (select min(date_trunc('week', created_at)) as startw, max(date_trunc('week', created_at)) as endw from admin.website_demo_requests),weeks as ( select generate_series(startw, endw, '7 days') as week from dates )select w.week, count(i.created_at) as ycounts from weeks w left outer join admin.website_demo_requests i on date_trunc('week', i.created_at) = w.week group by w.week order by w.week desc limit 7";
        $this->data["weeks"] = DB::SELECT($sql);

      }
      return view('report.graphs', $this->data);
    }else{
      return view('report.report_search', $this->data);
    }
  }

  // STAFFS REPORT
    public function staffs() {
        // echo "yes";
        // exit;
        if ($_POST) {
            $this->data['from_date'] = $from_date = date('Y-m-d 00:00:00', strtotime(request("from_date")));
            $this->data['to_date'] = $to_date = date('Y-m-d 23:59:59', strtotime(request("to_date")));
            if ($to_date < $from_date) {
              return redirect()->back()->with('error', "Invalid date range selection");
            }
        } else {
          $quater =DB::table('admin.year_quarters')->first();    
            $this->data['from_date'] = $from_date = date($quater->start_date.' 00:00:00');
            $this->data['to_date'] = $to_date = date($quater->end_date.' 23:59:59');
        }
        $id = request()->segment(3);
        $type = request()->segment(4);
        if ($type == 'delete' && (int) $id > 0) {
          \App\Models\StaffReport::where('id', $id)->delete();
        }
        $this->data['staff_reports'] = \App\Models\StaffReport::whereBetween('date', [$from_date, $to_date])->get();
        // if (Auth::user()->role_id == 1) 
        // { 

          $this->data['users'] = \App\Models\User::where('status',1)->get();
        // }
        // else
        // {
        //   $this->data['users'] = \App\Models\User::where('id', Auth::user()->id )->get();
        // }
        return view('users.hr.staffsreports', $this->data);
   
    }
  public function setreport() {
    $this->data['connection'] = config('database.connections');
    // $data = \App\Models\KeyPerformance::where($id)->first();
    $id = clean_htmlentities(request()->segment(3));
    $this->data['key_performances'] = DB::select('select * from admin.key_performances where user_id ='.$id);  
    $this->data['user'] = \App\Models\User::where('id', $id)->first();
    if ($_POST) {
     
      // dd(request()->all());
      if (request('is_derived')=='1') {        
      $kpi_performance = \App\Models\KeyPerformance::where('id', request('kpi_derived'))->first();
      $obj = array_merge(request()->except('kpi', 'kpi_derived', '_token'),
      [

      'kpi' => $kpi_performance->name,
      'is_derived_sql' => $kpi_performance->custom_query.'  a.created_at between \'' . request('start_date') . '\' and \'' . request('end_date') . '\'',
      'created_by_sid' => Auth::User()->sid,
      'schema_name'=>'shulesoft',
      'connection' =>$kpi_performance->connection,
      ]);
      }
      else{
        $obj = array_merge(request()->except('kpi', 'kpi_derived', '_token'),
        [
        'kpi' => request('kpi') ,
        'is_derived_sql' =>  '',
        'created_by_sid' => Auth::User()->sid,
        'schema_name'=>'shulesoft',
        'connection' =>'',
        ]);
      }
      \App\Models\StaffTarget::create($obj);
      return redirect()->back()->with('success', "success");
    }
    return view('users.hr.setreport', $this->data);

  }
  public function dashboard()
  {

    $id = clean_htmlentities(request()->segment(3));
    $this->data['user'] = \App\Models\User::where('id', $id)->first();
    if ($_POST) {
      
      $this->data['from_date'] = $from_date = date('Y-m-d 00:00:00', strtotime(request("from_date")));
      $this->data['to_date'] = $to_date = date('Y-m-d 23:59:59', strtotime(request("to_date")));
      if ($to_date < $from_date) {
        return redirect()->back()->with('error', "Invalid date range selection");
      }
    } else {
      $quater =DB::table('admin.year_quarters')->first();    
      $this->data['from_date'] = $from_date = date($quater->start_date.' 00:00:00');
      $this->data['to_date'] = $to_date = date($quater->end_date.' 23:59:59');
    }
    return view('users.hr.dashboard', $this->data);
  }
  public function deletetarget() 
  {
    $uuid = clean_htmlentities((request()->segment(3)));
    \App\Models\StaffTarget::where('uuid', $uuid)->delete();
    return redirect()->back()->with('success', "Deleted");
  }
  public function performances(request $request){
    // $data = request()->except('_token');
    $data = [
    'name' => $request->name,
    'created_by' => Auth::user()->id,
    'custom_query' => $request->custom_query,
    'user_id' =>$request->user_sid,
    'connection' =>$request->connection,
    ];

    \App\Models\KeyPerformance::create($data);
    return redirect()->back()->with('success', "success");

  }
  public function addReport() {
    if ($_POST) {
        $url = '';

        if (request()->file("attachment") != '') {
            //  $url = $this->saveFile(request()->file("attachment"), 'shulesoft');
            $file = request()->file("attachment");
            $url = 'attach_' . time() . rand(11, 8894) . '.' . $file->guessExtension();
            $url = base_url('storage/uploads/images/' . $url);
            $filePath = base_path() . '/storage/uploads/images/';
            $file->move($filePath, $url);
            $attach_file_name = request()->file("attachment")->getClientOriginalName();
        } else {
            $attach_file_name = '';
        }
        $array = array(
            "title" => date("Y-m-d", strtotime(request('date'))) . ' Report',
            "comment" => request("comment"),
            'attach' => $url,
            'attach_file_name' => $attach_file_name,
            "user_sid" => request("user_sid"),
            "user_id" => Auth::User()->id,
            "user_table" => 'users',
            'schema_name' =>'shulesoft',
            "date" => date("Y-m-d", strtotime(request('date'))),
        );
        $staff_report = \App\Models\StaffReport::create($array);
        $targets = request('targets');

        foreach ($targets as $key => $target) {
          if($target != null){
            \App\Models\StaffTargetsReport::create([
              'staff_report_id' => $staff_report->id,
              'staff_target_id' => $key,
              'date' => date("Y-m-d", strtotime(request('date'))),
              'current_value' => $target,
              'schema_name' =>'shulesoft',]
            );
          }
        }
        return redirect()->back()->with('success', 'Report Uploaded successfully ');
    } else {
       echo 'Error!!!!!!!';
       exit;
    }
}
public function edit_kpi(){
  
  $uuid = clean_htmlentities((request()->segment(3)));
  if($_POST){
    $obj = array(

    'kpi' => request('kpi'),
    'is_derived_sql' => request('is_derived_sql'),
    'value' => request('value'),
    'end_date' =>request('end_date'),
    'start_date' =>request('start_date'),
    'uuid' =>request('uuid'),
    'is_derived' =>request('is_derived'),
    );
    if(\App\Models\StaffTarget::where('uuid', $obj['uuid'])->update($obj)){
      return redirect()->back()->with('success', 'Updated successfully ');
    }
    
  }else{

  $data =\App\Models\StaffTarget::where('uuid', $uuid)->first();
//  $data = \APP\Models\StaffTarget::where('uuid', $id)->first();
  return response()->json($data);
  }

}
// OPERATION MANUALS
  public function manuals(){
    // get all departments 
    $data['departments'] = Department::all();
    $department_id =(int)request('deparment');
    $page =request('page');
    if($page){
      if($page== 'add'){
        return view('users.manuals.add', $data);
      }else{
        return redirect()->back()->with('error', 'Undefined page request');
      }
    }
   if($department_id){
      //get all data in the selected department
      $data['department_id'] = $department_id;
      $data['department_tasks'] = Department_task::where('department_id', $department_id)->get();
    return  view('users.manuals.index', $data);
    }
    else
    {
      //get all tasks in all departments
      $data['department_id'] =null;
      $data['department_tasks'] = Department_task::all();
      return  view('users.manuals.index', $data);
    }
  }
  public function addManual(){
    if($_POST){
      $data =[
         'department_id'=>request('department_id'),
         'name'=>request('name'),
         'content'=>request('content'),
         'created_by'=>Auth::User()->id,
      ];
      if(Department_task::create($data)){
        return redirect('report/manuals/')->with(['success'=>'Successs']);
      }
      
    }else{
      return redirect()->back()->with('error', 'Invalid post data');

    }
  }
  public function editManual(){
    if ($_POST) {
      $data=[
        'department_id'=>request('department_id'),
        'name'=>request('name'),
        'content'=>request('content'),
      ];
      $task_id = request('task_id');
      if(Department_task::where('id', $task_id)->update($data)){
        return redirect('report/manuals')->with('success', 'Updated successfully');
      }      else{
       return redirect('report/manuals')->with('error', 'Update Failed');
      }
    }else{
      $task_id=request()->segment('3');
      $data['departments'] = Department::all();
      $data['task'] = Department_task::where('id', $task_id)->first();
      if (empty($data['task'])) {
        return redirect()->back()->with('error', 'No manual with the given ID');
      }
      else{
        return view('users.manuals.edit', $data);
      }
    }
  }
  public function deleteManual(){
    $task_id=request()->segment('3');
    $task_check = Department_task::where('id', $task_id)->first();
    if (empty($task_check)) {
      return redirect()->back()->with('error', 'No manual with the given ID');
    }
    else{
      if(Department_task::where('id', $task_id)->delete()){
        return redirect('report/manuals')->with('success', 'Deleted');
      }else{
      return redirect()->back()->with('error', 'Delete failed');
      }
    }
  }
}