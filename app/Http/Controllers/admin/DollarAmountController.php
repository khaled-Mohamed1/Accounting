<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dollar_amount;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class DollarAmountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Dollar_amount  $dollar_amount
     * @return \Illuminate\Http\Response
     */
    public function show(Dollar_amount $dollar_amount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dollar_amount  $dollar_amount
     * @return \Illuminate\Http\Response
     */
    public function edit(Dollar_amount $dollar_amount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dollar_amount  $dollar_amount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(!empty($request->input('amount')))
        {
            $request->validate(
                [
                    'amount' => [ 'required', 'numeric'],
                ],
                [
                    'amount.required' => 'يجب ادخال هذا الحقل',
                    'amount.numeric' => 'يجب ادخال سعر دولار بالأرقام',
                ]
            );
            Dollar_amount::where('id', $id)->update([
                'USD_amount' => $request->amount,
            ]);
        }

        $reports = Report::whereDate('created_at', Carbon::today())->latest()->paginate(20);
        foreach ($reports as $report){
            $report->update([
                'profit'=>0
            ]);
        }

        return redirect()->back()->with('success','تم تغيير سعر الدولار');
    }

    public function updateSearch(Request $request, $id)
    {
        if(!empty($request->input('amount')))
        {
            $request->validate(
                [
                    'amount' => [ 'required', 'numeric'],
                ],
                [
                    'amount.required' => 'يجب ادخال هذا الحقل',
                    'amount.numeric' => 'يجب ادخال سعر دولار بالأرقام',
                ]
            );
            Dollar_amount::where('id', $id)->update([
                'USD_amount' => $request->amount,
            ]);
        }

        $reports = Report::whereDate('created_at', Carbon::today())->latest()->paginate(20);
        foreach ($reports as $report){
            $report->update([
                'profit'=>0
            ]);
        }

        return redirect()->back()->with('success','تم تغيير سعر الدولار');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dollar_amount  $dollar_amount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dollar_amount $dollar_amount)
    {
        //
    }

    public function profit(Request $request){
        $dollar = Dollar_amount::findOrFail(1);
        $report = Report::findOrFail($request->report_id);


        if($report->remittance_type == 'صادر'){

            if(!$request->percent_value == null || $request->numerical == null) {
                if($report->currency_type == 'دولار'){
                    if($report->delivery_USD > 0 && $report->delivery_ILS > 0){

                        $remain_USD = (($report->amount - ($report->amount * $request->percent_value) / 100)
                                - $report->delivery_USD) * $dollar->USD_amount - $report->delivery_ILS;
                        $remain_ILS = (($report->amount - ($report->amount * $request->percent_value) / 100)
                                - $report->delivery_USD) * $dollar->USD_amount - $report->delivery_ILS;
                        $report->update([
                            'profit_USD'=>$remain_USD / $dollar->USD_amount,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,
                        ]);

                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_ILS == 0){
                        $remain_USD = (($report->amount - ($report->amount * $request->percent_value) / 100)
                            - $report->delivery_USD) ;
                        $report->update([
                            'profit_USD'=>$remain_USD,
                            'profit_ILS'=>$remain_USD * $dollar->USD_amount,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_USD == 0){
                        $remain_ILS = (($report->amount - ($report->amount * $request->percent_value) / 100)
                                * $dollar->USD_amount) - $report->delivery_ILS;
                        $report->update([
                            'profit_USD'=>$remain_ILS /$dollar->USD_amount ,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);
                    }
                }elseif($report->currency_type == 'شيكل'){
                    if($report->delivery_USD > 0 && $report->delivery_ILS > 0){

                        $remain_ILS = (($report->amount - ($report->amount * $request->percent_value) / 100)
                            -($dollar->USD_amount * $report->delivery_USD) - $report->delivery_ILS);
                        $remain_USD = $remain_ILS / $dollar->USD_amount;
                        $report->update([
                            'profit_USD'=>$remain_USD,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,
                        ]);

                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_ILS == 0){
                        $remain_USD = (($report->amount - ($report->amount * $request->percent_value) / 100)
                            / $dollar->USD_amount- $report->delivery_USD) ;
                        $report->update([
                            'profit_USD'=>$remain_USD,
                            'profit_ILS'=>$remain_USD * $dollar->USD_amount ,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,

                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_USD == 0){
                        $remain_ILS = ($report->amount - ($report->amount * $request->percent_value) / 100)
                            - $report->delivery_ILS;
                        $report->update([
                            'profit_USD'=>$remain_ILS / $dollar->USD_amount ,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);
                    }
                }

            }

            if(!$request->numerical == null || $request->percent_value == null){

                if($report->currency_type == 'دولار') {

                    if($report->delivery_USD > 0 && $report->delivery_ILS > 0){
                        $remain_USD = (($report->amount - $request->numerical) - $report->delivery_USD)
                            * $dollar->USD_amount - $report->delivery_ILS;
                        $remain_ILS = (($report->amount - $request->numerical) - $report->delivery_USD)
                            * $dollar->USD_amount - $report->delivery_ILS;
                        $report->update([
                            'profit_USD'=>$remain_USD / $dollar->USD_amount,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);
                    }elseif($report->delivery_ILS == 0){
                        $remain_USD = (($report->amount - $request->numerical) - $report->delivery_USD);
                        $report->update([
                            'profit_USD'=>$remain_USD,
                            'profit_ILS'=>$remain_USD * $dollar->USD_amount,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_USD == 0){
                        $remain_ILS = (($report->amount - $request->numerical)
                                * $dollar->USD_amount) - $report->delivery_ILS;
                        $report->update([
                            'profit_USD'=>$remain_ILS /$dollar->USD_amount ,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);
                    }
                }elseif($report->currency_type == 'شيكل'){
                    if($report->delivery_USD > 0 && $report->delivery_ILS > 0){

                        $remain_ILS = ($report->amount - $request->numerical
                            - ($dollar->USD_amount * $report->delivery_USD) - $report->delivery_ILS);
                        $remain_USD = $remain_ILS / $dollar->USD_amount;
                        $report->update([
                            'profit_USD'=>$remain_USD,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);

                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_ILS == 0){
                        $remain_USD = (($report->amount - $request->numerical)
                            / $dollar->USD_amount- $report->delivery_USD) ;
                        $report->update([
                            'profit_USD'=>$remain_USD,
                            'profit_ILS'=>$remain_USD * $dollar->USD_amount ,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_USD == 0){
                        $remain_ILS = ($report->amount - $request->numerical)
                            - $report->delivery_ILS;
                        $report->update([
                            'profit_USD'=>$remain_ILS / $dollar->USD_amount,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);
                    }
                }

            }
        }elseif($report->remittance_type == 'وارد'){
            if(!$request->percent_value == null || $request->numerical == null) {
                if($report->currency_type == 'دولار'){
                    if($report->delivery_USD > 0 && $report->delivery_ILS > 0){
                        $remain_USD =($report->delivery_USD + $report->delivery_ILS / $dollar->USD_amount) ;
                        $remain_USD = ($remain_USD - ($remain_USD *$request->percent_value) / 100) - $report->amount;
                        $report->update([
                            'profit_USD'=>$remain_USD,
                            'profit_ILS'=>$remain_USD * $dollar->USD_amount,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,
                        ]);

                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_ILS == 0){
                        $remain_USD = ($report->delivery_USD - ($report->delivery_USD *$request->percent_value) / 100) - $report->amount;
                        $report->update([
                            'profit_USD'=>$remain_USD,
                            'profit_ILS'=>$remain_USD * $dollar->USD_amount,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_USD == 0){
                        $remain_USD =($report->delivery_ILS / $dollar->USD_amount);
                        $remain_USD = ($remain_USD - ($remain_USD *$request->percent_value) / 100) - $report->amount;
                        $report->update([
                            'profit_USD'=>$remain_USD ,
                            'profit_ILS'=>$remain_USD * $dollar->USD_amount,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);
                    }
                }elseif($report->currency_type == 'شيكل'){
                    if($report->delivery_USD > 0 && $report->delivery_ILS > 0){

                        $remain_ILS = ($report->delivery_ILS + ($report->delivery_USD * $dollar->USD_amount));
                        $remain_ILS = ($remain_ILS - ($remain_ILS * $request->percent_value) / 100) - $report->amount;

                        $report->update([
                            'profit_USD'=>$remain_ILS / $dollar->USD_amount,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,
                        ]);

                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_ILS == 0){
                        $remain_ILS = ($report->delivery_USD * $dollar->USD_amount);
                        $remain_ILS =     ($remain_ILS - ($remain_ILS * $request->percent_value) / 100)
                            - $report->amount;
                        $report->update([
                            'profit_USD'=>$remain_ILS / $dollar->USD_amount,
                            'profit_ILS'=>$remain_ILS  ,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_USD == 0){
                        $remain_ILS = ($report->delivery_ILS - ($report->delivery_ILS * $request->percent_value) / 100)
                            - $report->amount;
                        $report->update([
                            'profit_USD'=>$remain_ILS / $dollar->USD_amount,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>$request->percent_value,
                            'numerical'=>'null',
                            'dollar'=>$dollar->USD_amount,

                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);
                    }
                }

            }

            if(!$request->numerical == null || $request->percent_value == null){

                if($report->currency_type == 'دولار') {

                    if($report->delivery_USD > 0 && $report->delivery_ILS > 0){
                        $remain_USD =(($report->delivery_USD + $report->delivery_ILS / $dollar->USD_amount)
                            -  $request->numerical) - $report->amount ;
                        $report->update([
                            'profit_USD'=>$remain_USD,
                            'profit_ILS'=>$remain_USD *$dollar->USD_amount ,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);
                    }elseif($report->delivery_ILS == 0){
                        $remain_USD = ($report->delivery_USD - $request->numerical) - $report->amount;

                        $report->update([
                            'profit_USD'=>$remain_USD,
                            'profit_ILS'=>$remain_USD *$dollar->USD_amount ,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_USD == 0){
                        $remain_USD =($report->delivery_ILS / $dollar->USD_amount);
                        $remain_USD = ($remain_USD - $request->numerical) - $report->amount;
                        $report->update([
                            'profit_USD'=>$remain_USD ,
                            'profit_ILS'=>$remain_USD * $dollar->USD_amount ,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);
                    }
                }elseif($report->currency_type == 'شيكل'){
                    if($report->delivery_USD > 0 && $report->delivery_ILS > 0){

                        $remain_ILS = ($report->delivery_ILS + ($report->delivery_USD * $dollar->USD_amount));
                        $remain_ILS = ($remain_ILS - $request->numerical) - $report->amount;
                        $report->update([
                            'profit_USD'=>$remain_ILS / $dollar->USD_amount,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);

                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_ILS == 0){
                        $remain_ILS = (($report->delivery_USD * $dollar->USD_amount) - $request->numerical) - $report->amount;
                        $report->update([
                            'profit_USD'=>$remain_ILS / $dollar->USD_amount,
                            'profit_ILS'=>$remain_ILS ,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);

                    }elseif($report->delivery_USD == 0){
                        $remain_ILS = ($report->delivery_ILS - $request->numerical)
                            - $report->amount;
                        $report->update([
                            'profit_USD'=>$remain_ILS / $dollar->USD_amount,
                            'profit_ILS'=>$remain_ILS,
                            'percent'=>'null',
                            'numerical'=>$request->numerical,
                            'dollar'=>$dollar->USD_amount,
                        ]);
                        return response()->json([
                            'status' => 'success',
                        ]);
                    }
                }

            }
        }



    }
}
