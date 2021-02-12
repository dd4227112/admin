<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Reminder extends Controller {

    /**
     * Check which modules are not used by a certain user and ensure you remind them to use those modules
     * 
     * 1. Check if no marks has been entered
     * 2. check if no exams has been defined
     * 3. check any pending promotion for the next year
     * 4. check if there is no payment received
     * 5. check if there is there is not attendance
     * 
     */
    
    
    /**
     * One month login, for admin, teachers, parents, and staff members
     */
    public function usageReminder() {
        //admin
        $admins=DB::select("select * from admin.all_users a where lower(a.usertype)='admin' and a.id NOT IN (select user_id from admin.all_log where usertype='admin' and schema_name=a.schema_name)");
    }

    public function markReminder() {
        
    }

    public function promotionReminder() {
        
    }

    public function receivePaymentReminder() {
        
    }

    public function attendanceUsageReminder() {
        
    }

    public function functionName() {
        
    }

}
