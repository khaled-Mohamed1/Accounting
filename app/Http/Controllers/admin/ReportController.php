<?php

namespace App\Http\Controllers\admin;

use App\Exports\ReportSearchExport;
use App\Http\Controllers\Controller;
use App\Models\Dollar_amount;
use App\Models\FinancialFund;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        $dollar = Dollar_amount::findOrFail(1);
        $funds = FinancialFund::whereDate('created_at', Carbon::today())->latest()->get();
        $reports = Report::whereDate('created_at', Carbon::today())->latest()->paginate(200);
        return view('admin.reports.index', compact('reports', 'dollar','funds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $report = Report::find($id);
        return view('admin.reports.edit',compact('report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

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
                $fund = FinancialFund::whereDate('created_at', Carbon::today())->where('is_delete',0)
                    ->get()->last();
                if($request->delivery_USD > $report->delivery_USD){
                    $remain_USD = $request->delivery_USD - $report->delivery_USD;
                    $fund->decrement('financial_amount_USD', $remain_USD);

                }elseif($request->delivery_USD < $report->delivery_USD){
                    $remain_USD =  $report->delivery_USD - $request->delivery_USD ;
                    $fund->increment('financial_amount_USD', $remain_USD);

                }
            }

            if($request->delivery_ILS != $report->delivery_ILS){
                $fund = FinancialFund::whereDate('created_at', Carbon::today())->where('is_delete',0)
                    ->get()->last();
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
                $fund = FinancialFund::whereDate('created_at', Carbon::today())->where('is_delete',0)
                    ->get()->last();
                if($request->delivery_USD > $report->delivery_USD){
                    $remain_USD = $request->delivery_USD - $report->delivery_USD;
                    $fund->increment('financial_amount_USD', $remain_USD);

                }elseif($request->delivery_USD < $report->delivery_USD){
                    $remain_USD =  $report->delivery_USD - $request->delivery_USD ;
                    $fund->decrement('financial_amount_USD', $remain_USD);

                }
            }

            if($request->delivery_ILS != $report->delivery_ILS){
                $fund = FinancialFund::whereDate('created_at', Carbon::today())->where('is_delete',0)
                    ->get()->last();
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

        return redirect()->route('admin.reports.index')->with('success', 'تم تعديل التقرير');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $report = Report::findorFail($id);
        $fund = FinancialFund::whereDate('created_at', Carbon::today())
            ->where('is_delete',0)->get()->last();
        if ($fund == null) {
            $report->delete();
            return redirect()->route('admin.reports.index')->with('danger', 'تم حذف هذا التقرير');
        }
        if($report->remittance_type == 'صادر'){

            $fund->increment('financial_amount_USD', $report->delivery_USD);
            $fund->increment('financial_amount_ILS', $report->delivery_ILS);

//            if($report->currency_type == 'دولار'){
//                $fund->increment('financial_amount_USD', $report->amount);
//            }
//
//            if($report->currency_type == 'شيكل'){
//                $fund->increment('financial_amount_ILS', $report->amount);
//            }

            $report->update([
                'is_delete'=> true
            ]);

        }elseif($report->remittance_type == 'وارد'){
            $fund->decrement('financial_amount_USD', $report->delivery_USD);
            $fund->decrement('financial_amount_ILS', $report->delivery_ILS);
//            if($report->currency_type == 'دولار'){
//                $fund->decrement('financial_amount_USD', $report->amount);
//            }
//
//            if($report->currency_type == 'شيكل'){
//                $fund->decrement('financial_amount_ILS', $report->amount);
//            }
            $report->update([
                'is_delete'=> true
            ]);
        }
        return redirect()->route('admin.reports.index')->with('danger', 'تم حذف هذا التقرير');
    }

    public function export()
    {
        return Excel::download(new ReportExport, 'reports.xlsx');
    }

    public function exportSearch()
    {
        return Excel::download(new ReportSearchExport(), 'reports.xlsx');
    }

    public function search(Request $request)
    {
        $reports = Report::query();
        $dollar = Dollar_amount::findOrFail(1);
        $funds = FinancialFund::whereBetween('created_at', [ $request->date_from, $request->date_to ] )->latest()->get();


        $date_form = $request->date_from;
        $date_to = $request->date_to;


        if ($request->filled('date_from') || $request->filled('date_to')) {
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $reports = $reports->where('created_at', '>', $request->date_from)
                    ->where('created_at', '<', $request->date_to);
            }

            $reports = $reports->latest()->get();


            if($reports->isEmpty()){
                return  redirect()->back()->with('danger', 'لا يوجد نتائج لعرضها');
            }
        }else{
            return redirect()->back();
        }

        return view('admin.reports.search', compact('reports','date_form','date_to','dollar','funds'))->with('success', 'تم عرض نتائج البحث');

    }

    public function searchProfit(Request $request){

        $dollar = Dollar_amount::findOrFail(1);

        $reports = Report::where('created_at', '>', $request->date_form)
            ->where('created_at', '<', $request->date_to)->latest()->get();


        if(!empty($request->percent_value))
        {
            foreach ($reports as $report){
                $remain = (($report->amount - ($report->amount * $request->percent_value) / 100) - $report->delivery_USD) * $dollar->USD_amount;
                $report->update([
                    'profit'=>$remain - $report->delivery_ILS,
                ]);
            }


        }

        if(!empty($request->numerical)){
            foreach ($reports as $report){
                $remain = (($report->amount - $request->numerical) - $report->delivery_USD) * $dollar->USD_amount;
                $report->update([
                    'profit'=>$remain - $report->delivery_ILS,
                ]);
            }

        }
        return response()->json([
            'status' => 'success',
            'reports' => $reports,
        ]);

    }

}
