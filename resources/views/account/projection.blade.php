@extends('layouts.app')
@section('content')

<?php
$root = url('/') . '/public/';
function tagEdit($schema_name, $column, $value, $type = null) {
      $type = null ? $type = '"text"' : $type = $type;
    if ((int) request('skip') == 1) {
        $return = $value;
    } else {
        $return = '<input required class="text-muted" type="'. $type. '" schema="' . $schema_name . '" id="' . $column .$schema_name. '" value="' . $value . '" onblur="edit_records(\'' . $column . '\', this.value, \'' . $schema_name . '\')"/>
        <br/><p id="status_' . $column . $schema_name . '"></p>';
    }
    return $return;
  }
 ?>



<div class="main-body">
  <div class="page-wrapper">

     <div class="page-header">
            <div class="page-header-title">
                <h4>Create Invoices</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">payroll</a>
                    </li>
                </ul>
            </div>
        </div>

    <div class="page-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card"> 
                    <div class="card-block">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <div class="sub-title">Manage Invoices</div>                                        
                                <ul class="nav nav-tabs md-tabs " role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#profile7" role="tab">SHULESOFT INVOICE</a>
                                        <div class="slide"></div>
                                    </li>

                                     <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#other" role="tab"> OTHER INVOICES</a>
                                        <div class="slide"></div>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#home7" role="tab"> SENT INVOICES</a>
                                        <div class="slide"></div>
                                    </li>
                                </ul>
                              
                                <div class="tab-content">
                                    <div class="tab-pane active" id="profile7" role="tabpanel">
                                        <div class="card-block">
                                            <input type="checkbox" <?=(int) request('skip')==1 ?'checked':''?> id="skip_field" onmousedown="skip_field()"/> Hide Inputs Fields
                                            <div class="table-responsive dt-responsive">
                                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>School Name</th>
                                                            <th>Date Registered</th>
                                                            <th>Students</th>
                                                            <th>Price</th>
                                                            <th>Payment Deadline</th>
                                                            <th>Estimated Students</th>
                                                            <th>Start usage date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total_students = 0;
                                                        $total_price = 0;
                                                        $schemas=\DB::select("select * from admin.clients");
                                                        foreach ($schemas as $schema) {
                                                            ?>
                                                            <tr>
                                                                <td><?= warp(school_full_name($schema->username),20) ?></td>
                                                                <td><?= date('d M Y',strtotime($schema->created_at))  ?></td>
                                                                <td> 
                                                                    <?php 
                                                                    $setting = DB::table('admin.all_setting')->where('schema_name', $schema->username)->first();
                                                                     if(!empty($setting)) {
                                                                        $students = DB::table($schema->username. '.student')->where('status', 1)->count();
                                                                     } else {
                                                                        $students=$schema->estimated_students;
                                                                     }
                                                                    $total_students += $students;
                                                                    echo $students;
                                                                    ?>
                                                                </td>

                                                                <td>
                                                                 <?php
                                
                                                                    $price =$schema->price_per_student;
                                                                    $total_price += $price * $students;
                                                                    echo tagEdit($schema->username, 'price_per_student', $price);
                                                                    ?>
                                                                </td>

                                                                <td> 
                                                                    <?php
                                                                    $end_date =$schema->invoice_end_date;
                                                                    echo tagEdit($schema->username, 'invoice_end_date', $end_date, 'date');
                                                                    ?>
                                                                </td> 

                                                                <td>
                                                                    <?= tagEdit($schema->username, 'estimated_students', isset($schema->estimated_students) ? $schema->estimated_students:'') ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $usage_date =$schema->start_usage_date;
                                                                    echo tagEdit($schema->username, 'start_usage_date', $usage_date, 'date');
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php $url = "account/createShuleSoftInvoice/$schema->id"; ?>

                                                                    <a href="<?= url($url) ?>" class="btn btn-primary btn-sm  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Create invoice"> Create </a>
                                                                
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="2" class="">Total</th>
                                                            <th><?= $total_students ?></th>
                                                            <th><?= money($total_price) ?></th>
                                                            <th colspan="4">Total</th>

                                                        </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                        </div>
                                    </div>



                                   <div class="tab-pane" id="other" role="tabpanel">
                                     <div class="card-header"> 
                                          <h5>Create other invoices </h5> 
                                      </div> 
                                      <div class="card-block">
                                            
                                        <form action="<?= url('account/createinvoices') ?>" method="post">
                                          <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <strong> Invoice Type</strong>
                                                     <select type="text" name="type" style="text-transform:uppercase" class="js-example-basic-single form-control" required>
                                                    <option value="">Select here...</option>
                                                    <?php
                                                        $types = \App\Models\InvoiceType::get();
                                                        foreach($types as $type){
                                                           echo  '<option value="'.$type->id.'">'.$type->name.'</option>';
                                                        }
                                                    ?>
                                                    </select>
                                                </div>

                                                 
                                                 <div class="col-md-4">
                                                    <strong> Choose school </strong>
                                                    <select type="text"  name="school_id" class="form-control js-example-basic-single" required>
                                                       <?php \App\Models\School::chunk(50, function ($schools) {  ?>
                                                        <?php  foreach($schools as $value) { ?>
                                                           <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                                        <?php   }  ?>
                                                       <?php  }); ?>
                                                    </select>
                                                </div> 

                                                 <div class="col-md-4">
                                                    <strong> Number of students </strong>
                                                      <input type="text" name="students"  class="form-control" placeholder="" autofocus>
                                                  </div> 

                                               </div>
                                             </div>

                                          <div class="form-group">
                                            <div class="row">
                                             <div class="col-md-3">
                                                <strong>  Amount</strong>
                                                  <input type="text" name="amount"  class="form-control" placeholder="Enter required  Amount.." autofocus required>
                                               </div>

                                               <div class="col-md-3">
                                                <strong>  Deadline date</strong>
                                                 <input type="date"  class="form-control" name="due_date" required>
                                               </div>
                                         
                                              <div class="col-md-3">
                                                <strong>  Email</strong>
                                                  <input type="text" name="email"  class="form-control">
                                               </div>

                                               <div class="col-md-3">
                                                <strong>  Phone </strong>
                                                 <input type="text"  class="form-control" name="phone">
                                               </div>
                                            </div>
                                         </div>
                           
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                            <?= csrf_field() ?>
                                        </form>

                                        </div>
                                    </div>  
                                      
                                  
                                 <div class="tab-pane" id="home7" role="tabpanel">
                                       <div class="card-header">
                                            <h5>Current Sent School Invoices</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive dt-responsive">
                                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>School Name</th>
                                                            <th>Students</th>
                                                            <th>Paid Amount</th>
                                                            <th>Added By</th>
                                                            <th>Issued Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total_students = 0;
                                                        $total_price = 0;
                                                        $schools = App\Models\InvoiceSent::orderBy('id', 'DESC')->get();
                                                        if(count($schools)){ 
                                                        foreach ($schools as $school) {?>
                                                            <tr>
                                                                <td><?= school_full_name($school->schema_name) ?></td>
                                                                <td><?php echo $school->student; $total_students += $school->student; ?></td>
                                                                <td><?php echo $school->amount; $total_price += $school->amount;?> </td>
                                                                <td><?php echo $school->user->name;?> </td>
                                                                <td><?= $school->date ?></td>
                                                                <td ><a href="<?= url('account/invoiceView/' . $school->schema_name) ?>" class="btn btn-sm btn-success">View</a></td>
                                                            </tr>
                                                        <?php } 
                                                        }?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total</th>
                                                            <th><?= $total_students ?></th>
                                                            <th><?= $total_price ?></th>
                                                            <th>User</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
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

<script type="text/javascript">
    edit_records = function (tag, val, schema) {
        $.get('<?= url('customer/updateProfile/null') ?>', {schema: schema, table: 'setting', val: val, tag: tag, user_id: '1'}, function (data) {
            $('#status_' + tag + schema).html('<label class="badge badge-success">'+data+'</label>');
            toastr.success(data);
        });
    };

    $('input[type="checkbox"]').click(function () {
        if ($(this).prop("checked") == true) {
            window.location.href = '<?= url('/account/projection') ?>/null?skip=1';
        } else if ($(this).prop("checked") == false) {
            window.location.href = '<?= url('/account/projection') ?>/null?skip=0';
        }
    })

  $(".js-example-basic-single").select2({
     templateResult: formatState
});
</script>
@endsection

