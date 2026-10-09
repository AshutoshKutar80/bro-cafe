@extends('layouts.customer')
@section('title', 'Reset Password — BRO CAFE')

@section('content')
    <section class="section auth-section">
        <div class="container auth-container">
            <form method="POST" action="{{ route('password.reset') }}" class="auth-box">
                @csrf
                <h1 class="auth-title">RESET PASSWORD</h1>
                <input type="hidden" name="mobile" value="{{ $mobile }}">
                <label>New Password</label>
                <input type="password" name="password" required>
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
                <button class="btn btn-yellow btn-lg btn-block">UPDATE →</button>
            </form>
        </div>
    </section>
@endsection
