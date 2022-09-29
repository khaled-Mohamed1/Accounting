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


                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <a class="navbar-brand btn btn-secondary text-bg-light" type="button" href="{{route('admin.loan_funds.index')}}">نتائج البحث عن صندوق المالي</a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a class="nav-link active" aria-current="page" href="{{route('admin.files.index')}}">الأقساط</a>

                        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('admin.home')}}">الموظفين</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('admin.reports.index')}}">الحوالات</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('admin.expenditures.index')}}">المصاريف</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <form action="{{route('admin.loan_funds.export.search')}}" method="POST">
                            @csrf
                            <input type="hidden" name="date_form" value="{{$date_form}}">
                            <input type="hidden" name="date_to" value="{{$date_to}}">
                            <button class="btn btn-dark" type="submit"><i class="las la-file-export"></i></button>
                        </form>


                    </div>

                    <div class="card-body">

                        <table class="table user_table text-center">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">المضاف بالشيكل</th>
                                <th scope="col">الباقي بالشيكل</th>
                                <th scope="col">تاريخ العملية</th>
                                <th scope="col">تعديل</th>
                                <th>حذف</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($loans as $key => $loan)
                                <tr>
                                    <th>{{++$key}}</th>
                                    <td>{{$loan->loan_amount}}</td>
                                    <td class="table-active">{{$loan->amount}}</td>
                                    <td>{{$loan->created_at}}</td>
                                    <td>
                                        <a href="{{route('admin.edit-loan_fund',$loan->id)}}" class="btn btn-primary"><i class="las la-edit"></i></a>
                                    </td>
                                    <td>
                                        <form action="{{route('admin.delete-loan_fund', $loan->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" onclick="return confirm('هل تريد هذا الصندوق')" type="submit"><i class="las la-times"></i></button>
                                        </form>
                                    </td>
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
