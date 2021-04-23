<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandingOrder extends Model
{
    protected $table = 'standing_orders';

    protected $fillable = ['client_id', 'branch_id', 'company_file_id','school_contact_id','user_id',
    'occurrence','basis','total_amount','occurance_amount','date','status','created_at','updated_at'];

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function branch() {
        return $this->belongsTo(\App\Models\PartnerBranch::class, 'branch_id', 'id');
    }

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id');
    }

    public function schoolcontact() {
        return $this->belongsTo(\App\Models\SchoolContact::class,'school_contact_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }


}