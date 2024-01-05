@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>



<!-- Page-header start -->

<div class="page-header">
    <div class="page-header-title">
        <h4><?= 'Add a Customer to TRA VFD Service' ?></h4>
    </div>
    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#!">Partner</a>
            </li>
            <li class="breadcrumb-item"><a href="#!">services</a>
            </li>
        </ul>
    </div>
</div> 


<!-- Page-body start -->
<div class="page-body">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                @if (sizeof($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="card-block">
                    <form method="post" action="#" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                 <label for="tin" class="col-sm-2 control-label">Select School:</label>
                               <div class="col-sm-12">
                                 <select name='client_id'  id="region" class="form select2" required>

                                    @foreach($clients as $client)

                                    <option value="{{$client->id}}">{{ucfirst($client->name)}} </option>

                                    @endforeach
                                </select>
                               </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="tin" class="col-sm-2 control-label">
                                            TIN Number
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="number" min="0" max="999999999" class="form-control" id="tin" name="tin" value="<?= old('tin', request()->tin) ?>" >
                                        </div>
                                        <span class="offset-2">
                                            <?php echo form_error($errors, 'tin'); ?>
                                        </span>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="income_tax" class="col-sm-2 control-label">
                                            VAT Number
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="number" min="0" max="999999999" class="form-control" id="vrn" name="vrn" value="<?= old('vrn', request()->vrn) ?>" >
                                        </div>
                                        <span class="offset-2">
                                            <?php echo form_error($errors, 'vrn'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                         <label for="income_tax" class="col-sm-2 control-label">
                                                Tax Group
                                            </label>
                                            <div class="col-sm-10">
                                                <select name="tax_group" class="form-control">
                                                    <option value="5" <?= request()->tax_group == 5 ? 'selected' : '' ?>>Vat Exclusive Products or Services.</option>
                                                    <option value="3" <?= request()->tax_group == 3 ? 'selected' : '' ?>>Zero Rated Products or Services</option>
                                                    <option value="1" <?= request()->tax_group == 1 ? 'selected' : '' ?>>Vatable Products or Services</option>
                                                </select>
                                            </div>
                                            <span class="">
                                                <?php echo form_error($errors, 'tax_group'); ?>
                                            </span>
                                            <br>
                                            <br>
                                            <label for="income_tax" class="col-sm-2 control-label">
                                                Income Tax
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" name="income_tax" id="income_tax" class="form-control">
                                            </div>
                                            <span class="offset-2">
                                                <?php echo form_error($errors, 'tax_group'); ?>
                                            </span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kyc_forms" class="col-sm-8 control-label">
                                            KYC Forms
                                        </label>
                                        <div class="col-sm-12">
                                            <input type="file"   accept=".pdf" class="form-control" id="vrn" name="tin_certificate" value="<?= old('vrn', request()->tin_certificate) ?>" >
                                            TIN certificate</div>
                                        <div class="col-sm-12">
                                            <input type="file"   accept=".pdf"  class="form-control" id="vrn" name="vrn_certificate" value="<?= old('vrn', request()->vrn_certificate) ?>" >
                                            VRN Certificate (option) </div>
                                        <div class="col-sm-12">
                                            <input type="file" class="form-control" id="vrn" name="id_certificate" value="<?= old('vrn', request()->id_certificate) ?>" >
                                            Owner/Director Identification (NIDA, Passport and Driving License only)</div>
                                        <div class="col-sm-12">
                                            <input type="file"   accept=".pdf" class="form-control" id="vrn" name="application_letter" value="<?= old('vrn', request()->application_letter) ?>" >
                                            Application Letter <br/>
                                            <a href="<?=base_url('Partner/downloadSample')?>">Download Sample</a></div>

                                        <span class="offset-1">
                                            <?php echo form_error($errors, 'kyc_forms'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div id="savebtnWrapper" class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm btn-round">
                                &emsp;Submit&emsp;
                            </button>
                        </div>
                </div>

                </form>

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>

    $(".select2").select2({
        theme: "bootstrap",
        dropdownAutoWidth: false,
        allowClear: false,
        debug: true
    });
</script>
<script type="text/javascript">

    $('#region').change(function () {
        var val = $(this).val();
        $.ajax({
            method: 'get',
            url: '<?= url('Users/getBranch/null') ?>',
            data: {region: val, partner_id: 3},
            dataType: 'html',
            success: function (data) {
                $('#branch_id').html(data);
            }
        });
    });

    get_schools = function () {
        $("#get_schools").select2({
            minimumInputLength: 2,
            // tags: [],
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '<?= url('customer/getschools/null') ?>',
                dataType: 'json',
                type: "GET",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term,
                        token: $('meta[name="csrf-token"]').attr('content')
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            };
                        })
                    };
                }
            }
        });
    }

    $(document).ready(get_schools);
</script>
@endsection
