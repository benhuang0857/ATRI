<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionInvest extends Model
{
    protected $table = 'addition_invest';

    public function CompanyBasicInfo()
    {
        return $this->hasOne('App\CompanyBasicInfo', 'cid', 'cid');
    }
}
