<?php
namespace App\Imports;
use App\Models\PhoneCall;
use Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PhoneCall_Import implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * */
    public function model(array $row)
    {
    //    dd($row);
        return new PhoneCall([
            'full_name'  => $row['name'],
            'call_detail' => $row['call_detail'],
            'phone_number' => $row['phone_number'],
            'call_type' => $row['call_type'],
            'call_time' => date("Y-m-d H:i:s", strtotime($row['call_time'])),
            'next_followup' => date("H:i:s"),
            'call_duration' => $row['duration'],
            'followup_date' => $row['next_followup'],
            'location' => $row['location'],
            'email' => $row['email'],
            'user_id' => Auth::User()->id
        ]);
    }
}

