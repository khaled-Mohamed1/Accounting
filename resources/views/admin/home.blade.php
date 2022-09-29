@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="row justify-content-center">

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


            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand btn btn-secondary text-bg-light" type="button" href="{{route('admin.home')}}">الموظفين</a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a class="nav-link active" aria-current="page" href="{{route('admin.activity')}}">نشاطات الموظفين</a>
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
                        <a href="{{route('admin.create-user')}}" type="button" class="btn btn-success">اضافة مستخدم</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <table class="table user_table">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">الاسم</th>
                                    <th scope="col">بريد الإلكتروني</th>
                                    <th scope="col">رقم الهوية</th>
                                    <th scope="col">رقم الجوال</th>
                                    <th scope="col">الحالة</th>
                                    <th scope="col">تعديل</th>
                                    <th scope="col">حذف</th>
                                </tr>

                                </thead>
                                <tbody>
                                @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->ID_NO}}</td>
                                        <td>{{$user->phone_NO}}</td>
                                        <td>
                                            <div class="form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDisabled" disabled {{$user->status_log == 1 ? 'checked' : ''}}>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{route('admin.edit-user',$user->id)}}" class="btn btn-primary"><i class="las la-edit"></i></a>
                                        </td>
                                        <td>
                                            <form action="{{route('admin.delete-user', $user->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('هل تريد هذا الموظف {{$user->name}}')" type="submit"><i class="las la-times"></i></button>
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
