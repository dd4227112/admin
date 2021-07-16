<table>
    <thead>
        <tr>
            <th></th>
            <?php
            $vars = get_object_vars($headers);
            ?>

            <?php
            foreach ($vars as $key => $value) {
                ?>
                <th><?= $key ?></th>

                <?php
            }
            ?>

        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($contents as $content) {
            $i++;
            ?> 

            <tr>
                <td><?= $i ?></td>
                <?php
                $status = '';
                foreach ($vars as $key => $value) {
                    ?> 

                    <?php
                    if ($key == 'completed_at') {
                        ?>
                        <td>
                            <?php
                            if (preg_match('/exam/i', strtolower($content->activity))) {
                                //all classes have published an exam

                                $classes = DB::table($content->school_name . '.classes')->count();
                                $exams = DB::table($content->school_name . '.exam_report_settings')->count();
                                if ($exams >= $classes) {
                                    $status = ' Implemented';
                                } else {
                                    $status = ' Not Implemented';
                                }
                            } else if (preg_match('/account/i', strtolower($content->activity))) {
                                //receive at least 10 payments


                                $payments = DB::table($content->school_name . '.payments')->count();
                                $expense = DB::table($content->school_name . '.expense')->count();
                                if ($payments >= 10 && $expense >= 10) {
                                    $status = 'Implemented';
                                } else {
                                    $status = ' Not Implemented';
                                }
                            } elseif (preg_match('/onboarding/i', strtolower($content->activity))) {
                                //track no of users
                                $client = DB::table('admin.clients')->where('username', $content->school_name)->first();
                                $students = DB::table($content->school_name . '.student')->count();
                                if ($students >= (int) $client->estimated_students) {
                                    $status = 'Implemented';
                                } else {
                                    $status = ' Not Implemented';
                                }
                            } else if (preg_match('/operation/i', strtolower($content->activity))) {
                                //check transport and hostel
                                $tmembers = DB::table($content->school_name . '.tmembers')->count();
                                $hmembers = DB::table($content->school_name . '.hmembers')->count();
                                if ($tmembers >= 20 || $hmembers >= 20) {
                                    $status = 'Transport/Hostel Implemented';
                                } else {
                                    $status = 'Transport/Hostel  Not Implemented';
                                }
                                
                                
                            }else if (preg_match('/sms/i', strtolower($content->activity))) {
                                //check transport and hostel
                                $parent = DB::table($content->school_name . '.parent')->count();
                                $sms_count = DB::table($content->school_name . '.sms')->count();
                                if ($sms_count >= $parent) {
                                    $status = 'Implemented';
                                } else {
                                    $status = 'Not Implemented';
                                }
                                
                                
                            }
                            ?>
                        </td>
                    <?php } else if ($key == 'status') { ?>
                        <td><?= $status ?></td>

                    <?php } else { ?>
                        <td><?= $content->{$key} ?></td>



                        <?php
                    }
                }
                ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
