
@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
               
            <div class="page-header-breadcrumb">
               <?=isset($error_message) ? $error_message : '' ?>
            </div>
        </div>
        <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-header-text">School Login Information</h5>
                                                                <a href="<?=url('Customer/profile/'.$schema)?>" class="btn btn-primary waves-effect waves-light f-right">
                                                                    <i class="icofont icofont-right"> Go Back </i>
                                                                </a>
                                                            </div>
                                                            <div class="card-block">
                                                            <table class="table m-b-0">
                                                                                <tbody><tr>
                                                                                        <th class="social-label b-none p-t-0">School Name
                                                                                        </th>
                                                                                        <td class="social-user-name b-none p-t-0 text-muted"><?= $school->sname ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th class="social-label b-none">Location</th>
                                                                                        <td class="social-user-name b-none text-muted"><?= $school->address ?></td>
                                                                                    </tr>
                                                                                       
                                                                                        <tr>
                                                                                            <th class="social-label b-none">Contact Details</th>
                                                                                            <td class="social-user-name b-none text-muted"><?= $school->phone ?></td>
                                                                                        </tr>
                                                                                      
                                                                                        <tr>
                                                                                            <th class="social-label b-none p-b-0">School Access</th>
                                                                                            <td class="social-user-name b-none p-b-0 text-muted">
                                                                                            <?php
                                                                                            echo 'Username - '.$school->username.'<br>
                                                                                           Password - '.$pass;
                                                                                                
                                                                                                ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                           <td>Click to Login at <a href="https://<?=$schema?>.shulesoft.com/"> https://<?=$schema?>.shulesoft.com/ </a></td>
                                                                                           <td> <a href="https://<?=$schema?>.shulesoft.com/" class="btn btn-info btn-sm" target="_blank"><i class="icofont icofont-link"> </i> Visit Here </a>

                                                                                        </tr>
                                                                                        </tbody>
                                                                                        <table>
                                                            </div>
</div>
                                                        
</div>
</div>
@endsection