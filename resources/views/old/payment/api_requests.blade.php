@extends('layouts.app')
@section('content')

<div class="white-box">
    <h5 class="box-title">Payment Requests</h5>

    <div class="table-responsive"> 
        <table id="example23" class="display nowrap table color-table success-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Request Payload</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($requests as $key => $request) {
                    ?>
                    <tr>
                        <td><?= $request->id ?></td>
                        <td>
                            <pre><?php
                $payload = json_decode($request->content);
                echo json_encode($payload, JSON_PRETTY_PRINT);
                    ?></pre></td>
                        <td><?=date('d M Y H:i',strtotime($request->created_at))?></td>
                        <td></td>
                    </tr>
<?php } ?>
            </tbody>
        </table>
    </div>
    {{-- Paginate --}}
    <div class="row">
        <div class="center">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@include('layouts.datatable')


@endsection

