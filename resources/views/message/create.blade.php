@extends('layouts.app')
@section('content')
<?php $root =url('/').'/public/' ?>
<div class="white-box">
               <code id="mycode"><?=$script?> </code>                  
<form action="<?=url('message/create')?>" method='post' class="form-horizontal form-bordered">
  {{ csrf_field() }}
                                        <div class="form-body">
                 
                                            <div class="form-group">
                                                <label class="control-label">Write Message to notify users</label>
                                                <div class="col-md-12">
                                                    <textarea class="form-control" rows="5" name="message"><?=request('message')?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="form-body">
                 
                                            <div class="form-group last">
                                                <label class="control-label">Skip Schema</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="<?=request('skip')?>" class="form-control" name="skip" placeholder="separate by comma schema name to skip">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                                
                                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Submit</button>
                                                            <button type="button" class="btn btn-default">Cancel</button>
                                                      
                                          
                                        </div>
                                    </form>

</div>
 <script src="<?=$root?>js/clipboard.min.js"></script>
  <script>
    var clipboard = new Clipboard('.mycode');

    clipboard.on('success', function(e) {
        alert('copied');
    });

    clipboard.on('error', function(e) {
      alert('error,try again');
    });
    </script>
@endsection
