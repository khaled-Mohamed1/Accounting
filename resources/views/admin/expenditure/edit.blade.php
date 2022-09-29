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
                        <a class="btn btn-success" href="{{route('admin.expenditures.index')}}">الرجوع</a>

                    </div>
                </nav>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('تعديل مصروف يومي') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.update-expenditure',$expenditure->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="amount_spent_ILS" class="col-md-4 col-form-label text-md-end">{{ __('المبلغ بالشيكل') }}</label>

                                    <div class="col-md-6">
                                        <input id="amount_spent_ILS" type="text" class="form-control @error('amount_spent_ILS') is-invalid @enderror" name="amount_spent_ILS" value="{{ $expenditure->amount_spent_ILS }}" autofocus>

                                        @error('amount_spent_ILS')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="amount_spent_USD" class="col-md-4 col-form-label text-md-end">{{ __('المبلغ بالدولار') }}</label>

                                    <div class="col-md-6">
                                        <input id="amount_spent_USD" type="text" class="form-control @error('amount_spent_USD') is-invalid @enderror" name="amount_spent_USD" value="{{ $expenditure->amount_spent_USD }}" autofocus>

                                        @error('amount_spent_USD')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('الوصف') }}</label>

                                    <div class="col-md-6">
                                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $expenditure->description }}" required autofocus>

                                        @error('description')
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
@endsection
