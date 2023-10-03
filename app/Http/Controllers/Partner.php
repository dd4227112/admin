<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;

class Partner extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * $type_id meaning
     * 1. CRDB
     * 2. Whatsapp
     * 3. VFD
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $type_id = $this->data['type_id'] = (int) request()->segment(3) == 0 ? 1 : request()->segment(3);
        $this->data['clients'] = \App\Models\Client::all();

        if (Auth::user()->department == 9 || Auth::user()->department == 10) {
            $this->data['refer_bank_id'] = $refer_bank_id = preg_match('/crdb/', Auth::user()->email) ? 8 : 22;
            $ids = [$refer_bank_id];

            $this->data['requests'] = \App\Models\IntegrationRequest::where('type_id', $type_id)->latest()->get();
        } else {
            $this->data['refer_bank_id'] = $refer_bank_id = '';
            $ids = [22, 8];
            $this->data['requests'] = \App\Models\IntegrationRequest::where('type_id', $type_id)->latest()->get();
        }
        $this->data['invoices'] = \App\Models\Invoice::whereIn('client_id', \App\Models\IntegrationRequest::whereIn('refer_bank_id', $ids)->get(['client_id']))->where('note', 'integration')->latest()->get();
        return view('partners.requests', $this->data);
    }

    public function show() {
        $id = request()->segment(3);
        $this->data['request'] = $request = \App\Models\IntegrationRequest::find($id);
        $this->data['comments'] = \App\Models\IntegrationRequestComment::where('integration_request_id', $id)->get();
        $school = DB::table('admin.schools')->where('schema_name', $request->client->username)->first();
        $this->data['school'] = !empty($school) ? \App\Models\SchoolContact::where('school_id', $school->id)->first() : [];
        $this->data['client'] = \App\Models\ClientSchool::where('client_id', $request->client_id)->first();
        return view('partners.view_request', $this->data);
    }

    public function add() {
        $id = request()->segment(3);
        $this->data['districts'] = \App\Models\District::get();
        if ((int) $id > 0) {
            $this->data['districts'] = \App\Models\District::get();
            $this->data['school'] = \App\Models\School::where('id', $id)->first();
            $this->data['contact'] = \App\Models\SchoolContact::where('school_id', $id)->first();
        } else {
            $this->data['school'] = null;
            $this->data['contact'] = null;
        }
        if ($_POST) {
            $refer_bank_id = preg_match('/nmb/', Auth::user()->email) ? 22 : 8;
            $code = rand(343, 32323) . time();
            if (!empty(request('ward'))) {
                $ward = \App\Models\Ward::find(request('ward'));
            }

            $username = request('username');
            $array = [
                'name' => strtoupper(request('school_name')),
                'region' => $ward->district->region->name,
                'district' => $ward->district->name,
                'ownership' => request('ownership'),
                'type' => request('type'),
                'students' => request('students'),
                'schema_name' => $username,
                'ward_id' => request('ward'),
                'ward' => $ward->name
            ];
            if ((int) $id < 1) {
                $check_school = DB::table('admin.schools')->where('name', strtoupper(request('school_name')))->where('schema_name', $username)->first();
                if (empty($check_school)) {
                    $school_id = DB::table('admin.schools')->insertGetId($array);
                    $school = \App\Models\School::where('id', $school_id)->first();
                } else {
                    $school = \App\Models\School::where('id', $check_school->id)->first();
                    $school_id = $school->id;
                }
            } else {
                $school = \App\Models\School::where('id', $id)->first();
                \App\Models\School::where('id', $id)->update($array);
                $school_id = $id;
            }
            $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            if (empty($school_contact)) {
                DB::table('admin.school_contacts')->insert([
                    'name' => request('fullname'), 'email' => request('email'), 'phone' => request('phone'), 'school_id' => $school_id, 'user_id' => Auth::user()->id, 'title' => request('title')
                ]);
                $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            } else {
                $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->update([
                    'name' => request('fullname'), 'email' => request('email'), 'phone' => request('phone'), 'school_id' => $school_id, 'user_id' => Auth::user()->id, 'title' => request('title')
                ]);
            }

            $schema_name = request('username') != '' ? strtolower(trim(request('username'))) : $username;
            $check_client = DB::table('admin.clients')->where('username', $schema_name)->first();
            if (!empty($check_client)) {
                $client_id = $check_client->id;
            } else {
                $price = preg_match('/crdb/', Auth::user()->email) ? 12000 : 10000;
                $client_id = DB::table('admin.clients')->insertGetId([
                    'name' => $school->name,
                    'address' => request('address'),
                    'phone' => $school_contact->phone,
                    'email' => $school_contact->email,
                    'estimated_students' => request('students'),
                    'status' => 3,
                    'code' => $code,
                    'email_verified' => 0,
                    'phone_verified' => 0,
                    'created_by' => Auth::user()->id,
                    'username' => $schema_name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'price_per_student' => $price,
                    'registration_number' => request('registration_number')
                ]);
                //add company file
                $check_contract = DB::table('admin.client_contracts')->where('client_id', $client_id)->first();
                if (empty($check_contract)) {
                    $file = request()->file('attachments')[0];
                    if (filesize($file) > 2015110) {
                        return redirect()->back()->with('error', 'File must have less than 2MBs');
                    }
                    $file_id = $this->saveFile($file, TRUE);
                    //save contract
                    $contract_id = DB::table('admin.contracts')->insertGetId([
                        'name' => 'ShuleSoft', 'company_file_id' => $file_id, 'start_date' => request('implementation_date'), 'end_date' => date('Y-m-d', strtotime('+1 years')), 'contract_type_id' => request('contract_type_id'), 'user_id' => Auth::user()->id
                    ]);
                    //client contracts
                    DB::table('admin.client_contracts')->insert([
                        'contract_id' => $contract_id, 'client_id' => $client_id
                    ]);
                }
                //client school
                DB::table('admin.client_schools')->insert([
                    'school_id' => $school_id, 'client_id' => $client_id
                ]);

                //client projects
                DB::table('admin.client_projects')->insert([
                    'project_id' => 1, 'client_id' => $client_id //default ShuleSoft project
                ]);
            }
            //Bank Accounts Intergration Details
            $check_req = DB::table('admin.integration_requests')->where('client_id', $client_id)->first();
            if (empty($check_req)) {
                $request_id = DB::table('admin.integration_requests')->insertGetId([
                    'client_id' => $client_id, 'user_id' => Auth::user()->id, 'refer_bank_id' => $refer_bank_id, 'schema_name' => $schema_name, 'bank_approved' => 0, 'shulesoft_approved' => 1, 'created_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                DB::table('admin.integration_requests')->where('client_id', $client_id)->update([
                    'user_id' => Auth::user()->id, 'refer_bank_id' => $refer_bank_id, 'schema_name' => $schema_name, 'bank_approved' => 0, 'shulesoft_approved' => 1, 'created_at' => date('Y-m-d H:i:s')
                ]);
                $request_id = $check_req->id;
            }

            //Bank Accounts Details
            DB::table('admin.bank_accounts_integrations')->insert([
                'number' => request('account_number'), 'branch' => request('branch_name'), 'account_name' => request('account_name'), 'refer_currency_id' => request('refer_currency_id'), 'opening_balance' => request('opening_balance'), 'integration_request_id' => $request_id, 'refer_bank_id' => $refer_bank_id
            ]);

            //Install School Levels 
            $levels = request('classlevel');
            if (!empty($levels)) {
                foreach ($levels as $level) {
                    $check_level = DB::table('admin.school_levels')->where('name', $level)->where('client_id', $client_id)->first();
                    if (empty($check_level)) {
                        DB::table('admin.school_levels')->insert([
                            'name' => $level, 'client_id' => $client_id, 'schema_name' => $username
                        ]);
                    }
                }
            }

            //post task, onboarded
            $data = ['user_id' => Auth::user()->id, 'school_id' => $school_id, 'activity' => 'Onboarding', 'task_type_id' => request('task_type_id'), 'user_id' => Auth::user()->id];
            $task = \App\Models\Task::create($data);
            DB::table('tasks_schools')->insert([
                'task_id' => $task->id,
                'school_id' => $school_id
            ]);

            //add company file

            $attachments = request()->file('attachments');
            foreach ($attachments as $file) {
                if (filesize($file) > 2015110) {
                    return redirect()->back()->with('error', 'File must have less than 2MBs');
                }
                $file_id = $this->saveFile($file, TRUE);
                // Integration requests documents
                DB::table('admin.integration_requests_documents')->insertGetId(['company_file_id' => $file_id, 'integration_request_id' => $request_id]);
            }

            //once a school has been installed, now create an invoice for this school or create a promo code
            // create an invoice for this school
            $check_booking = DB::table('admin.invoices')->where('client_id', $client_id)->first();
            if (!empty($check_booking)) {
                $booking = $check_booking;
            } else {

                $client = \App\Models\Client::find($client_id);
                $year = \App\Models\AccountYear::where('name', date('Y'))->first();
                $reference = time(); // to be changed for selcom ID
                //once we introduce packages (module pricing), we will just loop here for modules selected by specific user
                $months_remains = 12 - (int) date('m', strtotime($client->created_at)) + 1;
                $unit_price = $months_remains * $client->price_per_student / 12;
                $amount = $unit_price * $client->estimated_students;

                $invoice = \App\Models\Invoice::create(['reference' => $reference, 'client_id' => $client_id, 'date' => date('d M Y'), 'due_date' => date('d M Y', strtotime(' +30 day')), 'year' => date('Y'), 'user_id' => Auth::user()->id, 'account_year_id' => $year->id, 'amount' => $amount]);
                \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee', 'quantity' => $client->estimated_students, 'unit_price' => $unit_price]);
            }
            $request = \App\Models\IntegrationRequest::find($request_id);

            $key_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();

            //send onboarding message to customer directly
            $message = 'Dear ' . $key_contact->name . '. We’re delighted to receive your application for Electronic Payment System integrated with CRDB bank Plc,
            Enclosed here with it’s an invoice for the service which shall be covered for one year. 
           
            Please pay the total amount specified to commence using the service <br><br>
            Regards
            ShuleSoft Team
            Account and Finance Department
            epayment@shulesoft.com';
            $this->send_email($key_contact->email, 'Onboarding Request: School Electronic Payment Integration Request', $message);
            $this->send_email($request->user->email, 'School Onboarding: School Electronic Payment Integration Request', $message);
            $this->send_sms($key_contact->phone, $message, 1);
            $this->send_sms($request->user->phone, $message, 1);

            //Send Email to Shulesoft Team
            $shulesoft_email = 'You have new application request for [ ' . $request->banks->referBank->name . '] Electronic Payment Integration from [' . $request->client->username . ']. Please login in admin.shulesoft.com  for application review and verification
            <br>Thanks
            <br>ShuleSoft Support Team';
            $this->send_email('finance@shulesoft.com', 'School Onboarding: School Electronic Payment Integration Request', $shulesoft_email);

            return redirect('account/InvoiceView/' . $invoice->id);
            //return redirect('https://' . $username . '.shulesoft.com/istall/database/'.$username);
            // }
        }
        return view('partners.add_new', $this->data);
    }

    public function InvoicePrefix() {
        $id = request()->segment(3);
        $send = request()->segment(4);
        // DB::statement("select constant.create_invoice_prefix_trigger()");
        $partner = $this->data['partner'] = \App\Models\IntegrationRequest::find($id);
        if ($send != '') {
            $message = 'Dear ' . $partner->client->username . '
        ShuleSoft is pleased to inform you that, we have successfully finalized integration with CRDB Bank for enabling your school to commence receiving fees electronically.
        To start using service please login ' . $partner->client->username . '.shulesoft.com go to settings then system settings and click Payment Integration. .   
        Thanks';
            $this->send_email($partner->client->email, 'School Electronic Payment Integration Accepted', $message);
            $this->send_sms($partner->client->phone, $message, 1);
        }
        return view('partners.show_prefix', $this->data);
    }

    public function onboardSchool() {
        $id = request()->segment(3); //request id
        $partner = \App\Models\IntegrationRequest::find($id);
        if (request('refer_bank_id') == 22) {
            //only for NMB BANK

            $school_account = DB::table($partner->schema_name . '.bank_accounts_integrations')->where('id', $partner->bank_accounts_integration_id)->first();
            if (!empty($school_account)) {
                DB::table($partner->schema_name . '.bank_accounts_integrations')->where('id', $partner->bank_accounts_integration_id)->update([
                    'api_username' => request('username'), 'api_password' => request('password')
                ]);
                $partner->update(['bank_approved' => 1, 'approval_user_id' => Auth::user()->id]);
                //send confirmation email here to client
                $this->confirmationEmail($partner->client_id);
            }
        } else {
            $partner->update(['bank_approved' => 1, 'approval_user_id' => Auth::user()->id]);
            //just send a confirmation email here to client
            $this->confirmationEmail($partner->client_id);
            return redirect()->back()->with('success', 'Approved successfully');
        }
    }

    public function confirmationEmail($client_id) {
        $client = DB::table('clients')->where('id', $client_id)->first();
        $permission = DB::table('constant.permission')->where('name', 'nmb_getting_started')->first();
        $guide = DB::table('constant.guides')->where('permission_id', !empty($permission) ? $permission->id : 0)->first();
        $content = !empty($guide) ? $guide->content : 'Your Account has been successfully integrated with the bank. Kindly proceed to create invoices and parents will be able to pay via control number generated';
        $html = view('email.index', compact('content'))->render();
        $this->send_email($client->email, 'BANK Integration', $html);
    }

    public function viewFile() {
        $id = request()->segment(3);
        $this->data['path'] = \App\Models\CompanyFile::where('id', $id)->first();
        return view('partners.file_view', $this->data);
    }

    public function school() {
        $this->data['use_shulesoft'] = DB::table('admin.all_setting')->count() - 5;
        $this->data['school_types'] = DB::select("select type, count(*) from admin.schools where ownership='Non-Government' group by type,ownership");
        return view('partners.school_list', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function psms($client_id) {

        //create a trial code for this school
        $trial_code = $client_id . time();

        $client = DB::table('admin.clients')->where('id', $client_id);
        DB::table('admin.clients')->where('id', $client_id)->update(['code' => $trial_code]);
        $user = $client->first();
        $message = 'Hello ' . $user->name . '. Your Invoice Trial Code is ' . $trial_code;
        $this->send_sms($user->phone, $message, 1);
        $this->send_email($user->email, 'Success: School Onboarded Successfully', $message);

        $sql = "insert into public.sms (body,users_id,type,phone_number) select '{$message}',id,'0',phone from admin.all_users WHERE schema_name::text IN ($list_schema) AND usertype !='Student' {$in_array} AND phone is not NULL ";
        DB::statement($sql);

        return redirect('message/create');
    }

    public function RequestComment() {
        if ($_POST) {
            $request = \App\Models\IntegrationRequest::find(request('integration_request_id'));
            \App\Models\IntegrationRequestComment::create(request()->all());
            $message = 'Hello ' . $request->user->name . ' ' . request('comment') . '<br> By.  ' . Auth::user()->name;
            if (request('status') == 'Rejected') {
                $message = 'Dear ' . $request->user->name . ' <br> We are sorry to inform you that your application was rejected
             for ' . $request->banks->referBank->name . ' Electronic Payment Integration. Reason for rejection "<i> ' . request('comment') . '</i>". Please consider to amend that and try again by clicking this link [' . $request->client->username . '.shulesoft.com/setting/index#payment_intergration_settings]<br>
                <br>Thanks
                <br>ShuleSoft Support Team';
                $this->send_email($request->user->email, 'School Onboarding: School Electronic Payment Integration Rejected', $message);
            }
            $this->send_sms($request->user->phone, $message, 1);
            return redirect('Partner/show/' . request('integration_request_id'));
        } else {
            return redirect('Partner/index/');
        }
    }

    public function partners() {
        $id = request()->segment(3);
        if ((int) $id > 0) {
            $this->data['partners'] = \App\Models\PartnerBranch::where('partner_id', $id)->get();
            $this->data['school'] = 1;
        } else {
            $this->data['partners'] = \App\Models\Partner::all();
            $this->data['school'] = 2;
        }
        $this->data['set'] = (int) $id;
        return view('partners.index', $this->data);
    }

    public function partnerStaff() {
        $id = request()->segment(3);
        if ((int) $id > 0) {
            $this->data['staffs'] = \App\Models\PartnerUser::where('branch_id', $id)->get();
            $this->data['branch'] = \App\Models\PartnerBranch::find($id);
        } else {
            $this->data['staffs'] = \App\Models\PartnerUser::whereIn('branch_id', \App\Models\PartnerBranch::where('partner_id', $id)->get(['partner_id']))->get();
        }
        $this->data['set'] = $id;
        return view('partners.staffs', $this->data);
    }

    public function addStaff() {
        if ($_POST) {
            //dd(request('position'));
            $name = request('firstname') . ' ' . request('lastname');
            $user = \App\Models\User::create(array_merge(request()->all(), ['password' => bcrypt(request('email')), 'name' => $name, 'phone' => request('phone'), 'role_id' => 7, 'department' => 10, 'created_by' => Auth::user()->id, 'status' => 1]));
            $partner = \App\Models\PartnerUser::create(['user_id' => $user->id, 'branch_id' => request('branch_id')]);

            $message = "Habari " . $name . ", umeunganishwa katika ShuleSoft Admin Panel (admin.shulesoft.com) na nenotumizi: " . request('email') . " na Password: " . request('email') . " . Tafadhali kumbuka kubadili Password yako pindi utakapoingia.";
            $phonenumber = request('phone_number');
            $sql = "insert into public.sms (body,user_id, type,phone_number) values ('$message', 1, '0', '$phonenumber')";
            DB::statement($sql);
            return redirect('partner/partnerStaff/' . request('branch_id'))->with('success', $name . ' Added successfully');
        }
    }

    public function partnerSchool() {
        $id = request()->segment(3);
        $branch = request()->segment(4);
        if ((int) $id > 0 && $branch == '') {
            $this->data['schools'] = \App\Models\PartnerSchool::whereIn('branch_id', \App\Models\PartnerBranch::where('partner_id', $id)->get(['id']))->get();
        }
        if ((int) $id > 0 && $branch != '') {
            $this->data['schools'] = \App\Models\PartnerSchool::where('branch_id', $id)->get();
            $this->data['branch'] = \App\Models\PartnerBranch::where('id', $id)->first();
        }
        $this->data['set'] = $id;
        return view('partners.schools', $this->data);
    }

    public function addPartner() {
        $this->data['countries'] = \App\Models\Country::all();
        $id = request()->segment(3);
        if ((int) $id > 0) {
            $this->data['partner'] = $partner = \App\Models\Partner::find($id);
            $this->data['regions'] = \App\Models\Region::where('country_id', $partner->country_id)->get();
            if ($_POST) {

                $partner = \App\Models\PartnerBranch::create(array_merge(request()->all(), ['partner_id' => $id, 'status' => 1]));
                $user = new User(array_merge(request()->all(), ['password' => bcrypt(request('email')), 'firstname' => request('name'), 'phone' => request('phone_number'), 'role_id' => 7, 'department' => 10, 'created_by' => Auth::user()->id]));
                $user->save();
                $message = "Habari " . request('name') . ", umeunganishwa katika ShuleSoft Admin Panel (admin.shulesoft.com) na nenotumizi: " . request('email') . " na Password: " . request('email') . " . Tafadhali kumbuka kubadili Password yako pindi utakapoingia.";
                $phonenumber = request('phone_number');
                $sql = "insert into public.sms (body,user_id, type,phone_number) values ('$message', 1, '0', '$phonenumber')";
                DB::statement($sql);
                return redirect('Partner/partners')->with('success', 'Branch ' . $partner->name . ' created successfully');
            }
            return view('partners.add_branch', $this->data);
        } else {
            if ($_POST) {
                $partner = \App\Models\Partner::create(request()->all());
                $user = new User(array_merge(request()->all(), ['password' => bcrypt(request('email')), 'firstname' => request('name'), 'phone' => request('phone_number'), 'role_id' => 7, 'department' => 10, 'created_by' => Auth::user()->id]));
                $user->save();
                $this->sendEmailAndSms($partner);
                return redirect('Partner/partners')->with('success', 'Partner ' . $partner->name . ' created successfully');
            }
            return view('partners.add', $this->data);
        }
    }

    public function addSchool() {
        $id = request()->segment(3);
        $this->data['partner'] = $partner = \App\Models\Partner::find($id);
        $this->data['regions'] = \App\Models\Region::where('country_id', $partner->country_id)->get();
        if ($_POST) {
            $school = \App\Models\PartnerSchool::create(array_merge(request()->all(), ['status' => 1]));
            return redirect('Partner/partnerSchool/' . $school->branch_id . '/branch')->with('success', 'School ' . $school->school->name . ' added successfully');
        }
        return view('partners.add_school', $this->data);
    }

    public function addPartnerService() {

        $this->data['clients'] = $partner = \App\Models\Client::all();
        if ($_POST) {
            $client_id = request('client_id');
            $client = \App\Models\Client::find($client_id);
            //If its a new version, then schema needs to be shulesoft
            $schema = (int) $client->is_new_version == 1 ? 'shulesoft' : $client->username;

            //if its an old version, then separate by settingID
            $column = (int) $client->is_new_version == 1 ? 'schema_name' : 'settingID';

            //for old version, default settingID is 1
            $column_value = (int) $client->is_new_version == 1 ? $client->username : 1;

            $this->validate(request(), [
                'tin' => 'required',
                'tin_certificate' => 'required',
                'id_certificate' => 'required',
                'application_letter' => 'required'
            ]);
            $setting_object = [
                "income_tax" => request('income_tax'),
                "vfd_enabled" => 1, // vfd enabled set to 1 means vfd will be enabled as the user insert a vfd integration request
                "tin" => request('tin'),
                "vrn" => request('vrn'),
                "tax_group" => request('tax_group')
            ];

            DB::table($schema . '.setting')->where($column, $column_value)->update($setting_object);

            $this->data['bank_id'] = $bank_id = DB::table($schema . '.bank_accounts')->first()->id;
            if ($schema == 'shulesoft') {
                $integration = DB::table($schema . '.bank_accounts_integrations')->where('schema_name', $client->username)->first();
            } else {
                $integration = DB::table($schema . '.bank_accounts_integrations')->first();
            }

            $bank_accounts_integration_id = !empty($integration) ? $integration->id : DB::table('shulesoft.bank_accounts_integrations')->first()->id; // if empty $integration pick any from shulesoft bank_accounts_integrations to preventing inserting null value (not recommended approach)

            $object = array(
                'client_id' => $client->id,
                'refer_bank_id' => 22,
                'bank_account_id' => $bank_id,
                'user_id' => Auth::User()->id,
                "table" => 'users',
                'bank_accounts_integration_id' => $bank_accounts_integration_id,
                'schema_name' => $schema,
                'type_id' => 1, // Fixed to 1 for VFD Integration request 
            );
            $int = DB::table('admin.integration_requests')
                            ->where('type_id', 1) // 1 for vfd 
                            ->where('client_id', $client->id)->first();

            if (empty($int)) {
                $integration_request_id = DB::table('admin.integration_requests')->insertGetId($object);
            } else {
                $integration_request_id = $int->id;
            }
            $this->uploadVfdFile('tin_certificate', $integration_request_id);
            !empty(request('vrn_certificate')) ?
                            $this->uploadVfdFile('vrn_certificate', $integration_request_id) : '';
            $this->uploadVfdFile('id_certificate', $integration_request_id);
            $this->uploadVfdFile('application_letter', $integration_request_id);

            $message = 'Dear ' . $client->name . ' 
We are glad to inform you that your application was successfully submitted for  TRA Virtual EFD  Integration. Your application is on verification stage.
We shall let you know once we have done with verification, then you can proceed with  integration services. ';
            $this->send_sms($client->phone, $message);
            $this->send_email($client->email, 'VFD Application Status', $message);
            return redirect('Partner/index/1')->with('success', 'success');
        }
        return view('partners.add_partner_service', $this->data);
    }

    public function uploadVfdFile($key, $integration_request_id) {
        //attach any file to this requests
        $file = request($key);
        // print_r($file);
        $url = 'attach_' . time() . rand(11, 8894) . '.' . $file->guessExtension();
        $url = base_url('storage/uploads/images/' . $url);
        $filePath = base_path() . '/storage/uploads/images/';
        $file->move($filePath, $url);

        //invoice
        $files_data = [
            'name' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'user_id' => Auth::user()->id,
            // 'size' => $file->getSize(),
            'caption' => $file->getRealPath(),
            'path' => $url
        ];
        $company_file_id = DB::table('admin.company_files')->insertGetId($files_data);

        $object = [
            'refer_bank_id' => 22,
            'company_file_id' => $company_file_id,
            'created_by' => session('id'),
        ];
        $integration_bank_document_id = DB::table('admin.integration_bank_documents')
                ->insertGetId($object);

        DB::table('admin.integration_requests_documents')->insert([
            'integration_request_id' => $integration_request_id,
            'integration_bank_document_id' => $integration_bank_document_id,
            'company_file_id' => $company_file_id,
            'path' => $url
        ]);
    }

    public function deletepPartner() {
        $id = request()->segment(3);
        if ((int) $id > 0) {
            $partner = \App\Models\Partner::where('id', $id)->first();
            \App\Models\PartnerBranch::where('partner_id', $id)->delete();
            //\App\Models\User::where('name', $partner->name)->delete();
            \App\Models\Partner::where('id', $id)->delete();
        }
        return redirect('Partner/partners')->with('success', $partner->name . ' Deleted successfully');
    }

    public function invoiceView() {
        $invoice_id = request()->segment(3);
        $set = $this->data['set'] = 1;
        if ((int) $invoice_id > 0) {
            $request_control = request()->segment(4);
            if ((int) $request_control > 0) {
                $this->createSelcomControlNumber($invoice_id);
                return redirect()->back()->with('success', 'success');
            }
            $this->data['invoice'] = $this->data['booking'] = \App\Models\Invoice::find($invoice_id);
            return redirect('epayment/i/' . $invoice_id);
        }
    }

// This method only create selcom booking ID, we don't detect errors due to its
    //sensitivity but in the future, we can add error control in case of anything
    public function createSelcomControlNumber($invoice_id) {
        $invoice = \App\Models\Invoice::find($invoice_id);
        $amount = $invoice->invoiceFees()->sum('amount');
        $order_id = rand(454, 4557) . time();
        if (strlen($invoice->token) < 4) {

            $phone_number = validate_phone_number($invoice->client->phone);
            if (is_array($phone_number)) {
                $phone = str_replace('+', null, validate_phone_number($invoice->client->phone)[1]);
            } else {
                $phone = '255754406004';
            }
            $order = array("order_id" => $order_id, "amount" => $amount,
                'buyer_name' => $invoice->client->name, 'buyer_phone' => $phone, 'end_point' => '/checkout/create-order', 'action' => 'createOrder', 'client_id' => $invoice->client_id, 'source' => $invoice->client_id);
            $this->curlPrivate($order);
        }
        return TRUE;
    }

    private function verifyVfdIntegration() {
        $req_id = request()->segment(3);
        $request = \App\Models\IntegrationRequest::find(request('integration_request_id'));
        $client = DB::table('admin.clients')->where('username', $request->schema_name)->first();

        //If its a new version, then schema needs to be shulesoft
        $schema = (int) $client->is_new_version == 1 ? 'shulesoft' : $request->schema_name;

        //if its an old version, then separate by settingID
        $column = (int) $client->is_new_version == 1 ? 'schema_name' : 'settingID';

        //for old version, default settingID is 1
        $column_value = (int) $client->is_new_version == 1 ? $request->schema_name : 1;

        DB::table($schema . '.setting')
                ->where($column, $column_value)
                ->update([
                    'vfd_serial_number' => request('vfd_serial_number'),
                    'vfd_password' => request('vfd_password'),
                    'vfd_approved' => 1
        ]);
        $request->update(['bank_approved' => 1, 'shulesoft_approved' => 1, 'approval_user_id' => Auth::User()->id]);
        $setting = DB::table($schema . '.setting')
                        ->where($column, $column_value)->first();
        $message = 'Hello ' . $setting->sname . ', Your VFD application  approved successfully. Now each payment you receive '
                . 'will automatically generate a VFD receipt';

        $email_message = 'Dear ' . $setting->sname . ' 
                    Your application for VFD receipt is approved successfully.
              . Now each payment you receive  will automatically generate a VFD receipt<br>
                <br>Thanks
                <br>ShuleSoft Support Team';
        $this->send_email($setting->email, 'School Onboarding: VFD application is successfully', $email_message);
        $this->send_sms($setting->phone, $message, 1);
    }

    public function VerifyPayment() {
        $req_id = request()->segment(3);
        if ((int) $req_id > 0) {
            $request = \App\Models\IntegrationRequest::where('id', $req_id)->update(['shulesoft_approved' => 1, 'approval_user_id' => Auth::User()->id]);
            return redirect('Partner/show/' . $req_id)->with('success', 'Request Approved.!!');
        }
        if ($_POST) {
            if (request('vfd_serial_number') != '') {
                $this->verifyVfdIntegration();
                return redirect('Partner/index/3')->with('success', 'Request Approved successfully');
            } else {
                $request = \App\Models\IntegrationRequest::find(request('integration_request_id'));
                $reference = request('reference');
                $invoice = \App\Models\Invoice::where('reference', $reference)->first();
                if (!empty($invoice)) {
                    $payments = \App\Models\Payment::where('invoice_id', $invoice->id)->first();
                    $file = request()->file('standing_order');
                    $contract_id = 0;
                    if ($file) {
                        if (filesize($file) > 2015110) {
                            return redirect()->back()->with('error', 'File must have less than 2MBs');
                        }
                        $file_id = $this->saveFile($file, TRUE);
                        //save contract
                        $contract_id = DB::table('admin.contracts')->insertGetId([
                            'name' => $request->client->name . ' Standing Order', 'company_file_id' => $file_id, 'start_date' => date('Y-m-d'), 'end_date' => date("Y-m-d", strtotime('1 year')), 'contract_type_id' => 2, 'user_id' => Auth::user()->id, 'note' => $request->client->name . ' Standing Order'
                        ]);
                        //client contracts
                        DB::table('admin.client_contracts')->insert([
                            'contract_id' => $contract_id, 'client_id' => $request->client_id
                        ]);
                    }
                    if ($contract_id > 0 || $payments) {
                        $request->update(['bank_approved' => 1, 'shulesoft_approved' => 1, 'approval_user_id' => Auth::User()->id]);
                        return redirect('Partner/show/' . request('integration_request_id'))->with('success', 'Payment accepted.!!');
                    } else {
                        return redirect('Partner/show/' . request('integration_request_id'))->with('error', 'Payment not accepted. Your Reference Number Does Not Match any of Recorded Payments, Try Again!!');
                    }
                } else {
                    $msg = 'Your Reference Number Does Not Match any of Recorded Payments, Try Again!! <br> Click Approve Without Payment, <a href="' . url('partner/VerifyPayment/' . request('integration_request_id')) . '"> click here  </a>  to approve';
                    return redirect('Partner/show/' . request('integration_request_id'))->with('error', $msg);
                }
            }
        } else {
            return redirect('Partner/index/');
        }
    }

    public function transactions() {
        
        $this->data['bank_accounts'] = DB::table('admin.all_bank_accounts_integrations')->whereRaw('UPPER(invoice_prefix) LIKE ?', ['%SASA%'])->get();
        $this->data['from_date'] = $from = request('from_date') != '' ? request('from_date') : date("Y-m-d", strtotime('-10 day'));
        $this->data['to_date'] = $to = request('to_date') != '' ? request('to_date') : date("Y-m-d");
        $reference = request('invoice_prefix') != '' ? 'PAYMENTREFERENCE":"' . request('invoice_prefix') : 'PAYMENTREFERENCE":"SASA80';
        $this->data['payments'] = DB::table('api.requests')
                        ->select('content')->whereBetween('created_at', [$from, $to])->whereRaw('UPPER(content) LIKE ?', ['%' . strtoupper($reference) . '%'])
                        ->groupBy('content')->get();
        $p=$this->data['invoice_prefix'] = request('invoice_prefix');
        $old_version_request = \collect(DB::select("select * from admin.all_bank_accounts_integrations a where upper(a.invoice_prefix) LIKE '%".$p."%' and exists (select 1 from admin.clients where is_new_version<>1 and username=a.schema_name)"))->first();
        $this->data['is_new_version'] = empty($old_version_request) ? 1 : 0;

        
        return view('partners.payments', $this->data);
    }

    public function nmbTransactions() {
        
        $this->data['bank_accounts'] = DB::table('admin.all_bank_accounts_integrations')->whereRaw('UPPER(invoice_prefix) LIKE ?', ['%SAS%'])->get();
        $this->data['from_date'] = $from = request('from_date') != '' ? request('from_date') : date("Y-m-d", strtotime('-10 day'));
        $this->data['to_date'] = $to = request('to_date') != '' ? request('to_date') : date("Y-m-d");
        $reference = request('invoice_prefix') != '' ? request('invoice_prefix') :'SAS';
        $this->data['payments'] = DB::table('api.requests')
                        ->select('content')->whereBetween('created_at', [$from, $to])->whereRaw('UPPER(content) LIKE ?', ['%' . strtoupper($reference) . '%'])->whereRaw('UPPER(content) NOT LIKE ?', ['%SASA%'])->whereRaw('content LIKE ?', ['%customer_name%'])
                        ->groupBy('content')->get();
        $p=$this->data['invoice_prefix'] = request('invoice_prefix');
        $old_version_request = \collect(DB::select("select * from admin.all_bank_accounts_integrations a where upper(a.invoice_prefix) LIKE '%".$p."%' and exists (select 1 from admin.clients where is_new_version<>1 and username=a.schema_name)"))->first();
        $this->data['is_new_version'] = empty($old_version_request) ? 1 : 0;

        
        return view('partners.nmb_payments', $this->data);
    }

    public function pushPayment() {
        $background = new \App\Http\Controllers\Background();
        $url = 'http://75.119.140.177:8081/api/init';
        $fields = json_decode(urldecode(request('data')));
        $curl = $background->curlServer($fields, $url, 'row');
        return $curl;
    }

    public function pushPaymentd() {
        $url = 'http://75.119.140.177:8081/api/init';
        $myvars = request('data');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        echo isset(json_decode($response)->description) ? json_decode($response)->description . ' - ' . json_decode($response)->reference : json_decode($response)->description;
    }

    public function addAddonsPayment() {
        $amount = request('amount');
        $client_id = request('school_id');
        $addon_id = request('addon_id');
        $method = request('method');
        $note = request('note');

        $tansaction_id = strtoupper(md5(date('Y-m-d:H:i:s')));
        $payment = [
            'amount' => $amount,
            'method' => $method,
            'transaction_id' => $tansaction_id,
            'client_id' => $client_id,
            'note' => $note,
        ];
        $payment_id = DB::table('admin.payments')->insertGetId($payment);
        $quantity = $amount / 20;
        $addon_payment = [
            'payment_id' => $payment_id,
            'addon_id' => $addon_id,
            'client_id' => $client_id,
            'quantity' => $quantity
        ];
        if (DB::table('admin.addons_payments')->insert($addon_payment)) {
            //check if client is already subscribed
            $check = DB::table('admin.sms_balance')->where('client_id', $client_id)->first();
            if (!empty($check)) {
                DB::select('update admin.sms_balance set balance =balance+' . $quantity . ' where client_id =' . $client_id);
            } else {
                DB::table('admin.sms_balance')->insert(['client_id' => $client_id, 'balance' => $quantity]);
            }
        }
        return redirect()->back()->with('success', "Payment received successfully");
        // Add code to send notification sms/email to payer
    }

    // download sample vfd application letter
    public function downloadSample() {
        $samplefile = storage_path('uploads/images/sample.pdf'); // Upload the actual sample pdf file named sample
        return response()->download($samplefile);
    }

}
