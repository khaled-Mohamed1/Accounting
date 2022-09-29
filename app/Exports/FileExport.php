<?php

namespace App\Exports;

use App\Models\File;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FileExport implements FromView
{
    public function view(): View
    {
        return view('exports.files', [
            'files' => File::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))->latest()->get()
        ]);
    }
}
