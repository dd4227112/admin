@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Payroll</h4>
                <span>Tax Status</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Payroll</a>
                    </li>
                </ul>
            </div>
        </div>
    
     <div class="page-body">
        <div class="row">
          <div class="card">
            <div class="col-sm-12">
              <div id="hide-table" class="card-block">
                 <div class="table-responsive table-sm table-striped table-bordered table-hover">
		          <?php if(isset($taxes) && !empty($taxes)) { ?>
                    <table id="example1" class="table dataTable">
                        <thead>
                            <tr>
                                <th class="col-lg-1">#</th>
                                <th class="col-lg-2">Name</th>
                                <th class="col-lg-1">From Amount</th>
                                <th class="col-lg-1">To Amount</th>
                                <th class="col-lg-1">Tax Rate</th>
                                <th class="col-lg-1">Excess Amount</th>
				                <th class="col-lg-2">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($taxes as $tax) { ?>
                                <tr>
                                    <td data-title="<?=__('slno')?>">
                                        <?php echo $i; ?>
                                    </td>
                                     <td data-title="<?=__('payroll_name')?>">
                                        <?php echo $tax->name; ?>
                                    </td>
                                    <td data-title="<?=__('payroll_from')?>">
                                        <?php echo $tax->from; ?>
                                    </td>
                                    <td data-title="<?=__('payroll_to')?>">
                                        <?php echo $tax->to; ?>
                                    </td>
                                    <td data-title="<?=__('tax_rate')?>">
                                        <?php echo $tax->tax_rate; ?>
                                    </td>
                                    <td data-title="<?=__('excess_amount')?>">
                                        <?php echo $tax->tax_plus_amount; ?>
                                    </td>
                                   
				                     <td data-title="<?=__('description')?>">
                                        <?php echo $tax->description; ?>
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
    $('#classlevel_id').change(function() {
        var classesID = $(this).val();
        if(classesID == 0) {
            $('#hide-table').hide();
        } else {
            $.ajax({
                type: 'POST',
                url: "<?=url('payroll/payroll_list')?>",
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