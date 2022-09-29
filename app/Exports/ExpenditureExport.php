<?php

namespace App\Exports;

use App\Models\Expenditure;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExpenditureExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.expenditures', [
            'expenditures' => Expenditure::whereDate('created_at', Carbon::today())->latest()->get()
        ]);
    }
}
