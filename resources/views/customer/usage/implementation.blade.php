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
                                $exams = DB::table($content->school_name . '.exam_report')->whereYear('created_at', 2021)->count();
                                if ($exams >= $classes) {
                                    $status = ' Implemented';
                                } else {
                                    $status = ' Not Implemented';
                                }
                            } else if (preg_match('/invoice/i', strtolower($content->activity))) {
                                //receive at least 10 payments


                                $payments = DB::table($content->school_name . '.payments')->whereYear('created_at', 2021)->count();
                                if ($payments >= 10) {
                                    $status = 'Implemented';
                                } else {
                                    $status = ' Not Implemented';
                                }
                            } else if (preg_match('/nmb/i', strtolower($content->activity))) {
                                //receive at least 10 payments


                                $nmb_payments = DB::table($content->school_name . '.payments')->whereYear('created_at', 2021)->whereNotNull('token')->count();
                                $mappend = DB::table($content->school_name . '.bank_accounts_integrations')->where('invoice_prefix', '<>', 'SAS')->count();
                                $is_mappend = (int) $mappend == 0 ? 'Not Mapped: ' : 'Mapped: ';
                                if ($nmb_payments >= 10) {
                                    $status = $is_mappend . 'Implemented';
                                } else {
                                    $status = $is_mappend . ' Not Implemented';
                                }
                            } else if (preg_match('/crdb/i', strtolower($content->activity))) {
                                //receive at least 10 payments


                                $crdb_payments = DB::table($content->school_name . '.payments')->whereYear('created_at', 2021)->whereNotNull('token')->count();

                                $mappend = DB::table($content->school_name . '.bank_accounts_integrations')->where('invoice_prefix', 'SAS')->count();
                                $is_mappend = (int) $mappend == 0 ? 'Not Mapped: ' : 'Mapped: ';
                                if ($crdb_payments >= 10) {
                                    $status = $is_mappend.'Implemented';
                                } else {
                                    $status = $is_mappend.' Not Implemented';
                                }
                            } else if (preg_match('/transaction/i', strtolower($content->activity))) {
                                //receive at least 10 payments


                                $expense = DB::table($content->school_name . '.expense')->whereYear('created_at', 2021)->count();
                                if ($expense >= 10) {
                                    $status = 'Implemented';
                                } else {
                                    $status = ' Not Implemented';
                                }
                            } else if (preg_match('/payroll/i', strtolower($content->activity))) {
                                //receive at least 10 payments


                                $salary = DB::table($content->school_name . '.salaries')->whereYear('created_at', 2021)->count();
                                if ($salary > 0) {
                                    $status = 'Implemented';
                                } else {
                                    $status = ' Not Implemented';
                                }
                            } else if (preg_match('/inventory/i', strtolower($content->activity))) {
                                //receive at least 10 payments


                                $inventory = DB::table($content->school_name . '.product_alert_quantity')->whereYear('created_at', 2021)->count();
                                if ($inventory >= 10) {
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
                                $tmembers = DB::table($content->school_name . '.tmembers')->whereYear('created_at', 2021)->count();
                                $hmembers = DB::table($content->school_name . '.hmembers')->whereYear('created_at', 2021)->count();
                                if ($tmembers >= 20 || $hmembers >= 20) {
                                    $status = 'Transport/Hostel Implemented';
                                } else {
                                    $status = 'Transport/Hostel  Not Implemented';
                                }
                            } else if (preg_match('/sms/i', strtolower($content->activity))) {
                                //check transport and hostel
                                $sms_config = DB::table('admin.school_keys')->where('api_key', '<>', '1234567894')->where('schema_name', $content->school_name)->count();

                                if ((int) $sms_config > 0) {
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
