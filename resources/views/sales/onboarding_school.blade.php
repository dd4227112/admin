
<div class="card">
    <div class="card-header">
        <h5>Customer Onboarding</h5>

    </div>
    <div class="card-block">
        <h4 class="sub-title">Basic Inputs</h4>
        <form action="<?= url('sales/onboard/' . $school->id) ?>" method="POST" enctype="multipart/form-data">

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Sales Person</label>
                <div class="col-sm-10">
                    <select name="sales_user_id" class="form-control">
                        <?php
                        foreach ($staffs as $staff) {
                            ?>
                            <option user_id="<?= $staff->id ?>" school_id="" value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Sales Method</label>
                <div class="col-sm-10">
                    <select name="task_type_id"  class="form-control">
                        <?php
                        $types = DB::table('task_types')->where('department', 2)->get();
                        foreach ($types as $type) {
                            ?>
                            <option value="<?= $type->id ?>"><?= $type->name ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Support Person</label>
                <div class="col-sm-10">
                    <select name="support_user_id" class="form-control">
                        <?php
                        foreach ($staffs as $staff) {
                            ?>
                            <option value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Price Per Student</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" value="10000" name="price" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Estimated Students</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" value="<?= $school->students ?>" name="students" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Data Format Available</label>
                <div class="col-sm-10">
                    <select name="data_type_id" class="form-control">
                        <option value="1">Excel With Parent Phone Numbers</option>
                        <option value="2">Physical Files Format</option>
                        <option value="3">Softcopy but without parents phone numbers</option>

                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Available Tasks Roles</label>
                <div class="col-sm-10">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tasks</th>
                                <th>Person Role Responsible at School</th>
                            </tr>
                        </thead> 
                        <tbody>
                            <?php
                            $sections = \App\Models\TrainItem::orderBy('id', 'asc')->get();
                            foreach ($sections as $section) {
                                ?>

                                <tr>
                                    <td><?=$section->content?></td>
                                    <td> <input type="text" class="form-control" value="" name="train_item<?=$section->id?>" required=""></td>
                                </tr>
                            <?php } ?>
                    
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Implementation Start Date</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control" value="" name="implementation_date" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Agreement Type</label>
                <div class="col-sm-10">
                    <select name="contract_type_id" class="form-control">

                        <?php
                        $ctypes = DB::table('admin.contracts_types')->get();
                        foreach ($ctypes as $ctype) {
                            ?>
                            <option value="<?= $ctype->id ?>"><?= $ctype->name ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contract Start Date</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" value="" name="start_date" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contract Start Date</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="end_date" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Upload Agreement Form</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" accept=".pdf" name="file" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Areas much interested</label>
                <div class="col-sm-10">
                    <textarea rows="5" cols="5" name="description" class="form-control" placeholder="Default textarea"></textarea>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Payment Status</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="payment_status" id="gender-1" value="1" required=""> Create Invoice (10%)
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="payment_status" id="gender-2" value="2" required=""> Provide Free Trial
                        </label>
                    </div>
                    <span class="messages"></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success" placeholder="Default textarea">Submit</button>
                </div>
            </div>
        </form>


    </div>
</div>