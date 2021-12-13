@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/';  ?>



  <div>
    <div class="page-header">
        <div class="page-header-title">
            <h4>SMS/Emails</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                 <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">communications</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">summary</a>
                </li>
            </ul>
        </div>
    </div> 
  </div>

    <div class="page-body">
   

           <div class="row">
                  <div class="col-xl-3 col-md-6">
                             <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Whatsapp Messages Sent</p>
                                                <h4 class="m-b-0">{{ number_format($whatsapp_sent_sms) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-mail f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                
                    <div class="col-xl-3 col-md-6">
                         <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Whatsapp Messages Delivered</p>
                                                <h4 class="m-b-0">{{ number_format($whatsapp_sent_delivered) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-mail f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">SMS Sent</p>
                                                <h4 class="m-b-0">{{ number_format($sms_sent)}}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-mail f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                   <div class="col-xl-3 col-md-6">
                        <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Pending SMS</p>
                                                <h4 class="m-b-0">{{ number_format($pending_sms)}}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-mail f-30 text-c-red" style="color:#19b99a"></i>
                                            </div>
                                    </div>
                                </div>
                         </div>
                   </div>

                    <div class="col-xl-3 col-md-6">
                         <div class="card shadow bg-primary">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Delivered SMS</p>
                                                <h4 class="m-b-0">{{ number_format($delevered_sms)}}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-mail f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                         </div>
                    </div>

                   

                      <div class="col-xl-3 col-md-6">
                         <div class="card shadow bg-primary">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Failed SMS</p>
                                                <h4 class="m-b-0">{{ number_format($failed_sms)}}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-mail f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                         </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                         <div class="card shadow bg-primary">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Sent Email</p>
                                                <h4 class="m-b-0">{{ number_format($sent_email)}}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-mail f-30 text-c-red"></i>

                                            </div>
                                    </div>
                                </div>
                         </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                            <div class="card shadow bg-primary">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Pending Email</p>
                                                <h4 class="m-b-0">{{ number_format($pending_email)}}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-mail f-30 text-c-red"></i>

                                            </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>

        
              
                       

                

        </div>
    </div>

<script>

</script>

@endsection
