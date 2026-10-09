@extends('layouts.customer')
@section('title', 'Verify OTP — BRO CAFE')

@section('content')
    <section class="section auth-section">
        <div class="container auth-container">
            <form method="POST" action="{{ route('otp.verify') }}" class="auth-box">
                @csrf
                <h1 class="auth-title">VERIFY OTP</h1>
                <p class="auth-sub">Enter the 6-digit code sent to <strong>{{ $mobile }}</strong></p>

                <input type="hidden" name="mobile" value="{{ $mobile }}">

                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $e)
                            <p>{{ $e }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="otp-inputs">
                    @for ($i = 0; $i < 6; $i++)
                        <input type="text" inputmode="numeric" maxlength="1" class="otp-box"
                            data-otp-index="{{ $i }}">
                    @endfor
                </div>
                <input type="hidden" name="otp" id="otp-final">

                <button class="btn btn-yellow btn-lg btn-block" type="submit">VERIFY →</button>

                <form action="{{ route('otp.resend') }}" method="POST" style="margin-top:12px">
                    @csrf
                    <input type="hidden" name="mobile" value="{{ $mobile }}">
                    <button type="submit" class="btn btn-outline btn-block" id="resend-btn" disabled>RESEND (30s)</button>
                </form>
            </form>
        </div>
    </section>
@endsection
