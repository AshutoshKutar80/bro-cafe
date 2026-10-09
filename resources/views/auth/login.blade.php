@extends('layouts.customer')
@section('title', 'Login — BRO CAFE')

@section('content')
    <section class="section auth-section">
        <div class="container auth-container">
            <form method="POST" action="{{ route('login') }}" class="auth-box">
                @csrf
                <h1 class="auth-title">LOGIN</h1>

                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $e)
                            <p>{{ $e }}</p>
                        @endforeach
                    </div>
                @endif

                <label>Mobile or Email</label>
                <input type="text" name="identifier" value="{{ old('identifier') }}" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <label class="check-row"><input type="checkbox" name="remember"> Remember me</label>

                <button class="btn btn-yellow btn-lg btn-block">LOGIN →</button>

                <p class="auth-foot">
                    <a href="{{ route('password.request') }}">Forgot Password?</a> ·
                    <a href="{{ route('register') }}">Sign Up</a>
                </p>
            </form>
        </div>
    </section>
@endsection
