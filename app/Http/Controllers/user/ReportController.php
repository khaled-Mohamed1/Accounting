<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\FinancialFund;
use App\Models\LoanFund;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $fund = FinancialFund::where('is_delete',0)->whereDate('created_at', Carbon::today())->get();
        if ($fund->isEmpty()) {
            FinancialFund::create();
        }
        $loan = LoanFund::where('is_delete',0)->whereDate('created_at', Carbon::today())->get();
        if ($loan->isEmpty()) {
            LoanFund::create();
        }
        $reports = Report::whereDate('created_at', Carbon::today())->latest()->paginate(20);
        return view('user.reports.index', compact('reports','fund'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('user.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $fund = FinancialFund::whereDate('created_at', Carbon::today())
            ->where('is_delete',0)->get()->last();


        $request->validate(
            [
                'transaction_NO' => ['required'],
                'remittance_type' => ['required'],
                'transaction_type' => ['required'],
                'currency_type' => ['required'],
                'amount' => ['required', 'numeric'],
            ],
            [
                'transaction_NO.required' => 'يجب ادخال رقم العملية',
                'remittance_type.required' => 'يجب ادخال نوع الحوالة',
                'transaction_type.required' => 'يجب ادخال نوع المعاملة',
                'currency_type.required' => 'يجب ادخال نوع العملة',
                'amount.required' => 'يجب ادخال قيمة المبلغ',
                'amount.numeric' => 'يجب ادخال المبلغ بالأرقام',
            ]
        );

        $report = Report::create([
            'user_id' => auth()->user()->id,
            'transaction_NO' => $request->transaction_NO,
            'remittance_type' => $request->remittance_type,
            'transaction_type' => $request->transaction_type,
            'currency_type' => $request->currency_type,
            'amount' => $request->amount,
        ]);

        if(!empty($request->input('delivery_USD')))
        {
            $request->validate(
                [
                    'delivery_USD' => ['sometimes', 'numeric'],
                ],
                [
                    'delivery_USD.numeric' => 'يجب ادخال قيمة المبلغ دولار بالأرقام',
                ]
            );
            $report->update([
                'delivery_USD' => $request->delivery_USD,
            ]);
        }

        if(!empty($request->input('delivery_ILS')))
        {
            $request->validate(
                [
                    'delivery_ILS' => ['sometimes', 'numeric'],
                ],
                [
                    'delivery_ILS.numeric' => 'يجب ادخال قيمة المبلغ شيكل بالأرقام',
                ]
            );
            $report->update([
                'delivery_ILS' => $request->delivery_ILS,
            ]);
        }

        if($request->remittance_type == 'صادر'){

            if(!empty($request->input('delivery_USD')))
            {
                $fund->decrement('financial_amount_USD', $request->delivery_USD);
            }

            if(!empty($request->input('delivery_ILS')))
            {
                $fund->decrement('financial_amount_ILS', $request->delivery_ILS);
            }

        }elseif($request->remittance_type == 'وارد'){

            if(!empty($request->input('delivery_USD')))
            {
                $fund->increment('financial_amount_USD', $request->delivery_USD);
            }
            if(!empty($request->input('delivery_ILS')))
            {
                $fund->increment('financial_amount_ILS', $request->delivery_ILS);
            }
        }

        return redirect()->route('user.reports.index')->with('success', 'تم اضافة التقرير');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        if(auth()->user()->c_update == true){
            $report = Report::findOrFail($id);
            return view('user.reports.edit',compact('report'));
        }else{
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {

        if(auth()->user()->c_update == true){
            $request->validate(
                [
                    'transaction_NO' => ['required'],
                    'remittance_type' => ['required'],
                    'transaction_type' => ['required'],
                    'currency_type' => ['required'],
                    'amount' => ['required', 'numeric'],
                ],
                [
                    'transaction_NO.required' => 'يجب ادخال رقم المعاملة',
                    'remittance_type.required' => 'يجب ادخال نوع الحوالة',
                    'transaction_type.required' => 'يجب ادخال نوع المعاملة',
                    'currency_type.required' => 'يجب ادخال نوع العملة',
                    'amount.required' => 'يجب ادخال قيمة المبلغ',
                    'amount.numeric' => 'يجب ادخال المبلغ بالأرقام',
                ]
            );

            Report::where('id', $id)->update([
                'transaction_NO' => $request->transaction_NO,
                'remittance_type' => $request->remittance_type,
                'transaction_type' => $request->transaction_type,
                'currency_type' => $request->currency_type,
                'amount' => $request->amount,
                'updated_by' => auth()->user()->id

            ]);



            $report = Report::findOrFail($id);
            if($request->remittance_type == 'صادر'){
                if($request->delivery_USD != $report->delivery_USD){
                    $fund = FinancialFund::whereDate('created_at', Carbon::today())
                        ->where('is_delete',0)->get()->last();
                    if($request->delivery_USD > $report->delivery_USD){
                        $remain_USD = $request->delivery_USD - $report->delivery_USD;
                        $fund->decrement('financial_amount_USD', $remain_USD);

                    }elseif($request->delivery_USD < $report->delivery_USD){
                        $remain_USD =  $report->delivery_USD - $request->delivery_USD ;
                        $fund->increment('financial_amount_USD', $remain_USD);

                    }
                }

                if($request->delivery_ILS != $report->delivery_ILS){
                    $fund = FinancialFund::whereDate('created_at', Carbon::today())
                        ->where('is_delete',0)->get()->last();
                    if($request->delivery_ILS > $report->delivery_ILS){
                        $remain_ILS = $request->delivery_ILS - $report->delivery_ILS;
                        $fund->decrement('financial_amount_ILS', $remain_ILS);

                    }elseif($request->delivery_ILS < $report->delivery_ILS){
                        $remain_ILS =  $report->delivery_ILS - $request->delivery_ILS ;
                        $fund->increment('financial_amount_ILS', $remain_ILS);

                    }
                }

            }elseif($request->remittance_type == 'وارد'){
                if($request->delivery_USD != $report->delivery_USD){
                    $fund = FinancialFund::whereDate('created_at', Carbon::today())
                        ->where('is_delete',0)->get()->last();
                    if($request->delivery_USD > $report->delivery_USD){
                        $remain_USD = $request->delivery_USD - $report->delivery_USD;
                        $fund->increment('financial_amount_USD', $remain_USD);

                    }elseif($request->delivery_USD < $report->delivery_USD){
                        $remain_USD =  $report->delivery_USD - $request->delivery_USD ;
                        $fund->decrement('financial_amount_USD', $remain_USD);

                    }
                }

                if($request->delivery_ILS != $report->delivery_ILS){
                    $fund = FinancialFund::whereDate('created_at', Carbon::today())
                        ->where('is_delete',0)->get()->last();
                    if($request->delivery_ILS > $report->delivery_ILS){
                        $remain_ILS = $request->delivery_ILS - $report->delivery_ILS;
                        $fund->increment('financial_amount_ILS', $remain_ILS);

                    }elseif($request->delivery_ILS < $report->delivery_ILS){
                        $remain_ILS =  $report->delivery_ILS - $request->delivery_ILS ;
                        $fund->decrement('financial_amount_ILS', $remain_ILS);

                    }
                }
            }

            if(!empty($request->input('delivery_USD')))
            {
                $request->validate(
                    [
                        'delivery_USD' => [ 'sometimes', 'numeric'],
                    ],
                    [
                        'delivery_USD.numeric' => 'يجب ادخال قيمة المبلغ دولار بالأرقام',
                    ]
                );
                Report::where('id', $id)->update([
                    'delivery_USD' => $request->delivery_USD,
                ]);
            }else{
                Report::where('id', $id)->update([
                    'delivery_USD' => 0,
                ]);
            }

            if(!empty($request->input('delivery_ILS')))
            {
                $request->validate(
                    [
                        'delivery_ILS' => ['sometimes', 'numeric'],
                    ],
                    [
                        'delivery_ILS.numeric' => 'يجب ادخال قيمة المبلغ شيكل بالأرقام',
                    ]
                );
                Report::where('id', $id)->update([
                    'delivery_ILS' => $request->delivery_ILS,
                ]);
            }else{
                Report::where('id', $id)->update([
                    'delivery_ILS' => 0,
                ]);
            }


            return redirect()->route('user.reports.index')->with('success', 'تم تعديل التقرير');
        }else{
            return redirect()->back();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        if(auth()->user()->c_delete == true) {
            $report = Report::findorFail($id);
            if ($report->remittance_type == 'صادر') {
                $fund = FinancialFund::whereDate('created_at', Carbon::today())
                    ->where('is_delete',0)->get()->last();
                $fund->increment('financial_amount_USD', $report->delivery_USD);
                $fund->increment('financial_amount_ILS', $report->delivery_ILS);
//                if($report->currency_type == 'دولار'){
//                    $fund->increment('financial_amount_USD', $report->amount);
//                }

//                if($report->currency_type == 'شيكل'){
//                    $fund->increment('financial_amount_ILS', $report->amount);
//                }
                $report->update([
                    'is_delete'=>true
                ]);
            } elseif ($report->remittance_type == 'وارد') {
                $fund = FinancialFund::whereDate('created_at', Carbon::today())
                    ->where('is_delete',0)->get()->last();
                $fund->decrement('financial_amount_USD', $report->delivery_USD);
                $fund->decrement('financial_amount_ILS', $report->delivery_ILS);
//                if($report->currency_type == 'دولار'){
//                    $fund->decrement('financial_amount_USD', $report->amount);
//                }
//
//                if($report->currency_type == 'شيكل'){
//                    $fund->decrement('financial_amount_ILS', $report->amount);
//                }
                $report->update([
                    'is_delete'=>true
                ]);
            }
            return redirect()->route('user.reports.index')->with('danger', 'تم حذف هذا التقرير');
        }else{
            return redirect()->back();
        }


    }
}
