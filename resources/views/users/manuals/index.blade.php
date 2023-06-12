@extends('layouts.app')
@section('content')

     <div class="page-header">
        <div class="page-header-title">
            <h4><?='Operation Manuals' ?></h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Users</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Operation Manuals</a>
                </li>
            </ul>
        </div>
    </div> 
        
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Manuals</h5>
                         
                            <div class="row">
                                <div class="col-md-6">
                                      <p align='left'>
                                        <a class="btn btn-primary btn-mini btn-round" href="<?= url('report/manuals/null?page=add') ?>">Add New Manual</a>
                                      </p>
                                    <br/>
                                </div>

                                <div class="col-md-3">
                                      <p align='left'>
                                        <label for="guide_type">Departments</label>
                                      <select class="form-control select2" id="department">
                                      <option  value="all">All</option>
                                         @if(!empty($departments))
                                        @foreach($departments as $key=>$department)
                                                <option  value="<?=$department->id?>" <?=$department_id ==$department->id?'selected':''?>><?=$department->name?></option>
                                        @endforeach
                                        @endif
                                        </select>
                                      
                                      </p>
                                    <br/>
                                </div>
                            </div>
                          
                        </div>

                        <div class="card-block">
                                <div class="table-responsive">
                                   <table id="dt-ajax-array" class="table table-striped table-bordered dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Department</th>
                                            <th>Task Name</th>
                                            <th>Content</th> 
                                            <th>Created By</th>  
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> @if(!empty($department_tasks))
                                        <?php $no=1;?>
                                        @foreach($department_tasks as $key=>$tasks)
                                        <tr>
                                            <td><?=$no?></td>
                                            <td><?=$tasks->department->name?></td>
                                            <td><?=$tasks->name?></td>
                                            <td>
                                            <a href="#"  data-toggle="modal" data-target="#exampleModal<?= $no ?>" data-whatever="@mdo" class="btn btn-info btn-mini btn-round">view content</a>
                                                         <div class="modal fade modal-flex" id="exampleModal<?= $no ?>" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                              <div class="modal-content">
                                                                <div class="modal-body model-container">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    <h5 class="font-header"><?= $tasks->name ?? '' ?></h5>
                                                                        <p>  <?= wordwrap($tasks->content, 80, "<br>") ?? '' ?> </p>
                                                                </div>
                                                                
                                                            </div>
                                                            </div>
                                                           </div>
                                        </td>
                                            <td><?=$tasks->user->firstname." ".$tasks->user->lastname?></td>
                                            <td class="text-center">
                                                <a  href="<?=base_url('report/editManual/'.$tasks->id)?>" class="btn btn-mini btn-round  edit_content btn-success " id ="<?=$tasks->id?>">edit</a>
                                                <a href="<?=base_url('report/deleteManual/'.$tasks->id)?>" class="btn btn-mini btn-round  delete_content btn-danger " id ="<?=$tasks->id?>">delete</a>
                                            </td>

                                        </tr>
                                        <?php $no++;?>
                                        @endforeach
                                        @endif
                                    

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

<script type="text/javascript">
    content_for = function () {
        $('#permission_group').change(function () {
            var group_id = $(this).val();
            if (group_id === '0') {
                $('#content_for').val(0);
            } else {
                $.ajax({
                    type: 'get',
                    url: "<?= url('support/getPermission') ?>",
                    data: "group_id=" + group_id,
                    dataType: "html",
                    success: function (data) {
                        $('#content_for').html(data);
                    }
                });
            }
        });
    }
    school_selector = function () {
        $('#department').change(function () {
            var val = $(this).val();
            window.location.href = '<?= url('report/manuals/null?deparment=') ?>' + val;
        })
    }
    $(document).ready(school_selector);
</script>
@endsection