@extends('layouts.admin')

@section('admin-content')
<div class="py-2">
    <style>
        .profile-shell { border:0; border-radius:18px; background:#fff; box-shadow:0 10px 22px rgba(0,0,0,.12); }
        .tabbar { display:flex; gap:.5rem; margin-bottom:1rem; }
        .tab-pill { display:inline-flex; align-items:center; gap:.5rem; padding:.45rem 1rem; border-radius:999px; background:#ececec; color:#333; font-weight:600; cursor:pointer; border:1px solid transparent; }
        .tab-pill:hover { background:#e6e6e6; }
        .tab-pill.active { background:#dfe9ff; border-color:#c8daff; }
        .profile-row label { font-size:.85rem; color:#777; margin-bottom:.2rem; }
        .profile-row .form-control { background:#f3f3f3; border:0; }
        .avatar { width:72px; height:72px; border-radius:50%; background:#e9e9e9; display:grid; place-items:center; font-size:2rem; }
        .section { display:none; }
        .section.active { display:block; }
    </style>

    <div class="tabbar" id="profile-tabs">
        <button class="tab-pill active" data-target="#tab-info"> Admin Info</button>
        <button class="tab-pill" data-target="#tab-security"> Security</button>
    </div>

    <div class="profile-shell p-4">
        <div id="tab-info" class="section active">
            <div class="mb-3">
                <div class="h5 mb-1">Profile Information</div>
                <div class="text-muted">Ensure that all personal and contact records are accurate and up to date.</div>
            </div>
            <div class="row g-4 align-items-center mb-4">
                <div class="col-auto">
                    <div class="avatar"> </div>
                </div>
                <div class="col">
                    <div class="fw-semibold">{{ $user->name ?? 'Administrator' }}</div>
                    <div class="text-muted small">Admin</div>
                    <div class="text-muted small">{{ $user->email ?? '' }}</div>
                </div>
            </div>
            <div class="row g-4 profile-row">
                <div class="col-md-6">
                    <label>First Name</label>
                    <input class="form-control" value="{{ \Illuminate\Support\Str::of($user->name ?? '')->before(' ') }}" disabled>
                </div>
                <div class="col-md-6">
                    <label>Last Name</label>
                    <input class="form-control" value="{{ \Illuminate\Support\Str::of($user->name ?? '')->after(' ') }}" disabled>
                </div>
                <div class="col-md-6">
                    <label>Email Address</label>
                    <input class="form-control" value="{{ $user->email ?? '' }}" disabled>
                </div>
                <div class="col-md-6">
                    <label>Phone Number</label>
                    <input class="form-control" value="" placeholder="—" disabled>
                </div>
                <div class="col-md-6">
                    <label>Account Created</label>
                    <input class="form-control" value="{{ optional($user->created_at)->format('F d, Y') }}" disabled>
                </div>
                <div class="col-md-6">
                    <label>Role</label>
                    <input class="form-control" value="Admin" disabled>
                </div>
            </div>
        </div>

        <div id="tab-security" class="section">
            <div class="mb-3">
                <div class="h5 mb-1">Security</div>
                <div class="text-muted">Update your password to keep your account secure.</div>
            </div>
            <form onsubmit="event.preventDefault(); alert('This is a demo UI. Hook into your update password route.');">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" placeholder="••••••••" />
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" placeholder="••••••••" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" placeholder="••••••••" />
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
      (function(){
        const tabs = document.querySelectorAll('#profile-tabs .tab-pill');
        tabs.forEach(btn => {
          btn.addEventListener('click', () => {
            tabs.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            const target = document.querySelector(btn.getAttribute('data-target'));
            if (target) target.classList.add('active');
          });
        });
      })();
    </script>
</div>
@endsection
