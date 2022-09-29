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
                                    <th scope="col">مجموع الصندوق</th>
                                    <th scope="col">مجموع الوارد</th>
                                    <th scope="col">المدفوع</th>
                                    <th scope="col">الباقي</th>
                                </tr>

                                </thead>
                                <tbody>

                                <tr>
                                    <th scope="row">-</th>
                                    <td>
                                        {{$loans->sum('loan_amount')}}
                                    </td>
                                    <td>
                                        {{$files->sum('incoming')}}
                                    </td>
                                    <td class="table-active">
                                        {{$files->sum('outgoing')}}
                                    </td>
                                    <td>
                                        {{$loans->sum('loan_amount') - $files->sum('outgoing')}}
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
                        <a class="navbar-brand btn btn-secondary text-bg-light" type="button" href="{{route('admin.files.index')}}">الأقساط</a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a class="nav-link active" aria-current="page" href="{{route('admin.loan_funds.index')}}">الصندوق المالية</a>

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
                        <a href="{{route('admin.file.export')}}" class="btn btn-dark"><i class="las la-file-export"></i></a>
                        <form action="{{ route('admin.files.search') }}" method="get" class="d-flex">
                            @csrf

                            <input name="date_from" placeholder="بداية تاريخ" class="form-control me-2"
                                   type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date_from" required/>

                            <input name="date_to" placeholder="نهاية تاريخ" class="form-control me-2"
                                   type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date_to" required/>                            <span>&nbsp;&nbsp;</span>
                            <button class="btn btn-success" type="submit">بحث</button>
                        </form>
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
                                <th scope="col">اسم الموظف</th>
                                <th scope="col">تاريخ العملية</th>
                                <th scope="col">رقم القسط</th>
                                <th scope="col">اسم الزبون</th>
                                <th scope="col">الصادر</th>
                                <th scope="col">الوارد</th>
                                <th scope="col">تعديل</th>
                                <th scope="col">حذف</th>
                            </tr>

                            </thead>
                            <tbody>
                                @foreach($files as $key => $file)
                                    <tr>
                                        <th>{{++$key}}</th>
                                        <td>
                                            <figure>
                                                <blockquote >
                                                    <p>{{$file->UserFile->name}}</p>
                                                </blockquote>
                                                @if($file->updated_by == null)
                                                @else
                                                    <figcaption class="blockquote-footer">
                                                        تم التعديل <cite title="Source Title"> - {{$file->UserUpdateFile->name}}</cite>
                                                    </figcaption>
                                                @endif
                                            </figure>
                                        </td>
                                        <td>{{$file->created_at}}</td>
                                        <td>{{$file->file_NO}}</td>
                                        <td>{{$file->client_name}}</td>
                                        <td>{{$file->outgoing}}</td>
                                        <td>{{$file->incoming}}</td>
                                        <td>
                                            <a href="{{route('admin.file.edit',$file->id)}}" class="btn btn-primary"><i class="las la-edit"></i></a>
                                        </td>
                                        <td>
                                            <form action="{{route('admin.file.delete', $file->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('هل تريد هذا القسط المالي')" type="submit"><i class="las la-times"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                            {{$files->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
i

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
