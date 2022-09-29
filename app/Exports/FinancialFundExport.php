<?php

namespace App\Exports;

use App\Models\FinancialFund;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FinancialFundExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        return view('exports.funds', [
            'funds' => FinancialFund::whereDate('created_at', Carbon::today())->latest()->get()
        ]);
    }
}
