<?php

namespace App\Http\Controllers;

use App\Models\Activity_log;
use App\Models\Expenditure;
use App\Models\FinancialFund;
use App\Models\LoanFund;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('is_admin','0')->latest()->get();
        $fund = FinancialFund::where('is_delete',0)->whereDate('created_at', Carbon::today())->get();
        if ($fund->isEmpty()) {
            FinancialFund::create();
        }
        $loan = LoanFund::where('is_delete',0)->whereDate('created_at', Carbon::today())->get();
        if ($loan->isEmpty()) {
            LoanFund::create();
        }
        return view('admin/home',compact('users'));
    }

    public function activity()
    {
        $users = Activity_log::latest()->paginate(20);
        return view('admin/user_activity',compact('users'));
    }

    public  function create(){
        return view('admin.create_user');
    }


    public function store(Request $request){

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'ID_NO' => ['required', 'numeric', 'digits:9','unique:users'],
                'phone_NO' => ['required', 'numeric','digits:10', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'start_log' => ['required', 'date_format:H:i'],
                'end_log' => ['required', 'date_format:H:i','after:start_log'],

            ],
            [
                'name.required' => 'يجب ادخال اسم الموظف',
                'email.required' => 'يجب ادخال بريد الإلكتروني للموظف',
                'email.unique' => 'هذا الإيميل تم استخدامه',
                'ID_NO.required' => 'يجب ادخال رقم هوية الموظف',
                'ID_NO.unique' => 'رقم الهوية مستخدم',
                'ID_NO.numeric' => 'يجب ادخال رقم الهوية بالأرقام',
                'ID_NO.digits' => 'رقم الهوية يتكون من 9 ارقام فقط',
                'phone_NO.required' => 'يجب ادخال رقم جوال الموظف',
                'phone_NO.unique' => 'رقم الجوال مستخدم',
                'phone_NO.numeric' => 'يجب ادخال رقم الجوال بالأرقام',
                'phone_NO.digits' => 'رقم الجوال يتكون من 10 ارقام فقط',
                'password.required' => 'يجب ادخال كلمة السر',
                'password.min' => 'يجب ادخال كلمة سر أكثر من 8 ارقام',
                'start_log.required' => 'يجب ادخال بداية دوام الموظف',
                'end_log.required' => 'يجب ادخال نهاية دوام الموظف',
                'end_log.after' => 'يجب ادخال نهاية وقت الدوام بعد وقت بداية الدوام',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'ID_NO' => $request->ID_NO,
            'phone_NO' => $request->phone_NO,
            'password' => Hash::make($request->password),
            'start_log' => $request->start_log,
            'end_log' => $request->end_log,
        ]);

        if($request->has('c_update')){
            $user->update([
                'c_update' => true,
            ]);
        }

        if($request->has('c_delete')){
            $user->update([
                'c_delete' => true,
            ]);
        }


        return redirect()->route('admin.home')->with('success', 'تم اضافة موظف جديد');

    }

    public function edit($id){
        $user = User::find($id);
        return view('admin.edit_user',compact('user'));

    }

    public  function update(Request $request, $id){

        $user = User::find($id);

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'ID_NO' => ['required', 'numeric', 'digits:9', Rule::unique('users')->ignore($user->id)],
                'phone_NO' => ['required', 'numeric','digits:10', Rule::unique('users')->ignore($user->id)],
                'start_log' => ['required', 'date_format:H:i'],
                'end_log' => ['required', 'date_format:H:i','after:start_log'],
            ],
            [
                'name.required' => 'يجب ادخال اسم الموظف',
                'email.required' => 'يجب ادخال بريد الإلكتروني للموظف',
                'email.unique' => 'هذا الإيميل تم استخدامه',
                'ID_NO.required' => 'يجب ادخال رقم هوية الموظف',
                'ID_NO.unique' => 'رقم الهوية مستخدم',
                'ID_NO.numeric' => 'يجب ادخال رقم الهوية بالأرقام',
                'ID_NO.digits' => 'رقم الهوية يتكون من 9 ارقام فقط',
                'phone_NO.required' => 'يجب ادخال رقم جوال الموظف',
                'phone_NO.unique' => 'رقم الجوال مستخدم',
                'phone_NO.numeric' => 'يجب ادخال رقم الجوال بالأرقام',
                'phone_NO.digits' => 'رقم الجوال يتكون من 10 ارقام فقط',
                'start_log.required' => 'يجب ادخال بداية دوام الموظف',
                'end_log.required' => 'يجب ادخال نهاية دوام الموظف',
                'end_log.after' => 'يجب ادخال نهاية وقت الدوام بعد وقت بداية الدوام',
            ]
        );

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'ID_NO' => $request->ID_NO,
            'phone_NO' => $request->phone_NO,
            'start_log' => $request->start_log,
            'end_log' => $request->end_log,
        ]);

        if(!empty($request->input('password')))
        {
            $request->validate(
                [
                    'password' => ['required', 'string', 'min:8'],
                ],
                [
                    'password.min' => 'يجب ادخال كلمة سر أكثر من 8 ارقام',
                ]
            );
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        if($request->has('c_update')){
            $user->update([
                'c_update' => true,
            ]);
        }else{
            $user->update([
                'c_update' => false,
            ]);
        }

        if($request->has('c_delete')){
            $user->update([
                'c_delete' => true,
            ]);
        }else{
            $user->update([
                'c_delete' => false,
            ]);
        }

        return redirect()->route('admin.home')->with('success', 'تم تعديل الموظف');

    }


    public function delete($id){

        User::findorFail($id)->delete();
        return redirect()->route('admin.home')->with('danger', 'تم حذف هذا الموظف');

    }

}
