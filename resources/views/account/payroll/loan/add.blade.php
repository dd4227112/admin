@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Loan</h4>
                <span>Add loan</span>
            </div>

            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a>
                    </li>
            <li class="breadcrumb-item"><a href="<?= url("loan/index") ?>"><?= __('loan_application') ?></a> </li>
            <li class="breadcrumb-item active"><?= __('menu_add') ?> <?= __('loan_application') ?></li>
                </ul>
            </div>

        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <header class="panel-heading">
                           Fill all basic information correctly
                        </header>
                        <div class="card-body row">
                            <div id="error_area"></div>
                            <div class="col-lg-8">
                                
                                <form class="form-horizontal" role="form" method="post" action="<?= url('Loan/loanAdd') ?>">

                                    <div class="form-group">              
                                        <label for="user" class="col-sm-2 control-label">
                                            Borrower
                                        </label>
                                        <div class="col-sm-6">
                                            <?php
                                             $users = \App\Models\User::where('status', 1)->where('role_id','<>', 7)->get();
                                            $array = array("0" => __("select"));
                                            foreach ($users as $user) {
                                                $array[$user->id] = $user->name;
                                            }
                                            echo form_dropdown("user_id", $array, old("user_id"), "id='user_id' class='form-control'");
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">              
                                        <label for="loan_type" class="col-sm-2 control-label">
                                            <?= __("source") ?>
                                        </label>
                                        <div class="col-sm-6">
                                            <?php
                                            $array = array("0" => __("select"));
                                            $deduction_types = [
                                                '1' => 'Loan From School',
                                                '2' => 'Loan From Bank'
                                            ];
                                            $loan_sources = DB::table('constant.loan_sources')->get();
                                            foreach ($loan_sources as $source) {
                                                $array[$source->id] = $source->name;
                                            }
                                            echo form_dropdown("loan_source_id", $array, old("loan_source_id"), "id='loan_source_id' class='form-control'");
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">              
                                        <label for="loan_type" class="col-sm-2 control-label">
                                            <?= __("loan_type") ?>
                                        </label>
                                        <div class="col-sm-6">
                                            <?php
                                            $array = array("0" => __("select"));
                                            foreach ($loan_types as $loan) {
                                                $array[$loan->id] = $loan->name;
                                            }
                                            echo form_dropdown("loan_type_id", $array, old("loan_type_id"), "id='loan_type_id' class='form-control'");
                                            ?>
                                        </div>
                                    </div>
                
                                    <div id="amount_check">
                                        <?php
                                        if (form_error($errors, 'amount'))
                                            echo "<div class='form-group has-error' >";
                                        else
                                            echo "<div class='form-group' >";
                                        ?>
                                        <label for="amount" class="col-sm-2 control-label">
                                            <?= __("amount") ?><span class="red">*</span>
                                        </label>
                                        <div class="col-sm-6">
                                            <input placeholder="<?= __("amount") ?>" type="number" class="form-control" id="amount" name="amount" value="<?= old('amount') ?>" onkeyup="loan()">
                                            <i class="fa fa-question-circle" data-container="body"
                                               data-toggle="popover" data-placement="top" data-trigger="hover"
                                               data-content="Amount of loan requested"
                                               title="<?= __("Default Amount") ?>"></i>
                                            <b class="label label-info" id="loan_amount" style="display: none;">Minimum: <b id="minimum_amount" class="badge badge-dark"></b>, Maximum: <b id="maximum_amount" class="badge badge-dark">43</b>  months</b>
                                        </div>
                                        <span class="col-sm-4 control-label">
                                            <?php echo form_error($errors, 'point'); ?>
                                        </span>
                                    </div>
                                    <?php
                                    if (form_error($errors, 'months'))
                                        echo "<div class='form-group has-error' >";
                                    else
                                        echo "<div class='form-group' >";
                                    ?>
                                    <label for="months" class="col-sm-2 control-label">
                                        <?= __("months") ?><span class="red">*</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <input placeholder="<?= __("months") ?>" type="number" class="form-control" id="months" name="months" value="<?= old('months') ?>"  onkeyup="loan()">
                                        <i class="fa fa-question-circle" data-container="body"
                                           data-toggle="popover" data-placement="top" data-trigger="hover"
                                           data-content="Number of months you are required to pay this loan requested"
                                           title="<?= __("Default Amount") ?>"></i>
                                        <b class="label label-info" id="tenor" style="display: none;">Minimum: <b id="minimum_tenor" class="badge badge-dark">23</b> months, Maximum: <b id="maximum_tenor" class="badge badge-dark">43</b>  months</b>
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'point'); ?>
                                    </span>
                            </div>
                        </div>
                
                        <div id="percentage_check" >
                
            
                        </div>
                
                        <?php
                        if (form_error($errors, 'description'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                        ?>
                        <label for="note" class="col-sm-2 control-label">
                            <?= __("description") ?><span class="red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <textarea style="resize:none;" placeholder="<?= __("description") ?>" class="form-control" id="note" name="description" required><?= old('description') ?></textarea>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors, 'note'); ?>
                        </span>
                        <a><i class="fa fa-question-circle" data-container="body"
                              data-toggle="popover" data-placement="top" data-trigger="hover"
                              data-content="<?= __("summary") ?>"
                              title="<?= __("summary") ?>"></i></a>
                    </div>
                
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <input type="hidden" id="loan_monthly_repayment_hidden" value="" name="loan_monthly_repayment">
                            <input type="hidden" id="user_net_salary_hidden" value="" name="user_net_salary">
                            <input type="hidden" id="qualified_hidden" value="" name="qualify">
                            <input type="submit" class="btn btn-primary btn-block" id="submit_loan_btn" value="Save" >
                        </div>

                    </div>
                    <?= csrf_field() ?>
                </form>
              </div>

                  <div class="col-lg-4">
                    <p class="lead">Summary</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width:50%"></th>
                                    <td><span class="credit_ratio" style="display: none;"></span>
                                    <span id="ratio" style="display: none"></span></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Your Net Salary:</th>
                                    <td><span class="user_net_salary"></span><span id="net_salary" style="display: none"></span></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Amount Requested:</th>
                                    <td><span class="loan_amount"></span></td>
                                </tr>
                                <tr>
                                    <th>Monthly Repayment</th>
                                    <td><span class="loan_monthly_repayment"></span></td>
                                </tr>
                                <tr>
                                    <th>Interest Rate:</th>
                                    <td><span class="loan_interest_rate"></span></td>
                                </tr>
                                <tr>
                                    <th>Payment Start Date:</th>
                                    <td><span class="loan_start_date"></span></td>
                                </tr>
                                <tr>
                                    <th>Payment End Date:</th>
                                    <td><span class="loan_end_date"></span></td>
                                </tr>
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
   </div>
</div>

</div>
</div>

<script type="text/javascript">
    $('#loan_type_id').change(function () {
        var val = $(this).val();
        if (val == 0) {
            $('#hide-table').hide();
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('loan/getDetails') ?>",
                data: "id=" + val,
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    $('#amount').val(data.minimum_amount)
                            .attr('min', data.minimum_amount)
                            .attr('max', data.maximum_amount);
                    $('#loan_amount').show();
                    $('#minimum_amount').html(data.minimum_amount);
                    $('#maximum_amount').html(data.maximum_amount);

                    $('#months').val(data.minimum_tenor)
                            .attr('min', data.minimum_tenor)
                            .attr('max', data.maximum_tenor);

                    $('#tenor').show();
                    $('#minimum_tenor').html(data.minimum_tenor);
                    $('#maximum_tenor').html(data.maximum_tenor);

                    $('#start_date').val(data.minimum_tenor)
                            .attr('min', data.minimum_tenor)
                            .attr('max', data.maximum_tenor);
                    $('.loan_interest_rate').html(data.interest_rate);

                    $('.loan_start_date').html(addMonths(0));
                    $('.loan_end_date').html(addMonths(data.maximum_tenor));
                    $('#ratio').html(data.credit_ratio);
                    check_credit_ratio(data.credit_ratio);

                }
            });
        }
    });
    function addMonths(months) {
        var date = new Date();
        var d = date.getDate();
        date.setMonth(date.getMonth() + +months);
        if (date.getDate() != d) {
            date.setDate(0);
        }
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        //return date.toString();
        return monthNames[date.getMonth() + 1] + ' ' + date.getFullYear();
        ;
    }

    function check_credit_ratio(ratio) {
        $.ajax({
            type: 'POST',
            url: "<?= url('loan/getNetPayment') ?>",
            data: "id=" + ratio,
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('.user_net_salary').html(data.salary);
                $('#net_salary').html(data.salary);
                loan();
                //amount=data.salary*principle*months/12;
            }
        });
    }

    function loan() {
        var amount = $('#amount').val();
        var month = $('#months').val();
        var rate = $('.loan_interest_rate').text();
        $('.loan_amount').html(amount);

        if (amount != '' && month != 'undefined' && rate != '') {
            $('.loan_end_date').html(addMonths(month));
            $.ajax({
                type: 'POST',
                url: "<?= url('loan/getRepayment') ?>",
                data: {amount: amount, month: month, rate: rate},
                dataType: "JSON",
                success: function (data) {

                    var net_salary = $('#net_salary').text();
                    var ratio = $('#ratio').text();
                    var final_salary = net_salary - data;
                    $('.user_net_salary').html(final_salary);
                    $('.loan_monthly_repayment').html(data);
                    $('#loan_monthly_repayment_hidden').val(data);
                    $('#user_net_salary_hidden').val(final_salary);
                    var valid_amount = ratio * net_salary / 100;
                    if (final_salary < valid_amount) {
                        $('.credit_ratio').show().html('Not Qualified').removeClass('label-success').addClass('label label-danger');
                        $('#submit_loan_btn').attr('disabled', 'disabled');
                    } else {
                        $('.credit_ratio').show().html('Qualified').removeClass('label-danger').addClass('label label-success');
                      
                        $('#submit_loan_btn').removeAttr('disabled');
                    }
                    $('#qualified_hidden').val($('.credit_ratio').text());
                }
            });
        }
    }
</script>

@endsection