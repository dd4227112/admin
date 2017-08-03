@extends('layouts.app')
@section('content')

<div class="white-box">
<div class="table-responsive">
                                <table class="table color-table primary-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Schema Name</th>
                                            <th>Total Tables</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
$i=1;
                                     foreach($data as $schema){ ?>
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$schema->table_schema}}</td>
                                            <td>{{$schema->count}}</td>
                                            <td><a href="<?=url('database/compareTableColumn/'.$schema->table_schema)?>" class="btn btn-success btn-rounded">Analyse</a></td>
                                        </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div></div>

@endsection
