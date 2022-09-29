<?php

namespace App\Exports;

use App\Models\FinancialFund;
use App\Models\LoanFund;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LoanFundExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        return view('exports.loanfunds', [
            'loans' => LoanFund::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))->latest()->get()
        ]);
    }
}
