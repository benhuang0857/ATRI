<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyStatus extends Model
{
    protected $table = 'company_status';

    public function CompanyBasicInfo()
    {
        return $this->hasOne('App\CompanyBasicInfo', 'cid', 'cid');
    }
}
