<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionRevenue extends Model
{
    protected $table = 'addition_revenue';

    public function CompanyBasicInfo()
    {
        return $this->hasOne('App\CompanyBasicInfo', 'cid', 'cid');
    }
}
