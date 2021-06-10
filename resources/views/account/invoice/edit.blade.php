@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Invoices</h4>
                <span>Show payments summary</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Invoices</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">

                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>Edit Invoice</strong> 
                                </a>
                                <div class="slide"></div>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="card-block">

                                    <header class="panel-heading">
                                        Edit Invoice Details

                                    </header>
                                    <div class="panel-body">
                                        <div id="error_area"></div>
                                        <div class=" form">
                                            <form class="cmxform form-horizontal " id="commentForm" method="post" action="<?= url('account/editShuleSoftInvoice/'.$invoice->id) ?>">
                                                <div class="form-group ">
                                                    <label for="type" class="control-label col-lg-3">Client Name</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control"  value="<?= $invoice->client->name ?>" disabled=""/>

                                                    </div>
                                                    <?php echo form_error($errors, 'client'); ?>
                                                    <div class="col-lg-6"> <span id="project_id_error"></span></div>
                                                </div>
                                                 <div class="form-group ">
                                                    <label for="type" class="control-label col-lg-3">Amount</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control"  value="<?= $invoice->invoiceFees()->sum('amount') ?>" disabled=""/>

                                                    </div>
                                                    <?php echo form_error($errors, 'amount'); ?>
                                                    <div class="col-lg-6"> <span id="project_id_error"></span></div>
                                                </div>

                                                     <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Students</label>
                                                    <div class="col-lg-6">
                                                        <input type="number" value="<?= $invoice->client->estimated_students ?>" name="estimated_students" id="date" class="form-control"/>

                                                    </div>
                                                    <?php echo form_error($errors, 'date'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Price</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" value="<?= $invoice->client->price_per_student ?>" name="price_per_student" id="date" class="form-control"/>

                                                    </div>
                                                    <?php echo form_error($errors, 'date'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div>

                                               

                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Due Date</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" value="<?= date('Y-m-d',strtotime($invoice->due_date)) ?>" name="due_date" id="date" class="form-control"/>

                                                    </div>
                                                    <?php echo form_error($errors, 'date'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div>

                                                  <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Start Date</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" value="<?= date('Y-m-d',strtotime($invoice->client->created_at)) ?>" name="onboard_date" id="onboard_date" class="form-control"/>

                                                    </div>
                                                    <?php echo form_error($errors, 'date'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                       <?= csrf_field() ?>
                                                        <button class="btn btn-primary" type="submit" >Update Invoice</button>
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
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalEmployer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal " id="commentForm" method="post" action="<?= url('user') ?>">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add New Entity</h4>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <div class=" form">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Name (required)</label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="cname" name="name" minlength="2" type="text" required="">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Abbreviation</label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="cname" name="abbreviation"  type="text" required="">
                                </div>
                            </div>
                            <div class="form-group " style="display: none;">
                                <label for="cemail" class="control-label col-lg-3">E-Mail (required)</label>
                                <div class="col-lg-6">
                                    <input class="form-control " id="cemail" type="email" name="email" required="" value="<?= time() . 'jkdjs@engineers.co.tz' ?>">
                                </div>
                            </div>
                            <!--                                            <div class="form-group ">
                                                                            <label for="curl" class="control-label col-lg-3">Phone (required)</label>
                                                                            <div class="col-lg-6">
                                                                                <input class="form-control " id="curl" type="text" name="phone">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <label for="ccomment" class="control-label col-lg-3">Location(required)</label>
                                                                            <div class="col-lg-6">
                                                                                <textarea class="form-control " id="ccomment" name="location" required=""></textarea>
                                                                            </div>
                                                                        </div>-->

                        </div>

                    </div>


                </div>
                <div class="modal-footer">
<?= csrf_field() ?>
                    <input type="hidden" name="user" value="employer"/>
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button class="btn btn-success" type="submit">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function addRow(a) {
        var table_id = $('#table');
        const newTr = `
 <tr class="hide">
   <td class="pt-3-half" contenteditable="true">Example</td>
   <td class="pt-3-half" contenteditable="true">Example</td>
   <td class="pt-3-half" contenteditable="true">Example</td>
   <td class="pt-3-half" contenteditable="true">Example</td>
   <td>
     <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Remove</button></span>
   </td>
 </tr>`;
        const $clone = table_id.find('tbody tr').last().clone(true).removeClass('hide table-line');

        if (table_id.find('tbody tr').length === 0) {

            $('tbody').append(newTr);
        }

        table_id.find('table').append($clone);

    }
    table_add = function () {
        var table_id = $('#table');

        var $BTN = $('#export-btn');
        var $EXPORT = $('#export');




        table_id.on('click', '.table-remove', function () {

            $(this).parents('tr').detach();
        });

        table_id.on('click', '.table-up', function () {

            const $row = $(this).parents('tr');

            if ($row.index() === 1) {
                return;
            }

            $row.prev().before($row.get(0));
        });

        table_id.on('click', '.table-down', function () {

            const $row = $(this).parents('tr');
            $row.next().after($row.get(0));
        });

        // A few jQuery helpers for exporting only
        jQuery.fn.pop = [].pop;
        jQuery.fn.shift = [].shift;

        $BTN.on('click', () => {

            const $rows = table_id.find('tr:not(:hidden)');
            const headers = [];
            const data = [];

            // Get the headers (add special header logic here)
            $($rows.shift()).find('th:not(:empty)').each(function () {

                headers.push($(this).text().toLowerCase());
            });

            // Turn all existing rows into a loopable array
            $rows.each(function () {
                const $td = $(this).find('td');
                const h = {};

                // Use the headers from earlier to name our hash keys
                headers.forEach((header, i) => {

                    h[header] = $td.eq(i).text();
                });

                data.push(h);
            });

            // Output the result
            $EXPORT.text(JSON.stringify(data));
        });
    }
    $(document).ready(table_add);
    single_no_excel_submit = function () {

        $('#noexcel').mousedown(function () {
            var client_id = $('#client_id').val();
            var project_id = $('#project_id').val();
            var date = $('#date').val();
            var force_new = $('#force_new').is(':checked');

            var ary = [];

            if (parseInt(project_id) < 1 || project_id == null) {
                $('#project_id_error').html('<div class="alert alert-danger">Please Select Project Name First</div>');
                return false;
            }
            if (parseInt(client_id) < 1 || client_id == null) {
                $('#client_id_error').html('<div class="alert alert-danger">Please Select Client Name First</div>');
                return false;
            }
            if (date == null || date == '') {
                $('#date_error').html('<div class="alert alert-danger">Please Select Date First</div>');
                return false;
            }

            $('#user_area tr').each(function (a, b) {
                var name = $('.name', b).text();
                var quantity = $('.quantity', b).text();
                var unit_price = $('.unit_price', b).text();
                var project = $('.project', b).text();
                if (quantity == '' || name == '' || unit_price == '' || project == '') {
                    $('#table_error_area').html('<br/><div class="alert alert-danger">Please fill all table inputs well </div>');
                    return false;
                }

                ary.push({name: name, quantity: quantity, unit_price: unit_price, project: project});

            });
            //alert(JSON.stringify(ary));
            $.ajax({
                type: 'get',
                url: "<?= url('account/createInvoice') ?>/null",
                data: {date: date, client_id: client_id, noexcel: 1, users: ary, project_id: project_id, force_new: force_new},
                dataType: "html",
                success: function (data) {
                    if (data == '1') {
                        window.location.href = "<?= url('account/invoice') ?>";
                    } else {
                        $('#table_error_area').html(data);
                    }
                }
            });
        });
    }
    checkClient = function () {
        $('#project_id').change(function () {
            var project_id = $(this).val();
            $.ajax({
                type: 'get',
                url: "<?= url('account/getClient') ?>/null",
                data: {project_id: project_id},
                dataType: "html",
                success: function (data) {
                    console.log(data);
                    $('#client_id').html(data);
//                    if (data === 'success') {
//$('#home7').html('<div clas="alert alert-success">Recorded successfully. To add new record, please refresh </div>');
//
//                    }

                }
            });
        });

    }
    $(document).ready(checkClient);
    ///$(document).ready(single_no_excel_submit);
</script>
@endsection


