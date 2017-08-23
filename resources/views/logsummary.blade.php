@extends('layouts.app')
@section('content')

                  <div class="row">
                    <div class="white-box">
                    <h5>Request made by each School</h5>
                    <div class="table-responsive"> 
                                <table class="table color-table success-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Name</th>
                                            <th>Total Logs</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   <?php $i=1;
                                 
                                   foreach ($data as $key => $value) {
                                 
                                      ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td>
                                            <a href="<?=url('readRequest/').'/'.$value->total_logs?>"><?=$value->total_logs?></a></td>
                                            <td><?=ucfirst($value->schema_name)?></td>             
                                        </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                </div>
   
@endsection
