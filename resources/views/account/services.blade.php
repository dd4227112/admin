@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
          <div class="page-header">
            <div class="page-header-title">
                <h4><?='Company services' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">company services</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">setting</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-body">
            <div class="row">

                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">

                             <h5 class="page-header">
                            <a href="#" type="button" class="btn btn-primary btn-mini btn-round" data-toggle="modal" data-target="#large-Modal">
                                Add New Services
                            </a>
                            </h5>

                            <div class="table-responsive">
                                <table class="table dataTable table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Service Name</th>
                                            <th>Desciption</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($services as $index => $service)
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>{{$service->name}}</td> 
                                            {{-- <td>
                                               <span style="text-decoration: none;" contenteditable="true" 
                                                 onblur="save('<?= $service->id . 'name' ?>', '<?= $service->id  ?>','name' )" 
                                                 id="<?= $service->id . 'name' ?>"> <?= $service->name == '' ? 'null' : $service->name ?>
                                                </span>
                                                <span id="stat<?= $service->id .  'name' ?>"></span>
                                             </td> --}}

                                            
                                           <td>
                                               <span style="text-decoration: none;" contenteditable="true" 
                                                 onblur="save('<?= $service->id . 'description' ?>', '<?= $service->id  ?>','description')" 
                                                 id="<?= $service->id . 'description' ?>"> <?= $service->description == '' ? 'null' : $service->description ?></span>
                                                  <span id="stat<?= $service->id .  'description' ?>"></span>
                                           </td>
                                           
                                        </tr>
                                        @endforeach
                                    </tbody>
                                  
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>


<div class="modal fade" id="large-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create company service</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="form-horizontal" role="form" method="post">  <div class="modal-body">
                <div class="col-sm-12">

                    <div class='form-group row' >
                        <label for="subcategory" class="col-sm-2 control-label">
                            <?= __("Service name") ?>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required="true"  name="name" value="<?= old('name') ?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors, 'name'); ?>
                        </span>
                    </div>

                    
                <div class='form-group row' >
                    <label for="note" class="col-sm-2 control-label">
                        <?= __("Description") ?> 
                    </label>
                    <div class="col-sm-8">
                        <textarea style="resize:none;" placeholder="Any description about this " class="form-control" id="description" name="description" required><?= old('description') ?></textarea>
                    </div>
                </div>
                   
                      
                   <?= csrf_field() ?>    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-mini btn-round" data-dismiss="modal">Close</button>
                <input type="hidden" value="<?= \Auth::user()->id ?>" name="created_by" />
                <button type="submit" class="btn btn-primary btn-mini btn-round">Save</button>
            </div>
             </form>
        </div>
    </div>
</div>

<script>
  function save(a, id, column) {
        var val = $('#' + a).text();
        if (val !== '') {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: "<?= base_url('account/editSetting/null') ?>",
                data: {"id": id, newvalue: val, column: column,table:'company_services'},
                dataType: "html",
                beforeSend: function (xhr) {
                    $('#stat' + id).html('<a href="#/refresh"<i class="feather icon-refresh-ccw f-13"></i> </a>');
                },
                complete: function (xhr, status)  {
                    $('#stat' + id).html('<label class="badge badge-info ">' + status + '</label>');
                },
                success: function (data) {
                     toastr.success(data);
                }
            });
        }
    }
</script>
@endsection