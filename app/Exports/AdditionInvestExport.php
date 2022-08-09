<?php

namespace App\Exports;

use App\AdditionInvest;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdditionInvestExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AdditionInvest::all();
    }
}
