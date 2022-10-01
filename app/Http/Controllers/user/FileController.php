<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\FinancialFund;
use App\Models\LoanFund;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $loan = LoanFund::where('is_delete',0)->whereDate('created_at', Carbon::today())->get();
        $files = File::whereDate('created_at', Carbon::today())->latest()->paginate(20);;
        return view('user.files.index', compact('files','loan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('user.files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $loans = LoanFund::whereDate('created_at', Carbon::today())->where('is_delete',0)->get()->last();

        $request->validate(
            [
                'file_NO' => ['required'],
                'client_name' => ['required', 'string'],
                'outgoing' => ['required', 'numeric'],
                'incoming' => ['required', 'numeric'],
            ],
            [
                'file_NO.required' => 'يجب ادخال رقم الملف',
                'file_NO.unique' => 'تم ادخال رقم الملف من قبل',
                'client_name.required' => 'يجب ادخال اسم الزبون',
                'client_name.string' => 'يجب كتابة اسم الزبون بالأحرف',
                'outgoing.required' => 'يجب ادخال قيمة الصادر',
                'outgoing.numeric' => 'يجب ادخال قيمة الصادر بالأرقام',
                'incoming.required' => 'يجب ادخال قيمة الوارد',
                'incoming.numeric' => 'يجب ادخال قيمة الوارد بالأرقام',

            ]
        );

        if(!empty($request->input('outgoing'))){

             LoanFund::whereDate('created_at', Carbon::today())->where('is_delete',0)->get()
                 ->last()->decrement('amount', $request->outgoing);
        }

//        if(!empty($request->input('incoming'))) {
//            LoanFund::whereDate('created_at', Carbon::today())->where('is_delete',0)->get()
//                ->last()->increment('amount', $request->incoming);
//        }

        File::create([
            'user_id' => auth()->user()->id,
            'file_NO' => $request->file_NO,
            'client_name' => $request->client_name,
            'outgoing' => $request->outgoing,
            'incoming' => $request->incoming,

        ]);

        return redirect()->route('user.files.index')->with('success', 'تم اضافة القسط المالي');

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
            $file = File::findOrFail($id);
            return view('user.files.edit',compact('file'));
        }else{
            return redirect()->back();
        }    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(auth()->user()->c_update){
            $request->validate(
                [
                    'file_NO' => ['required'],
                    'client_name' => ['required', 'string'],
                    'outgoing' => ['required', 'numeric'],
                    'incoming' => ['required', 'numeric'],
                ],
                [
                    'file_NO.required' => 'يجب ادخال رقم الملف',
                    'client_name.required' => 'يجب ادخال اسم الزبون',
                    'client_name.string' => 'يجب كتابة اسم الزبون بالأحرف',
                    'outgoing.required' => 'يجب ادخال قيمة الصادر',
                    'outgoing.numeric' => 'يجب ادخال قيمة الصادر بالأرقام',
                    'incoming.required' => 'يجب ادخال قيمة الوارد',
                    'incoming.numeric' => 'يجب ادخال قيمة الوارد بالأرقام',

                ]
            );

            $file = File::findOrFail($id);

            if(!empty($request->input('outgoing'))) {
                if($request->outgoing != $file->outgoing){
                    $loan = LoanFund::whereMonth('created_at', date('m'))
                        ->whereYear('created_at', date('Y'))->where('is_delete',0)->get()->last();
                    if($request->outgoing > $file->outgoing){
                        $remain_outgoing = $request->outgoing - $file->outgoing;
                        $loan->decrement('amount', $remain_outgoing);

                    }elseif($request->outgoing < $file->outgoing){
                        $remain_outgoing =  $file->outgoing - $request->outgoing;
                        $loan->increment('amount', $remain_outgoing);
                    }

                }
            }


//            if(!empty($request->input('incoming'))) {
//                if($request->incoming != $file->incoming){
//                    $loan = LoanFund::whereMonth('created_at', date('m'))
//                        ->whereYear('created_at', date('Y'))->where('is_delete',0)->get()->last();
//                    if($request->incoming > $file->incoming){
//                        $remain_incoming = $request->incoming - $file->incoming;
//                        $loan->increment('amount', $remain_incoming);
//
//                    }elseif($request->incoming < $file->incoming){
//                        $remain_incoming =  $file->incoming - $request->incoming;
//                        $loan->decrement('amount', $remain_incoming);
//                    }
//                }
//            }

            File::where('id',$id)->update([
                'file_NO' => $request->file_NO,
                'client_name' => $request->client_name,
                'outgoing' => $request->outgoing,
                'incoming' => $request->incoming,
                'updated_by' => auth()->user()->id

            ]);

            return redirect()->route('user.files.index')->with('success', 'تم تعديل القسط المالي');
        }else{
            return redirect()->back();
        }    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {

        if(auth()->user()->c_delete){
            $file = File::findorFail($id);
            $loan = LoanFund::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))->where('is_delete',0)->get()->last();
            $loan->increment('amount', $file->outgoing);
//            $loan->decrement('amount', $file->incoming);
            $file->update([
                'is_delete'=>true
            ]);

            return redirect()->route('user.files.index')->with('danger', 'تم حذف القسط المالي');
        }else{
            return redirect()->back();
        }

    }
}
