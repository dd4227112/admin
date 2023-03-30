@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.9/select2-bootstrap.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>


    
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h3 class="box-title"><i class="fa icon-expense"></i>  
                 <?php
                    if ($id == 4) {
                        echo ('Expenses');
                    } elseif ($id == 1) {
                        echo "Fixed Assets";
                    } else if ($id == 2) {
                        echo "Liabilities";
                    } else if ($id == 3) {
                        echo "Capital Management";
                    }else if($id==5){
                        echo 'Current Assets';
                    }
                    ?></h3> 
            </div>
    

            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url("dashboard/index") ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>
                        <?php
                            if ($id == 4) {
                                echo ('Expenses');
                            } elseif ($id == 1) {
                                echo "Fixed Assets";
                            } else if ($id == 2) {
                                echo "Liabilities";
                            } else if ($id == 3) {
                                echo "Capital Management";
                            }else if($id==5){
                                echo 'Current Assets';
                            }
                            ?>
                       </a>
                    </li>
                  
                </ul>
            </div>

        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-header">    

                            <span>Specify information correctly as specified. Area marked with * are mandatory</span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                        </div>
                        <div class="card tab-card">
                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item complete">
                                    <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                        <strong>Create Single Transaction</strong> 
                                    </a>
                                    <div class="slide"></div>
                                </li>
                               
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                    <div class="card-block">

                                        <header class="panel-heading">
                                            Add Current Assets
                                        </header>
                                        <div class="card-block">
                                            <form class="form-horizontal" role="form" method="post">
			
				    
                                            <?php
                                                if (form_error($errors, 'user_in_shulesoft'))
                                                    echo "<div class='form-group has-error' >";
                                                else
                                                    echo "<div class='form-group' >";
                                                ?>
                                                <label for="payment method" class="col-sm-2 control-label">
                                                    User From<span class="red">*</span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <select name="user_in_shulesoft" id="user_in_shulesoft" class="form-control">
                                                        <option value="0" selected="true">Select User type</option>
                                                        <option value="1">User in ShuleSoft</option>
                                                        <option value="2">User Not in ShuleSoft</option>
                                                    </select>
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'user_in_shulesoft'); ?>
                                                </span>
                                             </div>

                                                  <div  style="display: none" id="user_in_shulesoft_tag" <?php request('user_in_shulesoft') == 1 ? '' : 'style="display: none;"' ?>>        
                                                      <?php
                                                      if (form_error($errors, 'user_id'))
                                                          echo "<div class='form-group has-error' >";
                                                      else
                                                          echo "<div class='form-group' >";
                                                      ?>
                                                      <label for="payment method" class="col-sm-2 control-label">
                                                          Recipient <span class="red">*</span>
                                                      </label>
                                                      <div class="col-sm-6">
                                                        <?php
                                                        $uarray = array('0' => "select User");
                                                        $users = \App\Models\User::where('status', 1)->where('role_id', '<>', 7)->get();
                                                        if (count($users)) {
                                                            foreach ($users as $user) {
                                                                $uarray[$user->id] = $user->name();
                                                            }
                                                        }
                                                        echo form_dropdown("user_id", $uarray, old("user_id"), "id='user_id' class='form-control select2'");
                                                        ?>
                                                      </div>
                          
                                                      <span class="col-sm-4 control-label">
                                                          <?php echo form_error($errors, 'user_id'); ?>
                                                      </span>
                                                  </div>   
                                              </div>

                                        <div  style="display: none" id="user_not_in_shulesoft_tag"  <?php request('user_in_shulesoft') == 2 ? '' : 'style="display: none;"' ?>>
                                        <?php
                                        if (form_error($errors, 'payer_name'))
                                            echo "<div class='form-group has-error' >";
                                        else
                                            echo "<div class='form-group' >";
                                        ?>
                                        <label for="amount" class="col-sm-2 control-label">
                                            Recipient<span class="red">*</span>
                                        </label>
                                        <div class="col-sm-6">
                
                                            <input type="text" class="form-control" id="amount" name="payer_name" value="<?= old('payer_name') ?>"  placeholder="  e.g Juma Ali" onblur="this.value = this.value.toUpperCase()">
                                        </div>
                                        <span class="col-sm-4 control-label">
                                            <?php echo form_error($errors, 'payer_name'); ?>
                                        </span>
                                    </div>	    
                                   </div>	    
                                          
                                 <?php
                                    if (form_error($errors, 'amount'))
                                        echo "<div class='form-group has-error' >";
                                    else
                                        echo "<div class='form-group' >";
                                    ?>
                                    <label for="amount" class="col-sm-2 control-label">
                                        <?= ("Amount") ?> 
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control transaction_amount" id="amount" name="amount" value="<?= old('amount') ?>" required="true">
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'amount'); ?>
                                    </span>
                                </div>	
                                          
                                          
                                     <?php
                                        if (form_error($errors, 'from_expense'))
                                            echo "<div class='form-group has-error' >";
                                        else
                                            echo "<div class='form-group' >";
                                        ?>
                                        <label for="expense" class="col-sm-2 control-label">
                                            <?= ("Name") ?>
                                        </label>
                                        <div class="col-sm-6">
                                            <?php
                                            $array = array('0' => ("select name"));
                                            if (!empty($category)) {
                                                foreach ($category as $categ) {
                                                    $array[$categ->id] = $categ->name;
                                                }
                                            }
                                            echo form_dropdown("from_expense", $array, old("from_expense", $sub_id), "id='refer_expense_id' class='form-control' name='from_expense'");
                                            ?>
                                            <?php if (empty($category)) { ?>
                                                <span class="red">Please click  <a href="<?= url("expense/financial_category/$check_id") ?>" class="btn btn-primary" role="button">add category</a> to add category</span>
                                            <?php } ?>
                                        </div>
                                        <span class="col-sm-4 control-label">
                                            <?php echo form_error($errors, 'from_expense'); ?>
                                        </span>
                                       </div>
                                                 
                          
                                        <?php
                                            if (form_error($errors, 'to_expense'))
                                                echo "<div class='form-group has-error' >";
                                            else
                                                echo "<div class='form-group' >";
                                            ?>
                                            <label for="expense" class="col-sm-2 control-label">
                                                Transfer To
                                            </label>
                                            <div class="col-sm-6">
                                                <?php
                                                $array = array('0' => ("select name"));
                                                if (!empty($category)) {
                                                    foreach ($category as $categ) {
                                                        $array[$categ->id] = $categ->name;
                                                    }
                                                }
                                                echo form_dropdown("to_expense", $array, old("to_expense", $sub_id), "id='refer_expense_id' class='form-control' name='to_expense'");
                                                ?>
                                                
                                            </div>
                                            <span class="col-sm-4 control-label">
                                                <?php echo form_error($errors, 'from_expense'); ?>
                                            </span>
                                    </div>
                              
                                   <?php
                                      if (form_error($errors, 'transaction_id'))
                                          echo "<div class='form-group has-error' >";
                                      else
                                          echo "<div class='form-group' >";
                                      ?>
                                      <label for="amount" class="col-sm-2 control-label">
                                          <?= ("ref_no") ?>
                                      </label>
                                      <div class="col-sm-6">
                          
                                          <input type="text" placeholder="Enter ref number/cheque number" class="form-control" id="ref_no" name="transaction_id" value="<?= $transaction_id ?>">
                                      </div>
                                      <span class="col-sm-4 control-label">
                          
                                          <?php echo form_error($errors, 'transaction_id'); ?>
                                      </span>
                                  </div>
                          
                                  
                              <?php
                              if (form_error($errors, 'date'))
                                  echo "<div class='form-group has-error' >";
                              else
                                  echo "<div class='form-group' >";
                              ?>
                              <label for="date" class="col-sm-2 control-label">
                                Transfer Date
                              </label>
                              <div class="col-sm-6">
                                  <div class="icon-addon addon-lg">
                                  <input type="date" class="form-control calendar" id="date" name="date" value="<?= date('Y-m-d') ?>" required="true" >
                          <span class="fa fa-calendar"></span>
                                                          </div>
                              </div>
                              <span class="col-sm-4 control-label">
                                  <?php echo form_error($errors, 'date'); ?>
                              </span>
                          </div>
                          
                          <?php
                          if (form_error($errors, 'note'))
                              echo "<div class='form-group has-error' >";
                          else
                              echo "<div class='form-group' >";
                          ?>
                          <label for="note" class="col-sm-2 control-label">
                              <?= ("Expense note") ?>
                          </label>
                          <div class="col-sm-6">
                              <textarea style="resize:none;" class="form-control" id="note" name="note" required><?= old('note') ?></textarea>
                          </div>
                          <span class="col-sm-4 control-label">
                              <?php echo form_error($errors, 'note'); ?>
                          </span>
                          </div>
                          
                          <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-6">
                                  <input type="submit" class="btn btn-success btn-block" value="Save" >
                              </div>
                          </div>
                          
                          <?= csrf_field() ?>
                          </form>
                          </div>
                          </div>
                          
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                              <div class="x_panel">
                                  <div class="x_title">
                                      <h2>Current assets</h2>
                          
                                      <div class="clearfix"></div>
                          
                                  </div>
                                  <p><?= ("download") ?> <a href="<?= url('storage/uploads/sample/sample_expense_upload.xlsx') ?>"><?= ("sample_installment_file") ?></a></p><br/>
                                  <form id="demo-form2" action="<?= url('account/uploadByFile') ?>" class="form-horizontal" method="POST" enctype="multipart/form-data">
                          
                                      <div class="form-group">
                          
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                              <input id="file" name="file"  type="file" required="required" accept=".xls,.xlsx,.csv,.odt">
                                          </div>
                                      </div>
                                      <div class="ln_solid"></div>
                                      <div class="form-group">
                                          <div class="  col-md-4 col-sm-4 col-xs-12">
                                              <button type="submit" class="btn btn-success btn-block">Save</button>
                                          </div>
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
</div>


<script>
    payment_method_status = function () {
        $('#payment_method_status').change(function () {
            var val = $(this).val();
            if (val !== 'cash') {
                $('#refer_no').show();
            } else {
                $('#refer_no').hide();
            }
        });
  

    $('#status').click(function () {
        var depreciation = $('#status').val();
        if (depreciation == '0') {
            $('#dep').show();
        } else {
            $('#dep').hide();
        }



    });
  $('#user_in_shulesoft').change(function () {
            var val = $(this).val();
            if (val === '1') {
                $('#user_in_shulesoft_tag').show();
                $('#user_not_in_shulesoft_tag').hide();
            } else if (val === '2') {
                $('#user_in_shulesoft_tag').hide();
                $('#user_not_in_shulesoft_tag').show();
            } else {
                $('#user_in_shulesoft_tag').hide();
                $('#user_not_in_shulesoft_tag').hide();
            }
        });

  };
    $(document).ready(payment_method_status)

    $(".select2").select2({
		theme: "bootstrap",
		dropdownAutoWidth: false,
		allowClear: false,
        debug: true
	});

    $('.transaction_amount').attr("pattern", '^(\\d+|\\d{1,3}(,\\d{3})*)(\\.\\d{2})?$');
    $('.transaction_amount').on("keyup", function() {
        var currentValue = $(this).val();
        currentValue = currentValue.replace(/,/g, '');
        $(this).val(currentValue.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    });
</script>

@endsection


