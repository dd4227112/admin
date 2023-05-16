@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/' ?>
    <div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Current Quarter</a></li>
                </ol>
            </div>
            <h4 class="page-title">Current Quarter</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info">
                    Set the current quarter
                </div>
                    <?php if(empty($quarters)){?>
            <button class="btn btn-primary btn-sm add-quarter" role="button"> Add Quarter</i></button>
       
        <br/><br/><br/>
        <?php }?>
                    <form action="<?=base_url('role/updateQuarter')?>" method="post">
                   
                 <div class="table-responsive">
                                   <table id="dt-ajax-array" class="table table-striped table-bordered dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Start Date</th>  
                                            <th>End Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($quarters)){?>
                                        <tr>
                                        <td>1</td>
                                        <td class="text-center"><?=$quarters->name?></td>
                                        <td class="text-center"><?=$quarters->start_date?></td>
                                        <td class="text-center"><?=$quarters->end_date?></td>
                                        <td class="text-center"><button class="btn btn-primary" id="edit-btn">Edit</button>
                                    </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                            </table>
                            <?php if(!empty($quarters)){?>
                            <input type="hidden" name ="id" value ="<?=$quarters->id?>">
                            <?php } ?>
                            
                            </form>
                </div>
            </div>
        </div>
    </div>
<!-- Edit permission modal -->
<div class="modal fade" id="addQuarter">
    <div class="modal-dialog">
        <form  action="<?=base_url('Role/saveQuarter')?>" method="post" class="form-horizontal group_form " role="form">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Quarter</h5>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label> Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Quarter name E.g First Quarter" name="name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label> Start Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" 
                                        name="start_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label> End Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control"
                                        name="end_date" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>
    </div>
</div>
<script>
  $(document).ready(function() {
    // Handle edit button click
    $('#edit-btn').click(function() {
      // Get the table row
      var row = $(this).closest('tr');
      
      // Get the data in the row
      var name = row.find('td:eq(1)').text();
      var start_date = row.find('td:eq(2)').text();
      var end_date = row.find('td:eq(3)').text();

      
      // Replace the row data with input fields
      row.find('td:eq(1)').html('<input type="text" style ="width:90%" name ="name" class="form-control" value="' + name + '">');
      row.find('td:eq(2)').html('<input type="date" style ="width:90%"  name ="start_date" class="form-control" value="' + start_date + '">');
      row.find('td:eq(3)').html('<input type="date" style ="width:90%;"  name ="end_date" class="form-control" value="' + end_date + '">');

      
      // Replace the edit button with a save button
      row.find('td:eq(4)').html('<button type="submit" class="btn btn-success save-btn">Save</button>');
    });

    $('.add-quarter').on('click', function(e) {
    $('#addQuarter').modal('show');
    });
  });
</script>


@endsection
