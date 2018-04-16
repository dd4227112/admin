@extends('layouts.app')
@section('content')
<div class="row">
                    <div class="col-md-12">
                        <div class="white-box printableArea">
                            <h3><b>INVOICE</b> <span class="pull-right">#SAS00<?= rand(433, 32323)?></span></h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left"> <address>
                  <h3> &nbsp;<b class="text-danger">Inets Company Limited</b></h3>
                  <p class="text-muted m-l-5">11th Block, Bima Road, <br>
                    Mikocheni B,Kinondoni <br>
                    P.o Box - 32278, <br>
                    Dar es salaam, Tanzania</p>
                  </address> </div>
                                    <div class="pull-right text-right"> <address>
                  <h3>To,</h3>
                  <h4 class="font-bold"><?=$school->sname?>,</h4>
                  <p class="text-muted m-l-30"><?=$school->address?>, <br>
                   <?=$school->box?>, <br>
                   </p>
                  <p class="m-t-30"><b>Invoice Date :</b> <i class="fa fa-calendar"></i><?=date('d M Y')?></p>
                  <p><b>Due Date :</b> <i class="fa fa-calendar"></i> <?=date('d M Y',strtotime($school->payment_deadline_date))?></p>
                  </address> </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-40" style="clear: both;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Description</th>
                                                    <th class="text-right">No of Students</th>
                                                    <th class="text-right">Price per Student </th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td>ShuleSoft - Annual Service Charge</td>
                                                    <td class="text-right"><?=$user->student?> </td>
                                                    <td class="text-right"> <?= number_format($school->price_per_student)?></td>
                                                    <td class="text-right"><?= number_format($school->price_per_student*$user->student)?> </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">2</td>
                                                    <td>Associated Charges <br/>
                                                    Hosting, Cloud Storage, Bulk SMS & Emails, Training and Support</td>
                                                    <td class="text-right">  </td>
                                                    <td class="text-right"> 0 </td>
                                                    <td class="text-right"> 0 </td>
                                                </tr>
                                   
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="pull-right m-t-30 text-right">
                                        <p>Sub - Total amount: Tsh <?= number_format($school->price_per_student*$user->student)?></p>
                                        <p>vat (18%)- Excluded : 0 </p>
                                        <hr>
                                        <h3><b>Total :</b> Tsh <?= number_format($school->price_per_student*$user->student)?></h3> </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <div class="text-right">
                                        <button class="btn btn-danger" type="submit"> Send </button>
                                        <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php $root = url('/') . '/public/' ?>
   <script src="<?=$root?>js/jquery.PrintArea.js" type="text/JavaScript"></script>
    <script>
        $(document).ready(function () {
            $("#print").click(function () {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode
                    , popClose: close
                };
                $("div.printableArea").printArea(options);
            });
        });
    </script>
@endsection