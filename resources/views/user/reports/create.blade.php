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
                        <a class="btn btn-success" href="{{route('user.reports.index')}}">الرجوع</a>

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
                        <div class="card-header">{{ __('اضافة تقرير') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.report.store') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="transaction_NO" class="col-md-4 col-form-label text-md-end">{{ __('رقم المعاملة') }}</label>

                                    <div class="col-md-6">
                                        <input id="transaction_NO" type="text" class="form-control @error('transaction_NO') is-invalid @enderror" name="transaction_NO" value="{{ old('transaction_NO') }}" required>

                                        @error('transaction_NO')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="remittance_type" class="col-md-4 col-form-label text-md-end">{{ __('نوع الحوالة') }}</label>

                                    <div class="col-md-6">
                                        <select name="remittance_type" id="remittance_type" class="form-select @error('remittance_type') is-invalid @enderror" aria-label="Default select example" required>
                                            <option selected disabled value="">اختار...</option>
                                            <option value="صادر" {{ old('remittance_type') == 'صادر' ? 'selected' : '' }}>صادر</option>
                                            <option value="وارد" {{ old('remittance_type') == 'وارد' ? 'selected' : '' }}>وارد</option>
                                        </select>

                                        @error('remittance_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="transaction_type" class="col-md-4 col-form-label text-md-end">{{ __('نوع المعاملة') }}</label>

                                    <div class="col-md-6">
                                        <input id="transaction_type" type="text" class="form-control @error('transaction_type') is-invalid @enderror" name="transaction_type" value="{{ old('transaction_type') }}" required>


                                        @error('transaction_type')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="currency_type" class="col-md-4 col-form-label text-md-end">{{ __('نوع العملة') }}</label>

                                    <div class="col-md-6">
                                        <select name="currency_type" id="currency_type" class="form-select @error('currency_type') is-invalid @enderror" aria-label="Default select example" required>
                                            <option selected disabled value="">اختار...</option>
                                            <option value="شيكل" {{ old('currency_type') == 'شيكل' ? 'selected' : '' }}>شيكل</option>
                                            <option value="دولار" {{ old('currency_type') == 'دولار' ? 'selected' : '' }}>دولار</option>
                                        </select>

                                        @error('currency_type')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="amount" class="col-md-4 col-form-label text-md-end">{{ __('المبلغ') }}</label>

                                    <div class="col-md-6">
                                        <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required>

                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="delivery_USD" class="col-md-4 col-form-label text-md-end">{{ __('المبلغ بالدولار') }}</label>

                                    <div class="col-md-6">
                                        <input id="delivery_USD" type="text" class="form-control @error('delivery_USD') is-invalid @enderror" name="delivery_USD" value="{{ old('delivery_USD') }}">

                                        @error('delivery_USD')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="delivery_ILS" class="col-md-4 col-form-label text-md-end">{{ __('المبلغ بالشيكل') }}</label>

                                    <div class="col-md-6">
                                        <input id="delivery_ILS" type="text" class="form-control @error('delivery_ILS') is-invalid @enderror" name="delivery_ILS" value="{{ old('delivery_ILS') }}">

                                        @error('delivery_ILS')
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

            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
            </script>

            <script type="text/javascript">
                $("document").ready(function() {
                    setTimeout(() => {
                        $("div.alert").remove();
                    }, 4000);
                });
            </script>
@endsection
