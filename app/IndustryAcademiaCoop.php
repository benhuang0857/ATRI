<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustryAcademiaCoop extends Model
{
    protected $table = 'industry_academia_cooperation';

    public function CompanyBasicInfo()
    {
        return $this->hasOne('App\CompanyBasicInfo', 'cid', 'cid');
    }
}
