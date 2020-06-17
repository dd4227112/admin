@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Database</h4>
                <span></span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Database</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Create Script</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="panel">
                            <button  class="mycode btn btn-default" data-clipboard-action="copy" data-clipboard-target="#mycode"> <i class="ti-files"></i>copy</button>
                            <code id="mycode" style="margin: 5px;"><?= $script ?> </code>
                        </div>

                        <form action="<?= url('software/upgrade') ?>" method='post' class="form-horizontal form-bordered">
                            {{ csrf_field() }}
                            <div class="form-body">

                                <div class="form-group">
                                    <label class="control-label">SQL pane for upgrade script</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="5" name="sql"><?= request('sql') ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">

                                <div class="form-group last">
                                    <label class="control-label">Skip Schema</label>
                                    <div class="col-md-12">
                                        <input type="text" value="<?= request('skip') ?>" class="form-control" name="skip" placeholder="separate by comma schema name to skip">
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">

                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Submit</button>
                         

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= $root ?>js/clipboard.min.js"></script>
<script>
var clipboard = new Clipboard('.mycode');

clipboard.on('success', function (e) {
  console.log('copied');
});

clipboard.on('error', function (e) {
  console.log('error,try again');
});
</script>
@endsection
