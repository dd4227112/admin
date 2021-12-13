@extends('layouts.app')
@section('content')

    
      

        <div class="page-header">
            <div class="page-header-title">
                <h4><?='Sequence' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">sequence</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 
   
        <div class="page-body">
            <div class="">
                <div class="">
               
                    <div class="card">
                        <div class="card-header">
                            <h5>Sequence</h5>
                          

                            <div class="row">
                                <div class="col-md-12">
                                    <p align='left'>
                                        <!--<a class="btn btn-success" href="<?= url('customer/guide/null?pg=add') ?>">Add New Sequence</a></p>-->
                                    <br/>
                                </div>
                            </div>
                        </div>

                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
                                <table id="example23" class="display nowrap table  table-striped table-bordered dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Message</th>
                                            <th>Interval</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (isset($sequences) && sizeof($sequences) > 0) {
                                            foreach ($sequences as $sequence) {
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $sequence->title?></td>
                                                    <td><?= warp($sequence->message,80)?></td>
                                                    <td><?= $sequence->interval ?></td>
                                                   
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
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    content_for = function () {
        $('#permission_group').change(function () {
            var group_id = $(this).val();
            if (group_id === '0') {
                $('#content_for').val(0);
            } else {
                $.ajax({
                    type: 'get',
                    url: "<?= url('support/getPermission') ?>",
                    data: "group_id=" + group_id,
                    dataType: "html",
                    success: function (data) {
                        $('#content_for').html(data);
                    }
                });
            }
        });
    }
    $(document).ready(content_for);
</script>
@endsection