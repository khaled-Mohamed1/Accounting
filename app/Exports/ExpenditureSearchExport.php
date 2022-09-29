<?php

namespace App\Exports;

use App\Models\Expenditure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExpenditureSearchExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $date_form = request()->input('date_form') ;
        $date_to = request()->input('date_to') ;


        return view('exports.expenditures', [
            'expenditures' => Expenditure::whereBetween('created_at', [ $date_form, $date_to ] )->latest()->get()
        ]);
    }
}
