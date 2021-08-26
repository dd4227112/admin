<?php

function check_implementation($activity, $schema_name) {
    $status = '';
    if (preg_match('/exam/i', strtolower($activity))) {
        //all classes have published an exam
        $classes = DB::table($schema_name . '.classes')->count();
        $exams = DB::table($schema_name . '.exam_report')->whereYear('created_at', date('Y'))->count();
        if ($exams >= $classes) {
            $status = ' Implemented';
        } else {
            $status = ' Not Implemented';
        }
    } else if (preg_match('/invoice/i', strtolower($activity))) {
        //receive at least 10 payments

        $payments = DB::table($schema_name . '.payments')->whereYear('created_at', date('Y'))->count();
        if ($payments >= 10) {
            $status = 'Implemented';
        } else {
            $status = ' Not Implemented';
        }
    } else if (preg_match('/nmb/i', strtolower($activity))) {
        //receive at least 10 payments
        $nmb_payments = DB::table($schema_name . '.payments')->whereYear('created_at', date('Y'))->whereNotNull('token')->count();
        $mappend = DB::table($schema_name . '.bank_accounts_integrations')->join($schema_name . '.bank_accounts', $schema_name . '.bank_accounts.id', '=', $schema_name . '.bank_accounts_integrations.bank_account_id')->join('constant.refer_banks', $schema_name . '.bank_accounts.refer_bank_id', '=', 'constant.refer_banks.id')->where(['constant.refer_banks.id' => '22'])->count();
        $is_mappend = (int) $mappend == 0 ? 'Not Mapped: ' : 'Mapped: ';
        if ($nmb_payments >= 10) {
            $status = $is_mappend . 'Implemented';
        } else {
            $status = $is_mappend . ' Not Implemented';
        }
    } else if (preg_match('/crdb/i', strtolower($activity))) {
        //receive at least 10 payments
        $crdb_payments = DB::table($schema_name . '.payments')->whereYear('created_at', date('Y'))->whereNotNull('token')->count();
        $mappend = DB::table($schema_name . '.bank_accounts_integrations')->join($schema_name . '.bank_accounts', $schema_name . '.bank_accounts.id', '=', $schema_name . '.bank_accounts_integrations.bank_account_id')->join('constant.refer_banks', $schema_name . '.bank_accounts.refer_bank_id', '=', 'constant.refer_banks.id')->where(['constant.refer_banks.id' => '8'])->count();
        $is_mappend = (int) $mappend == 0 ? 'Not Mapped: ' : 'Mapped: ';
        if ($crdb_payments >= 10) {
            $status = $is_mappend . 'Implemented';
        } else {
            $status = $is_mappend . ' Not Implemented';
        }
    } else if (preg_match('/transaction/i', strtolower($activity))) {
        //receive at least 10 payments
        $expense = DB::table($schema_name . '.expense')->whereYear('created_at', date('Y'))->count();
        if ($expense >= 10) {
            $status = 'Implemented';
        } else {
            $status = ' Not Implemented';
        }
    } else if (preg_match('/payroll/i', strtolower($activity))) {
        //receive at least 10 payments

        $salary = DB::table($schema_name . '.salaries')->whereYear('created_at', date('Y'))->count();
        if ($salary > 0) {
            $status = 'Implemented';
        } else {
            $status = ' Not Implemented';
        }
    } else if (preg_match('/inventory/i', strtolower($activity))) {

        $inventory = DB::table($schema_name . '.product_alert_quantity')->whereYear('created_at', date('Y'))->count();
        if ($inventory >= 10) {
            $status = 'Implemented';
        } else {
            $status = ' Not Implemented';
        }
    } elseif (preg_match('/onboarding/i', strtolower($activity))) {
        //track no of users
        $client = DB::table('admin.clients')->where('username', $schema_name)->first();
        $students = DB::table($schema_name . '.student')->count();
        if ($students >= (int) $client->estimated_students) {
            $status = 'Implemented';
        } else {
            $status = ' Not Implemented';
        }
    } else if (preg_match('/operations/i', strtolower($activity))) {
        //check transport and hostel
        $tmembers = DB::table($schema_name . '.tmembers')->whereYear('created_at', date('Y'))->count();
        $hmembers = DB::table($schema_name . '.hmembers')->whereYear('created_at', date('Y'))->count();
        if ($tmembers >= 20 || $hmembers >= 20) {
            $status = 'Transport/Hostel Implemented';
        } else {
            $status = 'Transport/Hostel  Not Implemented';
        }
         
    } else if (preg_match('/operations:attendance/i', strtolower($activity))) {
      
        $students = DB::table($schema_name . '.student')->whereYear('created_at', date('Y'))->count();
        $sattendances = DB::table($schema_name . '.sattendances')->whereYear('created_at', date('Y'))->count();
        $teachers = DB::table($schema_name . '.teacher')->whereYear('created_at', date('Y'))->count();
        $tattendance = DB::table($schema_name . '.tattendance')->whereYear('created_at', date('Y'))->count();
        
        if ($students >= $sattendances || $teachers >= $tattendance ) {
            $status = 'Attendance Implemented';
        } else {
            $status = 'Attendance  Not Implemented';
        }

    } else if (preg_match('/sms/i', strtolower($activity))) {
        //check transport and hostel
        $sms_config = DB::table('admin.school_keys')->where('api_key', '<>', '6664567894')->where('schema_name', $schema_name)->count();

        if ((int) $sms_config > 0) {
            $status = 'Implemented';
        } else {
            $status = 'Not Implemented';
        }
    }
    return $status;
}

function customdate($datatime) {
    $newTZ = new DateTimeZone('America/New_York');
    date_default_timezone_set('America/New_York');
    $GMT = new DateTimeZone(Config::get('app.timezone'));
    $date = new DateTime($datatime, $newTZ);
    $date->setTimezone($GMT);
    return $date->format('Y-m-d H:i:s');
}

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function json_call($array = null) {
    if (isset($_GET['callback']) === TRUE) {
        header('Content-Type: text/javascript;');
        header('Access-Control-Allow-Origin: http://client');
        header('Access-Control-Max-Age: 3628800');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

        return request('callback') . '(' . (json_encode($array)) . ')';
    }
}

function money($amount, $decimal = 0) {
    return number_format($amount, $decimal);
}

/*
 * *  Function:   Convert number to string
 * *  Arguments:  int
 * *  Returns:    string
 * *  Description:
 * *      Converts a given integer (in range [0..1T-1], inclusive) into
 * *      alphabetical format ("one", "two", etc.).
 */

function number_to_words($number) {
    if (($number < 0) || ($number > 999999999)) {
        return "$number";
    }

    $Gn = floor($number / 1000000);  /* Millions (giga) */
    $number -= $Gn * 1000000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10; /* Ones */

    $res = "";

    if ($Gn) {
        $res .= number_to_words($Gn) . " Million";
    }

    if ($kn) {
        $res .= (empty($res) ? "" : " ") .
                number_to_words($kn) . " Thousand";
    }

    if ($Hn) {
        $res .= (empty($res) ? "" : " ") .
                number_to_words($Hn) . " Hundred";
    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eighty", "Ninety");

    if ($Dn || $n) {
        if (!empty($res)) {
            $res .= " and ";
        }

        if ($Dn < 2) {
            $res .= $ones[$Dn * 10 + $n];
        } else {
            $res .= $tens[$Dn];

            if ($n) {
                $res .= "-" . $ones[$n];
            }
        }
    }

    if (empty($res)) {
        $res = "zero";
    }

    return $res;
}

function userAccessRole() {
    $user_id = \Auth::user()->id;
    if ((int) $user_id > 0) {
        $user = \App\Model\User::where('id', $user_id)->first();
        if ($user) {
            $permission = \App\Models\PermissionRole::where('role_id', $user->role_id)->get();
            $objet = array();
            if (count($permission) > 0) {
                foreach ($permission as $perm) {
                    array_push($objet, $perm->permission->name);
                }
            }
            return $objet;
        }
    }
}

function form_error($errors, $tag) {
    if ($errors != null && $errors->has($tag)) {
        return $errors->first($tag);
    }
}

function can_access($permission) {
    $user_id = \Auth::user()->id;
    if ((int) $user_id > 0) {
        $global = userAccessRole();
        if (!is_array($global)) {
            return null;
        } else {
            return in_array($permission, $global) ? 1 : 0;
        }
    }
}

function createRoute() {
    $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $url_param = explode('/', $url);

    $controller = isset($url_param[2]) && !empty($url_param[2]) ? $url_param[2] . '' : 'analyse';
    $method = isset($url_param[3]) && !empty($url_param[3]) ? $url_param[3] : 'index';
    $view = $method == 'view' ? 'show' : $method;

    return in_array($controller, array('public', 'storage')) ? NULL : ucfirst($controller) . '@' . $view;
}

function timeAgo($datetime, $full = false) {
    return \Carbon\Carbon::createFromTimeStamp(strtotime($datetime))->diffForHumans();
}

/**
 * Drop-down Menu
 *
 * @access  public
 * @param   string
 * @param   array
 * @param   string
 * @param   string
 * @return  string
 */
if (!function_exists('form_dropdown')) {

    function form_dropdown($name = '', $options = array(), $selected = array(), $extra = '') {
        if (!is_array($selected)) {
            $selected = array($selected);
        }

        // If no selected state was submitted we will attempt to set it automatically
        if (count($selected) === 0) {
            // If the form name appears in the $_POST array we have a winner!
            if (isset($_POST[$name])) {
                $selected = array($_POST[$name]);
            }
        }

        if ($extra != '')
            $extra = ' ' . $extra;

        $multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

        $form = '<select name="' . $name . '"' . $extra . $multiple . ">\n";

        foreach ($options as $key => $val) {
            $key = (string) $key;

            if (is_array($val) && !empty($val)) {
                $form .= '<optgroup label="' . $key . '">' . "\n";

                foreach ($val as $optgroup_key => $optgroup_val) {
                    $sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

                    $form .= '<option value="' . $optgroup_key . '"' . $sel . '>' . (string) $optgroup_val . "</option>\n";
                }

                $form .= '</optgroup>' . "\n";
            } else {
                $sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

                $form .= '<option value="' . $key . '"' . $sel . '>' . (string) $val . "</option>\n";
            }
        }

        $form .= '</select>';

        return $form;
    }

}

/**
 * 
 * @param type $phone_number
 * @return array($country_name, $valid_number) or not array if wrong number
 */
function validate_phone_number($number,$country_code=NULL) {
    $phone_number = preg_replace("/[^0-9]/", '', $number);
    $phone = preg_replace('/' . $country_code . '/', '', $phone_number, 1);
    return $valid_number = $country_code . $phone;
}

function btn_attendance($id, $method, $class, $name) {
    return "<input type='checkbox' class='" . $class . "' $method id='" . $id . "' data-placement='top' data-toggle='tooltip' data-original-title='" . $name . "' > ";
}

function timeZones($value) {
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $value);
    $date->setTimeZone(new DateTimeZone('Africa/Dar_es_Salaam'));
    return $date->format('Y-m-d H:i:s');
}

function cdate($date) {
    return date('d-m-Y H:i:s');
}

function remove_comma($string_number) {
    return trim(str_replace(',', '', $string_number));
}

function school_full_name($schema_name = null) {
    return \App\Models\Client::where('username', $schema_name)->first()->name;
}

function warp($word, $size = 20) {
    return wordwrap($word, $size, "<br />\n");
}


    function base_url($url = '/') {
    return ($_POST && request('b_url') != '') ? url(request('b_url')) : url($url);
}

if (!function_exists('img')) {

    function img($src = '', $index_page = FALSE) {
        if (!is_array($src)) {
            $src = array('src' => $src);
        }

        // If there is no alt attribute defined, set it to an empty string
        if (!isset($src['alt'])) {
            $src['alt'] = '';
        }

        $img = '<img';

        foreach ($src as $k => $v) {

            if ($k == 'src' AND strpos($v, '://') === FALSE) {

                $img .= ' src="' . url($v) . '"';
            } else {
                $img .= " $k=\"$v\"";
            }
        }

        $img .= '/>';

        return $img;
    }

}

function clean_htmlentities($id) {
    return htmlentities($id, ENT_QUOTES, "UTF-8");
}

// Calculate working days depends on month and year
function workingDays($year, $month, $ignore = array(0, 6)) {
    $count = 0;
    $counter = mktime(0, 0, 0, $month, 1, $year);
    while (date("n", $counter) == $month) {
        if (in_array(date("w", $counter), $ignore) == false) {
            $count++;
        }
        $counter = strtotime("+1 day", $counter);
    }
    // days after weekends
    $remaindays = $count;
    //  Holiday days
    $holidays = \collect(DB::select("select count(*) from admin.public_days where extract(year from date) = '$year' and extract(month from date) = '$month' and extract(ISODOW from date) not in (6, 7)"))->first();
    // return working days
    return $remaindays - $holidays->count;
}
