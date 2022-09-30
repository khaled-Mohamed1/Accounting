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
                                    <th scope="col">#</th>
                                    <th scope="col">دولار</th>
                                    <th scope="col">شيكل</th>
                                </tr>

                                </thead>
                                <tbody>

                                <tr>
                                    <th scope="col">مجموع</th>
                                    <td>
                                        {{$expenditures->where('is_delete',0)->sum('amount_spent_USD')}}
                                    </td>
                                    <td>
                                        {{$expenditures->where('is_delete',0)->sum('amount_spent_ILS')}}
                                    </td>
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
                        <a class="navbar-brand btn btn-secondary text-bg-light" type="button" href="{{route('admin.expenditures.index')}}">نتائج البحث عن المصاريف</a>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('admin.home')}}">الموظفين</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('admin.files.index')}}">الأقساط</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('admin.reports.index')}}">الحوالات</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <form action="{{route('admin.expenditures.export.search')}}" method="POST">
                            @csrf
                            <input type="hidden" name="date_form" value="{{$date_form}}">
                            <input type="hidden" name="date_to" value="{{$date_to}}">
                            <button class="btn btn-dark" type="submit"><i class="las la-file-export"></i></button>
                        </form>

                    </div>

                    <div class="card-body">

                        <table class="table user_table ">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">مبلغ بالشيكل</th>
                                <th scope="col">مبلغ بالدولار</th>
                                <th scope="col">وصف</th>
                                <th scope="col">تاريخ العملية</th>
                                <th scope="col">تعديل</th>
                                <th>حذف</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($expenditures as $key => $expenditure)
                                <tr class="{{$expenditure->is_delete == 1 ? 'table-danger': ''}}">
                                    <th>{{++$key}}</th>
                                    <td>{{$expenditure->amount_spent_ILS}}</td>
                                    <td>{{$expenditure->amount_spent_USD}}</td>
                                    <td>{{$expenditure->description}}</td>
                                    <td>{{$expenditure->created_at}}</td>
                                    @if($expenditure->is_delete == 1)
                                        <td colspan="2" class="text-center">تم الحذف</td>
                                    @else
                                        <td>
                                            <a href="{{route('admin.edit-expenditure',$expenditure->id)}}" class="btn btn-primary"><i class="las la-edit"></i></a>
                                        </td>
                                        <td>
                                            <form action="{{route('admin.delete-expenditure', $expenditure->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('هل تريد هذا المصروف')" type="submit"><i class="las la-times"></i></button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
    </script>

@endsection
