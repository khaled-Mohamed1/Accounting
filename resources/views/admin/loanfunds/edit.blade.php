@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

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
                        <a class="btn btn-success" href="{{route('admin.loan_funds.index')}}">الرجوع</a>

                    </div>
                </nav>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('اضافة صندوق مالي') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.update-loan_fund',$loan->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="loan_amount" class="col-md-4 col-form-label text-md-end">{{ __('المبلغ بالشيكل') }}</label>

                                    <div class="col-md-6">
                                        <input id="loan_amount" type="text" class="form-control @error('loan_amount') is-invalid @enderror" name="loan_amount" value="{{ $loan->loan_amount}}" autofocus>

                                        @error('loan_amount')
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
