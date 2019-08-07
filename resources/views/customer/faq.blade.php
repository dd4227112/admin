@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <p align='right'><button class="btn btn-success"  data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add New FAQ</button></p>
        <h4 class="box-title m-b-20">Basic FAQs</h4>
        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <?php
            foreach ($faqs as $faq) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading<?=$faq->id?>">
                        <h4 class="panel-title"> 
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$faq->id?>" aria-expanded="true" aria-controls="collapse<?=$faq->id?>" class="font-bold"><?= $faq->question ?> </a> </h4> </div>
                    <div id="collapse<?=$faq->id?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?=$faq->id?>">
                        <div class="panel-body"> <?= $faq->answer ?></div>
                        <div class="row col-lg-offset-1">
                            <!--<a href="#"><i class="fa fa-edit"></i>Edit </a>-->
                            <a href="<?=url('support/faq?action=delete&id='.$faq->id)?>"><i class="fa fa-trash-o"></i> Delete </a>
                        </div>
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

<script type="text/javascript">
    add_faq = function () {
        $('#add_faq').click(function () {
            var question = $('#recipient-name1').val();
            var answer = $('#message-text1').val();
            if (answer != '' && question != '') {
                $.ajax({
                    url: '{{ url("home") }}',
                    data: {question: question, answer: answer},
                    type: 'get',
                    dataType: 'HTML',
                    success: function (data) {
                        $('#message_result').html(data);
                        window.location.reload();
                    }
                });
            }
        });
    }
    $(document).ready(add_faq);
</script>
@endsection