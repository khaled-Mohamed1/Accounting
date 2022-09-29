@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1500px">


        @if ($message = Session::get('success'))
            <div class="alert alert-success" id="alert">
                <p>{{ $message }}</p>
            </div>
        @endif

        @if ($message = Session::get('danger'))
            <div class="alert alert-danger" id="alert">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row justify-content-center">

            <div class="row">
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">

                            <table class="table text-center">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <td>سعر الدولار</td>
                                    <td></td>
                                </tr>

                                </thead>
                                <tbody>

                                <tr>
                                    <th scope="col"></th>
                                    <form action="{{route('admin.dollar.update',$dollar->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <td>
                                            <input name="amount" class="form-control me-2 @error('amount') is-invalid @enderror" type="text" value="{{$dollar->USD_amount}}">
                                            @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" onclick="return confirm('هل تريد تغيير سعر الدولار')"
                                                    type="submit"><i class="las la-redo-alt"></i></button>
                                        </td>
                                    </form>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col">الصندوق المالي</th>
                                    <td colspan="2">المجموع</td>
                                    <td colspan="2">الباقي</td>
                                </tr>

                                </thead>
                                <tbody>

                                <tr>
                                    <th scope="col">دولار</th>
                                    <th colspan="2">{{$funds->sum('financial_USD')}}</th>
                                    <th class="table-active">{{$funds->sum('financial_amount_USD') }}</th>
                                </tr>

                                <tr>
                                    <th scope="col">شيكل</th>
                                    <th colspan="2">{{$funds->sum('financial_ILS')}}</th>
                                    <th class="table-active">{{$funds->sum('financial_amount_ILS') }}</th>
                                </tr>

{{--                                    <tr>--}}
{{--                                        <th scope="col">دولار</th>--}}
{{--                                        <th colspan="2">{{$funds->sum('financial_USD')}}</th>--}}
{{--                                        <th class="table-active">{{$funds->sum('financial_USD')--}}
{{--                                        - $reports->where('remittance_type','صادر')->where('currency_type','دولار')->sum('amount')--}}
{{--                                         + $reports->where('remittance_type','وارد')->where('currency_type','دولار')->sum('amount')}}</th>--}}
{{--                                    </tr>--}}

{{--                                    <tr>--}}
{{--                                        <th scope="col">شيكل</th>--}}
{{--                                        <th colspan="2">{{$funds->sum('financial_ILS')}}</th>--}}
{{--                                        <th class="table-active">{{$funds->sum('financial_ILS')--}}
{{--                                        - $reports->where('remittance_type','صادر')->where('currency_type','شيكل')->sum('amount')--}}
{{--                                         + $reports->where('remittance_type','وارد')->where('currency_type','شيكل')->sum('amount')}}</th>--}}
{{--                                    </tr>--}}


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col">الحوالة</th>
                                    <td colspan="2">المجموع بالدولار</td>
                                    <td colspan="2">المجموع بالشيكل</td>
                                </tr>

                                </thead>
                                <tbody>

                                <tr>
                                    <th scope="col">صادر</th>
                                    <th colspan="2">{{$reports->where('remittance_type','صادر')->sum('delivery_USD')}}</th>
                                    <th colspan="2">{{$reports->where('remittance_type','صادر')->sum('delivery_ILS')}}</th>
                                </tr>

                                <tr>
                                    <th scope="col">وارد</th>
                                    <th colspan="2">{{$reports->where('remittance_type','وارد')->sum('delivery_USD')}}</th>
                                    <th colspan="2">{{$reports->where('remittance_type','وارد')->sum('delivery_ILS')}}</th>
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>


            <div class="row">

                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand btn btn-secondary text-bg-light" type="button" href="{{route('admin.reports.index')}}">الحوالات</a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a class="nav-link active" aria-current="page" href="{{route('admin.funds.index')}}">الصندوق المالية</a>

                        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('admin.home')}}">الموظفين</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('admin.files.index')}}">الأقساط</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('admin.expenditures.index')}}">المصاريف</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <a href="{{route('admin.report.export')}}" class="btn btn-dark"><i class="las la-file-export"></i></a>
                        <form action="{{ route('admin.reports.search') }}" method="get" class="d-flex">
                            @csrf

                            <input name="date_from" placeholder="بداية تاريخ" class="form-control me-2"
                                   type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date_from" required/>

                            <input name="date_to" placeholder="نهاية تاريخ" class="form-control me-2"
                                   type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date_to" required/>

                            <span>&nbsp;&nbsp;</span>
                            <button class="btn btn-success" type="submit">بحث</button>
                        </form>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table user_table profit_table">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الموظف</th>
                                <th scope="col">تاريخ العملية</th>
                                <th scope="col" colspan="2">رقم التتبع</th>
                                <th scope="col">نوع الحوالة</th>
                                <th scope="col">نوع المعاملة</th>
                                <th scope="col">نوع العملة</th>
                                <th scope="col">المبلغ</th>
                                <th scope="col">تسليم بالدولار</th>
                                <th scope="col">تسليم بالشيكل</th>
                                <th class="table-active" scope="col">الربح بالدولار</th>
                                <th class="table-active" scope="col">الربح بالشيكل</th>
                                <th scope="col" style="width: 100px" >نسبة مئوية</th>
                                <th scope="col" style="width: 100px">قيمة رقمية</th>
                                <th scope="col">تعديل</th>
                                <th scope="col">حذف</th>
                            </tr>

                            </thead>
                            <tbody>
                                @foreach($reports->where('remittance_type','صادر') as $key => $report)
                                    <tr>
                                        <th>{{++$key}}</th>
                                        <td>
                                            <figure>
                                                <blockquote >
                                                    <p>{{$report->UserReport->name}}</p>
                                                </blockquote>
                                                @if($report->updated_by == null)
                                                @else
                                                    <figcaption class="blockquote-footer">
                                                        تم التعديل <cite title="Source Title"> - {{$report->UserUpdateReport->name}}</cite>
                                                    </figcaption>
                                                @endif
                                            </figure>
                                        </td>
                                        <td>{{$report->created_at}}</td>
                                        <td colspan="2">{{$report->transaction_NO}}</td>
                                        <td>{{$report->remittance_type}}</td>
                                        <td>{{$report->transaction_type}}</td>
                                        <td>{{$report->currency_type}}</td>
                                        <td>{{$report->amount}}</td>
                                        <td>{{$report->delivery_USD}}</td>
                                        <td>{{$report->delivery_ILS}}</td>
                                        <td class="table-active test{{$report->id}}">{{$report->profit_USD}}</td>
                                        <td class="table-active testt{{$report->id}}">{{$report->profit_ILS}}</td>
                                        <form action="" method="POST" class="test" id="profit{{$report->id}}">
                                            @csrf
                                            <input type="hidden" name="report_id" id="report_id{{$report->id}}" value="{{$report->id}}">
                                            <td>
                                                <input id="percent{{$report->id}}" name="percent" class="form-control me-2 " type="number" min="0"
                                                       value="{{$report->percent == 'null' ? '': $report->percent}}">
                                            </td>
                                            <td>
                                                <input id="numerical{{$report->id}}" name="numerical" class="form-control me-2 " type="number" min="0"
                                                       value="{{$report->numerical == 'null' ? '': $report->numerical}}">
                                            </td>
                                        </form>
                                        <td>
                                            <a href="{{route('admin.report.edit',$report->id)}}" class="btn btn-primary"><i class="las la-edit"></i></a>
                                        </td>
                                        <td>
                                            <form action="{{route('admin.report.delete', $report->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('هل تريد هذه الحوالة')" type="submit"><i class="las la-times"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$reports->links()}}
                    </div>
                </div>
            </div>

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>

            <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>الوارد</h5>
                    </div>

                    <div class="card-body">

                        <table class="table user_table profit_table">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الموظف</th>
                                <th scope="col">تاريخ العملية</th>
                                <th scope="col" colspan="2">رقم التتبع</th>
                                <th scope="col">نوع الحوالة</th>
                                <th scope="col">نوع المعاملة</th>
                                <th scope="col">نوع العملة</th>
                                <th scope="col">المبلغ</th>
                                <th scope="col">تسليم بالدولار</th>
                                <th scope="col">تسليم بالشيكل</th>
                                <th class="table-active" scope="col">الربح بالدولار</th>
                                <th class="table-active" scope="col">الربح بالشيكل</th>
                                <th scope="col" style="width: 100px" >نسبة مئوية</th>
                                <th scope="col" style="width: 100px">قيمة رقمية</th>
                                <th scope="col">تعديل</th>
                                <th scope="col">حذف</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($reports->where('remittance_type','وارد') as $key => $report)
                                <tr>
                                    <th>{{++$key}}</th>
                                    <td>
                                        <figure>
                                            <blockquote >
                                                <p>{{$report->UserReport->name}}</p>
                                            </blockquote>
                                            @if($report->updated_by == null)
                                            @else
                                                <figcaption class="blockquote-footer">
                                                    تم التعديل <cite title="Source Title"> - {{$report->UserUpdateReport->name}}</cite>
                                                </figcaption>
                                            @endif
                                        </figure>
                                    </td>
                                    <td>{{$report->created_at}}</td>
                                    <td colspan="2">{{$report->transaction_NO}}</td>
                                    <td>{{$report->remittance_type}}</td>
                                    <td>{{$report->transaction_type}}</td>
                                    <td>{{$report->currency_type}}</td>
                                    <td>{{$report->amount}}</td>
                                    <td>{{$report->delivery_USD}}</td>
                                    <td>{{$report->delivery_ILS}}</td>
                                    <td class="table-active test{{$report->id}}">{{$report->profit_USD}}</td>
                                    <td class="table-active testt{{$report->id}}">{{$report->profit_ILS}}</td>
                                    <form action="" method="POST" class="test" id="profit{{$report->id}}">
                                        @csrf
                                        <input type="hidden" name="report_id" id="report_id{{$report->id}}" value="{{$report->id}}">
                                        <td>
                                            <input id="percent{{$report->id}}" name="percent" class="form-control me-2 " type="number" min="0"
                                                   value="{{$report->percent == 'null' ? '': $report->percent}}">
                                        </td>
                                        <td>
                                            <input id="numerical{{$report->id}}" name="numerical" class="form-control me-2 " type="number" min="0"
                                                   value="{{$report->numerical == 'null' ? '': $report->numerical}}">
                                        </td>
                                    </form>
                                    <td>
                                        <a href="{{route('admin.report.edit',$report->id)}}" class="btn btn-primary"><i class="las la-edit"></i></a>
                                    </td>
                                    <td>
                                        <form action="{{route('admin.report.delete', $report->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" onclick="return confirm('هل تريد هذه الحوالة')" type="submit"><i class="las la-times"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$reports->links()}}
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $("document").ready(function() {
            setTimeout(() => {
                $("div.alert").remove();
            }, 2000);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            let reports = JSON.parse('@json($reports)');


            $(".test").each(function(index) {


                $(document).on('input', '#percent'+reports.data[index].id, function() {
                    $("#numerical"+reports.data[index].id).val('');
                    var percent_value = $(this).val();
                    var report_id = $("#report_id"+reports.data[index].id).val();


                    $.ajax({
                        url: "{{ route('admin.profit') }}",
                        method: 'post',
                        data: {
                            percent_value: percent_value,
                            report_id:report_id
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                $('.test'+reports.data[index].id).load(location.href + ' .test'+reports.data[index].id);
                                $('.testt'+reports.data[index].id).load(location.href + ' .testt'+reports.data[index].id);
                            }
                        },
                        error: function(err) {

                        },
                    });

                });

                $(document).on('input', '#numerical'+reports.data[index].id, function() {
                    $("#percent"+reports.data[index].id).val('');
                    var numerical = $(this).val();
                    var report_id = $("#report_id"+reports.data[index].id).val();
                    $.ajax({
                        url: "{{ route('admin.profit') }}",
                        method: 'post',
                        data: {
                            numerical: numerical,
                            report_id:report_id
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                $('.test'+reports.data[index].id).load(location.href + ' .test'+reports.data[index].id);
                                $('.testt'+reports.data[index].id).load(location.href + ' .testt'+reports.data[index].id);
                            }
                        },
                        error: function(err) {

                        },
                    });

                });

            });

        });

    </script>




@endsection
