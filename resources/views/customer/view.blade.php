
@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
         <div class="page-header">
            <div class="page-header-title">
                <h4><?='Reset password' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">password</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-header">
          
            <div class="card">
                <?php if($schema != 'public') {  ?>
                    <div class="card-header"> 
                       <h5>School Login Information</h5>
                       <?php $profile_url = "Customer/profile/$schema"; ?>
                       <x-button :url="$profile_url" color="primary" btnsize="sm float-right"  title="Go back" shape="round" toggleTitle="Profile"></x-button>
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
                                    <td> <a href="https://<?=$schema?>.shulesoft.com/" class="btn btn-info btn-sm btn-round" target="_blank"> Visit Here </a>

                                </tr>
                                    <?php } ?>
                                </tbody>
                             <table>
                          </div>
                       </div>
                   </div>
    @endsection