<?php

namespace App\Http\Controllers\admin;

use App\Exports\ExpenditureExport;
use App\Exports\ExpenditureSearchExport;
use App\Exports\FinancialFundExport;
use App\Exports\FinancialFundSearchExport;
use App\Http\Controllers\Controller;
use App\Models\Expenditure;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $expenditures = Expenditure::whereDate('created_at', Carbon::today())->latest()->paginate(20);
        return view('admin.expenditure.index', compact('expenditures'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.expenditure.create_expenditure');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'description' => ['required', 'string'],
            ],
            [
                'description.required' => 'يجب ادخال وصف المصروف',
            ]
        );

        $expenditure = Expenditure::create([
            'description' => $request->description,
        ]);

        if(!empty($request->input('amount_spent_ILS')))
        {
            $request->validate(
                [
                    'amount_spent_ILS' => ['sometimes', 'numeric'],
                ],
                [
                    'amount_spent_ILS.required' => 'يجب ادخال المبلغ بالشيكل',
                    'amount_spent_ILS.numeric' => 'يجب ادخال المبلغ بالأرقام',
                ]
            );
            $expenditure->update([
                'amount_spent_ILS' => $request->amount_spent_ILS,
            ]);
        }

        if(!empty($request->input('amount_spent_USD')))
        {
            $request->validate(
                [
                    'amount_spent_USD' => ['sometimes', 'numeric'],
                ],
                [
                    'amount_spent_USD.required' => 'يجب ادخال المبلغ بالدولار',
                    'amount_spent_USD.numeric' => 'يجب ادخال المبلغ بالأرقام',
                ]
            );
            $expenditure->update([
                'amount_spent_USD' => $request->amount_spent_USD,
            ]);
        }
        return redirect()->route('admin.expenditures.index')->with('success', 'تم اضافة مصروف الموظف');
    }

    /**
     * Display the specified resource.
     *
     * @param Expenditure $expenditure
     * @return \Illuminate\Http\Response
     */
    public function show(Expenditure $expenditure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Expenditure $expenditure
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $expenditure = Expenditure::find($id);
        return view('admin.expenditure.edit',compact('expenditure'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Expenditure $expenditure
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'description' => ['required', 'string'],
            ],
            [
                'description.required' => 'يجب ادخال وصف المصروف',
            ]
        );
        $expenditure = Expenditure::findorFail($id);

        $expenditure->update([
            'description' => $request->description,
        ]);

        if(!empty($request->input('amount_spent_ILS')))
        {
            $request->validate(
                [
                    'amount_spent_ILS' => ['sometimes', 'numeric'],
                ],
                [
                    'amount_spent_ILS.required' => 'يجب ادخال المبلغ بالشيكل',
                    'amount_spent_ILS.numeric' => 'يجب ادخال المبلغ بالأرقام',
                ]
            );
            $expenditure->update([
                'amount_spent_ILS' => $request->amount_spent_ILS,
            ]);
        }

        if(!empty($request->input('amount_spent_USD')))
        {
            $request->validate(
                [
                    'amount_spent_USD' => ['sometimes', 'numeric'],
                ],
                [
                    'amount_spent_USD.required' => 'يجب ادخال المبلغ بالدولار',
                    'amount_spent_USD.numeric' => 'يجب ادخال المبلغ بالأرقام',
                ]
            );
            $expenditure->update([
                'amount_spent_USD' => $request->amount_spent_USD,
            ]);
        }
        return redirect()->route('admin.expenditures.index')->with('success', 'تم تعديل المصروف اليومي');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        Expenditure::findorFail($id)->delete();
        return redirect()->route('admin.expenditures.index')->with('danger', 'تم حذف هذا المصروف');
    }

    public function search(Request $request)
    {
        $expenditures = Expenditure::query();
        $date_form = $request->date_from;
        $date_to = $request->date_to;

        if ($request->filled('date_from') || $request->filled('date_to')) {
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $expenditures = $expenditures->where('created_at', '>', $request->date_from)
                    ->where('created_at', '<', $request->date_to);
            }

            $expenditures = $expenditures->latest()->get();
            if ($expenditures->isEmpty()) {
                return redirect()->back()->with('danger', 'لا يوجد نتائج لعرضها');
            }
        } else {
            return redirect()->back();
        }

        return view('admin.expenditure.search', compact('expenditures','date_form','date_to'))->with('success', 'تم عرض نتائج البحث');
    }


    public function export()
    {
        return Excel::download(new ExpenditureExport(), 'Expenditures.xlsx');
    }

    public function exportSearch()
    {
        return Excel::download(new ExpenditureSearchExport(), 'Expenditure.xlsx');
    }
}
