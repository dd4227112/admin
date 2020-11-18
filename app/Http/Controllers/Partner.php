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
     * @return \Illuminate\Http\Response
     */
    public function index() {
    if (Auth::user()->department == 9 ||  Auth::user()->department == 10) {
        $this->data['refer_bank_id'] = $refer_bank_id =  preg_match('/crdb/', Auth::user()->email) ? 8 : 22;
        $this->data['requests'] = \App\Models\IntegrationRequest::where('refer_bank_id', $this->data['refer_bank_id'])->get();
        }else{
            $this->data['refer_bank_id'] = $refer_bank_id =  '';
            $this->data['requests'] = \App\Models\IntegrationRequest::get();
        }
        $this->data['invoices'] = \App\Models\Invoice::whereIn('client_id', \App\Models\IntegrationRequest::get(['client_id']))->get();
        return view('partners.requests', $this->data);
    }

    public function show() {
        $id = request()->segment(3);
        $this->data['request'] = $request = \App\Models\IntegrationRequest::find($id);
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
            }

            $schema_name = request('username') != '' ? strtolower(trim(request('username'))) : $username;
            $check_client = DB::table('admin.clients')->where('username', $schema_name)->first();
            if (!empty($check_client)) {
                $client_id = $check_client->id;
            } else {
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
                    'price_per_student' => 12000,
                    'registration_number' => request('registration_number')
                ]);
                //add company file
                $check_contract = DB::table('admin.client_contracts')->where('client_id', $client_id)->first();
                if (empty($check_contract)) {
                    $file = request()->file('attachments')[0];
                    $file_id = $this->saveFile($file, 'company/contracts');
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
                    'client_id' => $client_id, 'user_id' => Auth::user()->id, 'refer_bank_id' => 8, 'schema_name' => $schema_name, 'bank_approved' => 0, 'shulesoft_approved' => 1, 'created_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $request_id = $check_req->id;
            }

            //Bank Accounts Details
            DB::table('admin.bank_accounts_integrations')->insert([
                'number' => request('account_number'), 'branch' => request('branch_name'), 'account_name' => request('account_name'), 'refer_currency_id' => request('refer_currency_id'), 'opening_balance' => request('opening_balance'), 'integration_request_id' => $request_id, 'refer_bank_id' => 8
            ]);

            //Install School Levels
            $levels = request('classlevel');
            if (!empty($levels)) {
                foreach ($levels as $level) {
                    DB::table('admin.school_levels')->insert([
                        'name' => $level, 'client_id' => $client_id, 'schema_name' => $username
                    ]);
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
                $file_id = $this->saveFile($file, 'company/contracts');
                // Integration requests documents

                $bank_file_id = DB::table('admin.integration_bank_documents')->insertGetId([
                    'refer_bank_id' => 8, 'company_file_id' => $file_id, 'created_by' => Auth::user()->id
                ]);

                DB::table('admin.integration_requests_documents')->insertGetId(['integration_bank_document_id' => $bank_file_id, 'integration_request_id' => $request_id]);
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
                $invoice = \App\Models\Invoice::create(['reference' => $reference, 'client_id' => $client_id, 'date' => date('d M Y'), 'due_date' => date('d M Y', strtotime(' +30 day')), 'year' => date('Y'), 'user_id' => Auth::user()->id, 'account_year_id' => $year->id]);
                //once we introduce packages (module pricing), we will just loop here for modules selected by specific user

                $months_remains = 12 - (int) date('m', strtotime($client->created_at)) + 1;
                $unit_price = $months_remains * $client->price_per_student / 12;
                $amount = $unit_price * $client->estimated_students;

                \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee', 'quantity' => $client->estimated_students, 'unit_price' => $unit_price]);
            }

            //send onboarding message to customer directly
            return redirect('account/InvoiceView/' . $invoice->id);
            //return redirect('https://' . $username . '.shulesoft.com/istall/database/'.$username);
            // }
        }
        return view('partners.add_new', $this->data);
    }

    public function InvoicePrefix() {
        $id = request()->segment(3);
        // DB::statement("select constant.create_invoice_prefix_trigger()");
        $partner = $this->data['partner'] = \App\Models\IntegrationRequest::find($id);
        //$this->data['integration'] = $bankAccountIntegration = DB::table($partner->schema_name . '.bank_accounts_integrations')->where('id', $partner->bank_accounts_integration_id)->first();
        //$this->data['bank'] = DB::table($partner->schema_name . '.bank_accounts')->where('id', $bankAccountIntegration->bank_account_id)->first();
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
                //dd(request()->all());
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

}
