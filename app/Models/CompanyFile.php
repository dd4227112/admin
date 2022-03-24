<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of ClientProject
 *
 * @author hp
 */
class CompanyFile extends Model {

    use \App\Traits\BelongsToUser;


    protected $table = 'company_files';
    protected $fillable = ['id', 'name', 'extenstion','user_id','size','caption','path', 'created_at', 'updated_at', 'note'];

}
