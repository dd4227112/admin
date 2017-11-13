@extends('layouts.app')
@section('content')

                  <div class="row">
                    <div class="white-box">
                    <h5>Request made by each School</h5>
                    <div class="table-responsive"> 
                                <table id="example23" class="display nowrap table color-table success-table" cellspacing="0" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Name</th>
                                            <th>Total Requests</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   <?php $i=1;
                                 
                                   foreach ($data as $key => $value) {
                                 
                                      ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            
                                            <td><?=ucfirst($value->schema_name)?></td> 
                                            <td>
                                            <a href="<?=url('readRequest/').'/'.$value->total_logs?>"><?=$value->total_logs?></a></td>            
                                            <td><a href="<?=url('analyse/').'/'.$value->schema_name?>" class="btn btn-sm btn-info">Analyse</a></td>
                                        </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                </div>
@include('layouts.datatable')
@endsection
