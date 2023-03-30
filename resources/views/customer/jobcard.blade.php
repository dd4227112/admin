@extends('layouts.app')
@section('content')
<?php
if((int) $show_download){ob_start();}
$root = url('/') . '/public/'
?>

<link href="<?php echo url('public/assets/print.css'); ?>?v=4" rel="stylesheet" type="text/css">
    
      
        <!-- Favicon icon -->
           <style>
                @page {
                    margin: 0
                }

                .letterhead{
                   font-weight: 100;
                   font-family: "Adobe Garamond Pro";
                  }
                  table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                    padding: 0.9%;
                     }
        
        </style>

   
       
             <button class="btn-cs btn-sm-cs" onclick="javascript:printDiv('printablediv')"><span
          
            class="fa fa-print"></span> <?= __('print') ?> </button>
            
                  <div id="printablediv" class="page center sheet padding-10mm" >
	   <div class="card-body">
        <div class="row">
        
            <div class="col-sm-12">
               
                <div class="card-header">
                <table style="margin: 1px 2px 1px 0px;">
                <thead >
                    <tr >
                        <th  class="letterhead" style="margin: 1% 0 0 16%; padding-top: 2%; ">
                          <h3 style="font-weight: bolder !important; font-size: 24px; text-transform: uppercase;"><img src="https://admin.shulesoft.com/public/assets/images/auth/shulesoft_logo.png" width="50" height="" style=""/> ShuleSoft Job card</h3>
                        </th>
                      </tr>              
                    </thead>
                  </table>
                </div>
                       <table  class="table table-striped table-bordered table-hover">
               
                                  <tbody>
                                         <tr style="border-bottom: 5px solid #8CDDCD; margin: bottom 2px;">
                                                    <td >Services provided to:</td>
                                                    <td>Name : <b><td><b><?= $client->name ?></b></td></b></td>
                                                </tr>
                                             
                                                 <tr>
                                                    <td style="float: left;border-right:5px solid #8CDDCD;">Start time:</td>
                                                    <td  style="float: right;border-right:5px solid #8CDDCD;">End time:</td>
                                                 </tr>
                                                
                                                <div class="table-responsive">      
                                   
                                               <table class="table table-bordered table-sm" width="50%" style="font-size: 12px;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Task</th>
                                                        <th>Description</th>
                                                        <th>Provided to</th>
                                                        <th>Status</th>
                                                        <th>Signature</th>
                                                    </tr>
                                              
                                               <tbody>
                                                    <?php
                                                    $x = 1;
                                                    foreach ($job_card_modules as $module) {
                                                        ?>
                                                        <tr>
                                                            <th width="5%"scope="row"><?= $x ?></th>
                                                            <td width="10%"><?= $module->module->name ?></td>
                                                            <td width="55%"> </td>
                                                            <td width="10%"> </td>
                                                            <td width="10%"> </td>
                                                            <td width="10%"> </td>
                                                        </tr>
                                                        <?php
                                                        $x++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                  

                                
                                        <br/>
                                        
                                        <table class="table  table-sm" style="margin: 1px 2px 1px 0px;">
                                            <thead>
                                                <tr  style="border-bottom: 5px solid #8CDDCD;">
                                                    <th colspan="2" class="text-white" style="background:#8CDDCD;text-align: center;
                                                        font-size: 18px;
                                                        ">Client</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 60% !important;">
                                                        <div>School Comments:
                                                        </div>
                                                    </td>
                                                    <td>  
                                                        <table class="table" style="margin: 1px;padding:1px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name:</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Designation:</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mobile No: </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Signature: </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                     </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    
                                        <br>

                                  
                                

                                
                                        <table class="table  table-sm" style="margin: 1px 2px 1px 0px;">
                                            <thead>
                                                <tr  style="border-bottom: 5px solid #8CDDCD;">
                                                    <th colspan="2" class="text-white" style="background:#8CDDCD;text-align: center;
                                                        font-size: 18px;
                                                       ">INETS COMPANY LIMITED</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 60% !important;">
                                                        For and on behalf of <br/>the INETS Company Limited, <br/>
                                                        the aforementioned services headed by</td>
                                                        <td>   
                                                         <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name:</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Designation:</td>
                                                                </tr><tr>
                                                                    <td>Department:</td>
                                                                </tr><tr>
                                                                    <td>Signature</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>

                                                </tr>

                                            </tbody>
                                        </table>
                                        <table class="table">
                                            <tr>
                                                <td style="width: 30% !important;">
                                                    <img src="<?= url('public/images/ShuleSoft-TM.png') ?>" width="250" height="" style=""/> 
                                                </td>
                                                <td style="width: 30% !important;">
                                                    <span style="font-size: 12px">
                                                        INETS is a Private Company Limited by shares and registered <br/>under the Company Act 2012 with registration number 9216.<br/> INETS deals solely with Software Development. <br/>Currently focused on a School Management System ShuleSoft </span></td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            
                 </div>
              </div>
            </div>
        </div>
    </div>
</div>
<script>
    function printDiv(divID) {

        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
              '<html><head><title></title></head><body>' +
              divElements + '</body>';

        //Print Page
        window.print();
        //Restore orignal HTML
        //  document.body.innerHTML = oldPage;
    }

     $(document).ready(function () {
        $("#printPayslip").click(function () {

            printDiv("print_div");
        });
    });
</script>

@endsection
