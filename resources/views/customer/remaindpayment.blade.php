@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>


    
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
                                                <th>Except</th>
                                                <th>Client Name</th>
                                                <th>Invoice  #</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                            </tr>
                                        </thead>
                             
                                        <tbody>
                                            <?php $x = 1;
                                            foreach ($unpaidclients as $value) {
                                                $amount = $value->invoiceFees()->sum('amount');
                                                $paid = $value->payments()->sum('amount');
                    
                                                //$unpaid = $amount - $paid;
                                                // $total_paid += $paid;
                                                // $total_amount += $amount;
                                                // $total_unpaid += $unpaid;
                                                
                                                ?>
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td class="text-center">
                                                    <?php
                                                          $check = \App\Models\Invoice::where('id', $value->id)->where('pay_status',0)->first();
                                                          !empty($check) ? $checked = 'checked' : $checked = '';
                                                
                                                      ?>
                                                     <input  type="checkbox"  {{ $checked }}  class="mychoice"  name="invoice_id"  value="<?=$value->id ?>"/>
                                                    </td>
                                                    <td><?= warp(strtoupper($value->client->name),20) ?></td>
                                                    <td><?= $value->reference ?></td>
                                                    <td><?= money($amount) ?></td>
                                                    <td><?= money($paid) ?></td>
                                                    
                                                </tr>
                                            <?php $x++; } ?>
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

            </div>
        </div>
        
        <!-- Page-body end -->
    </div>


<script type="text/javascript">
  $(document).ready(function() {
  $('.mychoice').click(function() {
    var invoice_id = $(this).val();
   //  alert(invoice_id);

    $.ajax({
     method: 'post',
     url: "<?= url('customer/updateUnpaidClient') ?>",
     data: {
        invoice_id: invoice_id
     },
     headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      dataType: 'html',
      success: function(data) {
        //  ... do something with the data...
          window.location.reload(); 
      }
    });
  });
});
</script>
@endsection
