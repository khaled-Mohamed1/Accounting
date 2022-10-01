<?php

namespace App\Http\Controllers\admin;

use App\Exports\FileExport;
use App\Exports\FileSearchExport;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\FinancialFund;
use App\Models\LoanFund;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $loans = LoanFund::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->get();
        $files = File::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->latest()->paginate(20);
        return view('admin.files.index', compact('files','loans'));
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
        $file = File::find($id);
        return view('admin.files.edit',compact('file'));
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


//        if(!empty($request->input('incoming'))) {
//            if($request->incoming != $file->incoming){
//                $loan = LoanFund::whereMonth('created_at', date('m'))
//                    ->whereYear('created_at', date('Y'))->where('is_delete',0)->get()->last();
//                if($request->incoming > $file->incoming){
//                    $remain_incoming = $request->incoming - $file->incoming;
//                    $loan->increment('amount', $remain_incoming);
//
//                }elseif($request->incoming < $file->incoming){
//                    $remain_incoming =  $file->incoming - $request->incoming;
//                    $loan->decrement('amount', $remain_incoming);
//                }
//            }
//        }

        File::where('id',$id)->update([
            'file_NO' => $request->file_NO,
            'client_name' => $request->client_name,
            'outgoing' => $request->outgoing,
            'incoming' => $request->incoming,
            'updated_by' => auth()->user()->id

        ]);

        return redirect()->route('admin.files.index')->with('success', 'تم تعديل القسط المالي');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $file = File::findorFail($id);
        $loan = LoanFund::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->where('is_delete',0)->get()->last();
        $loan->increment('amount', $file->outgoing);
//        $loan->decrement('amount', $file->incoming);
        $file->update([
            'is_delete'=>true
        ]);

        return redirect()->route('admin.files.index')->with('danger', 'تم حذف القسط المالي');
    }

    public function export()
    {
        return Excel::download(new FileExport(), 'files.xlsx');
    }

    public function exportSearch()
    {
        return Excel::download(new FileSearchExport(), 'files.xlsx');
    }

    public function search(Request $request)
    {
        $files = File::query();
        $loans = LoanFund::whereBetween('created_at', [ $request->date_from, $request->date_to ] )->latest()->get();

        $date_form = $request->date_from;
        $date_to = $request->date_to;


        if ($request->filled('date_from') || $request->filled('date_to')) {
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $files = $files->where('created_at', '>', $request->date_from)
                    ->where('created_at', '<', $request->date_to);
            }

            $files = $files->latest()->get();
            if($files->isEmpty()){
                return  redirect()->back()->with('danger', 'لا يوجد نتائج لعرضها');
            }
        }else{
            return redirect()->back();
        }

        return view('admin.files.search', compact('files','date_form','date_to','loans'))->with('success', 'تم عرض نتائج البحث');


    }
}
