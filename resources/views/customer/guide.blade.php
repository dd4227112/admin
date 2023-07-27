@extends('layouts.app')
@section('content')

     <div class="page-header">
        <div class="page-header-title">
            <h4><?='Guide' ?></h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">user manual</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">operations</a>
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
                            <h5>Guide</h5>
                            <span>You can view and edit user manual contents</span>

                          
                            <div class="row">
                                <div class="col-md-6">
                                      <p align='left'>
                                        <a class="btn btn-primary btn-mini btn-round" href="<?= url('customer/guide/null?pg=add') ?>">Add New Guide</a>
                                      </p>
                                    <br/>
                                </div>

                                <div class="col-md-3">
                                      <p align='left'>
                                        <label for="guide_type">Guide Type</label>
                                      <select class="form-control select2" id="guide_type">
                                      <option  value="">All</option>
                                      <?php
                                        $guide_types = [
                                            '1' =>'Product requirement documentation',
                                            '2' =>'UX design documentation',
                                            '3'=>'Software architecture design documentation',
                                            '4'=>'Source code documentation',
                                            '5'=>'Quality assurance documentation',
                                            '6'=>'Maintanance and help guide',
                                            '7'=>'API documentation',
                                            '8'=>'End -user documentation',
                                            '9'=>'System admin documentation',
                                        ];?>
                                        <?php 
                                        foreach($guide_types as $key=>$value){?>
                                                <option  value="<?=$key?>" <?=$key==$guide_selected?'selected':''?>><?=$value?></option>
                                            <?php  } ?>
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
                                            <th>Access Title</th>
                                            <th>Module Name</th>
                                            
                                            <th>Created By</th>  
                                            <th>Page Views</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (sizeof($guides) > 0) {
                                            foreach ($guides as $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= isset($value->permission->display_name) ? $value->permission->display_name : '' ?></td>
                                                    <td><?= isset($value->permission->permissionGroup->name) ? $value->permission->permissionGroup->name : '' ?></td>
                                                   
                                                    <td><?= $value->createdBy->firstname . ' ' . $value->createdBy->lastname ?></td>
                                                    <td><?=$value->guidePageVisit()->count()?></td>
                                                    <td>
                                                        <a href="#"  data-toggle="modal" data-target="#exampleModal<?= $i ?>" data-whatever="@mdo" class="btn btn-success btn-mini btn-round">View</a>
                                                         <div class="modal fade modal-flex" id="exampleModal<?= $i ?>" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                              <div class="modal-content">
                                                                <div class="modal-body model-container">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    <h5 class="font-header"><?= $value->permission->display_name ?? '' ?></h5>
                                                                        <p>  <?= wordwrap($value->content, 80, "<br>") ?? '' ?> </p>
                                                                    <div class="overflow-container">
                                                                        <h6>image</h6>
                                                                    </div>
                                                                   
                                                                    <img src="<?= $value->companyFile->path ?? 'No image' ?>" alt="Detailed image" class="img img-fluid">
                                                                    
                                                                </div>
                                                                
                                                            </div>
                                                            </div>
                                                           </div>


                                                        {{-- <div class="modal fade bs-example-modal-lg" id="exampleModl<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span></button>
                                                                        <h4 class="modal-title" id="exampleModalLabel1">How to <?= $value->permission->display_name ?></h4> </div>
                                                                    <div class="modal-body">
                                                                       <p class="text-justify"> <?= $value->content ?> </p>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <?= $value->content ?>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}

                                                        <?php echo '<a  href="' . url("/customer/guide/edit/$value->id") . ' " class="btn btn-info btn-mini btn-round">' . __('edit') . ' </a>' ?>

                                                        <?php // if(can_access('delete_guide')) { ?>
                                                        <?php echo '<a  href="' . url("customer/guide/delete/$value->id") . ' " class="btn btn-danger btn-mini btn-round delete_button" id="'.$value->id.'">' . __('delete') . ' </a>' ?>
                                                        <?php // } ?>
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
        $('#guide_type').change(function () {
            var val = $(this).val();
            window.location.href = '<?= url('customer/guide/null?pg=') ?>' + val;
        })
    }
    $(document).ready(school_selector);
    document.ready(function(){
        $('.delete_button').click(function(){
            Swal.fire({
      title: "Are you sure?",
      text: "This action cannot be undone.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      // If the user confirmed the deletion
      if (result.isConfirmed) {
        return true;
      }
    });
        });
    });
</script>
@endsection