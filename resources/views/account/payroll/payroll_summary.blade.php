@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
         <div class="page-header">
            <div class="page-header-title">
                <h4><?= $user->firstname.' '.$user->lastname. ' Payroll summary' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">salaries</a>
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
                            <div class="card-block">
                              
                                        <div class="table-responsive">
                                             <table class="table dataTable table-sm table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th class="col-sm-1"><?= __('#') ?></th>
                                                        <th class="col-sm-1"><?= __('Month') ?></th>
                                                        <th class="col-sm-1"><?= __('Basic pay') ?></th>
                                                        <th class="col-sm-1"><?= __('Allowance') ?></th>
                                                        <th class="col-sm-1"><?= __('Gross pay') ?></th>
                                                        <th class="col-sm-1"><?= __('Pension') ?></th>
                                                        <th class="col-sm-1"><?= __('Deduction') ?></th>
                                                        <th class="col-sm-1"><?= __('Taxable amount') ?></th>
                                                        <th class="col-sm-1"><?= __('Paye') ?></th>
                                                        <th class="col-sm-1"><?= __('Net pay') ?></th>
                                                        <?php
                                                        if (can_access('manage_payroll')) {?>
                                                            <th class="col-sm-4"><?= __('Action') ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $total_basic_pay = 0;
                                                    $sum_of_total_allowances = 0;
                                                    $total_gross_pay = 0;
                                                    $total_pension = 0;
                                                    $sum_of_total_deductions = 0;
                                                    $total_paye = 0;
                                                    $total_taxable_amount = 0;
                                                    $total_net_pay = 0;
                                                    foreach ($salaries as $salary) {
                                                        $basic_salary = $salary->basic_pay;
                                                        $total_basic_pay += $basic_salary;
                                    
                                                        ?>
                                                        <tr>
                                                            <td  data-title="<?= __('#') ?>"><?= $i ?></td>
                                                            <td  data-title="<?= __('#') ?>"><?= date('d/m/Y', strtotime($salary->payment_date)) ?></td>
                                                            <td  data-title="<?= __('basic_pay') ?>"><?= number_format($basic_salary) ?></td>
                                                            <td  data-title="<?= __('allowance') ?>">
                                                                <?php
                                                                //calculate user allowances
                                                                echo number_format($salary->allowance);
                                                                $sum_of_total_allowances += $salary->allowance;
                                                                ?>
                                                            </td>
                                                            <td  data-title="<?= __('gross_pay') ?>">
                                                                <?php
                                                                $gross_pay = $basic_salary + $salary->allowance;
                                                                echo number_format($gross_pay);
                                                                $total_gross_pay += $gross_pay;
                                                                ?> 
                                                            </td>
                                                            <td  data-title="<?= __('pension') ?>">  
                                                                <?php
                                                                //calculate user pension amount
                                                                echo number_format($salary->pension_fund);
                                                                $total_pension += $salary->pension_fund;
                                                                ?>
                                                            </td>
                                                            <td  data-title="<?= __('deduction') ?>">
                                                                <?php
                                                                //calculate user deductions
                                                                echo number_format($salary->deduction);
                                                                $sum_of_total_deductions += $salary->deduction;
                                                                ?> 
                                                            </td>
                                                            <td  data-title="<?= __('taxable_amount') ?>"> 
                                                                <?php
                                                                //calculate user taxable amount
                                                                $taxable_amount = $gross_pay - $salary->pension_fund;
                                                                echo number_format($taxable_amount);
                                                                $total_taxable_amount += $taxable_amount;
                                                                ?>  
                                                            </td>
                                                            <td  data-title="<?= __('paye') ?>">
                                                                <?php
                                                                //calculate PAYEE
                        
                                                                echo number_format($salary->paye);
                                                                $total_paye += $salary->paye;
                                                                ?> 
                                                            </td>
                                                            <td  data-title="<?= __('net_pay') ?>">
                                                                <?php
                                                                $net_pay = $gross_pay - $salary->pension_fund - $salary->deduction - $salary->paye;
                                                                echo number_format($net_pay);
                                                                $total_net_pay += $net_pay;
                                                                ?>
                                                            </td>
                                                          
                                                            <td class="text-center">
                                                              <?php $month = date('m', strtotime($salary->payment_date)); $_url = "payroll/payslip/null/?id=$salary->user_id&month=$month&set=$salary->payment_date";
                                                               $url_sig = "users/usersignature/null/?user_id=$salary->user_id&payment_date=$salary->payment_date"; ?>
                                                              <a href="<?= !is_null($user->signature) ? url($_url) : url($url_sig) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Show payslip"> Preview </a>
                                                            </td>                 
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th data-title="<?= __('') ?>"></th>
                                                        <th data-title="<?= __('total') ?>">Total</th>
                                                        <th data-title="<?= __('basic_pay') ?>"><?= number_format($total_basic_pay) ?></th>
                                                        <th data-title="<?= __('allowances') ?>"><?= number_format($sum_of_total_allowances) ?></th>
                                                        <th data-title="<?= __('gross_pay') ?>"><?= number_format($total_gross_pay) ?></th>
                                                        <th data-title="<?= __('pension') ?>"><?= number_format($total_pension) ?></th>
                                                        <th data-title="<?= __('deduction') ?>"><?= number_format($sum_of_total_deductions) ?></th>
                                                        <th data-title="<?= __('slno') ?>"><?= number_format($total_taxable_amount) ?></th>
                                                        <th data-title="<?= __('taxable_amount') ?>"><?= number_format($total_paye) ?></th>
                                                        <th data-title="<?= __('net_pay') ?>"><?= number_format($total_net_pay) ?></th>
                                                        <th> 
                                                      
                                                       </th>
                                                    </tr>
                                                </tfoot>
                                            </table>  
                                         </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
             </div>

@endsection


