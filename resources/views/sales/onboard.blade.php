@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<div class="main-body">
    <div class="page-wrapper">

     <div class="page-header">
            <div class="page-header-title">
              <h4><?='Onboard new school' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">new school</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">sales</a>
                    </li>
                </ul>
            </div>
        </div> 

          <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <form action="<?= url('sales/onboard/' . $school->id) ?>" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                            <div class="form-group">
                                                    <strong for="">School full name</strong>
                                                <input type="text" class="form-control form-txt-inverse text-bold" placeholder="Add School Namee eg, canossa" name="name" value="<?= strtoupper($school->name) ?> <?= strtoupper($school->type) ?> SCHOOL" required autofocus>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                        <strong> Sales Person </strong>
                                                        <select name="sales_user_id" class="form-control select2 form-txt-inverse text-bold" required>
                                                        <option value="0">Sales Person</option>
                                                        <?php foreach ($staffs as $staff) { ?>
                                                            <option user_id="<?= $staff->id ?>" school_id="" value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                                            <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                        <strong for="">Sales Method</strong>
                                                    <select name="task_type_id" class="form-control select2 form-txt-inverse" required>
                                                        <option value="0">Sales Method</option>
                                                        <?php $types = DB::table('task_types')->where('department', 2)->get();
                                                            foreach ($types as $type) { ?>
                                                                <option value="<?= $type->id ?>"><?= $type->name ?></option>
                                                            <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                        <strong>Price Per Student</strong>
                                                    <input type="text" name="price"  class="form-control form-txt-inverse text-bold transaction_amount" required placeholder="10000">
                                                </div>
                                                <div class="col-sm-6">
                                                        <strong>Estimated students</strong>
                                                        <input type="text" class="form-control form-txt-inverse transaction_amount" value="<?= $school->students ?>" name="students" required="">
                                                </div>
                                            </div>

                                                <?php
                                                $school_contact = DB::table('admin.school_contacts')->where('school_id', $school->id)->first(); { ?>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <strong>Customer Official Email</strong>
                                                            <input type="email" class="form-control" value="<?= $school_contact->email ?>" name="email" required="">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <strong>Customer Phone number</strong>
                                                                <input type="text" class="form-control" value="<?= $school_contact->phone ?>" name="phone" required="">
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                        </div>


                                            <div class="col-sm-6">
                                            <div class="form-group">
                                                <strong>School username</strong>
                                                <input style=" resize: none" class="form-control " id="school_username" name="username" type="text" placeholder="school name" value="<?= 'https://' .strtolower($school->name).'.shulesoft.com' ?>"  onkeyup="validateForm()" required=""> 
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                        <strong for="">Data Format Available</strong>
                                                        <select name="data_type_id" class="form-control">
                                                            <option value="1">Excel With Parent Phone Numbers</option>
                                                            <option value="2">Physical Files Format</option>
                                                            <option value="3">Softcopy but without parents phone numbers</option>
                                                        </select>
                                                </div>
                                                <div class="col-sm-6">
                                                        <strong for="">Implementation Start Date</strong>
                                                    <input type="datetime-local" class="form-control" value="" name="implementation_date" required="">
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-6">
                                                        <strong for="">Contract Start Date</strong>
                                                    <input type="date" class="form-control" value="" name="start_date" required="">
                                                </div>
                                                <div class="col-sm-6">
                                                        <strong for="">Contract Start Date</strong>
                                                        <input type="date" class="form-control" name="end_date" required="">
                                                </div>
                                            </div>

                                            <div class="row m-t-22">
                                                <div class="col-sm-6">
                                                        <strong for="">Agreement Type</strong>
                                                        <select name="contract_type_id" class="form-control">
                                                        <?php
                                                        $ctypes = DB::table('admin.contracts_types')->get();
                                                        foreach ($ctypes as $ctype) {
                                                            ?>
                                                            <option value="<?= $ctype->id ?>"><?= $ctype->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                        <strong for="">Upload Agreement Form</strong>
                                                        <input type="file" class="form-control" accept=".pdf" name="file" required="">
                                                </div>
                                            </div>
                                            </div>


                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <strong class="col-form-strong">Payment Option</strong>
                                                    <select name="payment_option" class="form-control" id="_payment_option">
                                                        <option value="Bank deposit">Bank deposit</option>
                                                        <option value="cash">Cash</option>
                                                        <option value="standing order">Standing order</option>
                                                        <option value="bank transfer">Bank transfer </option>
                                                    </select>
                                            </div> 
                                        </div>

                                        <div class="col-sm-12 m-t-20"  id="standing_order_form">
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                        <strong> Branch name </strong>
                                                        <input type="text" placeholder="Bank branch name"  class="form-control"  name="branch_name">
                                                </div>
                                                <div class="col-sm-4">
                                                        <strong for="">Contact person</strong>
                                                        <input type="text" placeholder="Contact person"  class="form-control"  name="contact_person">
                                                </div>
                                                    <div class="col-sm-4">
                                                        <strong for="">Number of Occurance</strong>
                                                        <input type="number" placeholder="must be number eg 2, 3, 12 etc"  class="form-control" id="box1" name="number_of_occurrence">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                        <strong>Payment Basis</strong>
                                                        <select name="which_basis"  class="form-control">
                                                            <option value=""></option>
                                                            <option value="Annually">Annually</option>
                                                            <option value="Semiannually">Semi Annually</option>
                                                            <option value="Quarterly">Quarterly</option>
                                                            <option value="Monthly">Monthly</option>
                                                        </select>
                                                </div>
                                                <div class="col-sm-4">
                                                        <strong>Amount for Every Occurrence </strong>
                                                        <input type="text"  class="form-control transaction_amount"  name="occurance_amount" id="box2">
                                                </div>
                                                    <div class="col-sm-4">
                                                        <strong>Total Amount</strong>
                                                        <input type="text" class="form-control" name="total_amount" >
                                                </div>
                                            </div>

                                                <div class="form-group row">
                                                <div class="col-sm-4">
                                                        <strong>Maturity Date</strong>
                                                        <input type="date"class="form-control" name="maturity_date">
                                                </div>
                                                <div class="col-sm-4">
                                                        <strong> Standing order file </strong>
                                                        <input type="file" class="form-control" name="standing_order_file">
                                                </div>
                                                    <div class="col-sm-4">
                                                        <strong> Refer bank</strong>
                                                        <select name="refer_bank_id"  class="form-control">
                                                        <?php
                                                        $banks = DB::table('constant.refer_banks')->get();
                                                        if (!empty($banks)) {
                                                            foreach ($banks as $bank) {
                                                                ?>
                                                        <option
                                                            value="<?= $bank->id ?>">
                                                                <?= $bank->name ?>
                                                        </option>
                                                        <?php
                                                        }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            </div>

                                        <br/>
                                        <div class="col-sm-12 m-t-20">
                                        <strong class="col-form-label">Areas much interested</strong>
                                        <div class="form-group row">
                                            <div class="col-sm-12"> 
                                                <textarea rows="2" cols="5" name="description" class="form-control" placeholder="Clarify if this client has any special needs or areas much interested to start ?"></textarea>
                                            </div>
                                        </div>
                                        </div>


                                    <div class="col-sm-12">
                                        <div class="form-group">
                                        <h4 class="col-form-label"> Module Selected by school</h4>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-sm-2">#</th>
                                                            <th class="col-sm-5">Tasks</th>
                                                            <th class="col-sm-5">Person Responsible <br/>at School (Name & Phone)</th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                        <?php
                                                        $sections = \App\Models\TrainItem::where('status', 1)->orderBy('id', 'asc')->get();
                                                        foreach ($sections as $section) {
                                                            ?>
                                                            <tr>
                                                                <td class="text-center"><input type="checkbox" value="<?=$section->id?>" name="module[]" multiple="" /></td>
                                                                <td><?= $section->content ?></td>
                                                                <td><input type="text" class="form-control" value="" name="train_item<?= $section->id ?>" ></td>
                                                            </tr>
                                                        <?php } ?>

                                                    </tbody>
                                                </table>
                                            </div>

{{--                                                                 
                                            <div class="card-block table-border-style">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th style="width:20%">Task</th>
                                                                <th>ShuleSoft Person Allocated</th>
                                                                <th>School Person/Role Allocated</th>
                                                                <th>Start Date : Time</th>
                                                                <th>End Date : Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $x = 1;

                                                            $trainings = \App\Models\trainItem::orderBy('id', 'asc')->get();
                                                            $trainings = [];
                                                            foreach ($trainings as $training) {
                                                                ?>
                                                                <tr>
                                                                    <th scope="row"><?= $x ?></th>
                                                                    <td><?= $training->content ?></td>
                                                                    <td> 
                                                                        <?php ?>   
                                                                        <select class="task_allocated_id"  name="person<?= $training->id ?>" id="<?= $training->id ?>" >
                                                                            <?php
                                                                            foreach ($staffs as $staff) {
                                                                                ?>
                                                                                <option value="<?= $staff->id ?>">
                                                                                    <?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                    <td> 
                                                                        <input type="text" class="form-control" value="" name="train_item<?= $training->id ?>" required="">
                                                                    </td>
                                                                    <td>
                                                                        <select class="task_group" name="slot_date<?= $training->id ?>" id="slot_for<?= $training->id ?>" data-task-id="<?= $training->id ?>"><?= $customer->getDate($staff->id) ?></select>
                                                                        <select type="text" data-attr="start_date" class="slot" id="start_slot<?= $training->id ?>"  name="slot_id<?= $training->id ?>"></select>
                                                                    </td>
                                                                    <td>
                                                                        <b data-attr="end_date" id="task_end_date_id<?= $training->id ?>"> </b>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $x++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div> --}}
                                        </div>
                                        </div>
                                    </div>
                                        <?= csrf_field() ?>
                                       <button type="submit" class="btn btn-primary  btn-sm btn-round">Submit data</button>
                                    
                                    </form>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


<script type="text/javascript">
     $('#_payment_option').change(function () {
        var val = $(this).val();
        if (val === 'standing order') {
            $('#standing_order_form').show();
        } else {
            $('#standing_order_form').hide();
        }
       
    });
</script>
@endsection