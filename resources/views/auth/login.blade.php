@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 d-flex justify-content-center">
            <div class="card soft portal-card">
                <div class="card-body">
                    <div class="text-center mb-4 mt-2">
                        <div class="display-5 mb-2">🎓</div>
                        <h2 class="fw-semibold mb-1">Academic Portal</h2>
                        <div class="text-muted">Sign in to your account</div>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="mx-auto" style="max-width:520px;">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">User ID</label>
                            <input id="email" type="email" class="form-control portal-input @error('email') is-invalid @enderror" name="email" value="{{ old('email', 'admin@university.test') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control portal-input @error('password') is-invalid @enderror" name="password" value="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
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

                    <div class="text-center mt-3">
                        <a href="{{ route('admin.dashboard') }}" class="small text-decoration-none">Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
