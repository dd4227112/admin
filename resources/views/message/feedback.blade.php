@extends('layouts.app')
@section('content')

<div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <ul class="timeline">
                                <?php
                                $i=1;
                                foreach ($feedbacks as $feedback) {  
                                    $user=\DB::table('admin.all_users')->where('id',$feedback->user_id)->where('table',$feedback->table)->where('schema_name',$feedback->schema)->first();
                                 
                                    ?>
                                <li <?=$i % 2==0 ?'class="timeline-inverted"' :''?> >
                                    <div class="timeline-badge success"><i class="fa fa-user"></i> </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><?=count($user)==1 ? $user->name : $feedback->username?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?=date('d M Y h:m:i',strtotime($feedback->created_at)) .' From: '.$feedback->schema?></small> </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?=$feedback->feedback?></p>
                                        </div>
                                         <hr>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-gear"></i> <span class="caret"></span> </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Reply</a> </li>
                                                </ul>
                                            </div>
                                    </div>
                                </li>
                                <?php $i++; } ?>

                            </ul>
                        </div>
                        <?=$feedbacks->links()?>
                    </div>
                </div>
@include('layouts.datatable')
@endsection
