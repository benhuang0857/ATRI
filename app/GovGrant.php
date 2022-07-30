<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GovGrant extends Model
{
    protected $table = 'gov_grant';

    public function CompanyBasicInfo()
    {
        return $this->hasOne('App\CompanyBasicInfo', 'cid', 'cid');
    }
}
