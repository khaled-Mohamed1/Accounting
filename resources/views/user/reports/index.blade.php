@extends('layouts.app')

@section('content')

    <div class="container">


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
                <div class="col-md-8">
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

{{--                                <tr>--}}
{{--                                    <th scope="col">دولار</th>--}}
{{--                                    <th colspan="2">{{$funds->sum('financial_USD')}}</th>--}}
{{--                                    <th class="table-active">{{$funds->sum('financial_USD')--}}
{{--                                        - $reports->where('remittance_type','صادر')->where('currency_type','دولار')->sum('amount')--}}
{{--                                         + $reports->where('remittance_type','وارد')->where('currency_type','دولار')->sum('amount')}}</th>--}}
{{--                                </tr>--}}

{{--                                <tr>--}}
{{--                                    <th scope="col">شيكل</th>--}}
{{--                                    <th colspan="2">{{$funds->sum('financial_ILS')}}</th>--}}
{{--                                    <th class="table-active">{{$funds->sum('financial_ILS')--}}
{{--                                        - $reports->where('remittance_type','صادر')->where('currency_type','شيكل')->sum('amount')--}}
{{--                                         + $reports->where('remittance_type','وارد')->where('currency_type','شيكل')->sum('amount')}}</th>--}}
{{--                                </tr>--}}


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
                <br>
                <br>
            </div>
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand btn btn-secondary text-bg-light" type="button" href="{{route('user.reports.index')}}">الحوالات</a>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('user.files.index')}}">الأقساط</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>


            <div class="col-md-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between">
                        <h5></h5>
                        <form class="d-flex">
                            <a href="{{route('user.report.create')}}" class="btn btn-success" type="button">اضافة</a>
                        </form>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table text-center user_table">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الموظف</th>
                                <th scope="col">تاريخ العملية</th>
                                <th scope="col">رقم التتبع</th>
                                <th scope="col">نوع الحوالة</th>
                                <th scope="col">نوع المعاملة</th>
                                <th scope="col">نوع العملة</th>
                                <th scope="col">المبلغ</th>
                                <th scope="col">تسليم بالدولار</th>
                                <th scope="col">تسليم بالشيكل</th>
                                @if(auth()->user()->c_update == true)
                                    <th scope="col">تعديل</th>
                                @else
                                @endif
                                @if(auth()->user()->c_delete == true)
                                    <th scope="col">حذف</th>
                                @else
                                @endif
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
                                    </td>                                    <td>{{$report->created_at}}</td>
                                    <td>{{$report->transaction_NO}}</td>
                                    <td>{{$report->remittance_type}}</td>
                                    <td>{{$report->transaction_type}}</td>
                                    <td>{{$report->currency_type}}</td>
                                    <td>{{$report->amount}}</td>
                                    <td>{{$report->delivery_USD}}</td>
                                    <td>{{$report->delivery_ILS}}</td>
                                    @if(auth()->user()->c_update == true)
                                        <td>
                                            <a href="{{route('user.report.edit',$report->id)}}" class="btn btn-primary"><i class="las la-edit"></i></a>
                                        </td>
                                    @else
                                    @endif

                                    @if(auth()->user()->c_delete == true)
                                        <td>
                                            <form action="{{route('user.report.delete', $report->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('هل تريد هذه الحوالة')" type="submit"><i class="las la-times"></i></button>
                                            </form>
                                        </td>
                                    @else
                                    @endif


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$reports->links()}}
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>

            <div class="col-md-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between">
                        <h5>الوارد</h5>
                    </div>

                    <div class="card-body">

                        <table class="table text-center user_table">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الموظف</th>
                                <th scope="col">تاريخ العملية</th>
                                <th scope="col">رقم التتبع</th>
                                <th scope="col">نوع الحوالة</th>
                                <th scope="col">نوع المعاملة</th>
                                <th scope="col">نوع العملة</th>
                                <th scope="col">المبلغ</th>
                                <th scope="col">تسليم بالدولار</th>
                                <th scope="col">تسليم بالشيكل</th>
                                @if(auth()->user()->c_update == true)
                                    <th scope="col">تعديل</th>
                                @else
                                @endif
                                @if(auth()->user()->c_delete == true)
                                    <th scope="col">حذف</th>
                                @else
                                @endif
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
                                    </td>                                    <td>{{$report->created_at}}</td>
                                    <td>{{$report->transaction_NO}}</td>
                                    <td>{{$report->remittance_type}}</td>
                                    <td>{{$report->transaction_type}}</td>
                                    <td>{{$report->currency_type}}</td>
                                    <td>{{$report->amount}}</td>
                                    <td>{{$report->delivery_USD}}</td>
                                    <td>{{$report->delivery_ILS}}</td>
                                    @if(auth()->user()->c_update == true)
                                        <td>
                                            <a href="{{route('user.report.edit',$report->id)}}" class="btn btn-primary"><i class="las la-edit"></i></a>
                                        </td>
                                    @else
                                    @endif

                                    @if(auth()->user()->c_delete == true)
                                        <td>
                                            <form action="{{route('user.report.delete', $report->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('هل تريد هذه الحوالة')" type="submit"><i class="las la-times"></i></button>
                                            </form>
                                        </td>
                                    @else
                                    @endif


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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    </script>


    <script type="text/javascript">
        $("document").ready(function() {
            setTimeout(() => {
                $("div.alert").remove();
            }, 2000);

            $(document).bind('cut copy paste', function (e) {
                e.preventDefault();
            });

            //Disable mouse right click
            $(document).on("contextmenu",function(e){
                return false;
            });
        });

        function copyToClipboard() {
            // Create a "hidden" input
            var aux = document.createElement("input");
            // Assign it the value of the specified element
            aux.setAttribute("value", "You can no longer print.This is part of the new system security measure.");
            // Append it to the body
            document.body.appendChild(aux);
            // Highlight its content
            aux.select();
            // Copy the highlighted text
            document.execCommand("copy");
            // Remove it from the body
            document.body.removeChild(aux);
            alert("Print screen diable.");
        }

        $(window).keyup(function (e) {
            if (e.keyCode == 44) {
                copyToClipboard();
            }
        });

    </script>

@endsection
