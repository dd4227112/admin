@extends('layouts.app')
@section('content')

<div class="white-box">
               <code><?=$script?> </code>                  
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

@endsection
