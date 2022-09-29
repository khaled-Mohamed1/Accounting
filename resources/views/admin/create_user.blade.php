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
                        <a class="btn btn-success" href="{{route('admin.home')}}">الرجوع</a>

                    </div>
                </nav>
            </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('اضافة موظف') }}</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.store-user') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('الاسم') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('البريداللإكتروني') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="ID_NO" class="col-md-4 col-form-label text-md-end">{{ __('رقم الهوية') }}</label>

                                        <div class="col-md-6">
                                            <input id="ID_NO" type="text" class="form-control @error('ID_NO') is-invalid @enderror" name="ID_NO" value="{{ old('ID_NO') }}" required>

                                            @error('ID_NO')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="phone_NO" class="col-md-4 col-form-label text-md-end">{{ __('رقم الجوال') }}</label>

                                        <div class="col-md-6">
                                            <input id="phone_NO" type="text" class="form-control @error('phone_NO') is-invalid @enderror" name="phone_NO" value="{{ old('phone_NO') }}" required>

                                            @error('phone_NO')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('كلمة السر') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-2 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="c_update" id="c_update" {{ old('c_update') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="c_update">
                                                    {{ __('امكانية التعديل') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-2 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="c_delete" id="c_delete" {{ old('c_delete') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="c_delete">
                                                    {{ __('امكانية الحذف') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="start_log" class="col-md-4 col-form-label text-md-end">{{ __('بداية الدوام') }}</label>

                                        <div class="col-md-6">
                                            <input id="start_log" type="time" class="form-control @error('start_log') is-invalid @enderror" name="start_log" value="{{ old('start_log') }}" required>

                                            @error('start_log')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="end_log" class="col-md-4 col-form-label text-md-end">{{ __('نهاية الدوام') }}</label>

                                        <div class="col-md-6">
                                            <input id="end_log" type="time" class="form-control @error('end_log') is-invalid @enderror" name="end_log" value="{{ old('end_log') }}" required>

                                            @error('end_log')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('اضافة') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
@endsection
