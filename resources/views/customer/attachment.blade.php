
@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';
?>

<!-- Sidebar inner chat end-->
<!-- Main-body start -->

<!-- Page-header start -->
<div class="page-header">
    <div class="page-header-title">
        <h4>Task Attachment</h4>
    </div>
    <a class="badge badge-inverse-primary" href="<?=base_url('customer/profile/'.$school)?>">Back</a>

    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#!">request</a>
            </li>
            <li class="breadcrumb-item"><a href="#!">operations</a>
            </li>
        </ul>
    </div>
</div> 
<!-- Page-header end -->
<!-- Page-body start -->
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
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
                                                                                </div>
                                                                                <p class="text-muted editable" id="txt1<?= $task->id ?>">
                                                                                    {{-- <?= $task->activity ?> --}}

                                                                                    <span style="text-decoration: none;" <?= $task->user->id == \Auth::user()->id && date('Y-m-d H:i:s') < date('Y-m-d H:i:s', strtotime("+60 minutes", strtotime($task->created_at))) ? 'contenteditable="true"' : 'contenteditable="false"' ?> onblur="save('<?= $task->id . 'activity' ?>', '<?= $task->id  ?>','activity')" id="<?= $task->id . 'activity' ?>"> <?= $task->activity == '' ? 'null' : $task->activity ?></span>
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
                                                                                    <?= date('Y-m-d', strtotime($task->end_date)) == '1970-01-01' ? '' : 'End Date - ' . $task->end_date  ?></p>

                                                                                <p>Assigned to -
                                                                                    @foreach ($task->taskUsers as $value)
                                                                                    <?= '<label class="badge badge-inverse-primary">' . $value->user->name() . '</label>' ?>
                                                                                    &nbsp; &nbsp;
                                                                                    @endforeach
                                                                                </p>
                                                                            </div>
                                                                        </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                @if($task->attachment_type =='Image')
                <img src="<?php echo base_url('storage/uploads/images/' . $task->attachment); ?>">
                @endif
                @if($task->attachment_type =='Video')
                <video src="<?php echo base_url('storage/uploads/images/' . $task->attachment);?>" width="640" height="360" controls  loop>
                  </video>

                @endif
                @if($task->attachment_type =='Audio')
                <audio controls>
                <source src="<?php echo base_url('storage/uploads/images/' . $task->attachment); ?>">
                </audio>
                @endif

            </div>
        </div>
    </div>
</div>

<script>

</script>
 @endsection

