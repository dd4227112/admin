
@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
               
           
        </div>
        <div class="col-sm-12">
                                                        <div class="card">
                                                          <?php if($schema != 'public') {  ?>
                                                             <div class="card-header"> 
                                                                <h5 class="card-header-text">School Login Information</h5>
                                                                <a href="<?=url('Customer/profile/'.$schema)?>" class="btn btn-primary waves-effect waves-light f-right">
                                                                    <i class="icofont icofont-right"> Go Back </i>
                                                                </a>
                                                            </div>
                                                         <?php } ?>

                                                            <div class="card-block">
                                                            <table class="table m-b-0">
                                                                                <tbody>

                                                                                    <tr> <th> <?= isset($error_message) ? 'Error Message ' : '' ?>
                                                                                        <td> 
                                                                                            <?=isset($error_message) ? $error_message : '' ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    
                                                                                    <tr>
                                                                                        <th class="social-label b-none p-t-0">School Name
                                                                                        </th>
                                                                                        <td class="social-user-name b-none p-t-0 text-muted"><?= isset($school->sname) ? $school->sname : '' ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th class="social-label b-none">Location</th>
                                                                                        <td class="social-user-name b-none text-muted"><?= isset($school->address) ?  $school->address : '' ?></td>
                                                                                    </tr>
                                                                                       
                                                                                        <tr>
                                                                                            <th class="social-label b-none">Contact Details</th>
                                                                                            <td class="social-user-name b-none text-muted"><?= isset($school->phone) ? $school->phone : '' ?></td>
                                                                                        </tr>
                                                                                      
                                                                                        <?php if(isset($school->username)) { ?>
                                                                                        <tr>
                                                                                            <th class="social-label b-none p-b-0">School Access</th>
                                                                                            <td class="social-user-name b-none p-b-0 text-muted">
                                                                                            <?php
                                                                                            echo 'Username - '.$school->username.'<br> Password - '.$pass;
                                                                                            ?>
                                                                                          </td>
                                                                                        </tr>
                                                                                        
                                                                                        <tr>
                                                                                           <td>Click to Login at <a href="https://<?=$schema?>.shulesoft.com/"> https://<?=$schema?>.shulesoft.com/ </a></td>
                                                                                           <td> <a href="https://<?=$schema?>.shulesoft.com/" class="btn btn-info btn-sm" target="_blank"><i class="icofont icofont-link"> </i> Visit Here </a>

                                                                                        </tr>
                                                                                         <?php } ?>
                                                                                        </tbody>
                                                                                        <table>
                                                                                                                                    </div>
                                                                        </div>
                                                                                                                                
                                                                        </div>
                                                                        </div>
                                                                        @endsection