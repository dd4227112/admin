@extends('layouts.app')
@section('content')
<?php
/**
 * select distinct &quot;schema_name&quot; from admin.all_student where extract (year from
  created_at)=&#39;2019&#39; order by &quot;schema_name&quot; -to get the schools that have recorded
  students this year.
  ● select distinct &quot;schema_name&quot; from admin.all_marks where extract (year from
  created_at)=&#39;2019&#39; -to get the schools that have recorded marks in the system.
  ● select distinct &quot;schema_name&quot; from admin.all_invoices where extract (year from
  created_at)=&#39;2019&#39; -to get the schools that have created invoices in the system.
  ● select distinct &quot;schema_name&quot; from admin.all_bank_accounts_integrations where
  extract (year from created_at)=&#39;2019&#39; -to get the schools that have been integrated
  with NMB.
  ● select distinct &quot;schema_name&quot; from admin.all_payments where extract (year from
  created_at)=&#39;2019&#39; -to get the schools that have recorded payments.
  ● select distinct &quot;schema_name&quot; from admin.all_payments where extract (year from
  created_at)=&#39;2019&#39; and &quot;token&quot; is not null -to get the schools that have recorded
  payments electronically.
  ● select distinct &quot;schema_name&quot; from admin.all_expense where extract (year from
  created_at)=&#39;2019&#39; -to
 */
?>

<div class="row">
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">Schools Students</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <li><i class="icon-people text-info"></i></li>
                <li class="text-right"><span class="counter">78</span></li>
            </ul>

        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">Total Parents</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <li><i class="icon-people text-info"></i></li>
                <li class="text-right"><span class="counter">78</span></li>
            </ul>
            <div class="pull-right">% <i class="fa fa-level-up text-success"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">Total Students</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <li><i class="icon-people text-info"></i></li>
                <li class="text-right"><span class="counter">77</span></li>
            </ul>
            <div class="pull-right"><i class="fa fa-level-up text-success"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">Total Teachers</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <li><i class="icon-people text-info"></i></li>
                <li class="text-right"><span class="counter">7</span></li>
            </ul>
            <div class="pull-right">77% <i class="fa fa-level-up text-success"></i></div>
        </div>

    </div>
</div>
@endsection
