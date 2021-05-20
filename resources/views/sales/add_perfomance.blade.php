@extends('layouts.app')
@section('content')
<?php use Carbon\Carbon;
$root = url('/') . '/public/' ?>
<div class="page-wrapper">
  <div class="page-header">
    <div class="page-header-title">
      <h4>Task Performance </h4>
    </div>
    <div class="page-header-breadcrumb">
  </div>
</div>
  
<?php  
  function check($module,$school_id){
    return \App\Models\PerfomanceMeasures::whereMonth('date', Carbon::now()->month)->where('school_id',$school_id)->where('module', $module)->first(); 
  }
?>

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <!-- Subscribe From card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Task Performance   <?= date('M') ?>  for  <?= $school->name?></h5>
                </div>

                <div class="card-block">
                    <div class="j-wrapper j-wrapper-640">
                            
                              
                                <div class="row col-sm-12">
                                    <div class="j-span6 j-unit j-input">
                                        <div class="checkbox-fade fade-in-primary">
                                     <?php    $check = check('Exam Published',$school->id);
                                            !empty($check) ? $checked = 'checked' : $checked = '';?>
                                        <label>
                                            <input type="checkbox" {{ $checked }} value="Exam Published"
                                                   onclick="submit_perfomance(this)">
                                                   <span class="cr">
                                                  <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                             <span>Exam Published</span>
                                         </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                           <?php  $check = check('Fee Collection',$school->id);
                                            !empty($check) ? $checked = 'checked' : $checked = '';?>
                                            <label>
                                            <input type="checkbox" {{ $checked }}  value="Fee Collection" onclick="submit_perfomance(this)">
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                            <span>Fee Collection</span>
                                           </label>
                                       </div>
                                    </div>

                                    <div class="j-span6 j-unit j-input">
                                        <div class="checkbox-fade fade-in-primary">
                                            <?php  $check = check('Payroll',$school->id);
                                               !empty($check) ? $checked = 'checked' : $checked = '';
                                             ?>
                                            <label>
                                                <input type="checkbox" {{ $checked }} value="Payroll" onclick="submit_perfomance(this)">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>Payroll</span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <?php  $check = check('Inventory',$school->id);
                                              !empty($check) ? $checked = 'checked' : $checked = '';
                                             ?>
                                            <label>
                                                <input type="checkbox" {{ $checked }} value="Inventory" onclick="submit_perfomance(this)">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>Inventory</span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="j-span6 j-unit j-input">
                                        <div class="checkbox-fade fade-in-primary">
                                            <?php  $check = check('Attendance',$school->id);
                                              !empty($check) ? $checked = 'checked' : $checked = '';
                                             ?>
                                            <label>
                                                <input type="checkbox" {{ $checked }} value="Attendance" onclick="submit_perfomance(this)">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>Attendance</span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <?php  $check = check('Library',$school->id);
                                               !empty($check) ? $checked = 'checked' : $checked = '';
                                            ?>
                                            <label>
                                                <input type="checkbox" {{ $checked }}  value="Library" onclick="submit_perfomance(this)">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>Library</span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="j-span6 j-unit j-input">
                                        <div class="checkbox-fade fade-in-primary">
                                            <?php  $check = check('Staff Login',$school->id);
                                              !empty($check) ? $checked = 'checked' : $checked = '';
                                            ?>
                                            <label>
                                                <input type="checkbox"  {{ $checked }} value="Staff Login" onclick="submit_perfomance(this)">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>Staff login</span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <?php  $check = check('Electronic payment',$school->id);
                                              !empty($check) ? $checked = 'checked' : $checked = '';
                                            ?>
                                            <label>
                                                <input type="checkbox" {{ $checked }} value="Electronic payment" onclick="submit_perfomance(this)">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>Electronic payment</span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="j-span6 j-unit j-input">
                                        <div class="checkbox-fade fade-in-primary">
                                            <?php  $check = check('Parent Login',$school->id);
                                               !empty($check) ? $checked = 'checked' : $checked = '';
                                            ?>
                                            <label>
                                                <input type="checkbox" {{ $checked }}  value="Parent Login" onclick="submit_perfomance(this)">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>Parent login</span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <?php  $check = check('Character',$school->id);
                                              !empty($check) ? $checked = 'checked' : $checked = '';
                                             ?>
                                            <label>
                                                <input type="checkbox" {{ $checked }} value="Character" onclick="submit_perfomance(this)">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>Character</span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="j-span6 j-unit j-input">
                                         <div class="checkbox-fade fade-in-primary">
                                             <?php  $check = check('Expenses',$school->id);
                                               !empty($check) ? $checked = 'checked' : $checked = '';?>
                                             <label>
                                               <input type="checkbox" {{ $checked }} value="Expenses" onclick="submit_perfomance(this)">
                                              <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                               </span>
                                             <span>Expenses</span>
                                             </label>
                                          </div>

                                          
                                        <div class="checkbox-fade fade-in-primary">
                                            <?php  $check = check('Transport',$school->id);
                                             !empty($check) ? $checked = 'checked' : $checked = '';
                                            ?>
                                           <label>
                                               <input type="checkbox"  {{ $checked }} value="Transport" onclick="submit_perfomance(this)">
                                               <span class="cr">
                                                   <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                               </span>
                                               <span>Transport</span>
                                           </label>
                                       </div>
                                    </div>

                                    <div class="j-span6 j-unit j-input">
                                        <div class="checkbox-fade fade-in-primary">
                                            <?php  $check = check('SMS',$school->id);
                                              !empty($check) ? $checked = 'checked' : $checked = '';?>
                                            <label>
                                             <input type="checkbox" {{ $checked }} value="SMS" onclick="submit_perfomance(this)">
                                              <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                               </span>
                                             <span>SMS</span>
                                            </label>
                                          </div>
                                    </div>


                            </div>
                    </div>
                </div>
            </div>



            <div class="card">
                <div class="card-header">
                    <h5>Task Performance</h5>
                 </div>

                 <div class="card-block">
                    <div class="j-wrapper j-wrapper-640">
                            
                        <td align="center"><span id="sum"></span></td>
                    </div>
                 </div>
                </div>
            </div>
        
        </div>
    </div>
</div>

<script>

function submit_perfomance(perfomance) {
    var perf = perfomance.value;
    var school_id = '<?=$school->id?>';

    if(!perfomance.checked){
        var url_obj = "<?= url('Sales/removeperfomance') ?>";
        remove(perf);
    } else {
        var url_obj = "<?= url('Sales/storeperfomance') ?>";
        summation(perf);
    }
    $.ajax({
        url: url_obj,
        type: 'POST',
        data: {"_token": "{{ csrf_token() }}",perf: perf,  school_id: school_id},
        dataType: "html",
        success: function(data) {
           // alert(data);
        }
    });
}

function summation(perf){
    var sum = 0;
    switch(perf) {
              case 'Exam Published':
                var value = 12;
                console.log(value);
                break;
              case 'Payroll':
                var value = 15;
                console.log(value);
                break;
              case 'Transport':
                var value = 10;
                break;
             default:
                // code block
            }
            sum += value;
           $("#sum").html(sum);
  }

function remove(perf){
    switch(perf) {
              case 'Exam Published':
                var value = 25;
                console.log(value);
                break;
              case 'Payroll':
                var value = 18;
                break;
              case 'Transport':
                var value = 12;
                break;
              default:
                // code block
            }
            sum -= value;
           $("#sum").html(sum);
  }
</script>

</div>


@endsection







