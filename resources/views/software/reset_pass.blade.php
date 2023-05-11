@extends('layouts.app')
@section('content')

    <div class="page-header">
        <div class="page-header-title">
            <h4>Reset school</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">passwords</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">school</a>
                </li>
            </ul>
        </div>
    </div>
        <div class="page-body">
            <div class="row">
                <div class="col-md-12 col-xl-12">

                      <div class="card">
                        <div class="card-block">
                            
                            <form role="form" method="post"> 

                              <div class="row d-flex justify-content-left">
                                
                                <div class="col-sm-10 col-xl-4 m-b-30">
                                    <h4 class="sub-title">Select School</h4>
                                    <select name="schema" class="select2"  id="schema">
                                       <option value="0">Select</option>
                                         <?php  
                                         $schemas1 = DB::table('admin.all_setting')->get();
                                         $schemas2 = DB::table('shulesoft.setting')->get();
                                          $schemas =array_merge($schemas1->toArray(), $schemas2->toArray());
                                        //  dd($schemas);

                                            foreach ($schemas as $schema) {
                                            ?>
                                            <option value="<?= $schema->schema_name ?>" selected><?= $schema->sname ?></option>
                                        <?php  }
                                        ?>
                                     </select>
                                   </div>

                                    <div class="col-sm-10 col-xl-4 m-b-30">
                                         <h4 class="sub-title">&nbsp;</h4>

                                          <button class="btn btn-primary" data-placement="top"  data-toggle="tooltip" data-original-title="" type="Submit">Submit  </button>
                                    </div>
                               
                                  <?= csrf_field() ?>
                                 </form>
                                </div>
                            </div>
                        </div>


                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab"
                                    aria-expanded="true">
                                </a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                            <div id="home3" role="tabpanel" aria-expanded="true">

                                <div class="card-block">
                                    <div class="dt-responsive">
                                        <table class="table tab nowrap">
                                            <thead>
                                                <tr>
                                                    <th>School</th>
                                                    <th>Username</th>
                                                    <th>Password</th>
                                            </thead>
                                            <?php if(isset($username) && isset($pass) && isset($schema_name)) { ?>
                                            <tbody>
                                                  <td><?= $schema_name ?></td>
                                                  <td><?= $username ?></td>
                                                  <td><?= $pass ?></td>
                                            </tbody>
                                             <?php } ?>

                                        </table>
                                    </div>
                                </div>
                      
                        </div>
                    </div>
                </div>
            </div>


            <script type="text/javascript">
               
                $(".select2").select2({
                    theme: "bootstrap",
                    dropdownAutoWidth: false,
                    allowClear: false,
                    debug: true
                }); 
            </script>
            @endsection