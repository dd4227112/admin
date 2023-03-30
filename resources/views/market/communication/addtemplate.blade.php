@extends('layouts.app')
@section('content')

  

        <div class="page-header">
            <div class="page-header-title">
                <h4>Add SMS/Email Template</h4>
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
                  <div class="col-sm-8">
                  
                      <form method="post" action="">
                           {{ csrf_field() }}
                                    
                                    <div class="col-md-6">
                                        <strong>Type:</strong>
                                        <select name='type' class="form-control select2" required>
                                               <option value="">Type </option>
                                               <option value="SMS">SMS</option>
                                               <option value="EMAIL">EMAIL </option>
                                        </select>
                                      </div>
                                        <br>
                                  

                                        <div class="col-md-12">
                                            <strong>Name:</strong>
                                            <input type="text" value="{{ old('title') }}" class="@error('name') is-invalid @enderror form-control" placeholder="Template name" name="name">
                                            @error('name')
                                                <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <br>

                                        <div class="col-md-12">
                                            <strong>Tags:</strong>
                                            #name,,#email,#phone
                                        </div>
                                        <br>

                                        <div class="col-md-12">
                                            <strong>Template:</strong>
                                            <textarea class="form-control" name="message" rows="4" cols="50" required> </textarea>
                                        </div>
                                        <br>
                                          
                                        <div class="col-sm-4">
                                             <button type="submit" class="btn btn-primary btn-round">
                                                        &emsp;Submit&emsp;
                                             </button>
                                        </div>
                                          
                            </form>
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
