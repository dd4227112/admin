<?php
if((int) $show_download){ob_start();}
$root = url('/') . '/public/'
?>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <title>ShuleSoft Job Card</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="ShuleSoft Admin">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="keywords" content="ShuleSoft, Admin , Admin Panel">
        <meta name="author" content="ShuleSoft">
        <!-- Favicon icon -->
        <link rel="icon" href="<?= $root ?>assets/images/favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css">

        <style>
            .left{
                width: 60% !important; border-right: 5px solid #8CDDCD;
            }
            @media print{
                #print{display: none;}
            }
        </style>
    </head>
    <body class="horizontal-static">
        <!-- Pre-loader start -->

        <div class="main-body" >
            <div class="page-wrapper">
                <!-- Page header start -->

                <!-- Page header end -->
                <!-- Page body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Default card start -->
                            <p align='right' id="print"><a href="#" onclick="window.print()"><i class="fa fa-print" ></i> Print</a></p>
                            <div class="card">
                                <div class="card-header">
                                    <h5><img src="https://admin.shulesoft.com/public/assets/images/auth/shulesoft_logo.png" width="50" height="" style=""/> ShuleSoft Job card</h5>
                                    
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr style="border-bottom: 5px solid #8CDDCD;">

                                                    <td class="left" style="border-right: 5px solid #8CDDCD;">Services provided to Client:</td>
                                                    <td>
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name : <b><?= $client->name ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Date Onboarded: <b><?= $client->created_at ?></b></td>
                                                                </tr><tr>
                                                                    <td>Start Date: Time</td>
                                                                </tr><tr>
                                                                    <td>End Date: Time</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>  
                                                    </td>
                                                </tr>


                                                <tr  style="border-bottom: 5px solid #8CDDCD;">
                                                    <td class="left"  style="border-right: 5px solid #8CDDCD;">
                                                        <b>Client Comment</b>
                                                        <br/>
                                                        <br/>
                                                        <p style="height:2em"></p>
                                                    </td>
                                                    <td>
                                                        Service Provided to :
                                                    </td>

                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="">
                                        <div class="">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Task</th>
                                                        <th>ShuleSoft Person</th>
                                                        <th><?= ucfirst($client->username) ?> Person</th>
                                                        <th>Start Date : Time</th>
                                                        <th>End Date : Time</th>
                                                        <th>Status</th>
                                                        <th>Client Signature</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $x = 1;
                                                 //   $customer = new \App\Http\Controllers\Customer();
                                                    $trainings = \App\Models\TrainItemAllocation::where('client_id', $client->id)->orderBy('id', 'asc')->get();
                                                    foreach ($trainings as $training) {
                                                        ?>
                                                        <tr>
                                                            <th scope="row"><?= $x ?></th>
                                                            <td><?= $training->trainItem->content ?></td>
                                                            <td><?= $training->user->firstname . ' ' . $training->user->lastname ?></td>
                                                            <td><?= strlen($training->school_person_allocated) > 4 ? $training->school_person_allocated : 'Not Allocated' ?></td>
                                                            <td><?= date('Y-m-d H:i', strtotime($training->task->start_date)) ?> </td>
                                                            <td><?= date('Y-m-d H:i', strtotime($training->task->end_date)) ?></td>
                                                            <td> <?= $training->task->status ?> </td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                        $x++;
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <br/>
                                        <table class="table">
                                            <thead>
                                                <tr  style="border-bottom: 5px solid #8CDDCD;">
                                                    <th colspan="2" style="background:#8CDDCD;text-align: center;
                                                        font-size: 18px;
                                                        color: white;">Client</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 60% !important;">
                                                        <div>For and behalf of Click here to enter text.<br/> I acknowledge those
                                                            services has been performed to Choose an item
                                                        </div>
                                                    </td>
                                                    <td>  
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name:</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Designation:</td>
                                                                </tr><tr>
                                                                    <td>Mobile No: </td>
                                                                </tr><tr>
                                                                    <td>Signature: </td>
                                                                </tr>
                                                            </tbody>
                                                        </table> </td>

                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr  style="border-bottom: 5px solid #8CDDCD;">
                                                    <th colspan="2" style="background:#8CDDCD;text-align: center;
                                                        font-size: 18px;
                                                        color: white;">INETS COMPANY LIMITED</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 60% !important;">For and on behalf of the INETS Company Limited, the aforementioned services headed by</td>
                                                    <td>    <table class="table">
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
                                                <td style="width: 60% !important;">
                                                    <img src="<?= url('public/images/ShuleSoft-TM.png') ?>" width="350" height="" style=""/> 
                                                </td>
                                                <td style="width: 60% !important;">
                                                    <span>
                                                        INETS is a Private Company Limited by shares and registered <br/>under the Company Act 2012 with registration number 9216.<br/> INETS deals solely with Software Development. <br/>Currently focused on a School Management System ShuleSoft </span></td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Page body end -->
            </div>
        </div>
</html>
<script type="text/javascript">window.print();</script>
<?php
if((int) $show_download){
$page = ob_get_clean();
$file_name =$client->username. '.doc';
Storage::disk('local')->put($file_name, $page);
}
?>