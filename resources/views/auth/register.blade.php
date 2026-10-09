@extends('layouts.customer')
@section('title', 'Sign Up — BRO CAFE')

@section('content')
    <section class="section auth-section">
        <div class="container auth-container">
            <form method="POST" action="{{ route('register') }}" class="auth-box">
                @csrf
                <h1 class="auth-title">SIGN UP</h1>
                <p class="auth-sub">Verify with SMS OTP — quick &amp; secure.</p>

                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $e)
                            <p>{{ $e }}</p>
                        @endforeach
                    </div>
                @endif

                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>

                <label>Mobile (10 digits)</label>
                <input type="tel" name="mobile" value="{{ old('mobile') }}" required pattern="[0-9]{10}">

                <label>Email (optional)</label>
                <input type="email" name="email" value="{{ old('email') }}">

                <label>Password</label>
                <input type="password" name="password" required>

                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>

                <button class="btn btn-yellow btn-lg btn-block">SEND OTP →</button>
                <p class="auth-foot">Already have an account? <a href="{{ route('login') }}">LOGIN</a></p>
            </form>
        </div>
    </section>
@endsection
