<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FosterList extends Model
{
    protected $table = 'foster_list';

    public function CompanyBasicInfo()
    {
        return $this->hasOne('App\CompanyBasicInfo', 'cid', 'cid');
    }
}
