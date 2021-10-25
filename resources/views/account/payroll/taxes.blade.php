@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">

        <div class="page-header">
            <div class="page-header-title">
                <h4>Taxes</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">current taxes</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">payroll</a>
                    </li>
                </ul>
            </div>
        </div> 
    
     <div class="page-body">
        <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>All taxes</h5>
           </div>

           <div class="card-block">
             <div class="col-sm-12">
             <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-2">Income Tax Year</label>
                <div class="col-sm-6">
                    <select class="form-control" name="request_type" id="tax_table">
                        <option value="0">Select Table Year Here to continue...</option>
                        @foreach ($tables as $table)
                        <option value="{{ $table->id }}"> {{ $table->name }} </option>
                        @endforeach
                    </select>
                </div>
                </div>
              </div>
           </div>

             
              <div class="card-block">
                <div class="table-responsive">
		          <?php if(isset($taxes) && !empty($taxes)) { ?>
                    <h6 class="text-center"> <strong>Income Tax Table <?= isset($status) ? 'for '. $status->name .'  Between <u>'.$status->start_date. '</u> To <u>'. $status->end_date .'</u>': '' ?> </strong> </h6>
                        <br>

                    <table class="table dataTable table-sm table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>From Amount</th>
                                <th>To Amount</th>
                                <th>Tax Rate</th>
                                <th>Excess Amount</th>
				                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($taxes as $tax) { ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                     <td>
                                        <?php echo $tax->name; ?>
                                    </td>
                                    <td>
                                        <?php echo money($tax->from); ?>
                                    </td>
                                    <td>
                                        <?php echo money($tax->to); ?>
                                    </td>
                                    <td>
                                        <?php echo $tax->tax_rate; ?>
                                    </td>
                                    <td>
                                        <?php echo money($tax->tax_plus_amount); ?>
                                    </td>
                                   
				                     <td>
                                        <?php echo warp($tax->description,18); ?>
                                    </td>
                                    
                                </tr>
                            <?php $i++; } ?>
                         </tbody>
                      </table>
                    </div>
		            <?php } ?>
                </div>
                
            </div> 
          </div> 
             
        </div>
    </div>

    
</div><!-- /.box -->
</div>
<script type="text/javascript">
     $('#tax_table').change(function () {
            var request_type =  $('#tax_table').val();
            if (request_type == '') {
                return false;
            } else {
                window.location.href = "<?= base_url('Payroll/taxes') ?>/"  + request_type;
            }
        });


    $('#classlevel_id').change(function() {
        var classesID = $(this).val();
        if(classesID == 0) {
            $('#hide-table').hide();
        } else {
            $.ajax({
                type: 'POST',
                url: "<?=base_url('payroll/payroll_list')?>",
                data: "id=" + classesID,
                dataType: "html",
                success: function(data) {
                    window.location.href = data;
                }
            });
        }
    });
</script>
@endsection