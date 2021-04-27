<?php /*
<table class="table table-responsive dataTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Ward</th>
                                                                        <th>District</th>
                                                                        <th>Region</th>
                                                                        <th>No of Schools</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $ward_ids = DB::table('users_schools_wards')->where('user_id', $user->id)->get(['ward_id']);
                                                                    $arr_wards = [];
                                                                    foreach ($ward_ids as $ward_id) {
                                                                        array_push($arr_wards, $ward_id->ward_id);
                                                                    }
                                                                    $wards = \App\Models\Ward::whereIn('id', $arr_wards)->get();
                                                                    foreach ($wards as $ward) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $ward->name ?></td>
                                                                            <td><?= $ward->district->name ?></td>
                                                                            <td><?= $ward->district->region->name ?></td>
                                                                            <td><?= $ward->schools()->where(DB::raw('lower(ownership)'), 'non-government')->count() ?></td>
                                                                            <td>

                                                                                <a type="button" class="btn btn-warning btn-sm waves-effect" href="<?= url('background/removeUserSchool/' . $user->id.'/'.$ward->id) ?>">Delete</a>

                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
 */ ?>