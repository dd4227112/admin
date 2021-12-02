@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>

    
  

      <div class="page-header">
            <div class="page-header-title">
                <h4>Revenues</h4>
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
                    <li class="breadcrumb-item"><a href="#!">transactions</a>
                    </li>
                </ul>
            </div>
        </div>


    <div class="page-body">
      <div class="row">
         <div class="col-sm-12">

            <div class="card">
                <div class="card-block">
                    <div class="row">

                    <div class="col-sm-12 col-xl-3 m-b-30">
                        <h4 class="sub-title"></h4>
                        <?php if (can_access('add_revenue')) { ?>
                            <a class="btn btn-sm btn-primary" href="<?php echo url('revenue/add/') ?>">
                                <i class="fa fa-plus"></i> 
                                Add Revenue
                            </a>
                        <?php } ?>
                    </div>
                   
                    <div class="col-sm-12 col-xl-9 m-b-30">
                      <form class="form-horizontal" role="form" method="post"> 
                        <div class="row">
                        <div class="col-sm-12 col-xl-4 m-b-30">
                            <h4 class="sub-title">Start Date</h4>
                             <input type="date"  class="form-control calendar" id="from_date" name="from_date" value="<?=$from_date?>"> 
                        </div>

                          <div class="col-sm-12 col-xl-4 m-b-30">
                              <h4 class="sub-title">End Date</h4>
                              <input type="date" class="form-control" id="to_date" name="to_date"  value="<?=$to_date?>">
                         </div>
                        

                           <div class="col-sm-12 col-xl-3 m-b-30">
                              <h4 class="sub-title">&nbsp;</h4>
                               <input type="submit" class="form-control btn btn-success" value="Submit"  style="float: right;">
                            </div>
                          </div>
                          <?= csrf_field() ?>

                        </form>
                      </div>


                    </div>
                </div>
                </div>
        
              <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="table-responsive"> 
                                       <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">

                                            <thead>
                                                <tr>
                                                    <th class="col-sm-1"><?= ('#') ?></th>
                                                    <th class="col-sm-2"><?= ('Name') ?></th>
                                                    <th class="col-sm-2">Payer name</th>
                                                    <th class="col-sm-1">Payer phone</th>
                                                    <th class="col-sm-1"><?= ('Amount') ?></th>
                                                    <th class="col-sm-2">Payment method</th>
                                                    <th class="col-sm-1">Transaction ID</th>
                                                    <th class="col-sm-2">Date</th>
                                                    <th class="col-sm-2">Note</th>
                                                    <?php if (can_access('edit_revenue') || can_access('delete_revenue')) { ?>
                                                        <th class="col-sm-2">Action</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total_expense = 0;
                                                if (count($revenues) > 0) { //dd($revenues);
                                                    $i = 1;
                                                    foreach ($revenues as $revenue) {
                                                        ?>
                                                        <tr>
                                                            <td data-title="<?= ('#') ?>">
                                                                <?php echo $i; ?>
                                                            </td>
                                                            <td data-title="<?= ('expense_name') ?>">
                                                                <?php echo $revenue->referExpense->name; ?>
                                                            </td>
                                                            <td data-title="<?= ('expense_payer') ?>">
                                                                <?php echo $revenue->payer_name; ?>
                                                            </td><td data-title="<?= ('expense_payer_phone') ?>">
                                                                <?php echo $revenue->payer_phone; ?>
                                                            </td>
                                                            <td data-title="<?= ('expense_amount') ?>">
                                                                <?php
                                                                $total_expense += $revenue->amount;
                                                                echo money($revenue->amount);
                                                                ?>
                                                            </td>
                                                            <td data-title="<?= ('expense_payment_method') ?>">
                                                                <?php echo $revenue->payment_method; ?>
                                                            </td>
                                                            <td data-title="<?= ('transaction_id') ?>">
                                                                <?php echo $revenue->transaction_id; ?>
                                                            </td>
                
                                                            <td data-title="<?= ('expense_date') ?>">
                                                                <?php echo date("d M Y", strtotime($revenue->date)); ?>
                                                            </td>                               
                                                            <td data-title="<?= ('expense_note') ?>">
                                                                <?php echo warp($revenue->note,20); ?>
                                                            </td>
                                                            <?php if (can_access('edit_revenue') || can_access('delete_revenue')) { ?>
                                                                <td data-title="<?= ('action') ?>">
                                                                    <?php
                                                                    echo '<a href="' . url('revenue/edit/' . $revenue->id . '/') . '" class="btn btn-primary btn-sm mr-1">' . ('edit') . '</a>';
                                                                    echo '<a href="' . url('revenue/delete/' . $revenue->id . '/') . '" class="btn btn-danger btn-sm mr-1">' . ('Delete') . '</a>';
                                                                    echo '<a href="' . url('revenue/receipt/' . $revenue->id . '/') . '" class="btn btn-default btn-sm">' . ('Receipt') . '</a>';
                                                                    ?>                                                               
                                                                </td>
                                                            <?php } ?>
                
                
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </tbody>  
                                            <?php if (!empty($revenues)) { ?>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4">Total</td>
                                                        <td><?= money($total_expense) ?></td>
                                                        <td colspan="5"></td>
                                                    </tr>
                                                </tfoot>
                                            <?php } ?>
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
@endsection


