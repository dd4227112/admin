@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/';  ?>

  <div>
    <div class="page-header">
        <div class="page-header-title">
            <h4>Operations</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                 <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Task Allocated</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">summary</a>
                </li>
            </ul>
        </div>
    </div> 
  </div>

    <div class="page-body">
     
                   <div class="card">
                    <div class="card-header">
                        <h5>My  Tasks</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table dataTable table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Task type</th>
                                        <th>School</th>
                                        <th>Activity</th>
                                        <th>Dead line</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($tasks_allocated)) {
                                        foreach ($tasks_allocated as $act) {
                                            ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $act->taskType->name ?></td>
                                                <td><?= $act->client->name ?></td>
                                                <td><?= warp($act->activity,100) ?> </td>
                                                <td><?= date('d-m-Y',strtotime($act->end_date)) ?></td>
                                                <td> <a  class="btn btn-primary btn-mini btn-round" href="<?= url('customer/activity/show/' . $act->id) ?>">View</a> </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                  </div>

        </div>
    </div>



@endsection
