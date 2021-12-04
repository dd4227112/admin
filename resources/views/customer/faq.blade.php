@extends('layouts.app')
@section('content')

    
     
        <div class="page-header">
            <div class="page-header-title">
                <h4><?='FAQ' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">faq</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 
        
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">

                        <div class="card-block">
                          <?php if(can_access('add_faq')) { ?>
                            <div class="card-header">
                                <p align='left'><button class="btn btn-success btn-mini btn-round"  data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add New FAQ</button></p>
                            </div>
                          <?php } ?>

                        </div>
                        <div class="row card-block">
                            <div class="col-md-12">

                                <h4 class="box-title m-b-20">Basic FAQs</h4>
                                <div class="panel-group card-block " role="tablist" aria-multiselectable="true">
                                    <?php
                                    foreach ($faqs as $faq) {
                                        ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="heading<?= $faq->id ?>">
                                                <h4 class="panel-title"> 
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $faq->id ?>" aria-expanded="true" aria-controls="collapse<?= $faq->id ?>" class="font-bold"><?= $faq->question ?> </a> </h4> </div>
                                            <div id="collapse<?= $faq->id ?>" class="panel-collapse collapse in" style="padding-left:5%" role="tabpanel" aria-labelledby="heading<?= $faq->id ?>">
                                                <div class="panel-body"> <?= $faq->answer ?></div>
                                                <?php if(can_access('delete_faq')) { ?>
                                                <div class="row col-lg-offset-1">
                                                    <p>&nbsp;&nbsp; <a class="btn btn-danger btn-sm" href="<?= url('customer/faq/null/?action=delete&id=' . $faq->id) ?>"><i class="fa fa-trash-o"></i> Delete </a></p>
                                                </div>
                                                <?php } ?>
                                                <br/>
                                            </div>

                                        </div>

                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="exampleModalLabel1">Add New FAQ</h4> </div>
                                    <div class="modal-body" id="message_result">
                                        <form>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">For:</label>
                                                <input type="radio" class="form-input" name="table" value="parent">Parents
                                                <input type="radio" class="form-input" name="table" value="teacher">Teachers 
                                                <input type="radio" class="form-input" name="table" value="student">Students
                                                <input type="radio" class="form-input" name="table" value="user">Staff Members </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Question:</label>
                                                <input type="text" class="form-control" id="recipient-name1"> </div>
                                            <div class="form-group">
                                                <label for="message-text" class="control-label">Answer:</label>
                                                <textarea class="form-control" id="message-text1"></textarea>
                                            </div>
                                        </form>
                                        <div ></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="add_faq">Submit</button>
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

<script type="text/javascript">
    add_faq = function () {
        $('#add_faq').click(function () {
            var question = $('#recipient-name1').val();
            var answer = $('#message-text1').val();
            if (answer != '' && question != '') {
                $.ajax({
                    url: '{{ url("customer/faq/null") }}',
                    data: {question: question, answer: answer},
                    type: 'post',
                    dataType: 'HTML',
                    success: function (data) {
                       // $('#message_result').html(data);
                        window.location.reload();
                    }
                });
            }
        });
    }
    $(document).ready(add_faq);
</script>
@endsection