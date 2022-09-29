@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container">

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
                        <div class="card-header">{{ __('تعديل الحوالة') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.report.update', $report->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="transaction_NO" class="col-md-4 col-form-label text-md-end">{{ __('رقم المعاملة') }}</label>

                                    <div class="col-md-6">
                                        <input id="transaction_NO" type="text" class="form-control @error('transaction_NO') is-invalid @enderror" name="transaction_NO" value="{{ $report->transaction_NO }}" required>

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
                                            <option value="صادر" {{ $report->remittance_type == 'صادر' ? 'selected' : '' }}>صادر</option>
                                            <option value="وارد" {{ $report->remittance_type == 'وارد' ? 'selected' : '' }}>وارد</option>
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
                                        <input id="transaction_type" type="text" class="form-control @error('transaction_type') is-invalid @enderror" name="transaction_type" value="{{ $report->transaction_type }}" required>


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
                                            <option value="شيكل" {{ $report->transaction_type == 'تسديد دفعة' ? 'selected' : '' }}>شيكل</option>
                                            <option value="دولار" {{ $report->transaction_type == 'تسديد دفعة' ? 'selected' : '' }}>دولار</option>
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
                                        <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $report->amount }}" required>

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
                                        <input id="delivery_USD" type="text" class="form-control @error('delivery_USD') is-invalid @enderror" name="delivery_USD" value="{{ $report->delivery_USD }}">

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
                                        <input id="delivery_ILS" type="text" class="form-control @error('delivery_ILS') is-invalid @enderror" name="delivery_ILS" value="{{ $report->delivery_ILS }}">

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
