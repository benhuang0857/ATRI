<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionStaff extends Model
{
    protected $table = 'addition_staff';

    public function CompanyBasicInfo()
    {
        return $this->hasOne('App\CompanyBasicInfo', 'cid', 'cid');
    }
}
