@extends('layouts.customer')
@section('title', 'Forgot Password — BRO CAFE')

@section('content')
    <section class="section auth-section">
        <div class="container auth-container">
            <form method="POST" action="{{ route('password.send') }}" class="auth-box">
                @csrf
                <h1 class="auth-title">FORGOT PASSWORD</h1>
                <p class="auth-sub">We'll send an OTP to your registered mobile.</p>

                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $e)
                            <p>{{ $e }}</p>
                        @endforeach
                    </div>
                @endif

                <label>Registered Mobile</label>
                <input type="tel" name="mobile" required pattern="[0-9]{10}">
                <button class="btn btn-yellow btn-lg btn-block">SEND OTP →</button>
            </form>
        </div>
    </section>
@endsection
