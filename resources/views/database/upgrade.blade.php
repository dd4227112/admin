@extends('layouts.app')
@section('content')
<?php $root =url('/').'/public/' ?>
<div class="white-box">
            <div class="panel">
                <button  class="mycode btn btn-default" data-clipboard-action="copy" data-clipboard-target="#mycode"> <i class="fa fa-clipboard"></i> </button>
                <code id="mycode"><?=$script?> </code>
            </div>

<form action="<?=url('database/upgrade')?>" method='post' class="form-horizontal form-bordered">
  {{ csrf_field() }}
                                        <div class="form-body">
                 
                                            <div class="form-group">
                                                <label class="control-label">SQL pane for upgrade script</label>
                                                <div class="col-md-12">
                                                    <textarea class="form-control" rows="5" name="sql"><?=request('sql')?></textarea>
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
        console.log('copied');
    });

    clipboard.on('error', function(e) {
      console.log('error,try again');
    });
    </script>
@endsection
