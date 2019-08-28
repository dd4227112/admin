<?php

/**
 * Description of upload_status
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-puzzle-piece"></i>Upload Status</h3>

        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li class="active">upload status</li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <span class="pull-left"> @if(url()->previous()!=url()->current())
                <a class="btn btn-sm btn-info" href="{{url()->previous()}}"><i class="fa fa-arrow-circle-left"> @lang('application_lang.go_back')</i></a>
                @endif
                    </span>
                <div class="col-sm-6 col-sm-offset-3 list-group">
                    <div class="list-group-item list-group-item-warning">
                       <?=$status?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>