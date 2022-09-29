@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="btn btn-success" href="{{route('user.files.index')}}">الرجوع</a>

                    </div>
                </nav>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">

                    @if ($message = Session::get('danger'))
                        <div class="alert alert-danger" id="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">{{ __('تعديل القسط المالي') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.file.update',$file->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="file_NO" class="col-md-4 col-form-label text-md-end">{{ __('رقم القسط') }}</label>

                                    <div class="col-md-6">
                                        <input id="file_NO" type="text" class="form-control @error('file_NO') is-invalid @enderror" name="file_NO" value="{{ $file->file_NO }}" required>

                                        @error('file_NO')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="client_name" class="col-md-4 col-form-label text-md-end">{{ __('اسم الزبون') }}</label>

                                    <div class="col-md-6">
                                        <input id="client_name" type="text" class="form-control @error('client_name') is-invalid @enderror" name="client_name" value="{{ $file->client_name }}" required>

                                        @error('client_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="outgoing" class="col-md-4 col-form-label text-md-end">{{ __('الصادر') }}</label>

                                    <div class="col-md-6">
                                        <input id="outgoing" type="text" class="form-control @error('outgoing') is-invalid @enderror" name="outgoing" value="{{ $file->outgoing }}" required>

                                        @error('outgoing')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="incoming" class="col-md-4 col-form-label text-md-end">{{ __('الوارد') }}</label>

                                    <div class="col-md-6">
                                        <input id="incoming" type="text" class="form-control @error('incoming') is-invalid @enderror" name="incoming" value="{{ $file->incoming }}">

                                        @error('incoming')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('تعديل') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
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
