<?php

namespace App\Http\Controllers;

use App\Models\ClientPharmacy;
use App\Models\LineshopCLient;
use Illuminate\Http\Request;
use \App\Models\UserAllowance;
use App\Models\SalaryAllowance;
use DB;
use  \App\Models\Pharmacies;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Lineshop extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->data['insight'] = $this;
    }
    // SALES PHARMACIES
    public function pharmacies()
    {
        $group = request()->segment(3);
        $reg_id = request()->segment(4);
        //get all clients
        if ($group == '1' || $group == null) {
            $group = '1';
            $this->data['pharmacies'] = Pharmacies::get();
        }
        //select client pharmacies only
        if ($group == '2') {
            $this->data['pharmacies'] = Pharmacies::whereIn('id', \App\Models\ClientPharmacy::pluck('pharmacy_id'))->get();
            // $this->data['pharmacies']= DB::select("select * from admin.pharmacies a join admin.client_pharmacy b on a.id =b.pharmacy_id join admin.lineshop_clients c on b.client_id =c.id where c.status =1");
        }
        //  dd( $this->data['pharmacies']);
        $this->data['group'] = $group;

        // $this->data['pharmacies'] =Pharmacies::join('lineshop_clients as b', 'pharmacies.id', '=', 'b.pharmacy_id')
        //     ->select('pharmacies.*')
        //     ->get();
        // dd($this->data['pharmacies']);
        // if ($id > 1) {
        //     if (isset($reg_id) && (int) $reg_id > 0) {
        //         $this->data['schools'] = \App\Models\ClientSchool::whereIn('school_id', \App\Models\School::whereIn('ward_id', \App\Models\Ward::whereIn('district_id', \App\Models\District::whereIn('region_id', [$reg_id])->get(['id']))->get(['id']))->get(['id']))->get();
        //     } else {
        //         $this->data['schools'] = \App\Models\ClientSchool::whereIn('school_id', \App\Models\School::whereIn('ward_id', \App\Models\Ward::whereIn('district_id', \App\Models\District::whereIn('region_id', \App\Models\Region::get(['id']))->get(['id']))->get(['id']))->get(['id']))->get();
        //     }
        // }
        // $this->data['use_shulesoft'] = DB::table('admin.all_setting')->count() - 5;
        // $this->data['nmb_schools'] = DB::table('admin.nmb_schools')->count();
        // $this->data['nmb_shulesoft_schools'] = \collect(DB::select("select count(distinct schema_name) as count from admin.all_bank_accounts where refer_bank_id=22"))->first()->count;
        // $this->data['school_types'] = DB::select("select type, count(*) from admin.schools where ownership='Non-Government' group by type,ownership");
        // $this->data['ownerships'] = DB::select('select ownership, COUNT(*) as count,SUM(COUNT(*)) over() as total_schools,(COUNT(*) * 1.0) / SUM(COUNT(*)) over() as percent FROM admin.schools group by ownership');
        return view('lineshop.sales.pharmacies', $this->data);
    }
    public function getPharmacies()
    {
        $sql = 'select a.* from admin.pharmacies';
        return $this->ajaxTable('pharmacies',  $sql);
    }
    public function pharmacyRequest()
    {
        $sql2_ = 'select count(*) as pharmacy, extract(month from created_at) as month from admin.website_join_lineshop a where extract(year from a.created_at)= extract(year from current_date)  group by month order by month';
        $this->data['requests'] = DB::select($sql2_);
        $this->data['allrequests'] = \collect(DB::select('select id, pharmacy_name,registration_number,contact_name,contact_phone,contact_email from admin.website_join_lineshop order by id desc'));
        return view('lineshop.sales.pharmacy_requests', $this->data);
    }
    public function onboardPharmacy()
    {
        $pharmacy_id = (int) request()->segment(3);


        $this->data['pharmacy'] = $pharmacy = Pharmacies::findOrFail($pharmacy_id);
        $username = clean(preg_replace('/[^a-z]/', null, strtolower($pharmacy->name)));

        $user_object = new \App\Http\Controllers\Users();
        $this->data['staffs'] = $user_object->shulesoftUsers();
        if ($_POST) {
            // dd(request()->all());
            $file = request()->file('file');
            if (filesize($file) > 2015110) {
                return redirect()->back()->with('error', 'File must have less than 2MBs');
            }

            $this->validate(
                request(),
                [
                    'name' => 'required',
                    'sales_user_id' => 'required',
                    'warehouse_number' => 'required|numeric',
                    'username' => 'required',
                    'nature' => 'required',
                ]
            );

            $code = rand(343, 32323) . time();
            $pharmacy_contact = DB::table('admin.lineshop_contacts')->where('pharmacy_id', $pharmacy_id)->first();
            if (empty($pharmacy_contact)) {
                DB::table('admin.lineshop_contacts')->insert([
                    'name' => request('owner_name'), 'email' => request('owner_email'), 'phone' => request('owner_phone'), 'pharmacy_id' => $pharmacy_id, 'user_id' => Auth::user()->id, 'title' => ''
                ]);
                $pharmacy_contact = DB::table('admin.lineshop_contacts')->where('pharmacy_id', $pharmacy_id)->first();
            }

            $username = str_replace(' ', '', request('username'));
            $check_client = DB::table('admin.lineshop_clients')->where('username', $username)->first();
            // $school_name = empty(request('school_name')) ? $school->name : request('school_name');
            // $school_email = !empty($school_contact->email) ? $school_contact->email : request('owner_email');
            // $school_phone = !empty($school_contact->phone) ? $school_contact->phone : request('owner_phone');
            // $address = $school->wards->name . ' ' . $school->wards->district->name . ' ' . $school->wards->district->region->name;

            $client_data = [
                'name' => request('name'),
                'address' => request('location'),
                'created_at' => date('Y-m-d H:i:s'),
                'phone' => request('owner_phone'),
                'email' => request('owner_email'),
                'warehouse_number' => request('warehouse_number'),
                'status' => 1, // Unapproved application
                'code' => $code,
                'region_id' => $pharmacy->wards->district->region->id,
                'email_verified' => 0,
                'phone_verified' => 0,
                'created_by' => Auth::user()->id,
                'username' => clean(request('username')),
                'payment_option' => request('payment_option'),
                'start_usage_date' => date('Y-m-d'),
                'trial' => 0,
                'owner_email' => request('owner_email'),
                'owner_phone' => request('owner_phone'),
                'note' => nl2br(request('description')),
                'registration_number' => request('registration_number'),
                'nature' => request('nature'),
                // 'pharmacy_id' => $pharmacy_id
            ];

            // $this->sendDataToAccounts($school_name, $schema_name, request('students'), $school_email, $school_phone, $address);
            if (!empty($check_client)) {
                $client_id = $check_client->id;
                DB::table('admin.lineshop_clients')->where('id', $client_id)->update(Arr::except($client_data, ['username']));
            } else {
                $client_id = DB::table('admin.lineshop_clients')->insertGetId($client_data);

                // trial period
                // if(request('check_trial') == 1 && !is_null(request('trial_period')) ) {
                //       $start = date('Y-m-d', strtotime(request('implementation_date')));
                //       $period  = request('trial_period');
                //     DB::table('admin.client_trials')->insert([
                //         'client_id' => $client_id,
                //         'period' => $period,
                //         'start_date' => $start,
                //         'end_date' => date('Y-m-d', strtotime($start. " + $period days")),
                //         'status' =>  1
                //      ]); 
                // }
                // client pharmacy
                DB::table('admin.client_pharmacy')->insert([
                    'pharmacy_id' => $pharmacy_id, 'client_id' => $client_id
                ]);
                //client projects
                // DB::table('admin.client_projects')->insert([
                //     'project_id' => 1, 'client_id' => $client_id //default ShuleSoft project
                // ]);
                //sales person
                // DB::table('admin.users_schools')->insert([
                //     'school_id' => $school_id, 'client_id' => $client_id, 'user_id' => Auth::user()->id, 'role_id' => 8, 'status' => 1
                // ]);
                //post task, onboarded
                // $data = ['user_id' => Auth::user()->id, 'school_id' => $school_id, 'activity' => 'Onboarding', 'task_type_id' => request('task_type_id'), 'user_id' => Auth::user()->id];
                // $task = \App\Models\Task::create($data);
                // DB::table('tasks_schools')->insert([
                //     'task_id' => $task->id,
                //     'school_id' => $school_id
                // ]);
            }

            if (!empty(request('file'))) {
                $file = request()->file('file');
                $company_file_id = $file ? $this->saveFile($file, TRUE) : 1;
                $contract_id = DB::table('admin.contracts')->insertGetId([
                    'name' => 'Lineshop service fee', 'company_file_id' => $company_file_id, 'start_date' => request('start_date'), 'end_date' => request('end_date'), 'contract_type_id' => request('contract_type_id'), 'user_id' => Auth::user()->id
                ]);
                //client contracts
                DB::table('admin.client_contracts')->insert([
                    'contract_id' => $contract_id, 'client_id' => $client_id
                ]);
            }

            // if document is standing order,Upload standing order files
            if (!empty(request('standing_order_file')) && preg_match('/Standing Order/i', request('payment_option'))) {
                $file = request()->file('standing_order_file');
                $company_file_id = $file ? $this->saveFile($file, TRUE) : 1;
                $total_amount = empty(request('total_amount')) ? request('occurance_amount') * request('number_of_occurrence') : request('total_amount');

                $contract_id = DB::table('admin.standing_orders')->insertGetId(array(
                    'type' => request('which_basis'), 'created_by' => Auth::user()->id,
                    'client_id' => $client_id, 'contract_type_id' => 8,
                    'is_approved' => '0', 'company_file_id' => $company_file_id,
                    'payment_date' => request('maturity_date'), 'occurance_amount' => remove_comma(request('occurance_amount')),
                    'contact_person' => request('contact_person'), 'branch_name' => request('branch_name'),
                    'occurrence' => request('number_of_occurrence'), 'total_amount' => remove_comma($total_amount),
                ));
                //client contracts
                DB::table('admin.client_contracts')->insert([
                    'contract_id' => $contract_id, 'client_id' => $client_id
                ]);
            }

            //once a school has been installed, now create an invoice for this school or create a promo code

            // $client = \App\Models\Client::findOrFail($client_id);
            // $year = \App\Models\AccountYear::where('name', date('Y'))->first();
            // $reference = time(); // to be changed for selcom ID
            // $invoice = \App\Models\Invoice::create(['reference' => $reference, 'client_id' => $client_id, 'date' => date('d M Y'), 'due_date' => date('d M Y', strtotime(' +30 day')), 'year' => date('Y'), 'user_id' => Auth::user()->id, 'account_year_id' => $year->id]);

            // $unit_price = remove_comma(request('price'));
            // $estimated_students = remove_comma(request('students'));
            // $amount = $unit_price * $estimated_students;
            //  \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee', 'quantity' => $estimated_students, 'unit_price' => $unit_price]);


            // $trial_code = $client_id . time();
            // $client = DB::table('admin.clients')->where('id', $client_id);
            // DB::table('admin.clients')->where('id', $client_id)->update(['code' => $trial_code]);
            // $user = $client->first();

            $user = \App\Models\User::find(request('sales_user_id'));

            $message = 'Hello ' . $user->firstname . ' ' . $user->lastname
                . chr(10) . 'Pharmacy :' . $pharmacy->name . ' has been onboarded succesfully'
                . chr(10) . 'Thank you.';
            $this->send_whatsapp_sms($user->phone, $message);
            $this->send_sms($user->phone, $message, 1, null, 'lineshop');

            // $finance = \App\Models\User::where('designation_id', 2)->where('status', 1)->first();
            // $sms = 'Hello ' . $finance->firstname . ' ' . $finance->lastname
            //     . chr(10) . 'New school :' . $school->name . ' has been onboarded in the shulesoft system'
            //     . chr(10) . 'You are remainded to verify the invoice document'
            //     . chr(10) . 'Thank you.';
            // $this->send_whatsapp_sms($finance->phone, $sms);
            // $this->send_sms($finance->phone, $sms, 1, null, 'lineshop');
            // return $this->url(strtolower(request('name')));
            return redirect(base_url('lineshop/profile/' . $pharmacy_id))->with('success', 'Pharmacy :' . $pharmacy->name . ' has been onboarded succesfully');
        }

        return view('lineshop.sales.add_new_client', $this->data);
    }

    function profile()
    {

        $id = (int) request()->segment(3);

        if ((int) $id == 0 || !is_int($id)) {
            return false;
        }

        // $this->data['school'] = \App\Models\School::findOrFail($id);
        //$this->data['pharmacy'] = $pharmacy=DB::table('pharmacies')->where('pharmacies.id', $id)->get(['id', 'name','ownership', 'account_number' , 'created_at', 'updated_at', 'ward_id' , 'status', 'type', 'registered', 'region', 'district' ])->first();
        $this->data['pharmacy'] = $pharmacy = Pharmacies::where('id', $id)->first();
        if (!empty($pharmacy->clientPharmacy)) {

            $client = LineshopCLient::find($pharmacy->clientPharmacy->client_id);

            $this->data['link'] = strtolower($this->url($client->username));
        } else {
            $this->data['link'] = '';
        }
        // DB::table('pharmacies')->where('pharmacies.id', $id)->get(['id', 'name','ownership', 'account_number' , 'created_at', 'updated_at', 'ward_id' , 'status', 'type', 'registered', 'region', 'district' ])->first();
        if (empty($pharmacy)) {
            return view('errors.404');
        }


        if ($_POST) {
            $file = request()->file('agreement_file');
            $company_file_id = $file ? $this->saveFile($file, TRUE) : 1;

            $school_array = array(
                'name' => request('school_name'),
                'nmb_school_name' => request('nmb_school_name'),
                'account_number' => request('account_number'),
                'students' => request('students'),
                'type' => request('school_type')
            );
            $agreement_array = array(
                'school_id' => request('school_id'), 'contact_person_name' => request('contact_person_name'), 'contact_person_phone' => request('contact_person_phone'),
                'contact_person_designation' => request('contact_person_designation'), 'company_file_id' => $company_file_id,
                'agreement_date' => date('Y-m-d', strtotime(request('agreement_date'))), 'form_type' => request('form_type'), 'created_by' => Auth()->user()->id
            );
            if ((int) request('add_sale') == 1) {
                \App\Models\School::findOrFail(request('school_id'))->update($school_array);

                $check = \App\Models\SchoolAgreement::where('school_id', (int) request('school_id'))->first();
                if (!empty($check)) {
                    \App\Models\SchoolAgreement::where('school_id', (int) request('school_id'))->update($agreement_array);
                } else {
                    \App\Models\SchoolAgreement::create($agreement_array);
                }

                return redirect()->back()->with('success', 'School record updated successfully');
            } else if ((int) request('add_user') == 1) {
                // dd(request()->all());
                \App\Models\PharmacyContact::create([
                    'name' => request('name'),
                    'email' => request('email'),
                    'phone' => request('phone'),
                    'school_id' => request('school_id'),
                    'user_id' => Auth::user()->id,
                    'title' => request('title'),
                    'notes' => request('notes')
                ]);
                return redirect()->back()->with('success', 'user recorded successfully');
            } else {
                $school_id = request('client_id');
                $data = array_merge(request()->all(), ['user_id' => Auth::user()->id, 'school_id' => request('client_id')]);
                DB::transaction(function () use ($data, $school_id) {
                    $task = \App\Models\Task::create($data);
                    \App\Models\UsersSchool::create([
                        'user_id' => Auth::user()->id, 'school_id' => (int) $school_id, 'role_id' => Auth::user()->role_id, 'status' => 1,
                    ]);
                    DB::table('tasks_schools')->insert([
                        'task_id' => $task->id,
                        'school_id' => (int) $school_id
                    ]);
                    return redirect()->back()->with('success', 'Report added successfully');
                });
            }
        }
        return view('lineshop.sales.profile', $this->data);
    }

    function addPharmacy()
    {
        if ($_POST) {
            $array = [
                'name' => strtoupper(request('name')),
                'ward_id' => request('ward'),
                'type' => request('type'),
                'zone_id' => request('zone'),
                'region' => request('region'),
            ];

            DB::table('admin.pharmacies')->insert($array);
            return redirect('lineshop/pharmacies')->with('success', request('name') . ' successfully');
        }
        return view('lineshop.sales.add_pharmacies', $this->data);
    }
    public function url($client_name)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host == 'localhost') {
            $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $url = explode('/', $url);
            $url = 'http://' . $host . '/' . $client_name . '/';
        } else {
            $url = 'http://' . $client_name . '.lineshop.africa';
        }
        return $url;
    }
    public function salesMaterials()
    {
        return view('lineshop.sales.sales_materials', $this->data);
    }

    // MARKETING FUNCTIONS
    public function events()
    {
        $id = request()->segment(3);
        if ((int) $id > 0) {

            if ($_POST) {
                $body = request('message');
                $sms = request('sms');
                $email = request('email');
                $events = \App\Models\LineshopEventAttendee::where('event_id', $id)->get();
                $workshop = \App\Models\LineshopEvent::where('id', $id)->first();
                foreach ($events as $event) {
                    if ($event->email != '' && (int) $email > 0) {
                        $message = '<h4>Dear ' . $event->name . '</h4>'
                            . '<h4>I trust this email finds you well.</h4>'
                            . '<h4>' . $body . '</h4>'
                            . '<p><br>Looking forward to hearing your contribution in the discussion.</p>'
                            . '<br>'
                            . '<p>Thanks and regards,</p>'
                            . '<p><b>Lineshop Team</b></p>'
                            . '<p>Call: +255 655 406 004 </p>';
                        $this->send_email($event->email, 'Lineshop Webinar on ' . $workshop->title, $message);
                    }
                    if ($event->phone != '' && (int) $sms > 0) {
                        $message1 = 'Dear ' . $event->name . '.'
                            . chr(10) . $body
                            . chr(10)
                            . chr(10) . 'Lineshop Team'
                            . chr(10) . 'Call: +255 655 406 004 ';
                        $sql = "insert into public.sms (body,user_id, type,phone_number, 'project') values ('$message1', 1, '0', '$event->phone', 'lineshop')";
                        $chatId = $event->phone . '@c.us';
                        $this->sendMessage($chatId, $message1);

                        DB::statement($sql);
                    }
                }
                return redirect()->back()->with('success', 'Message Sent Successfully to ' . count($events) . ' Attendees.');
            }
            $this->data['event'] = \App\Models\LineshopEvent::where('id', $id)->first();
            return view('lineshop.market.view_event', $this->data);
        }
        $this->data['events'] = \App\Models\LineshopEvent::orderBy('id', 'DESC')->get();
        return view('lineshop.market.event', $this->data);
    }

    public function addEvent()
    {
        if ($_POST) {
            $file_id = null;
            $attach_id = null;
            if (!empty(request('attached'))) {
                $file_id = $this->saveFile(request('attached'), TRUE);
            }

            if (!empty(request('image'))) {
                $attach_id = $this->saveFile(request('image'), TRUE);
            }
            $array = [
                'title' => request('title'),
                'note' => request('note'),
                'event_date' => request('event_date'),
                'start_time' => request('start_time'),
                'end_time' => request('end_time'),
                'category' => request('category'),
                'department_id' => request('department_id'),
                'meeting_link' => request('meeting_link'),
                'user_id' => Auth::user()->id,
                'file_id' => $file_id,
                'attach_id' => $attach_id
            ];
            $minute = \App\Models\LineshopEvent::create($array);
            return redirect('lineshop/events')->with('success', request('title') . ' added successfully');
        }
        $this->data['users'] = \App\Models\User::all();
        return view('lineshop.market.add_event', $this->data);
    }

    public function DeleteMedia()
    {
        $id = request()->segment(3);
        if ($id) {
            \App\Models\LineshopEvent::where('id', $id)->delete();
            return redirect()->back()->with('success', 'Deleted Successfully');
        }
    }

    public function deleteUser()
    {
        $id = request()->segment(3);
        \App\Models\LineshopEventAttendee::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'success');
    }


    public function socialMediaUpdate()
    {
        $media = request("socialmedia_id");
        $post = request("post_id");
        $type = request("type_id");
        $number = request("inputs");
        if ($number == '') {
            $number = 0;
        }
        $now = date('Y-m-d H:i:s');
        if ((float) request("inputs") >= 0 && request("post_id") != '' && request("socialmedia_id") != '') {
            \App\Models\SocialMediaPost::where('post_id', $post)->where('socialmedia_id', $media)->update([$type => $number, 'updated_at' => $now]);
            echo "success";
        } else {
            echo "Class can not be empty";
        }
    }
    public function customers(): string
    {
        echo 'Page under construction';
        return false;
    }
    public function feedbacks()
    {
        $feedbacks = \App\Models\LineshopFeedback::orderBy('id', 'desc')->paginate();
        return view('lineshop.customers.feedback', compact('feedbacks'));
    }
    public function usage()
    {
        echo "usage page under construction";
    }

    public function reports()
    {
        echo "reports page under construction";
    }
    public function customer_requirements()
    {

        $tab = request()->segment(3);
        $id = request()->segment(4);
        if ($tab == 'show' && $id > 0) {
            $this->data['requirement'] = \App\Models\LineshopRequirement::where('id', (int) $id)->first();
            if (empty($this->data['requirement'])) {
                return redirect(url('lineshop/customer_requirements'))->with('error', "No customer requirement associated  with the given id");
            }
            $next_id = \App\Models\LineshopRequirement::whereNotIn('id', [$id])->where('status', 'New')->first();
            $this->data['next'] = is_null($next_id) ? '' : $next_id->id;
            return view('lineshop/products/view_requirement', $this->data);
        }

        if ($tab == 'edit' && $id > 0) {
            $this->data['requirement'] = \App\Models\LineshopRequirement::where('id', $id)->first();
            return view('lineshop/products/edit_requirement', $this->data);
        }

        if ($tab == 'range') {
            $startDate = request('start');
            $endDate = request('end');
            $this->data['stats'] = $this->checkTaskProgress($startDate, $endDate);
            $this->data['requirements'] = \App\Models\LineshopRequirement::whereBetween('created_at', [$startDate, $endDate]);
            return view('lineshop/products/analysis', $this->data);
        }


        if ($tab == 'allocated') {
            $to_user_id = \Auth()->user()->id;
            $this->data['startDate'] = $startDate = date("Y-m-d", strtotime('monday this week'));
            $this->data['endDate'] = $endDate = date('Y-m-d', strtotime($startDate . ' + 6 days'));

            if ($_POST) {
                $to_user_id = request('to_user_id') != '' ? request('to_user_id') : \Auth()->user()->id;
                $this->data['startDate'] = $startDate = date('Y-m-d', strtotime(request('week')));
                $this->data['endDate'] = $endDate = date('Y-m-d', strtotime($startDate . ' + 6 days'));
                $this->data['person_stats'] = $this->checkTaskProgress($startDate, $endDate, $to_user_id);
                $this->data['requirements'] = \App\Models\LineshopRequirement::whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $this->data['requirements'] = \App\Models\LineshopRequirement::latest();
            }
            $this->data['person_stats'] = $this->checkTaskProgress($startDate, $endDate, $to_user_id);
            return view('lineshop/products/analysis', $this->data);
        }

        $this->data['levels'] = [];
        if ($_POST) {
            $validated = request()->validate([
                'note' => 'required|min:12',
            ]);
            $requirement = [
                'note' => request('note'),
                'priority' => request('priority'),
                'user_id' => Auth::user()->id,
                'contact' => DB::table('shulesoft.setting')->where('school_id', request('school_id'))->first() ? DB::table('shulesoft.setting')->where('school_id', request('school_id'))->first()->phone : '',
                'to_user_id' => request('to_user_id'),
                'user_sid' => request('user_sid'),
                'project_id' => 1,
                'module_id' => request('module_id'),
                'due_date' => request('due_date'),
                'pharmacy_id' => request('pharmacy_id'),
                'status' => 'New'
            ];
            $req = \App\Models\LineshopRequirement::create($requirement);
            if ((int) request('user_sid') > 0) {

                $client = \App\Models\LineshopCLient::where('username', $req->pharmacy->schema_name)->first();
                if (!empty($client)) {
                    if ($client->is_new_version) {
                        $user = \DB::table('shulesoft.users')->where('sid', request('user_sid'))->where('schema_name', $req->pharmacy->schema_name)->first();
                    } else {
                        $user = \DB::table('admin.all_users')->where('sid', request('user_sid'))->where('schema_name', $req->pharmacy->schema_name)->first();
                    }

                    $module = DB::table('admin.modules')->where('id', request('module_id'))->first()->name;
                    $new_req = isset($req->pharmacy->name) && (int) $req->pharmacy_id > 0 ? ' - from ' . $req->pharmacy->name . ' on ' . $module : ' - ' . $module;
                    $message = 'Hello ' . $user->name . '<br/>'
                        . '</p>Your Requirement has been submitted for implementation</p>'
                        . '<br/><p><b>Requirement:</b> ' . $req->note . '</p>'
                        . '<br/><br/><p><b>By:</b> ' . $req->user->name . '</p>';
                    $this->send_email($user->email, 'Lineshop New Customer Requirement', $message);

                    $sms = 'Hello ' . $user->name . '.'
                        . chr(10) . 'Your Requirement: ' . $new_req . '.'
                        . chr(10) . strip_tags($req->note)
                        . chr(10) . 'is received by Lineshop team. We will update you for any status about it. '
                        . ''
                        . chr(10) . 'Thanks and regards.';

                    $this->send_whatsapp_sms($user->phone, $sms);
                    $this->send_sms($user->phone, $sms, 1, null, 'lineshop');
                }
            }
            if ((int) request('to_user_id') > 0) {
                $user = \App\Models\User::find(request('to_user_id'));
                $module = DB::table('admin.modules')->where('id', request('module_id'))->first()->name;
                $new_req = isset($req->pharmacy->name) && (int) $req->pharmacy_id > 0 ? ' - from ' . $req->pharmacy->name . ' on ' . $module : ' - ' . $module;
                $message = 'Hello ' . $user->name . '<br/>'
                    . 'There is ' . $new_req . '</p>'
                    . '<br/><p><b>Requirement:</b> ' . $req->note . '</p>'
                    . '<br/><br/><p><b>By:</b> ' . $req->user->name . '</p>';
                $this->send_email($user->email, 'Lineshop New Customer Requirement', $message);

                $sms = 'Hello ' . $user->name . '.'
                    . chr(10) . 'There is ' . $new_req . '.'
                    . chr(10) . strip_tags($req->note)
                    . chr(10) . 'By: ' . $req->user->name . '.'
                    . chr(10) . 'Thanks and regards.';

                //                $url = 'https://www.pivotaltracker.com/services/v5/projects/2553591/stories';
                //
                //                $fields = [
                //                    "current_state" => request('current_state'),
                //                    "name" => 'Hello ' . $user->name . ' - ' . $new_req,
                //                    "estimate" => 1,
                //                    "story_type" => request("task_type"),
                //                    "requested_by_id" => request('requested_by_id'),
                //                    "story_priority" => request('priority'),
                //                    "token" => "c3c067a65948d99055ab1ac60891c174",
                //                    "description" => Auth::User()->name . ' - ' . strip_tags(request('note'))
                //                ];
                //                $story = new \App\Http\Controllers\General();
                //                $data1 = $story->post($url, $fields);

                $this->send_whatsapp_sms($user->phone, $sms);
                $this->send_sms($user->phone, $sms, 1, null, 'lineshop');
            }
            if (request('notify_to')) {
                $users_selected = request('notify_to');
                foreach ($users_selected as $key => $value) {
                    $notify_data = [
                        'user_id' => $value,
                        'task_id' => $req->id
                    ];
                    DB::table('admin.notify_tasks')->insert($notify_data);
                    $user = User::find($value);
                    $user_allocated = User::find(request('to_user_id'));
                    $module = DB::table('admin.modules')->where('id', request('module_id'))->first()->name;
                    $new_req = isset($req->pharmacy->name) && (int) $req->pharmacy_id > 0 ? ' - from ' . $req->pharmacy->name . ' on ' . $module : ' - ' . $module;
                    $message = 'Hello ' . $user->name . '<br/>'
                        . 'There is ' . $new_req . ' allocated to' . $user_allocated->name . ' </p>'
                        . '<br/><p><b>Requirement:</b> ' . $req->note . '</p>'
                        . '<br/><br/><p><b>By:</b> ' . $req->user->name . '</p>';
                    $this->send_email($user->email, 'Lineshop New Customer Requirement', $message);

                    $sms = 'Hello ' . $user->name . '.'
                        . chr(10) . 'There is ' . $new_req . ' allocated to ' . $user_allocated->name
                        . chr(10) . strip_tags($req->note)
                        . chr(10) . 'By: ' . $req->user->name . '.'
                        . chr(10) . 'Thanks and regards.';

                    //                    $url = 'https://www.pivotaltracker.com/services/v5/projects/2553591/stories';
                    //    
                    //                    $fields = [
                    //                        "current_state" => request('current_state'),
                    //                        "name" => 'Hello ' . $user->name . ' - ' . $new_req,
                    //                        "estimate" => 1,
                    //                        "story_type" => request("task_type"),
                    //                        "requested_by_id" => request('requested_by_id'),
                    //                        "story_priority" => request('priority'),
                    //                        "token" => "c3c067a65948d99055ab1ac60891c174",
                    //                        "description" => Auth::User()->name . ' - ' . strip_tags(request('note'))
                    //                    ];
                    //$story = new \App\Http\Controllers\General();
                    //$data1 = $story->post($url, $fields);

                    $this->send_whatsapp_sms($user->phone, $sms);
                    $this->send_sms($user->phone, $sms, 1, null, 'lineshop');
                }
            }
        }
        $this->data['requirements'] = \App\Models\LineshopRequirement::latest();
        return view('lineshop/products/analysis', $this->data);
    }
    public function training_request()
    {
        echo "training_request page under construction";
    }




    public function getWard()
    {
        $id = request()->segment(3);
        $districts = \App\Models\Ward::where('district_id', $id)->get();
        if (count($districts) > 0) {
            $select = '';
            foreach ($districts as $type) {
                $select .= '<option value="' . $type->id . '"> ' . $type->name . '</option>';
            }
            echo $select;
        }
    }
    public function getCLientPharmacy()
    {
        $sql = "SELECT A.id, upper(A.name) as name, CASE WHEN B.client_id is not null THEN 1 ELSE 0 END AS client FROM admin.pharmacies A JOIN admin.client_pharmacy B on A.id = B.pharmacy_id WHERE A.name ilike 
        '%" . request('term') . "%' LIMIT 10";
        die(json_encode(DB::select($sql)));
    }
    //communication
    public function communication(request $req)
    {
        $this->data['never_use'] = DB::table('admin.nmb_schools')->count();
        if ($_POST) {
            $this->validate(request(), [
                'message' => 'required'
            ]);
            $message = request("message");
            $prospectscriteria = request('prospectscriteria');
            $leadscriteria = request('leadscriteria');
            $firstCriteria = request('firstCriteria');
            $customer_criteria = request('customer_criteria');
            $customer_segment = request('customer_segment');
            $custom_numbers = request('custom_numbers');
            $criteria = request('less_than');
            $student_number = request('student_number');
            $file = request('file_');
            if ($custom_numbers !== NULL) {
                $numbers = explode(',', $custom_numbers);
                $this->sendCustomNumer($message, $numbers);
                return redirect()->back()->with('success', 'Message sent successfuly');
            }
            switch ($firstCriteria) {
                case 00:
                    //customers First
                    return $this->sendCustomSmsToCustomers($message, $customer_criteria, $criteria, $student_number, $customer_segment, $prospectscriteria = null, $leadscriteria = null);
                    break;
                case 01:
                    //Prospects: all schools never signup for shulesoft
                    $custom_numbers = DB::select('select distinct name,phone from admin.lineshop_contacts a where not exists  (select 1 from admin.lineshop_contacts b join admin.lineshop_clients c on c.id=b.client_id where c.status=1 and b.pharmacy_id=a.pharmacy_id) and phone is not null');

                    return $this->sendCustomSmsToProspects($message, $custom_numbers);
                    break;
                case 02:
                    //Leads: all schools sign for shulesoft but not customers
                    $custom_numbers = DB::select('select distinct name,phone,username from admin.lineshop_clients where status <>1');
                    return $this->sendCustomSmsToLeads($message, $custom_numbers);
                    break;
                case 03:
                    //All customers
                    return $this->sendCustomSmsToAll($message, $customer_criteria);
                    break;
                case 04:
                    // Not Custom selection
                    return $this->sendCustomSms($message);
                    break;
                default:
                    break;
            }
        }
        return view('lineshop.market.communication.index', $this->data);
    }
    public function sendCustomSmsToLeads($message, $custom_numbers)
    {
        $numbers = $custom_numbers;
        //        if (preg_match('/,/', $custom_numbers)) {
        //            $numbers = explode(',', $custom_numbers);
        //        } else if (preg_match('/ /', $custom_numbers)) {
        //            $numbers = explode(' ', $custom_numbers);
        //        } else {
        //            $numbers = [$custom_numbers];
        //        }
        $sent_to = 0;
        $wrong = 0;
        $invalid_numbers = '';
        $replacements = array('', '', '', '', '', '');

        // $sms = $this->getCleanSms($replacements, $message);

        foreach ($numbers as $number) {
            $valid = validate_phone($number->phone);
            if (is_array($valid)) {
                $sent_to++;
                $replacements = array(
                    $number->name, $number->username, $number->username
                );

                $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i', '/#username/i', '/#schema_name/i',
                ));
                $this->sendMessages($valid[1], $sms);
            } else {
                $wrong++;
                $invalid_numbers .= $number->phone . ',';
            }
        }
    }
    public function sendCustomNumer($message, $numbers)
    {

        $sent_to = 0;
        $wrong = 0;
        $invalid_numbers = '';
        $replacements = array('', '', '', '', '', '');

        foreach ($numbers as $number) {
            $valid = validate_phone($number);
            if (is_array($valid)) {
                $sent_to++;
                // $replacements = array(
                //     $number->name, $number->username, $number->username
                // );

                $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i', '/#username/i', '/#schema_name/i',
                ));
                $this->sendMessages($valid[1], $sms);
            } else {
                $wrong++;
                $invalid_numbers .= $number . ',';
            }
        }
    }

    public function sendCustomSmsToProspects($message, $custom_numbers)
    {
        $numbers = $custom_numbers;
        //        if (preg_match('/,/', $custom_numbers)) {
        //            $numbers = explode(',', $custom_numbers);
        //        } else if (preg_match('/ /', $custom_numbers)) {
        //            $numbers = explode(' ', $custom_numbers);
        //        } else {
        //            $numbers = [$custom_numbers];
        //        }
        $sent_to = 0;
        $wrong = 0;
        $invalid_numbers = '';

        //$replacements = array('', '', '', '', '', '');
        //$sms = $this->getCleanSms($replacements, $message);

        foreach ($numbers as $number) {
            $valid = validate_phone($number->phone);
            if (is_array($valid)) {
                $sent_to++;
                $replacements = array(
                    $number->name, '', ''
                );
                $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i', '/#username/i', '/#schema_name/i',
                ));
                $this->sendMessages($valid[1], $sms);
            } else {
                $wrong++;
                $invalid_numbers .= $number->phone . ',';
            }
        }
    }

    function getTemplateContent()
    {
        $id = (int) request('templateID');
        $template = DB::table('admin.lineshoptemplates')->where('id', $id)->first();
        return $template->message;
    }

    public function sendCustomSmsToCustomers($message, $customer_criteria, $criteria, $student_number, $customer_segment = null, $prospectscriteria = null, $leadscriteria = null)
    {

        // $dates = date('Y-m-d',strtotime('first day of January'));
        $dates = '2021-01-01';
        $customers = \DB::select("select * from admin.lineshop_clients where status=1");
        switch ($customer_criteria) {
            case 0:   //All customers (paid)
                //$customers = \DB::select("select * from admin.clients where id in (select client_id from admin.invoices where id in (select invoice_id from admin.payments where created_at::date > '" . $dates . "'))");

                break;
            case 1:
                //Active & Full paid customers
                //$customers = \DB::select("select a.client_id,a.name,a.username,a.remain_amount from (select i.client_id,i.reference,i.account_year_id,c.name,c.username,f.amount as total_amount,COALESCE(sum(p.amount),0) as paid_amount,f.amount - COALESCE(sum(p.amount),0) as remain_amount from admin.invoices i join admin.invoice_fees f on i.id = f.invoice_id join admin.payments p on p.invoice_id = i.id join admin.clients c on c.id = i.client_id group by i.reference,i.account_year_id,f.amount,c.name,i.client_id,c.username ) a where a.remain_amount = 0");
                break;
            case 2:
                //Active & partial paid customers
                //$customers = \DB::select("select a.client_id,a.name,a.username,a.total_amount,a.remain_amount from (select i.client_id,i.reference,i.account_year_id,c.name,c.username,f.amount as total_amount,COALESCE(sum(p.amount),0) as paid_amount,f.amount - COALESCE(sum(p.amount),0) as remain_amount from admin.invoices i join admin.invoice_fees f on i.id = f.invoice_id join admin.payments p on p.invoice_id = i.id join admin.clients c on c.id = i.client_id group by i.reference,i.account_year_id,f.amount,c.name,i.client_id,c.username ) a where a.remain_amount > 0");
                break;
            case 3:
                // Active but not paid customers (have S.I)
                // $customers = \DB::select("select a.client_id,a.phone,a.name,a.username,a.total_amount,a.paid_amount from (select i.client_id,i.reference,i.account_year_id,c.name,c.username,c.phone,f.amount as total_amount,
                //   COALESCE(sum(p.amount),0) as paid_amount,f.amount - COALESCE(sum(p.amount),0) as remain_amount from admin.invoices i join admin.invoice_fees f on i.id = f.invoice_id join admin.payments p on p.invoice_id = i.id join admin.clients c on c.id = i.client_id group by i.reference,i.account_year_id,f.amount,c.name,c.phone,i.client_id,c.username ) a 
                //      where a.paid_amount = 0 and a.client_id in (select client_id from admin.standing_orders)");
                break;
            case 4:
                // Not active & paid customers
                break;

            case 5:
                return $this->sendCustomSmsBySegment($message, $customer_segment, $criteria, $student_number);
                break;
            default:
                break;
        }
        if (isset($customers) && count($customers) > 0) {
            foreach ($customers as $customer) {
                $replacements = array(
                    $customer->name, $customer->username
                );
                $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i', '/#username/i', '/#schema_name/i',
                ));
                $this->sendMessages($customer->phone, $sms);
            }

            return redirect()->back()->with('success', 'Message sent successfuly');
        } else {
            return redirect()->back()->with('error', 'Message Failed to be sent');
        }
    }
    public function getCleanSms($replacements, $message, $pattern = null)
    {
        $sms = preg_replace($pattern != null ? $pattern : $this->patterns, $replacements, $message);
        if (preg_match('/#/', $sms)) {
            //try to replace that character
            return preg_replace('/\#[a-zA-Z]+/i', '', $sms);
        } else {
            return $sms;
        }
    }



    public function templates()
    {
        $type = request()->segment(3);
        $id = request()->segment(4);
        $this->data['mailandsmstemplates'] = DB::table('admin.lineshoptemplates')->orderBy('created_at', 'desc')->get();
        if ($type == 'delete') {
            DB::table('admin.lineshoptemplates')->where('id', $id)->delete();
            return redirect(base_url('lineshop/templates'))->with('success', 'Successful deleted!');
        } elseif ($type == 'edit') {
            $this->data['temp'] = DB::table('admin.lineshoptemplates')->where('id', (int) $id)->first();
            if ($_POST) {
                $data = ['type' => request('type'), 'name' => request('name'), 'message' => request('message')];
                DB::table('admin.lineshoptemplates')->where('id', $id)->update($data);
                return redirect(base_url('lineshop/templates'))->with('success', 'Successful Edited!');
            }
            return view('lineshop.market.communication.edittemplate', $this->data);
        } elseif ($type == 'view') {
            $this->data['temp'] = DB::table('admin.lineshoptemplates')->where('id', (int) $id)->first();
            return view('lineshop.market.communication.viewtemplate', $this->data);
        }
        return view('lineshop.market.communication.templates', $this->data);
    }

    public function addtemplate()
    {
        if ($_POST) {
            $validated = request()->validate([
                'name' => 'required|max:255',
                'message' => 'required',
            ]);
            // dd(request());
            $data = ['type' => request('type'), 'name' => request('name'), 'message' => request('message')];
            DB::table('admin.lineshoptemplates')->insert($data);
            return redirect(base_url('lineshop/templates'))->with('success', 'Successfully!');
        } else {
            return view('lineshop.market.communication.addtemplate');
        }
    }
    public function summary()
    {
        $this->data['summary'] = [];
        $this->data['whatsapp_sent_sms'] = DB::table('admin.whatsapp_messages')->where(['project' => 'lineshop'])->count();
        $this->data['whatsapp_sent_delivered'] = DB::table('admin.whatsapp_messages')->where(['status' => 1, 'project' => 'lineshop'])->count();
        $this->data['sms_sent'] = DB::table('public.sms')->where(['project' => 'lineshop'])->count();
        $this->data['pending_sms'] = DB::table('public.sms')->where(['status' => 0, 'project' => 'lineshop'])->count();
        $this->data['delevered_sms'] = DB::table('public.sms')->where(['status' => 1, 'project' => 'lineshop'])->count();
        $this->data['failed_sms'] = DB::table('public.sms')->where(['status' => 2, 'project' => 'lineshop'])->count();

        $this->data['sent_email'] = DB::table('public.email')->where(['status' => 1, 'project' => 'lineshop'])->count();
        $this->data['pending_email'] = DB::table('public.email')->where(['status' => 0, 'project' => 'lineshop'])->count();
        return view('lineshop.market.communication.summary', $this->data);
    }

    public function sendCustomSmsToAll($message, $customer_criteria)
    {
        return false;
        $customers = DB::select("select * from admin.all_users where \"table\" not in ('parent','setting','student') and status=1 and schema_name in (select username from admin.clients where status=1) and  usertype not in ('Student','Parent','Driver','Matron','Cooks','Cleaner','Secreatry','Conductor','Gardener','Normal','Nurse','Dormitory','Cook','Gatekeeper','Sanitation','Doctor','Attendant','Janitor','Security guard')");
        if (isset($customers) && count($customers) > 0) {
            foreach ($customers as $customer) {
                $replacements = array(
                    $customer->name, $customer->schema_name, $customer->schema_name
                );
                $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i', '/#schema_name/i', '/#username/i'
                ));
                $this->sendMessages($customer->phone, $sms);
            }
            return redirect()->back()->with('success', 'Message sent successfuly');
        } else {
            return redirect()->back()->with('error', 'Message Failed to be sent');
        }
    }

    public function sendCustomSms($message)
    {
        return false;
    }

    public function sendCustomSmsBySegment($message, $customer_segment, $criteria, $students_number)
    {
        return false;
        switch ($customer_segment) {
            case 00: //Nursey schools only 
                $segments = DB::select("select * from admin.all_classlevel where lower(name) = 'nursery' or lower(name) = 'nursery level'");
                break;
            case 01:
                //Primary schools
                $segments = DB::select("SELECT * FROM admin.all_classlevel WHERE lower(name) = 'primary' OR lower(name) = 'primary level'");
                break;
            case 02:
                //Secondary schools
                $segments = DB::select("SELECT * FROM admin.all_classlevel WHERE lower(name) = 'a-level' OR lower(name) = 'o-level' or lower(name) = 'secondary' or lower(result_format) = 'csee' or lower(result_format) = 'acsee'");
                break;
            case 03:
                // College only
                $segments = DB::select("SELECT * FROM admin.all_classlevel WHERE lower(result_format) = 'college' or lower(name) = 'nacte'");
                break;
            case 04:
                // Schools with student (greater than or less than)
                return $this->sendSmsByStudentNumber($message, $criteria, $students_number, $customer_segment);
                break;
            default:
                break;
        }

        if (isset($segments) && count($segments) > 0) {
            foreach ($segments as $segment) {
                $customer = \collect(\DB::select("select * from admin.all_setting where schema_name ='{$segment->schema_name}'"))->first();
                $replacements = array($customer->sname, $segment->schema_name);
                $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i', '/#schema_name/i', '/#username/i',
                ));
                $this->sendMessages($customer->phone, $sms);
            }
            return redirect()->back()->with('success', 'Message sent successfuly');
        } else {
            return redirect()->back()->with('error', 'Message Failed to be sent');
        }
    }
    public function sendMessages($phone, $message)
    {
        $channels = request('sms_channels');
        $phone = \collect(DB::select("select * from admin.format_phone_number('" . $phone . "')"))->first();
        $phonenumber = $phone->format_phone_number;

        if (in_array("quick-sms", $channels)) {
            // Send messages by quick sms
            $this->send_sms($phonenumber, $message, 1, null, 'lineshop');
        }

        if (in_array("whatsapp", $channels)) {
            $this->send_whatsapp_sms($phonenumber, $message, 'lineshop');
        }

        if (in_array("telegram", $channels)) {
            // Send messages by  Telegram
        }

        if (in_array("phone-sms", $channels)) {
            // Send messages by  normal sms
            $this->send_sms($phonenumber, $message, 1, null, 'lineshop');
        }

        if (in_array("email", $channels)) {
            // Send messages by Email
            $user = \collect(DB::select("select * from admin.all_users where phone = '" . $phonenumber . "' and status=1 and email not like '%@shulesoft.%'"))->first();
            if (isset($user) && !empty($user->email)) {
                $this->send_email($user->email, 'ShuleSoft', $message,  'lineshop');
            }
        }
    }
}
