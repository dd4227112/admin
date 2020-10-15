<form action="<?= url('sales/onboard') ?>" method="POST" enctype="multipart/form-data">

                <div class="form-group row" style="border: 1px dashed; ">
                  <label class="col-sm-2 col-form-label">Domain Name</label>
                  <div class="row">
                    <div class="col-lg-2">  <b style="font-size: 1.4em;"> https://</b> </div>
                    <div id="col-lg-6">
                      <input style="max-width: 20em;
                      resize: none" class="form-control " id="school_username" name="username" type="text" placeholder="school name" value="" required="" onkeyup="validateForm()">

                    </div>
                    <div id="col-lg-4">
                      <b style="font-size: 1.4em;">.shulesoft.com</b>
                    </div>
                  </div>
                  <small style="max-width: 13em;" id="username_message_reply"></small>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Estimated Students</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" value="" name="students" required="">
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



                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <div class="row">

                      <div class="col-md-6">
                        Name
                        <input type="text" name="name" class="form-control"/>
                      </div>
                      <div class="col-md-6">
                        Phone
                        <input type="text" name="phone" class="form-control"/>
                      </div>
                      <div class="col-md-6">
                        Email
                        <input type="text" name="email" class="form-control"/>
                      </div>
                      <div class="col-md-6">
                        Title
                        <select name="title" class="form-control select2">

                          <option value="director">Director/Owner</option>
                          <option value="manager">School Manager</option>
                          <option value="head teacher">Head Teacher</option>
                          <option value="Second Master/Mistress">Second Master/Mistress</option>
                          <option value="academic master">Academic Master</option>
                          <option value="teacher">Normal Teacher</option>
                          <option value="Accountant">Accountant</option>
                          <option value="Other Staff">Other Non Teaching Staff</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <strong> Select Ownership</strong>
                        <select name="ownership" class="form-control" required>
                          <option value="Non-Government">Non-Government</option>
                          <option value="Government">Government</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <strong> Select School Type</strong>
                        <select type="text" name="type" class="form-control" required>
                          <option value="primary"> Primary School</option>
                          <option value="secondary"> Secondary School</option>
                          <option value="college"> College</option>
                        </select>
                      </div>
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
                    <label class="col-sm-2 col-form-label">Contract End Date</label>
                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="end_date" required="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Upload Agreement Form(pdf)</label>
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
                    <label class="col-sm-2 col-form-label">Joining Status</label>
                    <div class="col-sm-10">
                      <div class="form-check form-check-inline">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="payment_status" id="gender-1" value="1" required=""> All Information Verified
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="payment_status" id="gender-2" value="2" required=""> School Still on-progress
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="payment_status" id="gender" value="2" required=""> School Under ShuleSoft Follow-up
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