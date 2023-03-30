<?php
namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RequirementImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * */
    public function model(array $row)
    { 
        if(!empty($row)) {
           $user = \DB::table('admin.users')->where('name','ilike','%' . $row['to_user'] . '%')->first();
           $to_user_id = !empty($user) ? $user->id : \Auth::User()->id;

           $school = \DB::table('schools')->where('schema_name', $row['school'])->first();
           $school_id = !empty($school) ? $school->id : 0;
    
           $requirement_array = array( 
                'note'  => $row['note'],
                'priority' => $row['priority'],
                'user_id' => \Auth::User()->id,
                'contact' => $row['contact'],
                'to_user_id' => $to_user_id,
                'school_id' => $school_id,
                'status' => $row['status'] 
            );

          return new \App\Models\Requirement($requirement_array);
      }
   }
}

