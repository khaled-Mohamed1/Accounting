<?php

namespace App\Exports;

use App\Models\FinancialFund;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FinancialFundSearchExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        $date_form = request()->input('date_form') ;
        $date_to = request()->input('date_to') ;


        return view('exports.funds', [
            'funds' => FinancialFund::whereBetween('created_at', [ $date_form, $date_to ] )->latest()->get()
        ]);
    }
}
