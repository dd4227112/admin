@extends('layouts.app')
@section('content')


    
       <div class="page-header">
            <div class="page-header-title">
                <h4><?='Schools Users panel' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">School Users</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Password</a>
                    </li>
                </ul>
            </div>
        </div> 
       
        <div class="page-body">
                <div class="col-lg-12">

                           <div class="card">
                            <div class="card-block">
                             <form method="post">

                             <div class="row">
                                <div class="col-sm-12 col-xl-6 m-b-30">
                                    <h4 class="sub-title">Select School</h4>
                                    <select name="schema_name" class="form-control select2" id="payment_schema">
                                        <option value="0">Select</option>
                                        <?php
                                        $schemas = DB::select('select distinct "schema_name" from admin.all_setting');
                                        foreach ($schemas as $schema) {
                                            ?>
                                            <option value="<?= $schema->schema_name ?>"><?= $schema->schema_name ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>

                                 <div class="col-sm-3 col-xl-4 m-b-30">
                                    <h4 class="sub-title">Select Type</h4>
                                        <select class="form-control" name="table" id="usertable" required>
                                            <option value="">select</option>
                                            <option value="parent">Parent</option>
                                            <option value="student">Student</option>
                                            <option value="teacher">Teacher</option>
                                            <option value="user">Other Staffs</option>
                                        </select>
                                  </div>

                                 
                                   <div class="col-sm-3 col-xl-2 m-b-30">
                                      <h4 class="sub-title"> &nbsp;&nbsp; </h4>
                                      <button type="submit" name="submit" class="btn btn-primary btn-mini btn-round"> Submit </button>
                                   </div>
                                </div>
                                  <?= csrf_field() ?>
                                </form>
                                </div>
                            </div>
                        
                     <?php if (isset($users) && count($users) > 0) { ?>
                        <div class="card">
                        <div class="card-block">
                           <div id="sync_status"></div>
                            <div class="table-responsive dt-responsive "> 
                                <table id="api_requests" class="table table-striped dataTable table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Phone</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>School</th>
                                            <th>Channel</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i = 1;
                                            foreach ($users as $tran) {
                                        ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $tran->name ?></td>
                                                <td><?= $tran->phone ?></td>
                                                <td><?= $tran->username ?></td>
                                                <td><?= $tran->default_password ?></td>
                                                <td><?= $tran->schema_name ?></td>
                                                <td>
                                                <a href="#" onclick="return false" class="btn btn-primary btn-mini btn-round" onmousedown="reconcile('<?=$tran->table?>','<?=$tran->id?>','<?=$tran->schema_name?>','message')"> Message </a>
                                                <a href="#" onclick="return false" class="btn btn-success btn-mini btn-round" onmousedown="reconcile('<?=$tran->table?>','<?=$tran->id?>','<?=$tran->schema_name?>','whatsapp')"> Whatsapp </a>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    ?>
                                       
                                    </tbody>
                                </table>
                             </div>
                           </div>
                         </div>
                      <?php   } ?>

                    </div> 
              </div> 
           </div>
     </div>

<script type="text/javascript">
    reconcile = function (a,b,c,d) {
        $.ajax({
            url: '<?=url('Workshop/resetP')?>',
            method: 'POST',
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
            data: {
                "id": b,
                "table": a,
                "schema": c,
                "type": d
              },dataType: "html ",
              success: function (data) {
                toast(data);
              }
        });
    }

    $(".select2").select2({
        theme: "bootstrap",
        dropdownAutoWidth: false,
        allowClear: false,
        debug: true
    });


</script>
@endsection

