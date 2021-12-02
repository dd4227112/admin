@extends('layouts.app')
@section('content')

    
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Add Prospect</h4>
                <span>Specify information correctly</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Sales</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">add prospect</a>
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
                        <div class="card-block">
                            <div class="row">
                                <div class="card-block">
                                    <form id="main" method="post" action="#" novalidate="">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="title">
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mr">Mrs</option>
                                                    <option value="Sr">Sr</option>
                                                    <option value="Fr">Fr</option>
                                                    <option value="Prof">Prof</option>
                                                </select>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Prospect Name">
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number">
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-sm-2 col-form-label">Software Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="software_status" id="software_status">
                                                    <option value="0">They do not have a system </option>
                                                    <option value="1">Have School Management System</option>
                                                    <option value="2">Have Accounting Software</option>
                                                    <option value="3">Have Software for Academic</option>
                                                </select>
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row " id="software_name" style="display: none;">
                                            <label class="col-sm-2 col-form-label">Software Name </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="action_date" name="software_name" placeholder="Which software name they use eg Excel, Tally, etc">
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-sm-2 col-form-label">Action to be Taken</label>
                                            <div class="col-sm-10">
                                                <select class="form-control"  name="action">
                                                    <option value="Call">Call </option>
                                                    <option value="Email">Email</option>
                                                    <option value="Visition">Visitation</option>
                                                    <option value="Referral">Find a referral</option>
                                                </select>
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-sm-2 col-form-label">Action Date</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="action_date" name="action_date" placeholder="Enter action date">
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-sm-2 col-form-label">Any Comment</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="" name="message" placeholder="write any comment"></textarea>
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>              </div>
                    </div>              </div>
            </div>              </div>
    </div>              </div>
<script type="text/javascript">
    software_status = function () {
        $('#software_status').change(function () {
            var type = $(this).val();
            if (type == '0') {
                $('#software_name').hide();
            } else {
                $('#software_name').show();
            }
        });
    }
    $(document).ready(software_status);
</script>
@endsection
