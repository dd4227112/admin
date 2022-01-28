@extends('layouts.app')
@section('content')

<?php
$root = url('/') . '/public/';
function tagEdit($schema_name, $column, $value, $type = null) {
      $type = null ? $type = '"text"' : $type = $type;
    if ((int) request('skip') == 1) {
        $return = $value;
    } else {
        $return = '<input required  class="form-control" type="'. $type. '" schema="' . $schema_name . '" id="' . $column .$schema_name. '" value="' . $value . '" onblur="edit_records(\'' . $column . '\', this.value, \'' . $schema_name . '\')"/>';
    }
    return $return;
  }
 ?>
     <div class="page-header">
            <div class="page-header-title">
                <h4>Create Invoices</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">invoice</a>
                    </li>
                </ul>
            </div>
        </div>

    <div class="page-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card"> 
                    <div class="card-block">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                
                                  <div class="row d-flex justify-content-center">
                                     <div class="col-sm-10 col-xl-4 m-b-30">
                                                <h4 class="sub-title">Select invoice Type</h4>
                                                <select name="invoice_type" class="select2"  id="invoice_type">
                                                <option value="0">Select</option>
                                                    <?php
                                                        foreach ($invoice_types as $project) { ?>
                                                        <option value="<?= $project->id ?>" selected><?= $project->name ?></option>
                                                    <?php  }
                                                    ?>
                                            </select>
                                         </div>

                                           <div class="col-sm-10 col-xl-4 m-b-30">
                                                <h4 class="sub-title">Select School</h4>
                                                <select name="client_name" class="select2"  id="clients">
                                                    
                                                </select>
                                            </div>
                                     </div>
                              
                                  </div>
                                  </div>
                               </div>
                            </div>

                             <?php if(isset($client) ) {  ?>
                                <div class="card"> 
                                    <div class="card-header">
                                        <h5>  CREATE INVOICE FOR <?= strtoupper($client->name) ?>  </h5>
                                    </div>
                                     <div class="card-block">
                                           
                                            <div class="table-responsive dt-responsive">
                                                <table class="table  table-bordered nowrap ">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Service Name</th>
                                                            <th>Description</th>
                                                            <th>Quantity</th>
                                                            <th>Unit price</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                          <form method="POST" action="<?= url('account/projection/'.$invoice_type . '/' . $client->id) ?>" >
 
                                                            <?php $i=1; if(!empty($services)) {
                                                                   foreach($services as $service)  { ?>
                                                             <tr>
                                                                <td>
                                                                   <input class="form-control" type="checkbox" id="services<?= $service->id ?>"  value="<?= $service->id ?>"  onclick="service('<?= $service->id ?>')" name="service_ids[]" />
                                                                </td>
                                                             
                                                                <th style="width: 40px;">
                                                                    <?=  warp($service->name,20); ?>  
                                                                </th>

                                                                <th>
                                                                   <input class="form-control" type="text" id="note<?= $service->id ?>"  value="<?php echo preg_match('/Shulesoft system/i', strtolower($service->name)) ? 'Training and Support,Unlimited Cloud hosting for School Information,Unlimited bandwidth for users to access,Customization of features based on school requestsFree Technical support for all ShuleSoft users ( parents, teachers, students and staff)': '' ;?>"  name="note[]"  disabled="disabled"/>
                                                                </th>

                                                                <td style="width: 30px;"> 
                                                                   <input class="form-control" type="number" id="quantity<?= $service->id ?>"  value="<?php echo preg_match('/Shulesoft system/i', strtolower($service->name)) ? $client->estimated_students :  '' ;?>"  name="quantity[]"  onkeyup="quantity('<?= $service->id ?>')"  disabled="disabled"/>
                                                                </td> 
                                                                
                                                                  <td style="width: 30px;">
                                                                   <input class="form-control amounts"  type="number" id="amount<?= $service->id ?>"  value="<?php echo preg_match('/Shulesoft system/i', strtolower($service->name)) ? $client->price_per_student :  '' ;?>"  name="amounts[]"  onkeyup="get_amount('<?= $service->id ?>')" disabled="disabled"/>
                                                                </td>

                                                                 <td>
                                                                    <span id="amount_tag<?=$service->id?>" class="total_amount"></span>
                                                                </td>
                                                            </tr>
                                                            
                                                          <?php  $i++; } } ?>

                                                             <tr>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td>
                                                                     <div> 
                                                                        <strong >Email </strong>
                                                                            <input class="form-control" type="email" value="<?= $client->email ?>"  name="email" id="email"  required>
                                                                      </div>
                                                                  </td> 
                                                                  <td>
                                                                      <div>
                                                                          <strong>Phone number </strong>
                                                                          <input class="form-control" type="phone" value="<?= $client->phone ?>"  name="phone" id="phone" required>
                                                                    </div>
                                                                  </td>
                                                                  <td>
                                                                      <div> 
                                                                       <strong >Invoice start date </strong>
                                                                          <input class="form-control" type="date" value="<?= date('Y-m-d') ?>"  name="invoice_start_date" required>
                                                                      </div>
                                                                  </td>
                                                                  <td>
                                                                      
                                                                  </td>
                                                              
                                                             </tr>
                                                             <td>
                                                                 <td colspan="2">
                                                                     <div class="col-md-4 col-sm-4 col-xs-12 ">
                                                                        <button type="submit" id="add_revenue" class="btn btn-primary btn-sm btn-round"> Save </button>
                                                                    </div>
                                                                  </td> 
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td></td>
                                                             </tr>

                                    
                                                    <?= csrf_field() ?>

                                                </form>
                                        </tbody>
                                        
                                    </table>
                                </div> 
                                <?php } ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    
        $(".select2").select2({
        theme: "bootstrap",
        dropdownAutoWidth: false,
        allowClear: false,
        debug: true
        }); 


       service = function (id) {
         var service_id = id;
         if ( $("#services" + service_id).is(":checked")) {
                $("#quantity" + service_id).removeAttr("disabled");
                $("#amount" + service_id).removeAttr("disabled");
                $("#note" + service_id).removeAttr("disabled");
                $("#quantity"+service_id).focus();
                $("#amounts"+service_id).focus();
                $("#note"+service_id).focus();
            }else {
                $("#quantity" + service_id).attr("disabled", "disabled");
                $("#amount" + service_id).attr("disabled", "disabled");
                $("#note" + service_id).attr("disabled", "disabled");
            }
        };


    $('#invoice_type').change(function (event) {
        var invoice_type = $(this).val();
        var invoice_t = document.getElementById("invoice_type");
        var type = invoice_t.options[invoice_t.selectedIndex].text;
        var type = type.toLowerCase();

           if(type.match(/proforma invoice/)){
               var url = '<?= url('Account/getSchools') ?>';
             }else{
               var url = '<?= url('Account/getClients') ?>';
             }

            $.ajax({ 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                data: {invoice_type: invoice_type},
                dataType: "html", 
                cache: false,
                success: function (data) { 
                    $('#clients').html(data);
                }
            });
        });

        $('#clients').change(function () {
        var client_id = $(this).val();
        var invoice_type = $('#invoice_type').val();
        if (client_id == 0 || invoice_type == 0) {
           } else {
            window.location.href = "<?= url('Account/projection') ?>/" + invoice_type + '/' + client_id;
        }
    });



    edit_records = function (tag, val, schema) {
        $.get('<?= url('customer/updateProfile/null') ?>', {schema: schema, table: 'setting', val: val, tag: tag, user_id: '1'}, function (data) {
            $('#status_' + tag + schema).html('<label class="badge badge-success">'+data+'</label>');
            toastr.success(data);
        });
    };

     get_amount = function (id) {
         var service_id = id;
            $('#amount_tag' + id).html($('#quantity' + id).val() * $('#amount' + id).val());
            var sum = 0;
            $('.total_amount').each(function () {
                sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
            });
            console.log(sum);
            $('#amount').val(sum);
        };

    
</script>
@endsection