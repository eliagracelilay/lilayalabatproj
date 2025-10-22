@extends('layouts.app')

@section('content')
    <div class="card portal-card" style="width:100%; max-width:960px;">
        <div class="row g-0">
            <div class="col-md-5 d-none d-md-block" style="background: rgba(255,255,255,.25); min-height:560px; background-image:url('{{ asset('images/fsuu.png') }}'); background-size:cover; background-position:center; border-top-left-radius:28px; border-bottom-left-radius:28px;"></div>
            <div class="col-12 col-md-7">
                <div class="card-body">
                    <div class="portal-header">
                        <div class="portal-icon">🔐</div>
                        <div class="portal-title">Login</div>
                        <div class="portal-subtitle">Welcome Back! Please login to your account</div>
                    </div>
                    <form method="POST" action="{{ route('login') }}" class="portal-form">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">User ID</label>
                    <div style="position:relative;">
                        <input id="email" type="text" placeholder="userID" class="form-control portal-input @error('email') is-invalid @enderror" name="email" value="{{ old('email', 'admin@university.test') }}" required autocomplete="username" autofocus>
                        <span style="position:absolute; right:14px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:18px;">👤</span>
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div style="position:relative;">
                        <input id="password" type="password" placeholder="Password" class="form-control portal-input @error('password') is-invalid @enderror" name="password" value="password" required autocomplete="current-password">
                        <span style="position:absolute; right:14px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:18px;">🔒</span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn portal-submit">Login</button>
                <div class="portal-footer"><a href="{{ route('admin.dashboard') }}" class="portal-link">Admin</a></div>
            </form>
                </div>
            </div>
        </div>
    </div>
@endsection