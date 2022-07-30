<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechTransfer extends Model
{
    protected $table = 'tech_transfer';

    public function CompanyBasicInfo()
    {
        return $this->hasOne('App\CompanyBasicInfo', 'cid', 'cid');
    }
}
