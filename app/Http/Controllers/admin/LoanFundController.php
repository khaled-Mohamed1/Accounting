<?php

namespace App\Http\Controllers\admin;

use App\Exports\FinancialFundExport;
use App\Exports\FinancialFundSearchExport;
use App\Exports\LoanFundExport;
use App\Exports\LoanFundSearchExport;
use App\Http\Controllers\Controller;
use App\Models\FinancialFund;
use App\Models\LoanFund;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LoanFundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $loans = LoanFund::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->latest()->paginate(20);
        return view('admin.loanfunds.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.loanfunds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->filled('loan_amount')) {
            $loan = LoanFund::create();
            if(!empty($request->input('loan_amount')))
            {
                $request->validate(
                    [
                        'loan_amount' => ['numeric'],
                    ],
                    [
                        'loan_amount.numeric' => 'يجب ادخال المبلغ بالأرقام',
                    ]
                );
                $loan->update([
                    'loan_amount' => $request->loan_amount,
                    'amount' => $request->loan_amount,
                ]);
            }


        }else{
            return redirect()->back()->with('danger', 'يجب ادخال مبلغ للإتمام العملية');
        }

        return redirect()->route('admin.loan_funds.index')->with('success', 'تم اضافة صندوق مالي');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanFund  $loanFund
     * @return \Illuminate\Http\Response
     */
    public function show(LoanFund $loanFund)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanFund  $loanFund
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $loan = LoanFund::find($id);
        return view('admin.loanfunds.edit',compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanFund  $loanFund
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->filled('loan_amount')) {
            $loan = LoanFund::findorFail($id);
            if(!empty($request->input('loan_amount')))
            {
                $request->validate(
                    [
                        'loan_amount' => ['numeric'],
                    ],
                    [
                        'loan_amount.numeric' => 'يجب ادخال المبلغ بالأرقام',
                    ]
                );
                $loan->update([
                    'amount' => $loan->amount + $request->loan_amount,
                    'loan_amount' => $loan->loan_amount +  $request->loan_amount,
                ]);
            }


        }else{
            return redirect()->back()->with('danger', 'يجب ادخال مبلغ للإتمام العملية');
        }

        return redirect()->route('admin.loan_funds.index')->with('success', 'تم تعديل صندوق مالي');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanFund  $loanFund
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        LoanFund::findorFail($id)->update([
            'is_delete'=>true
        ]);
        return redirect()->route('admin.loan_funds.index')->with('danger', 'تم حذف هذا القرض');
    }

    public function search(Request $request)
    {
        $loans = LoanFund::query();
        $date_form = $request->date_from;
        $date_to = $request->date_to;

        if ($request->filled('date_from') || $request->filled('date_to')) {
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $loans = $loans->where('created_at', '>', $request->date_from)
                    ->where('created_at', '<', $request->date_to);
            }

            $loans = $loans->latest()->get();
            if ($loans->isEmpty()) {
                return redirect()->back()->with('danger', 'لا يوجد نتائج لعرضها');
            }
        } else {
            return redirect()->back();
        }

        return view('admin.loanfunds.search', compact('loans','date_form','date_to'))->with('success', 'تم عرض نتائج البحث');
    }


    public function export()
    {
        return Excel::download(new LoanFundExport(), 'LoanFunds.xlsx');
    }

    public function exportSearch()
    {
        return Excel::download(new LoanFundSearchExport(), 'LoanFunds.xlsx');
    }
}
