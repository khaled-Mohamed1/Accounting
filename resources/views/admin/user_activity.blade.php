@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="row justify-content-center">

                <div class="row">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <a class="navbar-brand btn btn-secondary text-bg-light" type="button" href="{{route('admin.activity')}}">نشاطات الموظفين</a>
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            <a class="nav-link active" aria-current="page" href="{{route('admin.home')}}">الموظفين</a>

                            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="{{route('admin.reports.index')}}">الحوالات</a>
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



                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5></h5>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <table class="table user_table text-center">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">الاسم الموظف</th>
                                    <th scope="col">بريد الإلكتروني</th>
                                    <th scope="col">ip address</th>
                                    <th scope="col">الوصف</th>
                                    <th scope="col">الحالة</th>
                                    <th scope="col">تاريخ</th>
                                </tr>

                                </thead>
                                <tbody>
                                @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$user->UserActivity->name}}</td>
                                        <td>{{$user->UserActivity->email}}</td>
                                        <td>{{$user->user_ip}}</td>
                                        <td>{{$user->description}}</td>
                                        <td>
                                            @if($user->user_status == 'try_log_in')
                                            <span class="text-warning">{{$user->user_status}}</span>
                                            @elseif($user->user_status == 'log_in')
                                                <span class="text-success">{{$user->user_status}}</span>
                                            @else
                                                <span class="text-danger">{{$user->user_status}}</span>
                                            @endif
                                        </td>
                                        <td>{{\Carbon\Carbon::parse($user->activity_time )->format('H:i -- d/m/Y')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>

        <script type="text/javascript">
            $("document").ready(function() {
                setTimeout(() => {
                    $("div.alert").remove();
                }, 2000);
            });
        </script>

@endsection
