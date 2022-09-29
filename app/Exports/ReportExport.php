<?php

namespace App\Exports;

use App\Models\Report;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    public function view(): View
    {

        return view('exports.reports', [
            'reports' => Report::whereDate('created_at', Carbon::today())->latest()->get()
        ]);
    }
}
