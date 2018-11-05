@extends('layouts.app')
@section('content')
<div class="box">
    <div class="box-body">
        <div class="white-box">
            <span class="section"></span>
      
         <table class="table table-striped table-bordered table-hover dataTable no-footer">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>School Name</th>
                        <th>Association</th>
                        <th>Date created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
         
                    if (count($schools) > 0) {
                        foreach ($schools as $school) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $school->schema_name ?></td>
                                <td><?= $school->association->name ?></td>
                                <td><?= $school->created_at ?></td>
                                <td>
                      
                         
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('layouts.datatable')
@endsection