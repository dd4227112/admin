@extends('layouts.app')
@section('content')

<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Customer Analysis</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Error Logs</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="card" style="height: 65em">
                        <div class="card-block tab-icon">
                            <!-- Row start -->
                            <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                    <!-- <h6 class="sub-title">Tab With Icon</h6> -->
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs md-tabs " role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><i
                                                    class="icofont icofont-home"></i>Requirements</a>
                                            <div class="slide"></div>
                                        </li>
                                        
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#addnew" role="tab"><i
                                                    class="icofont icofont-list "></i>Add New</a>
                                            <div class="slide"></div>
                                        </li>

                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content card-block">
                                        <div class="tab-pane active" id="home7" role="tabpanel">
                                            <div class="card-block task-list">
                                                <div class="table-responsive dt-responsive">
                                                    <table id="dt-ajax-array"
                                                        class="table table-striped table-bordered nowrap dataTable">
                                                        <thead>

                                                            <tr>
                                                                <th>#</th>
                                                                <th>Task list</th>
                                                                <th>Last Commit</th>
                                                                <th>Status</th>
                                                                <th>Assigned</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="task-page">
                                                       
                                                            <?php
                            
                                                            if(sizeof($requirements) > 0){
                                                                $i = 1;
                                                            foreach ($requirements as $req) {

                                                            ?>
                                                       
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td><?= ucfirst($req->school->name) ?> <?= ucfirst($req->school->name) ?> <?= ucfirst($req->school->name) ?></td>
                                                                <td>
                                                                    <input type="date" value="<?=old('created_at', date("Y-m-d", strtotime($req->created_at))) ?>" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <select name="select"
                                                                        class="form-control form-control-sm">
                                                                        <option value="<?= $req->status ?>"><?= $req->status ?></option>
                                                                        <option value="opt1">Open</option>
                                                                        <option value="opt2">Resolved</option>
                                                                        <option value="opt3">Invalid</option>
                                                                        <option value="opt4">On hold</option>
                                                                        <option value="opt5">Close</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                <?php echo $req->toUser->name;?>
                                                                    <a href="#"><i
                                                                            class="icofont icofont-plus f-w-600"></i></a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a class="dropdown-toggle addon-btn"
                                                                        data-toggle="dropdown" aria-expanded="true">
                                                                        <i class="icofont icofont-ui-settings"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item" href="<?= url('customer/requirements/show/' . $req->id) ?>"><i class="icofont icofont-attachment"> </i>View</a>
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="icofont icofont-attachment"></i>Attach
                                                                            File</a>
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="icofont icofont-ui-edit"></i>Edit
                                                                            Task</a>
                                                                        <div role="separator" class="dropdown-divider">
                                                                        </div>
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="icofont icofont-refresh"></i>Reassign
                                                                            Task</a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            
                                                          <?php }
                                                                }  ?>
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="addnew" role="tabpanel">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Add New Requirement</h4>
                                                    <span>This Part Allow you to add New Requirement School</span>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="#" method="post">

                                                        <div class="form-group">
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <strong> Select School</strong>
                                                                    <input type="number" class="form-control"
                                                                        id="get_schools" name="school_id" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <strong>School Contacts Phone/Email</strong>
                                                                    <input type="text" name="contact"
                                                                        style="text-transform:uppercase"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <strong> Person Allocated to do</strong>
                                                            <select name="to_user_id" class="form-control select2"
                                                                required>
                                                                <?php
                                                                $staffs = DB::table('users')->where('status', 1)->where('role_id', '<>', 7)->get();
                                                                foreach ($staffs as $staff) {
                                                                    ?>
                                                                <option value="<?= $staff->id ?>">
                                                                    <?= $staff->firstname . ' ' . $staff->lastname ?>
                                                                </option>
                                                                <?php } ?>

                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <strong> More Details</strong>
                                                            <textarea name="note" rows="3" id="content_part"
                                                                placeholder="Write More details Here .."
                                                                class="form-control"> </textarea>
                                                        </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light ">Submit
                                                        Here</button>
                                                </div>
                                                <?= csrf_field() ?>
                                                </form>
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
    </div>
</div>
</div>
<script>
    get_schools = function () {
        $("#get_schools").select2({
            minimumInputLength: 2,
            // tags: [],
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '<?= url('
                student / getschools / null ') ?>',
                dataType: 'json',
                type: "GET",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term,
                        token: $('meta[name="csrf-token"]').attr('content')
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            };
                        })
                    };
                }
            }
        });
    }

    $(document).ready(get_schools);

</script>

<script src="<?= url('public/assets/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript">
    wywig = function () {
        tinymce.init({
            selector: 'textarea#content_part',
            height: 200,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            content_css: [
                '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                '//localhost/shule/public/assets/tinymce/codepan.css'
            ]
        });
    }
    wywig();

</script>
@endsection
