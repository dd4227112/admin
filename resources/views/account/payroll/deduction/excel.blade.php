
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?= __('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li class="active"><?= __('menu_user') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">

            <div class="col-sm-12">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul>Update by Excel</ul>
                    <div id="myTabContent" class="tab-content">


                        <div class="x_panel">
                            <div class="x_title">
                                <p class="alert">Updated file can continue the following column names,phone,deduction_name, amount, deadline (yyyy-0m-0d)</p>

                                <div class="clearfix"></div>

                            </div>
<!--                                    <p><?= __("file") ?> 
                                <a href="<?= url('storage/uploads/sample/sample_students_upload.xlsx') ?>"><i class="fa fa-2x fa-cloud-download"></i></a></p>-->
                            <form id="demo-form2" action="<?= url('deduction/uploadFileByExcel') ?>" class="form-horizontal" method="POST" enctype="multipart/form-data">

                                <div class="form-group">

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="file" name="file" type="file" required="required" accept=".xls,.xlsx,.csv,.odt">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
                                        <button type="submit" class="btn btn-success"><?= __("submit") ?></button>
                                    </div>
                                </div>

                                <?= csrf_field() ?>
                            </form>
                        </div>

                    </div>
                </div>
            </div> <!-- col-sm-12 -->
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
