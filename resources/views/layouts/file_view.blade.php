@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
     <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

          <div class="page-body">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Default card start -->
                        <div class="card">                            
                            <div class="card-block">
                                  <div>
                                      <embed src="<?= $path ?>"  width="100%" height="700px" />
                                  </div>
                                        <!-- <iframe src="https://docs.google.com/gview?url=<?= $path ?>&embedded=true" style="width:100%; height:450px;" frameborder="0" class="col-lg-12 col-md-8" title="File View"></iframe> -->
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
          </div>
    </div>
</div>


@endsection


