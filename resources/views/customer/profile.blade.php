@extends('layouts.app')
@section('content')

<?php
$root = url('/') . '/public/';
define('SCHEMA', $schema);

function check_status($table, $where = null) {
$schema = SCHEMA;
if ($table == 'admin.vendors') {
$report = \collect(DB::select('select created_at::date from ' . $table . '  ' . $where . ' order by created_at::date desc limit 1'))->first();
} elseif ($table == 'invoices') {
$report = \collect(DB::select('select date::date as created_at from ' . $schema . '.' . $table . '  ' . $where . ' order by date::date desc limit 1'))->first();
} else {
$report = \collect(DB::select('select created_at::date from ' . $schema . '.' . $table . '  ' . $where . ' order by created_at::date desc limit 1'))->first();
}
if (!empty($report)) {
$echo = '<label class="badge badge-success">' . date('d M Y', strtotime($report->created_at)) . '</label>';
} else {
$echo = '<label class="badge badge-inverse-warning">Not Defined</label>';
}
return $echo;
}
// ?>



<?php $school_name = isset($school->sname) ? $school->sname : '';
      $numbers=isset($profile->estimated_students) ? 'Estimated students '. $profile->estimated_students : '';
      $s_address = isset($school->address) ? $school->address : '';
 ?>
    <div class="page-header">
            <div class="page-header-title">
                <h4><?= $school_name ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"><?=$numbers?></a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"><?=$s_address?></a>
                    </li>
                </ul>
            </div>
        </div> 

 <?php if(isset($client->trial) && $client->trial == 1) { ?>
    <label class="badge badge-warning"> School on trial period  <?= isset($trial->end_date) ? 'Until '. date("d-m-Y", strtotime($trial->end_date)) : ''  ?></label>
<?php } ?>
    

<div class="page-body">
<div class="row">
<div class="col-sm-12">
<div>
<div class="content social-timeline">
<div class="">
<!-- Row Starts -->
<div class="row">
<div class="col-md-12">
<!-- Social wallpaper start -->
<div class="social-wallpaper">
<div class="mapouter"> 
<?php if (isset($school->sname)) { ?>
<div class="gmap_canvas"><iframe width="100%" height="500"
id="gmap_canvas"
src="https://maps.google.com/maps?q=<?= $school->sname ?>&t=&z=13&ie=UTF8&iwloc=&output=embed"
frameborder="0" scrolling="no" marginheight="0"
marginwidth="0"></iframe><a
href="https://www.embedgooglemap.net/blog/nordvpn-coupon-code/">nordvpn
coupon</a>
</div>
<?php } ?>
<style>
.mapouter {
position: relative;
text-align: right;
height: 300px;
width: 100%;
}

.gmap_canvas {
overflow: hidden;
background: none !important;
height: 300px;
width: 100%;
}
</style>
</div>

</div>

{{-- <div class="timeline-btn">
<a href="#" class="btn btn-primary waves-effect waves-light">Send
Message</a>
</div> --}}
</div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
<div class="col-xl-3 col-lg-4 col-md-4 col-xs-12">

<div class="card">
<div class="social-profile">
<?php
$image = isset($school->photo) && strlen($school->photo) > 3 ? 'storage/uploads/images/' . $school->photo : 'storage/uploads/images/default.png';
?>
<img class="img-fluid width-100"
src="https://demo.shulesoft.com/<?= $image ?>" alt="">
<div class="profile-hvr m-t-15">
<i class="icofont icofont-ui-edit p-r-10"></i>
<i class="icofont icofont-ui-delete"></i>
</div>
</div>

<div class="card-block">
<?php
if ($is_client == 1) {
?>
<div class="">
<div class="row m-2">
<label class="badge badge-inverse-primary">
      <?= \DB::table($schema . '.student')->where('status', 1)->count() ?>
</label>
<label>Students</label>
</div>

<div class="row m-2">
<label class="badge badge-inverse-primary">
    <?= \DB::table($schema . '.parent')->where('status', 1)->count() ?>
</label>
<label>Parents</label>
</div>

<div class="row m-2">
<label class="badge badge-inverse-primary">
<?= \DB::table($schema . '.user')->where('status', 1)->count() ?>
</label>
<label>Staff</label>
</div>

<div class="row m-1">
<label class="badge badge-inverse-primary">
   <?= \DB::table($schema . '.teacher')->where('status', 1)->count() ?>
</label>
<label>Teacher</label>
</div> 

<div class="col-md-12 col-lg-12">
<hr>
 <h6 class="">School Status</h6>
<?php
$st = DB::table($schema . '.setting')->first();
if (!empty($st)) {
echo '<a data-toggle="modal" data-target="#status-Modal">';
if ($st->school_status == 1) {
echo '<div class="btn btn-sm btn-round btn-primary">Active Paid</div>';
} elseif ($st->school_status == 2) {
echo '<div class="btn btn-success">Active</div>';
} elseif ($st->school_status == 3) {
echo '<div class="btn btn-warning">Resale</div>';
} elseif ($st->school_status == 4) {
echo '<label class="badge badge-inverse-default"> Inactive </label>';
} else {
echo '<label class="badge badge-inverse-warning">Not defined</div>';
}
echo '</a>';
}
?> 
</div>
</div>
<?php } ?>
</div>

<?php
if ($is_client == 1) {
?>
<div class="card">
<div class="card-header">
    <h6 class="card-header-text">Top user Logins</h6>
</div>
<div class="card-block user-box">
<?php
if (!empty($top_users)) {
foreach ($top_users as $log) {
?>
<div class="media m-b-10">
<a class="media-left" href="#!">
<?php $user_image = 'storage/uploads/images/defualt.png'; ?>

<img class="media-object img-circle"
src="https://demo.shulesoft.com/<?= $user_image ?>"
alt="Image">
</a>
<div class="media-body">
  <div class="text-info social-designation"><?= $log->name ?></div>
  <div class="text-muted social-designation">
  <?= $log->usertype ?></div>
</div>
</div>
<?php
}
}
?>

</div>
</div> 

<div class="card">
<div class="card-block">
<h4>Training Reports</h4>
<ul class="list-group">
<li class="list-group-item justify-content-between">
<a href="<?= url('customer/training/config/null?id=' . encrypt($schema)) ?>"
target="_blank">Configuration</a>
<a href="#" title="copy link"><span
class="badge badge-default badge-pill">&></span></a>

</li>
<li class="list-group-item justify-content-between">
<a href="<?= url('customer/training/account/null?id=' . encrypt($schema)) ?>"
target="_blank"> Accounts</a>
<span class="badge badge-default badge-pill">&></span>
</li>
<li class="list-group-item justify-content-between">
<a href="<?= url('customer/training/exam/null?id=' . encrypt($schema)) ?>"
target="_blank"> Exams</a>
<span class="badge badge-default badge-pill">&></span>
</li>

</ul>
</div>
</div>
<?php } ?>
</div>
</div>

<div class="col-lg-9">
<!-- Nav tabs -->
        <div class="card mt-4">
        <ul class="nav nav-tabs md-tabs nav-justified tab-timeline" role="tablist">
        <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#timeline"
        role="tab" aria-expanded="false">Activities</a>
        <div class="slide"></div>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#about" role="tab"
        aria-expanded="false">About</a>
        <div class="slide"></div>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#implementation"
        role="tab" aria-expanded="false"> Implementation</a>
        <div class="slide"></div>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#photos" role="tab"
        aria-expanded="false"> Usage</a>
        <div class="slide"></div>
        </li>
        <li class="nav-item">
        <a class="nav-link " data-toggle="tab" href="#friends" role="tab"
        aria-expanded="true">Staff Members</a>
        <div class="slide"></div>
        </li>
      
        <li class="nav-item">
        <a class="nav-link " data-toggle="tab" href="#payments" role="tab"
        aria-expanded="true">Invoice</a>
        <div class="slide"></div>
        </li>
      
        </ul>
        </div>

<!-- Tab panes -->
<div class="tab-content">
<!-- Timeline tab start -->
<div class="tab-pane active" id="timeline" aria-expanded="false">
<div class="row">
<div class="card-block">
<button type="button" class="btn btn-primary btn-lg btn-round" data-toggle="modal" data-target="#large-Modal">Create Task</button>

<div class="modal fade" id="large-Modal" tabindex="-1"
role="dialog" aria-hidden="true"
style="z-index: 1050;  display: none;">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Create Task/Activity 
</h4>
<button type="button" class="close"
data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<form action="#" method="post">
<div class="modal-body">
<span>
Create a task for this school with
implementation deadline</span>

<div class="form-group">
<textarea class="form-control" rows="4"  placeholder="Create Task" name="activity">
</textarea>


</div>
<div class="form-group">
<div class="row"> 

<div class="col-md-6">
Task Type
<select name="task_type_id"
class="select2">
<?php
$types = Auth::user()->role_id == 1 ? DB::table('task_types')->get() : DB::table('task_types')->where('department', Auth::user()->department)->get();
if (!empty($types)) {
foreach ($types as $type) {
?>
<option
value="<?= $type->id ?>">
<?= $type->name ?>
</option>
<?php
}
}
?>
</select>
</div>


<div class="col-md-6">
Person Allocated to do
<select name="to_user_id[]" class="select2"  multiple="">
<?php
$staffs = DB::table('users')->where('status', 1)->where('role_id', '<>', 7)->get();
if (!empty($staffs)) {
foreach ($staffs as $staff) {
?>
<option value="<?= $staff->id ?>">
<?= $staff->firstname . ' ' . $staff->lastname ?>
</option>
<?php
}
}
?>

</select>
</div>
</div>
</div>

<div class="form-group">

<div class="row">
<div class="col-md-6">
<strong> Task Executed Successfully</strong>
<select name="status" class="form-control"  onchange="chooseValue(this.value);" id="task_executed" required>
    <option value='new'> Select
    Task Status Here...
    </option>
    <option value='complete'>
    Yes and Completed
    </option>
    <option value='on progress'>
    Yes but on Progress
    </option>
    <option value='schedule'>
    Not yet (Schedule)
    </option>
</select>
</div>

<div class="col-md-6"  id="remainder_date">
   <strong> Notification Date</strong>
   <input type="date"  name="remainder_date" class="form-control">
</div>
</div>
</div>


<div class="form-group">
<div class="row">
<div class="col-md-6">
<strong> Start Date</strong>
<input type="datetime-local" required
class="form-control" 
placeholder="Deadline"
name="start_date">
</div>

<div class="col-md-6" id="end_date">
<strong> End Date </strong>
<input type="datetime-local"
class="form-control"
placeholder="Time"
name="end_date">
</div>
</div>
</div>


<div class="form-group">
<strong> Pick Modules where task will be Performed</strong>
<hr>
<select name="module_id[]" class="select2"  multiple="">
<?php
$modules = DB::table('modules')->get();
if (!empty($modules)) {
foreach ($modules as $module) {
?>
<option value="<?= $module->id ?>">
<?= $module->name ?>
</option>
<?php
}
}
?>
</select>
</div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm btn-round" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary btn-sm btn-round">Save changes</button>
</div>
<input type="hidden" value="<?= $client_id ?>"
name="client_id" />
<?= csrf_field() ?>
</form>
</div>
</div>
</div>
</div>


<div class="col-md-12 timeline-dot">
<?php
$tasks_ids = \App\Models\TaskSchool::whereIn('school_id', \App\Models\ClientSchool::where('client_id', $client_id)->get(['school_id']))->get(['task_id']);
$tasks = \App\Models\Task::whereIn('id', \App\Models\TaskClient::where('client_id', $client_id)->get(['task_id']))->orWhereIn('id', $tasks_ids)->orderBy('created_at', 'desc')->get();
if (!empty($tasks)) {
foreach ($tasks as $task) {
?>
<div class="social-timelines p-relative o-hidden"
id="removetag<?= $task->id ?>">
<div class="row">
<div class="col-xs-2 col-sm-1">
<div class="social-timelines-left">
</div>
</div>
<div class="col-xs-10 col-sm-11 p-l-5 p-b-35">
<div class="card m-0">

<div
class="dropdown-menu dropdown-menu-right b-none services-list">
<a class="dropdown-item" href="#"
onmousedown="removeTag(<?= $task->id ?>)">Remove
tag</a>
<a class="dropdown-item" href="#">Report
Photo</a>


</div> 

<div class="card-block">
<div class="timeline-details">
<div class="chat-header">
    <?php 
      $task_user_id = $task->user->id == '' ? 1 : $task->user->id;
      $path = \collect(DB::select("select f.path from admin.users a join admin.company_files f on a.company_file_id = f.id where a.id = '{$task_user_id}'"))->first(); 
      $local = $root . 'assets/images/user.png';
     ?>
    <img src="<?= isset($path->path) && ($path->path != '')  ? $path->path : $local ?>" class="img-circle" style="position: relative;
           width: 25px;
           height: 25px;
           border-radius: 50%;
           overflow: hidden;">
   &nbsp;&nbsp;<?= $task->user->firstname ?> -
    <span class="text-muted"><?= date("d M Y", strtotime($task->created_at)) ?></span> &nbsp;&nbsp; <label class="badge badge-inverse-primary">{{ $task->status}}</label>
    <?php if(can_access('delete_tasks')) { ?>
       <a class="btn btn-mini btn-round btn-danger float-right text-light"   onclick="RemoveAttr(<?= $task->id ?>);"> delete </a>
    <?php } ?>
</div>
<p class="text-muted editable" id="txt1<?= $task->id ?>">
   {{-- <?= $task->activity ?> --}}

   <span style="text-decoration: none;" <?= $task->user->id == \Auth::user()->id && date('Y-m-d H:i:s') < date('Y-m-d H:i:s', strtotime("+60 minutes", strtotime($task->created_at))) ? 'contenteditable="true"': 'contenteditable="false"' ?> 
    onblur="save('<?= $task->id . 'activity' ?>', '<?= $task->id  ?>','activity')" 
    id="<?= $task->id . 'activity' ?>"> <?= $task->activity == '' ? 'null' : $task->activity ?></span>
    <span id="stat<?= $task->id .  'activity' ?>"></span>
</p>
<?php
$modules = $task->modules()->get();
if (count($modules) > 0) {
echo '<p>Task Module Performed</p>';
foreach ($modules as $module) {
?>
<?= $module->module->name ?> &nbsp;
&nbsp; |
<?php
}
}
?>


<p>Start Date- <?= $task->start_date ?>
 &nbsp; &nbsp; | &nbsp; &nbsp; 
 <?= date('Y-m-d', strtotime($task->end_date)) == '1970-01-01' ? '' : 'End Date - '.$task->end_date  ?></p> 

 <p>Assigned to - 
     @foreach ($task->taskUsers as $value)
     <?= '<label class="badge badge-inverse-primary">' . $value->user->name() . '</label>' ?>
       &nbsp; &nbsp;
    @endforeach
</p>
</div>

<div class="user-box">
<?php
$comments = $task->taskComments()->get();
if (count($comments) > 0) {
?>
<div class="mt-1"> <span class="f-14"><a
href="#">What have been
done</a></span></div>
<?php
foreach ($comments as $comment) {
?>
<div class="media" class="pb-1">
<a class="media-left" href="#">
<?php
$task_user_id = $task->user->id == '' ? 1 : $task->user->id;
$path = \collect(DB::select("select f.path from admin.users a join admin.company_files f on a.company_file_id = f.id where a.id = '{$task_user_id}'"))->first(); 
$local = $root . '/assets/images/avatar-2.png';  ?>
<img src="<?= isset($path->path) && ($path->path != '')  ? $path->path : $local ?>" class="img-circle" style="position: relative;
width: 22px; height: 22px;border-radius: 50%;overflow: hidden;">
</a>
<div
class="media-body b-b-muted social-client-description">
<div class="chat-header">
<?= $comment->user->name ?> &nbsp;&nbsp; <span 
class="text-muted"><?= date('d M Y', strtotime($comment->created_at)) ?></span>
</div>
<p class="text-muted">
<?= $comment->content ?></p>
</div>
</div>

<?php
}
}
?>
<div
class="new_comment<?= $task->id ?>">
</div>
<div class="media">
<a href="#"
class="btn btn-success btn-mini btn-round m-1"
onclick="return false"
onmousedown="$('#comment_area<?= $task->id ?>').toggle()"><i
class="ti-comment"></i>
Comment </a>
<div class="media-body"
id="comment_area<?= $task->id ?>"
style="display:none">
<form class="">
<div class="">
<textarea rows="4"
class="form-control"
id="task_comment<?= $task->id ?>"
placeholder="Write Your comment Here......"></textarea>
<input type="hidden"
class="form-control"
value="<?= $task->id ?>"
id="task_id<?= $task->id ?>" />
<span
class="input-group-btn">
  <button type="button" class="btn btn-primary btn-sm btn-round"  onmousedown="save_comment(<?= $task->id ?>)">Send</button>
</span>

<span
class="fs1 text-info"
aria-hidden="true"
data-icon=""></span>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
}
}
?>
</div>
</div>
</div>


<div class="tab-pane" id="about" aria-expanded="true">
<div class="row">

<div class="col-sm-12">
<div class="card">
<div class="card-header">
<h5 class="card-header-text h5">Basic Information</h5>
<?php if(can_access('update_school_data')) { ?>                                                                                                                 
<button id="edit-btn" type="button" class="btn btn-primary btn-round btn-sm float-right"
data-toggle="modal" data-target="#school_details">
 Update
</button>
<?php }  ?>
</div>
<div class="card-block">
<div id="view-info" class="row">
<div class="col-lg-6 col-md-12">
<form>
<table class="table m-b-0">
<tbody>
<tr>
<th
class="social-label b-none p-t-0">
School Name
</th>
<td
class="social-user-name b-none p-t-0">
<?= $school->sname ?? '' ?></td>
</tr>

<tr>
<th class="social-label b-none">
Location</th>
<td
class="social-user-name b-none">
<?= $school->address ?? '' ?></td>
</tr>
<?php if ($is_client == 1) { ?>
<tr>
<th class="social-label b-none">
Date On boarded</th>
<td
class="social-user-name b-none">
    <?= isset($school->created_at) ? date('d M Y h:i', strtotime($school->created_at)) : '' ?>
</td>
</tr>
<tr>
<th class="social-label b-none">
Contact Details</th>
<td
class="social-user-name b-none">
<?= $school->phone ?? '' ?></td>
</tr>
<tr>
<th class="social-label b-none p-b-0">School Level</th>
<td class="social-user-name b-none p-b-0"><?php
    if (!empty($levels)) {
        foreach ($levels as $level) {
            echo $level->name . ' - ' . $level->result_format . '<br/>';
        }
    }
    ?>
</td>

<?php /* if( can_access('reset_school_password') && isset($school->username) && !preg_match('/stfrancisgirls/i', strtolower($school->username))) { ?>
<tr>
<th class="social-label b-none p-b-0">School Access</th>
<td class="social-user-name b-none p-t-10">
        <?php
        if (isset($school->username) && $schema != 'accounts') {
            echo 'Username - ' . $school->username . '<br><a href="' . url('customer/resetPassword/' . $schema) . '" class="btn btn-primary btn-sm btn-round">
                 Reset Password</a>';
        }
        ?>
</td>
</tr>
<?php } */ ?>
<?php } ?>

</tbody>
</table>
</form>
</div>



<div class="col-lg-6 col-md-12">
<form>
<table class="table m-b-0">
<tbody>
<tr>
<th
class="social-label b-none p-t-0">
Zone Manager
</th>
<td
class="social-user-name b-none p-t-0">
<?= isset($manager->name) ? $manager->name  : ''  ?></td>
</tr>
<tr>
<th class="social-label b-none">
Zone Manager phone</th>
<td
class="social-user-name b-none">
<?= isset($manager->phone) ? $manager->phone :'' ?></td>
</tr>

<tr>
<th class="social-label b-none">
Email</th>
<td
class="social-user-name b-none">
<?= isset($manager->email) ? $manager->email : '' ?></td>
</tr>

</tbody>
</table>
</form>
</div>


</div>
<div id="edit-info" class="row" style="display: none;">
<div class="col-lg-12 col-md-12">
<form>

<div class="input-group">
<input type="text" class="form-control"
placeholder="Full Name">
</div>
<div class="input-group">
<div class="form-radio">
<div class="form-radio">
<label
class="md-check p-0">Gender</label>
<div class="radio radio-inline">
<label>
<input type="radio"
        name="radio"
        checked="checked">
<i
    class="helper"></i>Male
</label>
</div>
<div class="radio radio-inline">
<label>
<input type="radio"
        name="radio">
<i
    class="helper"></i>Female
</label>
</div>
</div>
</div>
</div>

<div class="input-group">
<input id="dropper-default"
class="form-control" type="text"
placeholder="Birth Date">
</div>
<div class="input-group">
<select id="hello-single"
class="form-control">
<option value="">---- Marital Status
----</option>
<option value="married">Married
</option>
<option value="unmarried">Unmarried
</option>
</select>
</div>
<div class="md-group-add-on">
<textarea rows="5" cols="5"
class="form-control"
placeholder="Address..."></textarea>
</div>
<div class="text-center m-t-20">
<a href="javascript:;" id="edit-save"
class="btn btn-primary waves-effect waves-light m-r-20">Save</a>
<a href="javascript:;" id="edit-cancel"
class="btn btn-default waves-effect waves-light">Cancel</a>
</div>
</form>
</div>
</div>
</div>
</div>
</div>





<div class="col-sm-12">
    <div class="card">
    <div class="card-header">
    <h2 class="card-header-text h5">School Agreement Information</h2>
    <button id="edit-btn" type="button" class="btn btn-primary btn-round btn-sm float-right"
       data-toggle="modal" data-target="#agreement_school_details">
     Update info
    </button>
    </div>
    <div class="card-block">
    <div id="view-info" class="row">
    <div class="col-lg-6 col-md-12">
    <table class="table m-b-0">
    <?php if(isset($agreement)) { ?>
    <tbody>
    <tr>
    <th
    class="social-label b-none p-t-0">
      Contact person name
    </th>
    <td
    class="social-user-name b-none p-t-0">
      <?= $agreement->contact_person_name ?? '' ?>
   </td>

   <th
    class="social-label b-none p-t-0">
      NMB Account name
    </th>
    <td
    class="social-user-name b-none p-t-0">
      <?= $agreement->school->nmb_school_name ?? '' ?>
   </td>
    </tr>

    <tr>
    <th class="social-label b-none">
        Contact person phone</th>
    <td class="social-user-name b-none">
        <?= $agreement->contact_person_phone ?? '' ?>
    </td>

    <th class="social-label b-none">
        NMB Account</th>
    <td class="social-user-name b-none">
        <?= $agreement->school->account_number ?? '' ?>
    </td>

    </tr>

    <tr>
    <th class="social-label b-none"> Designation</th>
    <td
    class="social-user-name b-none">
        <?= $agreement->contact_person_designation ?? '' ?>
    </td>
    </tr>

    <tr>
    <th class="social-label b-none">
        Agreement date</th>
    <td class="social-user-name b-none">
       <?= isset($agreement->agreement_date) ? date('d-m-Y',strtotime($agreement->agreement_date)) : '' ?></td>
    </tr>

    <tr>
        <th class="social-label b-none"> Agreement form type</th>
        <td class="social-user-name b-none">
           <?= $agreement->form_type ?? '' ?></td>

        <th class="social-label b-none"> View file</th>
           <td class="social-user-name b-none">
              <?php $viw_url = isset($agreement) ?  "customer/viewContract/$agreement->id/agreement" : ''; ?>
               <a  target="_blank" href="<?= url($viw_url)?>" class="btn btn-primary btn-mini btn-round">View</a>
        </td>
    </tr>

    <tr>
        <th class="social-label b-none">
             Created by</th>
        <td class="social-user-name b-none">
           <?= isset($agreement) ? $agreement->user->name() : '' ?></td>
    </tr>
    </tbody>
  <?php } ?>
    </table>
    </div>
    </div>
  
    </div>
    </div>
    </div>





<div class="col-sm-12">
<div class="card">

<div class="card-header">
   <h5 class="card-header-text">Customer Contracts</h5>
   <button id="edit-Contact" type="button"class="btn btn-primary btn-round btn-sm float-right" data-toggle="modal" data-target="#customer_contracts_model">Add Contract </button>
</div>

<div class="card-block">
<div class="card">
   <span class="text-primary">All customer legal documents are included in this part </span>
<div class="card-block">
<div class="table-responsive">
<table id="simpletable" class="table table-striped table-bordered nowrap dataTable">
<thead>
<tr>
<th>#</th>
<th>Contract Name</th>
<th>Contract Type</th>
<th>Start Date</th>
<th>End Date</th>
<th>Uploaded By</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$client_contracts = DB::select("select a.*,b.start_date,b.end_date,b.name,b.type,c.name as username from admin.client_contracts a join admin.contracts b on a.contract_id = b.id join admin.users c on c.id = b.user_id  where a.client_id= '{$client_id}' ");
$i = 1;
if (!empty($client_contracts)) {
foreach ($client_contracts as $client_contract) { 
?>
<tr>
<th scope="row"><?= $i ?></th>
<td><?= isset($client_contract->name) ? $client_contract->name : '' ?>
</td>
<td><?= isset($client_contract->type) ? $client_contract->type : 'Not Defined' ?>
</td>
<td><?= isset($client_contract->start_date) ? $client_contract->start_date : '' ?>
</td>
<td><?= isset($client_contract->end_date) ? $client_contract->end_date : '' ?>
</td>
<td><?= isset($client_contract->username) ? $client_contract->username : '' ?>
</td>
<td>
 <a type="button"
        class="btn btn-primary btn-sm btn-round"
        target="_blank"
        href="<?= isset($client_contract->contract_id) ? url('customer/viewContract/' . $client_contract->contract_id) : '' ?>">View</a>
<?php if(can_access('delete_contract')) { ?>
 <a type="button" class="btn btn-danger btn-sm btn-round"
        href="<?= isset($client_contract->contract_id) ? url('customer/deleteContract/' . $client_contract->contract_id) : '' ?>">Delete</a>
<?php }  ?>
</td>
</tr>

<?php
$i++;
}
}

?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="tab-pane" id="implementation" aria-expanded="false">


<div class="card">
<div class="card-header">
   <h5 class="h3 m-b-3">JOB CARD</h5>

<div class="card-block d-flex justify-content-between">
   <button type="button" class="float-right btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#jobcard-Modal">Create Job card </button>
   <button type="button" class="float-left user_dialog btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#uploadjobcard-Modal">Upload Job card</button>
</div>




<div class="modal fade" id="jobcard-Modal" tabindex="-1"
role="dialog" aria-hidden="true"
style="z-index: 1050; display: none;">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Create Job Card
</h4>
<button type="button" class="close"
data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<form action="<?= url('customer/createJobCard') ?>" method="post">
<div class="modal-body">
<div class="form-group">
<div class="row">
<div class="col-md-6">
<strong> Date</strong>
<input type="date"
class="form-control"
value="<?= date('Y-m-d') ?>"
name="date">
</div>

</div>
</div>

<div class="form-group">
<strong> Pick Modules where task will be
Performed</strong>
<hr>
<?php
$modules = DB::table('modules')->get();
if (!empty($modules)) {
foreach ($modules as $module) {
?>
<input type="checkbox"
id="features<?= $module->id ?>"
value="{{$module->id}}"
                name="module_ids[]">
<?php echo $module->name; ?> &nbsp;
&nbsp;
<?php
}
}
?>
</div>
</div>

<div class="modal-footer">
<button type="button"
class="btn btn-default btn-mini btn-round"
data-dismiss="modal">Close</button>
   <button type="submit" class="btn btn-primary btn-mini btn-round">Save changes</button>
</div>
<input type="hidden" value="<?= $client_id ?>"
name="client_id" />
<?= csrf_field() ?>
</form>
</div>
</div>
</div>

</div>

<div class="card-block">
<div class="table-responsive">
<table class="table table-bordered dataTable">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Created by</th> 
<th>View</th>
</tr>
</thead>
<tbody>
<?php
$x = 1;
$jobcards = \DB::select("select a.*,b.name from admin.client_job_cards a join admin.users b on a.created_by = b.id where client_id = '{$client_id}' order by a.id desc");
foreach ($jobcards as $jobcard) {
?>
<tr>
<th scope="row"><?= $x ?></th>
<td><?= date('d-m-Y', strtotime($jobcard->date)) ?></td>
<td><?= $jobcard->name ?? '' ?></td>
<td class="text-center">
 <a  target="_break" href="<?= url('customer/viewContract/' . $jobcard->id . '/jobcard') ?>" class="btn btn-sm btn-primary btn-round">View </a> 
</td>
</tr>
<?php
$x++;
}
?>

</tbody>
</table>
</div>
</div>
</div>



<div class="modal fade" id="uploadjobcard-Modal" tabindex="-1"
role="dialog" aria-hidden="true"
style="z-index: 1050; display: none;">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Upload Job Card 
</h4>
<button type="button" class="close"
data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>

<form action="<?= url('customer/uploadJobCard') ?>" method="post" enctype="multipart/form-data">
<div class="modal-body">
<div class="form-group">
<div class="row">
<div class="col-md-6">
<strong> Upload Job card</strong>
<input type="file"
class="form-control"
name="job_card_file">
</div>

<div class="col-md-6">
<strong>Job card date</strong>
<input type="date"
class="form-control" id="job_date" 
name="job_date" value="job_card"  required>
</div>
</div>
</div>
</div>

<div class="modal-footer">
<button type="button"
class="btn btn-default waves-effect "
data-dismiss="modal">Close</button>
<button type="submit"
class="btn btn-primary waves-effect waves-light ">Save
changes</button>
</div>
<input type="hidden" value="<?= $client_id ?>"
name="client_id" />
<?= csrf_field() ?>
</form>
</div>
</div>
</div>



<div class="modal fade" id="Update-trial" tabindex="-1"
role="dialog" aria-hidden="true"
style="z-index: 1050; display: none;">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title"> Update trial period
</h4>
<button type="button" class="close"
data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>

<form action="<?= url('customer/updateSchoolTrialPeriod') ?>" method="post">
<div class="modal-body">
<div class="form-group">
<div class="row">

<div class="col-md-6">
<strong>Start date</strong>
<input type="date" class="form-control"  name="start_date" value="<?= old('start_date')?>"  required>
</div>

<div class="col-md-6">
<strong> Period (Days)</strong>
<input type="number" class="form-control"  name="period" value="<?= old('period')?>"  required>
</div>

</div>
</div>
</div>

<div class="modal-footer">
<button type="button"
class="btn btn-default waves-effect "
data-dismiss="modal">Close</button>
<button type="submit"
class="btn btn-primary waves-effect waves-light ">Save
changes</button>
</div>
<input type="hidden" value="<?= $client_id ?>"
name="client_id" />
<?= csrf_field() ?>
</form>
</div>
</div>
</div>





<div class="modal fade" id="edit-Modal-task" tabindex="-1"
role="dialog">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Edit this task
</h4>
<button type="button" class="close"
data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>

<form action="" method="post">
<div class="modal-body">
<div class="form-group">
<div class="row">
<div class="col-md-6">
<strong> Upload Job card</strong>
<input type="file"
class="form-control"
name="job_card_file">
</div>


</div>
</div>
</div>

<div class="modal-footer">
<button type="button"
class="btn btn-default waves-effect "
data-dismiss="modal">Close</button>
<button type="submit"
class="btn btn-primary waves-effect waves-light ">Save
changes</button>
</div>
<input type="hidden" value=""
name="client_id" />
<?= csrf_field() ?>
</form>
</div>
</div>
</div>

<div class="card">
<div class="card-header">
<h5>Project Implementation Schedule</h5>
<span>This part have to be followed effectively </span>

<?php if(date('Y-m-d', strtotime($client->created_at. " + 7 days")) > date('Y-m-d')) { ?>
<p class="float-left">
   <button type="button" class="float-left user_dialog btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#Update-trial">Update trial</button>
</p>
<?php } ?>

<p class="float-right">
<?php $i_url = "customer/download/$client_id"; ?>
 <a href="<?= url($i_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Initial Implementation Plan">Implementation plan  </a>

</p>
</div>
<div class="card-block">
<div class="table-responsive">
<table class="table table-bordered dataTable">
<thead>
<tr>
<th>#</th>
<th>Task</th>
<th><?= ucfirst($schema) ?> Person </th>
<th>Start Date</th>
<th>End Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$x = 1;
$customer = new \App\Http\Controllers\Customer();
$trainings = \App\Models\TrainItemAllocation::where('client_id', $client_id)->orderBy('id', 'asc')->whereIn('train_item_id',\App\Models\TrainItem::where('status',1)->get(['id']))->get();
foreach ($trainings as $training) {
$status  = check_implementation($training->trainItem->content, $schema);
?>
<tr>
<th scope="row"><input type="checkbox"/></th>
<td><?= $training->trainItem->content ?></td>

<td> <b data-attr="school_person"
task-id="<?= $training->task->id ?>"
id="school_person<?= $training->id ?>"
contenteditable="true"
class="task_school_group"><?= strlen($training->school_person_allocated) > 4 ? $training->school_person_allocated : 'Not Allocated' ?></b>
</td>
<td>
<?php
if(preg_match('/not implemented/i', $status)){
if (date('Y', strtotime($training->start_date)) == 1970 || strtotime($training->start_date) < time()) {
?>
<select id="start_date<?= $training->id ?>"
class="task_group"
data-task-id="<?= $training->id ?>"
data-user_id="<?= $training->task->user_id ?>"><?= $customer->getDate($training->task->user_id, $training->start_date) ?></select>
<?php
} else {
echo date('d M Y', strtotime($training->start_date));
}
}
?>         
</td>
<td>

<b data-attr="end_date"
id="task_end_date_id<?= $training->id ?>"><?= date('Y', strtotime($training->end_date))==1970 ? '':date('d M Y', strtotime($training->end_date)) ?>
</b>

</td>
<td> 
<?php


echo $status;
?>

</td>
<td>
<?php
if(preg_match('/not implemented/i', $status)){
?>
<button task-id="<?= $training->id ?>" section_id="<?= $training->trainItem->id ?>" class="btn btn-primary btn-sm btn-round task_allocated_id">Save</button>
<?php } ?>
</td>
</tr>
<?php
$x++;
}
?>

</tbody>
</table>
</div>
</div>
</div>

</div>
<!-- About tab end -->
<!-- Photos tab start -->
<div class="tab-pane" id="photos" aria-expanded="false">
<!--                                                <div class="card">
<div class="card-footer">
<div class="row text-center">
<div class="col-sm-4">
<div class="social-media">
<span>Weekly Logins Users</span>
<i class="icofont  icofont-ui-user"></i>
<h5 class="counter">2587</h5>
</div>
</div>
<div class="col-sm-4">
<div class="social-media">
<span>Weekly Logins Parents</span>
<i class="icofont icofont-ui-user"></i>
<h5 class="counter">5987</h5>
</div>
</div>
<div class="col-sm-4">
<div class="social-media">
<span>Weekly Logins Users</span>
<i class="icofont  icofont-ui-user"></i>
<h5 class="counter">58,158</h5>
</div>
</div>
</div>
</div>
</div>-->

<div class="card">
<div class="card-header">
<h5>Client Usage Stages</h5>
<span>This part analyze customer system usage and provide a
guidance for account manager to guide properly a school to
reach the highest stage. </span>

</div>
<div class="card-block">
<div class="table-responsive">
 <table id="simpletable" class="table table-striped table-bordered nowrap dataTable">

<thead>
<tr>
<th>#</th>
<th>Module</th>
<th>Status</th>
</tr>

</thead>
<tbody>
<tr>
<th scope="row" colspan="3">
<label class="label label-inverse-primary">Stage 1</label>
</th>
</tr>

<tr>
<th scope="row">1</th>
<td>Basic Configuration</td>
<td>
<?php
//classlevel
$levels = DB::table($schema . '.classlevel')->get();
if (empty($levels)) {
echo '<label class="badge badge-warning">Class Level Not Defined</label>';
}
/**
* --Check if Academic Years defined
*/
if (!empty($levels)) {
foreach ($levels as $level) {

$academic_year = DB::table($schema . '.academic_year')->where('class_level_id', $level->classlevel_id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->first();
if (empty($academic_year)) {
echo '<label class="badge badge-inverse-warning">Academic Year Not Defined for ' . $level->name . ' (' . date('Y') . ')</label><br/>';
}
}
} else {
echo '<label class="badge badge-inverse-warning">Academic Year Not Defined</label><br/>';
}
/**
*
* Check if terms have been defined
*/
if (!empty($levels)) {
foreach ($levels as $level) {

$academic_year = DB::table($schema . '.academic_year')->where('class_level_id', $level->classlevel_id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->first();
if (empty($academic_year)) {
echo '<label class="badge badge-inverse-warning">No Terms Defined for ' . $level->name . ' (' . date('Y') . ')</label><br/>';
} else {
//check terms for this defined year
$terms = DB::table($schema . '.semester')->where('academic_year_id', $academic_year->id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->count();

echo $terms == 0 ? '<label class="badge badge-inverse-warning">No Terms Defined for ' . $level->name . ' (' . date('Y') . ')</label><br/>' : '<label class="badge badge-inverse-success">' . $level->name . ' (' . $academic_year->name . ') at ' . date('d M Y', strtotime($academic_year->created_at)) . '</label>';
}
}
} else {
echo '<label class="badge badge-inverse-warning">Not Defined</label><br/>';
}
/**
*
* --check if stamp has been defined
* Electronic Payments
*/
if (!empty($levels)) {
foreach ($levels as $level) {
if (strlen($level->stamp) < 3) {
echo '<label class="badge badge-inverse-warning">No Stamp for ' . $level->name . '</label><br/>';
}
}
}
?>

</td>
</tr>

<tr>
<th scope="row">2</th>
<td>Marking</td>
<td>
<?= check_status('mark'); ?>
</td>
<td></td>
</tr>
<tr>
<th scope="row">3</th>
<td>Exam Published</td>
<td><?= check_status('exam_report'); ?></td>
<td></td>
</tr>
<tr>
<th scope="row">4</th>
<td>Invoice Created</td>
<td> <?= check_status('invoices') ?></td>
<td></td>
</tr>
<tr>
<th scope="row">5</th>
<td>Payments Received</td>
<td> <?= check_status('payments'); ?></td>
<td></td>
</tr>
<tr>
<th scope="row">6</th>
<td>SMS sents</td>
<td> <?= check_status('sms'); ?>
<br />
<?php
/*
$karibu = DB::connection('karibusms')->table('client')->where('keyname', $schema)->first();
$karibu_shulesoft = DB::connection('karibusms')->table('client')->where('client_id', 318)->first();
if (!empty($karibu) && !empty($karibu_shulesoft) && $karibu->gcm_id = $karibu_shulesoft->gcm_id) {

$last_online = $karibu->last_reported_online;

$time = strtotime($last_online);
$tz_date = strtotime('-4 hours', $time);



$sms_time = date('d-m-Y H:i', $tz_date);
?>
Sent From <label
class="label label-success"> ShuleSoft
Phone</label><br />
Last Seen <label class="label label-info">
<?= $sms_time ?>
</label>
<?php
} else if (!empty($karibu)) {
$last_online = $karibu->last_reported_online;

$time = strtotime($last_online);
$tz_date = strtotime('-4 hours', $time);



$sms_time = date('d-m-Y H:i', $tz_date);
?>
Sent From <label
class="label label-success">
<?= $schema ?> Phone</label><br />
Last Seen <label class="label label-info">
<?= $sms_time ?>
</label>
<?php } */
?>
</td>
<td></td>
</tr>
<tr>
<th scope="row">7</th>
<td>Expenses</td>
<td> <?= check_status('expense', ' WHERE refer_expense_id in (select id from ' . $schema . '.refer_expense where financial_category_id in (2,3)) '); ?>
<br />
</td>
</tr>
<tr>
<th scope="row" colspan="3">
<label class="label label-inverse-primary">Stage 2</label>
</th>

</tr>
<tr>
<th scope="row">1</th>
<td>Payroll Usage</td>
<td> <?= check_status('salaries'); ?></td>
<td></td>
</tr>
<tr>
<th scope="row">2</th>
<td>Electronic Payments</td>
<td>
Integration Date:
<?= check_status('bank_accounts_integrations'); ?><br />
Last Online Transaction Date:
<?= check_status('payments', ' WHERE token is not null'); ?>
</td>
</tr>
<tr>
<th scope="row">3</th>
<td>Inventory Usage</td>
<td>Vendors Registered:
<?= check_status('admin.vendors', "WHERE schema_name='" . $schema . "'"); ?><br />
Items
Registered:<?= check_status('product_alert_quantity'); ?>

</td>
<td></td>
</tr>
<tr>
<th scope="row">4</th>
<td>Other Transactions</td>
<td>
Revenue:
<?= check_status('revenues', ' WHERE refer_expense_id in (select id from ' . $schema . '.refer_expense where financial_category_id=1) '); ?>
<br />

Capital :
<?= check_status('revenues', ' WHERE refer_expense_id in (select id from ' . $schema . '.refer_expense where financial_category_id=7) '); ?><br />
Fixed Assets:
<?= check_status('expense', ' WHERE refer_expense_id in (select id from ' . $schema . '.refer_expense where financial_category_id=4) '); ?><br />
Liabilities :
<?= check_status('expense', ' WHERE refer_expense_id in (select id from ' . $schema . '.refer_expense where financial_category_id=6) '); ?><br />
</td>
<td></td>
</tr>
<tr>
<th scope="row" colspan="3">
<label class="label label-inverse-primary">Stage 3</label>
</th>

</tr>
<tr>
<th scope="row">1</th>
<td>Library Usage</td>
<td>
Books Added:
<?= check_status('book'); ?><br />
Book Issue: <?= check_status('issue'); ?>
</td>

</tr>
<tr>
<th scope="row">2</th>
<td>Attendance Usage</td>
<td>
Student:
<?= check_status('sattendances'); ?>
<br />
Teacher: <?= check_status('uattendances'); ?>
<br />
Exam: <?= check_status('eattendance'); ?>
<br />
Teacher on Duty:
<?= check_status('teacher_duties'); ?>
</td>
<td></td>
</tr>
<tr>
<th scope="row">3</th>
<td>Routine Usage</td>
<td> <?= check_status('routine'); ?></td>
<td></td>
</tr>
<tr>
<th scope="row">4</th>
<td>General Character assessment</td>
     <td> <?=  check_status('general_character_assessment');  ?> 
     </td>
</tr>
<tr>
<th scope="row">5</th>
<td>Hostel</td>
<td> <?= check_status('hmembers'); ?> </td>
<td></td>
</tr>

<tr>
<th scope="row">6</th>
<td>Transport</td>
<td> <?= check_status('tmembers'); ?> </td>
</tr>
</tbody>
</table>
</div>
</div>
</div>












{{-- 

<div class="card">
<br>
<br>                                                
<div id="container_log" style="min-width: 80%;  height: 480px; margin: 0 auto">
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<hr/>
<div id="contain" style="min-width: 70%;  height: 480px; margin: 0 auto">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
</div>
</div> --}}

</div>

<div class="tab-pane" id="friends" aria-expanded="false">
<div class="card"> 
  <div class="card-block">
    <div class="table-responsive">
        <table id="example"  class="table dataTable table-mini table-striped table-bordered nowrap">
        <thead>
        <tr>
        <th>#</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Title</th>
        </tr>
        </thead>
        <tbody> 
        <?php $i = 1;
        $users = DB::table($schema . '.user')->where('status', 1)->get();
        if (!empty($users)) {
        foreach ($users as $user) {
        ?>
        <tr>
        <td><?= $i ?></td>
        <td><?= $user->name ?></td>
        <td><?= $user->phone ?></td>
        <td><?= $user->email ?></td>
        <td><?= $user->usertype ?></td>
        </tr>
        <?php
        $i++;  }
        }
        ?>
        </tbody>
        </table>
</div>
</div>
</div>
</div>


<!-- Friends tab end -->

<div class="tab-pane" id="payments" aria-expanded="false" >
<div class="row">
<div class="modal fade" id="standing-order-Modal" tabindex="-1"
role="dialog" aria-hidden="true"
style="z-index: 1050; display: none;">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">

<div class="modal-header">
<h6 class="modal-title">ADD STANDING ORDER</h6>
<button type="button" class="close"
data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>

<form action="{{ url('Customer/addstandingorder') }}" method="post"  enctype="multipart/form-data">
<div class="modal-body">
<div class="form-group">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
<div class="row">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
<div class="col-md-6">                                                                                                                                                                                                                                                                                                                                      
   <strong> Branch name </strong>
   <input type="text" placeholder="Bank branch name"  class="form-control"  name="branch_name" required>
</div>
<div class="col-md-6">
<strong> Contact person </strong>
   <input type="text" placeholder="Contact person"  class="form-control"  name="contact_person" required>
</div>
</div>
</div>

<div class="form-group">
<div class="row">
<div class="col-md-6">
<strong> Number of occurrence </strong>
<input type="number" placeholder="must be number eg 2, 3, 12 etc" oninput="calculate()" 
class="form-control" id="box1" name="number_of_occurrence" required>
</div>
<div class="col-md-6">
<strong> Basis </strong>
<select name="which_basis"  class=" select2" required>
<option value=""></option>
<option value="Annually">Annually</option>
<option value="Semiannually">Semi Annually</option>
<option value="Quarterly">Quarterly</option>
<option value="Monthly">Monthly</option>
</select>
</div>
</div>
</div>

<div class="form-group">
<div class="row">

<div class="col-md-6">
<strong> Amount for Every Occurrence </strong>
<input type="text" oninput="calculate()" 
class="form-control"  name="occurance_amount" id="box2" required>
</div>

<div class="col-md-6">
<strong> Total amount</strong>
<input type="text" class="form-control" name="total_amount"  required>
</div>
</div>
</div>

<div class="form-group">
<div class="row">
<div class="col-md-6">
<strong> Maturity Date</strong>
<input type="date"
class="form-control"
name="maturity_date" required>
</div>
<div class="col-md-6">
<strong> Standing order  </strong>
<input type="file"
class="form-control"
name="standing_order_file"
required>
</div>
</div>
</div>

<div class="form-group">
<div class="row">
<div class="col-md-6">
<strong> Refer bank</strong>
<select name="refer_bank_id"  required
class="f select2">
<?php
$banks = DB::table('constant.refer_banks')->get();
if (!empty($banks)) {
    foreach ($banks as $bank) {
        ?>
<option
    value="<?= $bank->id ?>">
        <?= $bank->name ?>
</option>
<?php
}
}
?>
</select>
</div>

</div>
</div>


<div class="form-group">
<div class="row">
<div class="col-md-12">
<strong> Note</strong>
<input type="text"
class="form-control"
name="note"
required>
</div>

</div>
</div>
</div>

<div class="modal-footer">
<button type="button"
class="btn btn-default btn-mini btn-round"
data-dismiss="modal">Close</button>
<button type="submit"
class="btn btn-primary btn-mini btn-round">Save
changes</button>
</div>
<input type="hidden" value="<?= $client_id ?>"
name="client_id" />
<?= csrf_field() ?>
</form>
</div>
</div>
</div>
</div>      



<div class="card">
<div class="card-header">

<div class="col-sm-4 my-2">
<a class="btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#standing-order-Modal">
    Add Standing Orders
</a>
</div>
 <div class="table-responsive">
 <table id="example"  class="table dataTable table-sm table-striped table-bordered nowrap">
<thead>
<tr>
    <th>#</th>
    <th>Type</th>
    <th>Occurance Amount </th>
    <th>Total Amount</th>
    <th>Maturity date</th>
    <th>Contact</th>

    <th colspan="1">Action</th>
</tr>
</thead>
<tbody>
<?php if (count($standingorders) > 0) { ?>
    <?php
    $i = 1;
    foreach ($standingorders as $order) {
        ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $order->type ?? '' ?></td>
            <td><?= money($order->occurance_amount) ?? '' ?></td>
            <td><?= money($order->total_amount) ?? '' ?></td>
            <td><?= date('d/m/Y', strtotime($order->payment_date)) ?? '' ?></td>
            <td><?= $order->schoolcontact->name ?? '' ?></td>

            <td><a target="_break" href="<?= url('customer/viewContract/' . $order->id . '/standing') ?>" class="btn btn-mini btn-round btn-primary btn-sm">View</a> 

            <?php if (!isset($order->payment_date) || !isset($order->type)) { ?>
                <a  href="<?= url('account/editStandingOrder/' . $order->id) ?>" class="btn btn-mini btn-round btn-info btn-sm">edit</a>
            <?php } ?>
            </td>
        </tr>
        <?php
        $i++;
    }
    ?>
 <?php } ?>
</tbody>

</table>
</div>


</div>
</div>





<div class="card">
<div class="card-header">
<div class="table-responsive dt-responsive">
<div class="table-responsive">
<h5>Invoices </h5>
<table id="example" class="table table-striped table-bordered nowrap dataTable">
<thead>
<tr>
    <th>Client Name</th>
    <th>Reference #</th>
    <th>Amount</th>
    <th>Paid Amount</th>
    <th>Remained Amount</th>
    <th>Due Date</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php
$total_amount = 0;
$total_paid = 0;
$total_unpaid = 0;
$i = 1;
foreach ($invoices as $invoice) {
    $amount = $invoice->invoiceFees()->sum('amount');
    $paid = $invoice->payments()->sum('amount');
    $unpaid = $amount - $paid;
    $total_paid += $paid;
    $total_amount += $amount;
    $total_unpaid += $unpaid;
    ?>

    <tr>
        <td><?= $invoice->client->username ?></td>
        <td><?= $invoice->reference ?></td>
        <td><?= money($amount) ?></td>
        <td><?= money($paid) ?></td>
        <td><?= money($unpaid) ?></td>
        <td><?= date('d M Y', strtotime($invoice->due_date)) ?>
        </td>
        <td>

            <div
                class="dropdown-secondary dropdown f-right">
                <button
                    class="btn btn-success btn-mini dropdown-toggle waves-effect waves-light"
                    type="button" id="dropdown"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">Options</button>
                <div class="dropdown-menu"
                        aria-labelledby="dropdown6"
                        data-dropdown-in="fadeIn"
                        data-dropdown-out="fadeOut"><a
                        class="dropdown-item waves-light waves-effect"
                        href="<?= url('account/invoiceView/' . $invoice->id) ?>"><span
                            class="point-marker bg-danger"></span>View</a>
                    <a class="dropdown-item waves-light waves-effect"
                        href="<?= url('account/invoice/edit/' . $invoice->id) ?>"><span
                            class="point-marker bg-warning"></span>Edit</a>
                            {{-- <a
                        class="dropdown-item waves-light waves-effect"
                        href="<?= url('account/invoice/delete/' . $invoice->id) ?>"><span
                            class="point-marker bg-warning"></span>Delete</a> --}}
                        <?php if ((int) $unpaid > 0) { ?>
                        <hr />
                        <a class="dropdown-item waves-light waves-effect"
                            href="<?= url('account/payment/' . $invoice->id) ?>"><span
                                class="point-marker bg-warning"></span>Add
                            Payments</a>
                    <?php } ?>
                    <?php if ((int) $unpaid > 0) { ?>
                        <a class="dropdown-item waves-light waves-effect"
                            href="#" data-toggle="modal"
                            data-target="#large-Modal"
                            onclick="$('#invoice_id').val('<?= $invoice->id ?>')"><span
                                class="point-marker bg-warning"></span>Send Invoice</a>
                        <?php } ?>
                        <?php if ((int) $paid > 0) { ?>
                        <a class="dropdown-item waves-light waves-effect"
                            href="<?= url('account/receipts/' . $invoice->id) ?>"
                            target="_blank"><span
                                class="point-marker bg-warning"></span>Receipt</a>
                        <?php }
                        ?>
                </div>
            </div>
        </td>
    </tr>
    <?php
    $i++;
}
?>
</tbody>
<tfoot>
<tr>
    <td colspan="2">Total</td>
    <td><?= money($total_amount) ?></td>
    <td><?= money($total_paid) ?></td>
    <td><?= money($total_unpaid) ?></td>
    <td colspan="2"></td>
</tr>
</tfoot>
</table>
</div>
</div>
</div>
</div>






</div>
<!-- Row end -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Page-body end -->
</div>
</div>

<div class="card-block">
<div class="modal fade" id="status-Modal" tabindex="-1" role="dialog" aria-hidden="true"
style="z-index: 1050; display: none;">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Change Schools Status</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<form action="<?= url('customer/schoolStatus') ?>" method="post">
<div class="modal-body">
<div class="form-group">
    <input type="hidden" value="<?= $schema ?>" name="schema_name" />
</div>
<div class="form-group">
    School <?= ucfirst($schema) ?> status
    <select name="status" class="form-control select2">
        <option value="">Select status</option>
        <option value="1">Active Paid</option>
        <option value="2">Active</option>
        <option value="3">Resale</option>
        <option value="4">Inactive</option>
    </select>
</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default btn-mini btn-round " data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary btn-mini btn-round ">Save changes</button>
</div>
<?= csrf_field() ?>
</form>
</div>
</div>
</div>
</div>
<div class="modal fade" id="customer_contracts_model" tabindex="-1" role="dialog" style="z-index: 1050; display: none;"
aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Upload Contract</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
<p align='center'><span class="label label-danger">Once you upload a contract, you cannot EDIT</span>
</p>
<form action="<?= url('customer/contract/' . $client_id) ?>" method="POST"
enctype="multipart/form-data">

<div class="form-group row">
<label class="col-sm-2 col-form-label">Contract Name</label>
<div class="col-sm-10">
    <input type="text" class="form-control" name="name" required="">
</div>
</div>


<div class="form-group row">
<label class="col-sm-2 col-form-label">Agreement Type</label>
<div class="col-sm-10">
    <select name="contract_type_id" class="form-control">

        <?php
        $ctypes = DB::table('admin.contracts_types')->where('id', '!=', '8')->get();
        if (!empty($ctypes)) {
            foreach ($ctypes as $ctype) {
                ?>
                <option value="<?= $ctype->id ?>"><?= $ctype->name ?></option>
                <?php
            }
        }
        ?>

    </select>
</div>
</div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Contract Start Date</label>
<div class="col-sm-10">
    <input type="date" class="form-control" value="" name="start_date" required="">
</div>
</div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Contract End Date</label>
<div class="col-sm-10">
    <input type="date" class="form-control" name="end_date" required="">
</div>
</div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Upload Document</label>
<div class="col-sm-10">
    <input type="file" class="form-control" accept=".pdf" name="file" required="">
</div>
</div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Notes</label>
<div class="col-sm-10">
    <textarea rows="5" cols="5" name="description" class="form-control"
                placeholder="Any important details about this document"></textarea>
</div>
</div>

<div class="form-group row">
<label class="col-sm-2 col-form-label"></label>
<div class="col-sm-10">
    <?= csrf_field() ?>
    <button type="submit" class="btn btn-success" placeholder="Default textarea">Submit</button>
</div>
</div>
</form>

<div class="modal-footer">
<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php
if (!empty($profile)) {  
?>
<div class="modal fade" id="school_details" tabindex="-1" role="dialog" style=" display: none;"aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
 <div class="modal-header">
  <div class="card-block">
    
<div class="row">
    <form action="<?= url('customer/editdetails/' . $client_id) ?>" method="POST">
        <div class="form-group row">
            <label class="col-sm-4">School Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="name" value="<?= $profile->name ?>">
            </div>
        </div>

         <div class="form-group row justify-content-center">
            <label class="col-sm-4 col-form-label">Estimated students</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="estimated_students" value="<?= $profile->estimated_students ?>">
            </div>
        </div>


         <div class="form-group row">
            <label class="col-sm-4 col-form-label">School Address</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="address" value="<?= $profile->address ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">School Email</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="email" value="<?= $profile->email ?>">
            </div>
        </div>


        <label class="">School Owner Contacts</label>
          <div class="form-group row">
            <div class="col-sm-6">
                 <label for="">Phone</label>
                <input type="text" class="form-control" name="owner_phone" value="<?= $profile->owner_phone ?>">
            </div>

              <div class="col-sm-6">
                 <label for="">Email</label>
                <input type="text" class="form-control" name="owner_email" value="<?= $profile->owner_email ?>">
            </div>
          </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-mini btn-round">Submit</button>
        </div>
   </form>
</div>
</div>
</div>
</div>

</div>
</div>



<div class="modal fade" id="agreement_school_details" tabindex="-1" role="dialog" style="display: none;"aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <div class="modal-header"> 
      <div class="card-block">
        
    <div class="row">
        <h5> Edit Agreement Details </h5>
         <br>
         <br>
         
        <form action="<?= url('sales/editAgreementDetails/' . $school_id) ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-sm-6">Contact Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contact_person_name" value="<?= $agreement->contact_person_name ?? '' ?>">
                </div>
            </div>
    
             <div class="form-group row ">
                <label class="col-sm-6">Contact Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contact_person_phone" value="<?= $agreement->contact_person_phone ?? '' ?>">
                </div>
            </div>

            <div class="form-group row ">
                <label class="col-sm-6">Contact person Designation</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contact_person_designation" value="<?= $agreement->contact_person_designation ?? '' ?>">
                </div>
            </div>
    
    
             <div class="form-group row">
                <label class="col-sm-6 col-form-label">Agreement Date</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="agreement_date" value="<?= $agreement->agreement_date ?? '' ?>">
                </div>
            </div>
    
    
              <div class="form-group row">
                <div class="col-sm-6">
                     <label for="type">Type</label>
                     <select name="form_type" class="form-control"  required>
                        <option value='0'> Choose</option>
                        <option value='Shulesoft'> Shulesoft</option>
                        <option value='NMB'> NMB </option>
                    </select>
                </div>
    
                  <div class="col-sm-6">
                     <label for="">Document</label>
                    <input type="file" class="form-control" name="agreement_file" >
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-6">
                     <label for="">NMB School name</label>
                    <input type="text" class="form-control" name="nmb_account_name" value="<?= $agreement->school->nmb_school_name ?? '' ?>">
                </div>
    
                  <div class="col-sm-6">
                     <label for="">NMB Account</label>
                    <input type="text" class="form-control" name="nmb_account" value="<?= $agreement->school->account_number ?? '' ?>">
                </div>
              </div>
    
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-mini btn-round">Submit</button>
            </div>
       </form>
      </div>
    </div>
    </div>
    </div>
    
 </div>
</div>

<?php } ?>
                                                                                                                  <!-- notify js Fremwork -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.brighttheme.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.buttons.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.history.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.mobile.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/pnotify/notify.css">

        <script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.desktop.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.buttons.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.confirm.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.callbacks.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.animate.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.history.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.mobile.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.nonblock.js"></script>
        <script type="text/javascript" src="<?= $root ?>assets/pages/pnotify/notify.js"></script>
        <script src="http://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyBgc2zYiUzXGjZ277annFVhIXkrpXdOoXw"></script>
        <script src="{{$root}}/js/jquery.geocomplete.min.js"></script>

      <script>

      


    function RemoveAttr(a) {
        var val = a;
        if (val !== '') {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: "<?= base_url('customer/removeTag/null') ?>",
                data: {"id": val},
                dataType: "html",
                success: function (data) {
                     toastr.success(data);
                     location.reload();
                }
            });
          }
        }
     
        function chooseValue(value){
              if(value == 'complete'){
                $('#end_date').hide();  
                $('#remainder_date').hide();  
              }else{
                $('#end_date').show();
                $('#remainder_date').show();
              }
            }


     function save(a, id, column) {
        var val = $('#' + a).text();
        if (val !== '') {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: "<?= base_url('account/editSetting/null') ?>",
                data: {"id": id, newvalue: val, column: column,table:'tasks'},
                dataType: "html",
                beforeSend: function (xhr) {
                    $('#stat' + id).html('<a href="#/refresh"<i class="feather icon-refresh-ccw f-13"></i> </a>');
                },
                complete: function (xhr, status)  {
                    $('#stat' + id).html('<label class="badge badge-info ">' + status + '</label>');
                },
                success: function (data) {
                     toastr.success(data);
                }
            });
          }
        }

          $(document).ready(function() {
           $('#example').DataTable();
          });

       $(".select2").select2({
            theme: "bootstrap",
            dropdownAutoWidth: false,
            allowClear: false,
            debug: true
        });
        
        $('#supplied').click(function() {
             $('#idate')[this.checked ? "show" : "hide"]();
         });

        function calculate() {
            var myBox1 = document.getElementById('box1').value;
            var myBox2 = document.getElementById('box2').value;
            ue;
            var result = document.getElementById('result');
            var myResult = myBox1 * myBox2;
            x2;
            result.value = myResult;
        }

 
        function save_comment(id) {
            var content = $('#task_comment' + id).val();
            var task_id = $('#task_id' + id).val();
            $.ajax({
                type: 'POST',
                 headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: "<?= url('customer/taskComment/null') ?>",
                data: {
                    content: content,
                    task_id: task_id
                },
                dataType: "html",
                success: function (data) {
                    $('input[type="text"],textarea').val('');
                    $('.new_comment' + id).after(data);
                }
            });
        }

        notify = function (title, message, type) {
            new PNotify({
                title: title,
                text: message,
                type: type,
                hide: 'false',
                icon: 'icofont icofont-info-circle'
            });
        }

        allocate = function (a, role_id) {
            $.ajax({
                url: '<?= url('customer/allocate/null') ?>',
                data: {
                    user_id: a,
                    school_id: '<?= $school->school_id ?? '' ?>',
                    role_id: role_id,
                    schema: '<?= $schema ?>'
                },
                dataType: 'html',
                success: function (data) {
                    $('#supportl').html(data);
                }
            });
        }

        show_tabs = function (a) {
            $('.live_tabs').hide(function () {
                $('#' + a).show();
            });
        }

        $('#school_id').click(function () {
            var val = $(this).val();
            $.ajax({
                url: '<?= url('customer/search/null') ?>',
                data: {
                    val: val,
                    type: 'school',
                    schema: '<?= $schema ?>'
                },
                dataType: 'html',
                success: function (data) {

                    $('#search_result').html(data);
                }
            });
        });

  
       

        task_group = function () {
            $('.task_groups').change(function () {
                var val = $(this).val();
                var task_id = $(this).attr('data-task-id');
                var data_attr = $('#task_user' + task_id).val();
                $.ajax({
                    url: '<?= url('customer/getAvailableSlot') ?>/null',
                    method: 'get',
                    data: {
                        start_date: val,
                        user_id: data_attr
                    },
                    success: function (data) {
                        $('#start_slot' + task_id).html(data);
                    }
                });
            });
            $('.task_school_group').blur(function () {
                var val = $(this).text();
                var data_attr = $(this).attr('data-attr');
                var task_id = $(this).attr('task-id');
                // var date=$('#'+task_id).val();
                $.ajax({
                    url: '<?= url('customer/editTrain') ?>/null',
                    method: 'get',
                    dataType: 'html',
                    data: {
                        task_id: task_id,
                        value: val,
                        attr: data_attr
                    },
                    success: function (data) {
                        // $(this).after(data).addClass('label label-success');
                        notify('Success', 'Success', 'success');
                    }
                });
            });
            $(document).on("click", ".user_dialog", function () {
                var UserName = $(this).data('id');
                $(".modal-body #job_date").val(UserName);
            });
            $('.slot').change(function () {
                var val = $(this).val();
                //var data_attr = $(this).attr('data-attr');
                var task_id = $(this).attr('data-id');
                var date = $('#' + task_id).val();
                $.ajax({
                    url: '<?= url('customer/editTrain') ?>/null',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        task_id: task_id,
                        value: date,
                        slot_id: val,
                        attr: 'start_date'
                    },
                    success: function (data) {
                        $('#task_end_date_id' + data.task_id).html(data.end_date);
                        notify('Success', 'Success', 'success');
                    }
                });
            });
            
            $('.task_allocated_id').mousedown(function () {
                var task_id = $(this).attr('task-id');
                var start_date = $('#start_date' + task_id).val();
                var school_person = $('#school_person' + task_id).text();
                var section_id = $(this).attr('section_id');
                $.ajax({
                    url: '<?= url('customer/editTrain') ?>/null',
                    method: 'get',
                    data: {
                        task_id: task_id,
                        start_date: start_date,
                        school_person: school_person,
                        section_id: section_id
                    },
                    success: function (data) {
                        notify('Success', data, 'success');
                    }
                });
            });
        }
        $(document).ready(task_group);
        $("#town").geocomplete()
                .bind("geocode:result", function (event, result) {
                    var loc = result.geometry.location;
                    $("#location").val(loc.lng() + ", " + loc.lat());
                })
                .bind("geocode:error", function (event, status) {
                    console.log("ERROR: " + status);
                })
                .bind("geocode:multiple", function (event, results) {
                    console.log("Multiple: " + results.length + " results found");
                });
        </script>
         @endsection