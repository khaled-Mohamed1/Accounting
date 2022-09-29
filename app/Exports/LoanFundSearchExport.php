<?php

namespace App\Exports;

use App\Models\LoanFund;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LoanFundSearchExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $date_form = request()->input('date_form') ;
        $date_to = request()->input('date_to') ;


        return view('exports.loanfunds', [
            'loans' => LoanFund::whereBetween('created_at', [ $date_form, $date_to ] )->latest()->get()
        ]);
    }
}
