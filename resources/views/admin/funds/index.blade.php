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

                        <a class="navbar-brand btn btn-secondary text-bg-light" type="button" href="{{route('admin.funds.index')}}">الصندوق المالي</a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a class="nav-link active" aria-current="page" href="{{route('admin.reports.index')}}">الحوالات</a>

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


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <a href="{{route('admin.funds.export')}}" class="btn btn-dark"><i class="las la-file-export"></i></a>

                        <form action="{{ route('admin.funds.search') }}" method="get" class="d-flex">
                            @csrf

                            <input name="date_from" placeholder="بداية تاريخ" class="form-control me-2"
                                   type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date_from" required/>

                            <input name="date_to" placeholder="نهاية تاريخ" class="form-control me-2"
                                   type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date_to" required/>

                            <span>&nbsp;&nbsp;</span>
                            <button class="btn btn-success" type="submit">بحث</button>
                        </form>

{{--                        <form class="d-flex">--}}
{{--                            <a href="{{route('admin.create-fund')}}" class="btn btn-success" type="button">اضافة</a>--}}
{{--                        </form>--}}

                    </div>

                    <div class="card-body">

                        <table class="table user_table text-center">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">المضاف بالدولار</th>
                                <th scope="col">الباقي بالدولار</th>
                                <th scope="col">المضاف بالشيكل</th>
                                <th scope="col">الباقي بالشيكل</th>
                                <th scope="col">تاريخ العملية</th>
                                <th scope="col">تعديل</th>
                                <th>حذف</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($funds as $key => $fund)
                                <tr class="{{$fund->is_delete == 1 ? 'table-danger': ''}}">
                                    <th>{{++$key}}</th>
                                    <td>{{$fund->financial_USD}}</td>
                                    <td class="{{$fund->is_delete == 1 ? '': 'table-active'}}">{{$fund->financial_amount_USD}}</td>
                                    <td>{{$fund->financial_ILS}}</td>
                                    <td class="{{$fund->is_delete == 1 ? '': 'table-active'}}">{{$fund->financial_amount_ILS}}</td>
                                    <td>{{$fund->created_at}}</td>
                                    @if($fund->is_delete == 1)
                                        <td colspan="2" class="text-center">تم الحذف</td>
                                    @else
                                        <td>
                                            <a href="{{route('admin.edit-fund',$fund->id)}}" class="btn btn-primary"><i class="las la-edit"></i></a>
                                        </td>
                                        <td>
                                            <form action="{{route('admin.delete-fund', $fund->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('هل تريد هذا الصندوق')" type="submit"><i class="las la-times"></i></button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="text-end" colspan="3">
                                        @foreach($fund->notifys as $notify)
                                            <figure>
                                                <blockquote >
                                                    <p></p>
                                                </blockquote>
                                                @if($notify->old_amount_USD == null)
                                                    <figcaption class="blockquote-footer">
                                                        تم اضافة قيمة مقدارها <span class="fs-6 text-gray fw-bolder text-decoration-underline">{{$notify->new_amount_ILS - $notify->old_amount_ILS}}</span> على القيمة القديمة <span class="fs-6 text-gray fw-bolder text-decoration-underline">{{$notify->old_amount_ILS}}</span> <span class="fs-6 text-info fw-bolder">(شيكل)</span>
                                                    </figcaption>
                                                @else
                                                    <figcaption class="blockquote-footer">
                                                        تم اضافة قيمة مقدارها <span class="fs-6 text-gray fw-bolder text-decoration-underline">{{$notify->new_amount_USD - $notify->old_amount_USD}}</span> على القيمة القديمة <span class="fs-6 text-gray fw-bolder text-decoration-underline">{{$notify->old_amount_USD}}</span>  <span class="fs-6 text-info fw-bolder">(دولار)</span>
                                                    </figcaption>
                                                @endif
                                            </figure>
                                        @endforeach
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
