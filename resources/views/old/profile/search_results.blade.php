@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">Search Here</h3>
            <form class="form-group" action="" role="search">
                <div class="input-group">
                    <input type="text" id="example-input1-group2" name="q" class="form-control" placeholder="Search"> <span class="input-group-btn"><button type="button" class="btn waves-effect waves-light btn-info"><i class="fa fa-search"></i></button></span> </div>
            </form>
   
            <h2 class="m-t-40">Search Result For "<?= request('q')?>"</h2> <small>About <?=$result->total?> result ( <?= (microtime(true) - LARAVEL_START)           ?>  seconds)</small>
            <hr>
            <ul class="search-listing">
                <?=$result->result?>
          
            </ul>
           
        </div>
    </div>
</div>
@endsection