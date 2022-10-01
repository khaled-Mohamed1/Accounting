<?php

namespace App\Http\Controllers\admin;

use App\Exports\FinancialFundExport;
use App\Exports\FinancialFundSearchExport;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\FinancialFund;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FinancialFundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $funds = FinancialFund::whereDate('created_at', Carbon::today())->latest()->paginate(20);
        return view('admin.funds.index', compact('funds'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.funds.creat_FinancialFund');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        if ($request->filled('financial_amount_USD') || $request->filled('financial_amount_ILS')) {
            $fund = FinancialFund::create();
            if (!empty($request->input('financial_amount_USD'))) {
                $request->validate(
                    [
                        'financial_amount_USD' => ['numeric'],
                    ],
                    [
                        'financial_amount.numeric' => 'يجب ادخال المبلغ بالأرقام',
                    ]
                );
                $fund->update([
                    'financial_amount_USD' => $request->financial_amount_USD,
                    'financial_USD' => $request->financial_amount_USD,
                ]);
            }

            if (!empty($request->input('financial_amount_ILS'))) {
                $request->validate(
                    [
                        'financial_amount_ILS' => ['numeric'],
                    ],
                    [
                        'financial_amount_ILS.numeric' => 'يجب ادخال المبلغ بالأرقام',
                    ]
                );
                $fund->update([
                    'financial_amount_ILS' => $request->financial_amount_ILS,
                    'financial_ILS' => $request->financial_amount_ILS,
                ]);
            }
        } else {
            return redirect()->back()->with('danger', 'يجب ادخال مبلغ للإتمام العملية');
        }

        return redirect()->route('admin.funds.index')->with('success', 'تم اضافة صندوق مالي');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $fund = FinancialFund::find($id);
        return view('admin.funds.edit',compact('fund'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->filled('financial_amount_USD') || $request->filled('financial_amount_ILS')) {
            $fund = FinancialFund::findorFail($id);
            if (!empty($request->input('financial_amount_USD'))) {
                $request->validate(
                    [
                        'financial_amount_USD' => ['numeric'],
                    ],
                    [
                        'financial_amount.numeric' => 'يجب ادخال المبلغ بالأرقام',
                    ]
                );
                $fund->update([
                    'financial_amount_USD' => $fund->financial_amount_USD + $request->financial_amount_USD,
                    'financial_USD' => $fund->financial_USD + $request->financial_amount_USD,
                ]);
            }

            if (!empty($request->input('financial_amount_ILS'))) {
                $request->validate(
                    [
                        'financial_amount_ILS' => ['numeric'],
                    ],
                    [
                        'financial_amount_ILS.numeric' => 'يجب ادخال المبلغ بالأرقام',
                    ]
                );
                $fund->update([
                    'financial_amount_ILS' =>$fund->financial_amount_ILS + $request->financial_amount_ILS,
                    'financial_ILS' =>$fund->financial_ILS + $request->financial_amount_ILS,
                ]);
            }
        } else {
            return redirect()->back()->with('danger', 'يجب ادخال مبلغ للإتمام العملية');
        }

        return redirect()->route('admin.funds.index')->with('success', 'تم تعديل صندوق مالي');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $fund = FinancialFund::findorFail($id);
        $fund->update([
            'is_delete'=>true
        ]);
        return redirect()->route('admin.funds.index')->with('danger', 'تم حذف هذا القرض');
    }

    public function search(Request $request)
    {
        $funds = FinancialFund::query();
        $date_form = $request->date_from;
        $date_to = $request->date_to;

        if ($request->filled('date_from') || $request->filled('date_to')) {
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $funds = $funds->where('created_at', '>', $request->date_from)
                    ->where('created_at', '<', $request->date_to);
            }

            $funds = $funds->latest()->get();
            if ($funds->isEmpty()) {
                return redirect()->back()->with('danger', 'لا يوجد نتائج لعرضها');
            }
        } else {
            return redirect()->back();
        }

        return view('admin.funds.search', compact('funds','date_form','date_to'))->with('success', 'تم عرض نتائج البحث');
    }

    public function export()
    {
        return Excel::download(new FinancialFundExport(), 'funds.xlsx');
    }

    public function exportSearch()
    {
        return Excel::download(new FinancialFundSearchExport(), 'funds.xlsx');
    }
}
