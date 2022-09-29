<?php

namespace App\Exports;

use App\Models\Report;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportSearchExport implements FromView
{
    public function view(): View
    {
        $date_form = request()->input('date_form') ;
        $date_to = request()->input('date_to') ;

        return view('exports.reports', [
            'reports' => Report::whereBetween('created_at', [ $date_form, $date_to ] )->latest()->get()
        ]);
    }
}
