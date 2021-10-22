@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
   <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
      
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                    <thead>
                                        <tr>
                                            <th># </th>
                                            <th>School Name</th>
                                            <th>Status </th>
                                            <th>Api Key</th>
                                            <th>Contacts</th>
                                            <th>last Active</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; $cont = [];  $schools = [];
                                            $contacts = DB::table('admin.all_users')->where('usertype','Admin')->where('status','1')->get();
                                            foreach ($contacts as $contact) {
                                                $cont[$contact->schema_name] = $contact->phone;
                                            }

                                            $clients = DB::select('select c.id,c.name as client_name,c.username,s.school_id,p.branch_id from admin.clients c 
                                                    join admin.client_schools s on c.id = s.client_id left join admin.partner_schools p on p.school_id =s.school_id');
                                            foreach ($clients as $client) {
                                                $schools[$client->username] = $client->client_name;
                                            }
                                            
                                            if(count($sms_status) > 0)  
                                            foreach ($sms_status as $status) { 
                                    
                                            ?>
                                            <tr>
                                                <td> <?= $i ?> </td>
                                                <td> <?= !empty($status->schema_name) ? $status->schema_name : '' ?></td>
                                                <td> <?= $status->last_active == '' ? '<label class="label label-inverse-warning">Not Installed</label>' : '<label class="label label-inverse-success">Installed</label>' ?></td>
                                                <td><label class="badge badge-primary"><?= $status->api_key ?></label></td> 
                                                    
                                                <td>
                                                    <?php
                                                    if(isset($cont[$status->schema_name])) {
                                                        echo $cont[$status->schema_name] .'<br/>';
                                                    } else {
                                                        echo '<label class="label label-inverse-info-border">Not Specified</label>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?= isset($status->last_active) ? 
                                                '<label class="badge badge-inverse-primary">' . \Carbon\Carbon::parse($status->last_active)->diffForHumans() . '</label>' 
                                                    : '' ?>
                                                </td>
                                                </tr>
                                            <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
   

    @endsection