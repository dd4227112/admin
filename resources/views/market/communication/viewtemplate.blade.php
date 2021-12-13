@extends('layouts.app')
@section('content')

  

        <div class="page-header">
            <div class="page-header-title">
                <h4>View SMS/Email Template</h4>
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
                  <div class="col-sm-12">
                      <p><?= $temp->message ?></p>
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
