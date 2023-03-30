@extends('layouts.app')
@section('content')

  

        <div class="page-header">
            <div class="page-header-title">
                <h4>Email / SMS Template</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Communication</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">templates</a>
                    </li>
                </ul>
            </div>
        </div> 
   
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
           <div class="card">
            <div class="card-block">
               
              <div class="row">
                 <div class="col-sm-2">
                     <div class="card">
                         <a href="<?= url('marketing/addtemplate') ?>" class="btn btn-primary btn-mini btn-round" style="font-weight: bold"> Add a template </a>
                     </div>  
                  </div>  
                </div>  
    
                  <div class="table-responsive">
                    <table id="dt-ajax-array" class="table dataTable table-mini table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th># </th>
                          <th>Name</th>
                          <th>Type</th>
                          <th>Template </th>
                          <th>Action </th>
                        </tr>
                      </thead>
                      <tbody>
                     <?php $i=1; foreach($mailandsmstemplates as $template) { ?>
                      <tr>
                          <td><?= $i ?></td>
                          <td><?= $template->name ?></td>
                          <td><?= $template->type ?> </td>
                          <td><?= warp($template->message,65) ?></td>
                          <td class="text-center"> 
                              <a href="<?= url('marketing/templates/view/'.$template->id) ?>" class="btn btn-mini btn-primary btn-round">view</a>
                              <a href="<?= url('marketing/templates/edit/'.$template->id) ?>" class="btn btn-mini btn-primary btn-round">edit</a>
                              <a href="<?= url('marketing/templates/delete/'.$template->id) ?>" class="btn btn-mini btn-danger btn-round">delete</a>
                          </td>
                      </tr>
                    <?php $i++; } ?>
                      </tbody>

                    </table>
                  </div>
                 </div>
                
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

 <script type="text/javascript">

 
 </script>

@endsection
