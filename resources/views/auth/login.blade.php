@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 d-flex justify-content-center">
            <div class="card soft portal-card">
                <div class="card-body">
                    <div class="portal-header">
                        <div class="portal-icon">🎓</div>
                        <h2 class="portal-title">Academic Portal</h2>
                        <div class="portal-subtitle">Sign in to your account</div>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="portal-form">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">User ID</label>
                            <input id="email" type="email" class="form-control portal-input @error('email') is-invalid @enderror" name="email" value="{{ old('email', 'admin@university.test') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control portal-input @error('password') is-invalid @enderror" name="password" value="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">I am a:</label>
                            <select id="role" name="role" class="form-select portal-input">
                                <option selected>Select an option</option>
                                <option>Faculty</option>
                                <option>Student</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-brand portal-submit">
                            <span class="me-2">🔐</span> Sign In
                        </button>
                    </form>

                    <div class="portal-footer">
                        <a href="{{ route('admin.dashboard') }}" class="portal-link">Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
