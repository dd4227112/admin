@extends('layouts.app')
@section('content')
<div class="white-box">
    <h5 class="box-title">Payment Requests</h5>

    <div class="table-responsive"> 
        <div class="col-sm-12 col-xs-12">
            <form action="" method="post">
                <div class="form-group col-lg-3">
                    <label for="from">School </label>
                    <select id="" class="form-control" name="school">
                        <option value="">Select School</option>
                        <?php foreach ($schools as $school) {
                            ?>
                            <option value="<?= $school->table_schema ?>"><?= $school->table_schema ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="from">From </label>
                    <input type="date" name="from" class="form-control" id="exampleInputEmail1" placeholder="From"> </div>
                <div class="form-group col-lg-3">
                    <label for="to">To</label>
                    <input type="date" name="to" class="form-control" id="exampleInputEmail1" placeholder="To"> </div>
                <div class="form-group col-lg-3"><br/>
                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Reconcile</button>
                    {{ csrf_field() }}
                </div>
            </form>
        </div>
        <br/>
     
    </div>

</div>
@include('layouts.datatable')
@endsection
