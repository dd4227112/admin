@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>

<div class="main-body">
    <div class="page-wrapper">
        <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">

                    <!-- Zero config.table start -->
                    <div class="card">
                     <div class="card tab-card">
                      

                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="card-block">
                                   <div class="dt-responsive table-responsive">
                                
                                      <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Except this school</th>
                                                <th>Client Name</th>
                                                <th>Invoice  #</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                            </tr>
                                        </thead>
                             
                                        <tbody>
                                            <?php $x = 1;
                                            foreach ($unpaidclients as $value) {?>
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <th scope="row" class="text-center"><input type="checkbox"/></th>
                                                    <td><?= $value->name ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    
                                                </tr>
                                            <?php $x++; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                {{-- <td colspan="3">Total</td>
                                                <td><?= money($total_amount) ?></td>
                                                <td><?= money($total_paid) ?></td>
                                                <td><?= $total_sms ?></td>
                                                <td colspan="4"></td> --}}
                                            </tr>
                                        </tfoot>
                                    </table>
                               </div>
                            </div>
                          </div>
                        </div>
                    
                   </div>
                  </div> 

                </div>


                      
                </div>

            </div>
        </div>
        
        <!-- Page-body end -->
    </div>


<script type="text/javascript">
    $('#schema_project').change(function () {
        var schema = $(this).val();
        if (schema > 0) {
            $('#year_id').show();
            return false;
        } else {
          //  window.location.href = "<?= url('account/invoice') ?>/" + schema;
        }
    });
    $('#year_select').change(function () {
        var year = $(this).val();
        var project = $('#schema_project').val();
        if (year == 0) {
            return false;
        } else {
            window.location.href = "<?= url('account/invoice') ?>/" + project + '/' + year;
        }
    });
</script>
@endsection
