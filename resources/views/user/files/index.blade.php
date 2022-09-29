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
                        <a class="navbar-brand btn btn-secondary text-bg-light" type="button" href="{{route('user.files.index')}}">الأقساط</a>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('user.reports.index')}}">الحوالات</a>
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
                            <a href="{{route('user.file.create')}}" class="btn btn-success" type="button">اضافة</a>
                        </form>
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
                                <th scope="col">اسم الموظف</th>
                                <th scope="col">تاريخ العملية</th>
                                <th scope="col">رقم القسط</th>
                                <th scope="col">اسم الزبون</th>
                                <th scope="col">الصادر</th>
                                <th scope="col">الوارد</th>
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
                                    </td>                                    <td>{{$file->created_at}}</td>
                                    <td>{{$file->file_NO}}</td>
                                    <td>{{$file->client_name}}</td>
                                    <td>{{$file->outgoing}}</td>
                                    <td>{{$file->incoming}}</td>
                                    @if(auth()->user()->c_update == true)
                                        <td>
                                            <a href="{{route('user.file.edit',$file->id)}}" class="btn btn-primary"><i class="las la-edit"></i></a>
                                        </td>
                                    @else
                                    @endif

                                    @if(auth()->user()->c_delete == true)
                                        <td>
                                            <form action="{{route('user.file.delete', $file->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('هل تريد هذا القسط')" type="submit"><i class="las la-times"></i></button>
                                            </form>
                                        </td>
                                    @else
                                    @endif
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


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
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
